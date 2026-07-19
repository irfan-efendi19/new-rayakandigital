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

        $tempExtractDir = storage_path('app/temp_screen_preset_extract_'.uniqid());

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

        if (! $hasIndexHtml) {
            $zip->close();
            throw new Exception('Template tidak valid: File index.html tidak ditemukan.');
        }

        File::makeDirectory($tempExtractDir, 0755, true, true);
        $zip->extractTo($tempExtractDir);
        $zip->close();

        $rootThemeDir = $this->findRootDirectory($tempExtractDir);

        // 1. Extract only inline <style> blocks from index.html.
        //    These contain CSS variables/theme tokens that must live in <head>
        //    before the external stylesheet is loaded.
        $htmlContent = File::get($rootThemeDir.'/index.html');
        preg_match_all('/<style[^>]*>.*?<\/style>/si', $htmlContent, $styleMatches);

        $inlineStyles = '';
        if (! empty($styleMatches[0])) {
            $inlineStyles = $this->rewriteAssetUrlsToAbsolute(
                implode("\n", $styleMatches[0]),
                $presetSlug
            );
        }

        // 2. Deploy all files to public/screen-presets/{slug}/ maintaining native structure.
        //    css/style.css, js/app.js, and assets/* are stored as real separate files.
        $publicPresetDir = public_path("screen-presets/{$presetSlug}");
        File::deleteDirectory($publicPresetDir);
        File::makeDirectory($publicPresetDir, 0755, true, true);

        $files = File::allFiles($rootThemeDir);
        foreach ($files as $file) {
            $relativePath = str_replace($rootThemeDir.DIRECTORY_SEPARATOR, '', $file->getPathname());

            // Skip root index.html — local-preview only; inline styles already extracted.
            if ($relativePath === 'index.html') {
                continue;
            }

            $targetPath = $publicPresetDir.DIRECTORY_SEPARATOR.$relativePath;
            File::makeDirectory(dirname($targetPath), 0755, true, true);

            // Rewrite CSS url() to absolute server paths so assets resolve from any URL.
            if ($file->getExtension() === 'css') {
                $cssContent = File::get($file->getPathname());
                $cssContent = $this->rewriteAssetUrlsToAbsolute($cssContent, $presetSlug);
                File::put($targetPath, $cssContent);
            } else {
                File::copy($file->getPathname(), $targetPath);
            }
        }

        // 3. Cleanup temp files.
        File::deleteDirectory($tempExtractDir);
        Storage::disk('public')->delete($zipFilePath);

        return [
            'html_content' => $inlineStyles,
            'zip_path' => "uploaded:{$presetSlug}",
        ];
    }

    private function findRootDirectory(string $path): string
    {
        if (File::exists($path.'/index.html')) {
            return $path;
        }

        $directories = File::directories($path);
        foreach ($directories as $dir) {
            if (File::exists($dir.'/index.html')) {
                return $dir;
            }
        }

        throw new Exception('Tidak dapat menemukan index.html dalam struktur folder yang diekstrak.');
    }

    /**
     * Rewrite relative url() references in CSS/inline-style content to absolute
     * server paths: /screen-presets/{slug}/{normalized-path}.
     *
     * http/https/data/protocol-relative URLs are left untouched.
     */
    private function rewriteAssetUrlsToAbsolute(string $content, string $presetSlug): string
    {
        return preg_replace_callback(
            '/url\(\s*["\']?([^"\')\s]+)["\']?\s*\)/i',
            function (array $matches) use ($presetSlug) {
                $path = $matches[1];

                if (preg_match('/^(https?:\/\/|\/\/|data:|#)/i', $path)) {
                    return $matches[0];
                }

                $normalized = $this->normalizePath($path);

                return "url('/screen-presets/{$presetSlug}/{$normalized}')";
            },
            $content
        );
    }

    /**
     * Strip leading ./ and ../ segments from a relative path.
     *
     * Examples:
     *   ../assets/bg.jpg  → assets/bg.jpg
     *   ./assets/bg.jpg   → assets/bg.jpg
     *   assets/bg.jpg     → assets/bg.jpg
     */
    private function normalizePath(string $path): string
    {
        return preg_replace('/^(\.\.\/|\.\/)+/', '', $path);
    }
}
