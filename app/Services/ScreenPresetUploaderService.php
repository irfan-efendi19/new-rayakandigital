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

        // 1. Process the entire index.html.
        //    All asset paths (href, src, url()) are rewritten to point to public assets.
        $htmlContent = File::get($rootThemeDir.'/index.html');
        $processedHtmlContent = $this->rewriteAssetPaths($htmlContent, $presetSlug);

        // 2. Deploy all files to public/screen-presets/{slug}/ maintaining native structure.
        //    css/style.css, js/app.js, and assets/* are stored as real separate files.
        $publicPresetDir = public_path("screen-presets/{$presetSlug}");
        File::deleteDirectory($publicPresetDir);
        File::makeDirectory($publicPresetDir, 0755, true, true);

        $files = File::allFiles($rootThemeDir);
        foreach ($files as $file) {
            $relativePath = str_replace($rootThemeDir.DIRECTORY_SEPARATOR, '', $file->getPathname());

            // Skip root index.html — local-preview only; the whole file is saved to database.
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
            'html_content' => $processedHtmlContent,
            'zip_path' => "uploaded:{$presetSlug}",
        ];
    }

    /**
     * Rewrite relative asset paths in index.html to point to public screen-presets directory.
     */
    private function rewriteAssetPaths(string $html, string $presetSlug): string
    {
        // Replace href="..."
        $html = preg_replace_callback('/href="([^"]+)"/i', function ($matches) use ($presetSlug) {
            return $this->processPath('href', $matches[1], $presetSlug);
        }, $html);

        // Replace src="..."
        $html = preg_replace_callback('/src="([^"]+)"/i', function ($matches) use ($presetSlug) {
            return $this->processPath('src', $matches[1], $presetSlug);
        }, $html);

        // Rewrite inline style url() references
        $html = preg_replace_callback(
            '/url\(\s*["\']?([^"\')\s]+)["\']?\s*\)/i',
            function (array $matches) use ($presetSlug) {
                $path = $matches[1];

                if (preg_match('/^(https?:\/\/|\/\/|data:|#)/i', $path) || str_contains($path, '{{') || str_contains($path, '%7B%7B')) {
                    return $matches[0];
                }

                $normalized = $this->normalizePath($path);

                return "url('{{ asset(\"screen-presets/{$presetSlug}/{$normalized}\") }}')";
            },
            $html
        );

        // Remove Blade escaping if the user already wrote {{ ... }} manually
        $html = str_replace(['%7B%7B', '%7D%7D'], ['{{', '}}'], $html);

        return $html;
    }

    /**
     * Process path for href/src rewriting to asset() calls.
     */
    private function processPath(string $attribute, string $path, string $presetSlug): string
    {
        // Ignore absolute URLs, data URIs, mailto, tel, anchor links, and already-templated segments
        if (
            preg_match('/^(http|https|\/\/|data:|mailto:|tel:|#)/i', $path) ||
            str_contains($path, '{{') ||
            str_contains($path, '%7B%7B')
        ) {
            return "{$attribute}=\"{$path}\"";
        }

        $cleanPath = $this->normalizePath($path);

        return "{$attribute}=\"{{ asset('screen-presets/{$presetSlug}/{$cleanPath}') }}\"";
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
