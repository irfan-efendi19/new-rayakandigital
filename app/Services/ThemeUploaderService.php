<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ThemeUploaderService
{
    /**
     * Extracts a theme ZIP file securely and deploys it.
     *
     * @param string $zipFilePath Path to the uploaded zip in storage
     * @param string $themeName Name of the theme to act as folder identifier
     * @return string The generated view path (e.g. themes.custom.my_theme)
     * @throws Exception
     */
    public function deploy(string $zipFilePath, string $themeName): string
    {
        $themeSlug = Str::slug($themeName);
        $fullZipPath = Storage::disk('public')->path($zipFilePath);
        
        $tempExtractDir = storage_path('app/temp_theme_extract_' . uniqid());
        
        $zip = new ZipArchive;
        if ($zip->open($fullZipPath) !== true) {
            throw new Exception("Could not open ZIP file.");
        }

        // 1. Security Scan
        $hasIndexHtml = false;
        $blockedExtensions = ['php', 'phtml', 'php3', 'php4', 'php5', 'phps', 'exe', 'sh', 'bat'];
        
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $blockedExtensions)) {
                $zip->close();
                throw new Exception("Security Error: Blocked file extension detected -> {$filename}");
            }
            
            if (basename($filename) === 'index.html') {
                $hasIndexHtml = true;
            }
        }

        if (!$hasIndexHtml) {
            $zip->close();
            throw new Exception("Invalid Theme: Missing index.html in the root folder.");
        }

        // 2. Extract to temp dir
        File::makeDirectory($tempExtractDir, 0755, true, true);
        $zip->extractTo($tempExtractDir);
        $zip->close();

        // 3. Find the actual directory containing index.html (in case it was zipped inside a wrapper folder)
        $rootThemeDir = $this->findRootDirectory($tempExtractDir);

        // 4. Process index.html to index.blade.php
        $indexPath = $rootThemeDir . '/index.html';
        $htmlContent = File::get($indexPath);
        
        // Rewrite asset paths
        $htmlContent = $this->rewriteAssetPaths($htmlContent, "themes/custom/{$themeSlug}");
        
        $viewsDir = resource_path("views/themes/custom");
        File::makeDirectory($viewsDir, 0755, true, true);
        $bladePath = $viewsDir . "/{$themeSlug}.blade.php";
        
        File::put($bladePath, $htmlContent);

        // 5. Move Assets (everything except index.html) to public directory
        $publicAssetsDir = public_path("themes/custom/{$themeSlug}");
        File::deleteDirectory($publicAssetsDir); // Clean if exists
        File::makeDirectory($publicAssetsDir, 0755, true, true);
        
        $filesAndDirs = File::allFiles($rootThemeDir);
        foreach ($filesAndDirs as $file) {
            if ($file->getFilename() === 'index.html') {
                continue;
            }
            
            $relativePath = str_replace($rootThemeDir . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $targetPath = $publicAssetsDir . DIRECTORY_SEPARATOR . $relativePath;
            
            File::makeDirectory(dirname($targetPath), 0755, true, true);
            File::copy($file->getPathname(), $targetPath);
        }

        // 6. Cleanup temp folder and zip
        File::deleteDirectory($tempExtractDir);
        Storage::disk('public')->delete($zipFilePath);

        return "themes.custom.{$themeSlug}";
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

        throw new Exception("Could not locate index.html inside the extracted folder structure.");
    }

    private function rewriteAssetPaths(string $html, string $assetPrefix): string
    {
        // Replace href="..."
        $html = preg_replace_callback('/href="([^"]+)"/i', function ($matches) use ($assetPrefix) {
            return $this->processPath('href', $matches[1], $assetPrefix);
        }, $html);

        // Replace src="..."
        $html = preg_replace_callback('/src="([^"]+)"/i', function ($matches) use ($assetPrefix) {
            return $this->processPath('src', $matches[1], $assetPrefix);
        }, $html);

        // Remove Blade escaping if the user already wrote {{ ... }} manually 
        // Sometimes an HTML editor escapes brackets like %7B%7B or &amp;
        $html = str_replace(['%7B%7B', '%7D%7D'], ['{{', '}}'], $html);

        return $html;
    }

    private function processPath(string $attribute, string $path, string $assetPrefix): string
    {
        // Ignore absolute URLs (http, https, //), data URIs, mailto, tel, anchor links (#)
        if (
            preg_match('/^(http|https|\/\/|data:|mailto:|tel:|#)/i', $path) || 
            str_contains($path, '{{') || // Already a blade directive
            str_contains($path, '%7B%7B') // URL-encoded blade directive (decoded after asset rewrite)
        ) {
            return "{$attribute}=\"{$path}\"";
        }

        // Clean leading slashes or dots
        $cleanPath = ltrim($path, './');
        
        return "{$attribute}=\"{{ asset('{$assetPrefix}/{$cleanPath}') }}\"";
    }
}
