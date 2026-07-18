<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ScreenPresetUploaderService
{
    public function deploy(string $zipFilePath, string $presetName): array
    {
        $presetSlug = Str::slug($presetName);
        $fullZipPath = Storage::disk('public')->path($zipFilePath);

        $tempExtractDir = storage_path('app/temp_screen_preset_extract_' . uniqid());

        $zip = new ZipArchive;
        if ($zip->open($fullZipPath) !== true) {
            throw new Exception('Tidak dapat membuka file ZIP.');
        }

        $hasIndexHtml = false;
        $blockedExtensions = ['php', 'phtml', 'php3', 'php4', 'php5', 'phps', 'exe', 'sh', 'bat'];

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($ext, $blockedExtensions)) {
                $zip->close();
                throw new Exception("Keamanan: Ekstensi file dilarang -> {$filename}");
            }

            if (basename($filename) === 'index.html') {
                $hasIndexHtml = true;
            }
        }

        if (!$hasIndexHtml) {
            $zip->close();
            throw new Exception('Template tidak valid: File index.html tidak ditemukan.');
        }

        File::makeDirectory($tempExtractDir, 0755, true, true);
        $zip->extractTo($tempExtractDir);
        $zip->close();

        $rootThemeDir = $this->findRootDirectory($tempExtractDir);

        $htmlContent = File::get($rootThemeDir . '/index.html');

        $cssContent = '';
        $cssPath = $rootThemeDir . '/css/style.css';
        if (File::exists($cssPath)) {
            $cssContent = '<style>' . File::get($cssPath) . '</style>';
        }

        $jsContent = '';
        $jsPath = $rootThemeDir . '/js/main.js';
        if (File::exists($jsPath)) {
            $jsContent = '<script>' . File::get($jsPath) . '</script>';
        }

        $publicAssetsDir = public_path("screen-presets/{$presetSlug}");
        File::deleteDirectory($publicAssetsDir);
        File::makeDirectory($publicAssetsDir, 0755, true, true);

        $files = File::allFiles($rootThemeDir);
        foreach ($files as $file) {
            $relativePath = str_replace($rootThemeDir . DIRECTORY_SEPARATOR, '', $file->getPathname());

            if (in_array($file->getFilename(), ['index.html', 'style.css', 'main.js'])) {
                continue;
            }

            $targetPath = $publicAssetsDir . DIRECTORY_SEPARATOR . $relativePath;
            File::makeDirectory(dirname($targetPath), 0755, true, true);
            File::copy($file->getPathname(), $targetPath);
        }

        $htmlContent = $this->rewriteAssetPaths($htmlContent, "screen-presets/{$presetSlug}");
        $cssContent = $this->rewriteCssAssetPaths($cssContent, "screen-presets/{$presetSlug}");

        $combined = $htmlContent . "\n" . $cssContent . "\n" . $jsContent;

        File::deleteDirectory($tempExtractDir);
        Storage::disk('public')->delete($zipFilePath);

        return [
            'html_content' => $combined,
            'zip_path' => "uploaded:{$presetSlug}",
        ];
    }

    private function findRootDirectory(string $path): string
    {
        if (File::exists($path . '/index.html')) {
            return $path;
        }

        $directories = File::directories($path);
        foreach ($directories as $dir) {
            if (File::exists($dir . '/index.html')) {
                return $dir;
            }
        }

        throw new Exception('Tidak dapat menemukan index.html dalam struktur folder yang diekstrak.');
    }

    private function rewriteAssetPaths(string $html, string $assetPrefix): string
    {
        $html = preg_replace_callback('/href="([^"]+)"/i', function ($matches) use ($assetPrefix) {
            return $this->processPath('href', $matches[1], $assetPrefix);
        }, $html);

        $html = preg_replace_callback('/src="([^"]+)"/i', function ($matches) use ($assetPrefix) {
            return $this->processPath('src', $matches[1], $assetPrefix);
        }, $html);

        $html = str_replace(['%7B%7B', '%7D%7D'], ['{{', '}}'], $html);

        return $html;
    }

    private function rewriteCssAssetPaths(string $css, string $assetPrefix): string
    {
        return preg_replace_callback('/url\(["\']?([^"\'\)]+)["\']?\)/i', function ($matches) use ($assetPrefix) {
            $path = $matches[1];

            if (preg_match('/^(http|https|\/\/|data:)/i', $path) || str_contains($path, '{{')) {
                return $matches[0];
            }

            $cleanPath = ltrim($path, './');
            return "url('{{ asset('{$assetPrefix}/{$cleanPath}') }}')";
        }, $css);
    }

    private function processPath(string $attribute, string $path, string $assetPrefix): string
    {
        if (
            preg_match('/^(http|https|\/\/|data:|mailto:|tel:|#)/i', $path) ||
            str_contains($path, '{{') ||
            str_contains($path, '%7B%7B')
        ) {
            return "{$attribute}=\"{$path}\"";
        }

        $cleanPath = ltrim($path, './');

        return "{$attribute}=\"{{ asset('{$assetPrefix}/{$cleanPath}') }}\"";
    }
}
