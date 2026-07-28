<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ScreenPresetUploaderService
{
    /**
     * Deploy a ZIP template to storage/app/public/screen-templates/{slug}/.
     *
     * Per PRD §1.1 & §2: berkas diekstrak ke Storage public agar Nginx dapat
     * melayaninya langsung tanpa melewati PHP (PRD §4). Runtime parser di
     * ScreenDisplayController yang bertugas mengganti path relatif → URL absolut.
     *
     * @return array{storage_path: string, zip_path: string}
     *
     * @throws Exception
     */
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

        // Direktori tujuan di storage public (PRD §1.1)
        $storagePath = "screen-templates/{$presetSlug}";
        $fullStoragePath = Storage::disk('public')->path($storagePath);

        // Hapus folder lama jika ada, lalu buat ulang
        if (Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->deleteDirectory($storagePath);
        }
        File::makeDirectory($fullStoragePath, 0755, true, true);

        // Salin seluruh isi template ke storage (termasuk index.html)
        $files = File::allFiles($rootThemeDir);
        foreach ($files as $file) {
            $relativePath = str_replace($rootThemeDir.DIRECTORY_SEPARATOR, '', $file->getPathname());
            // Normalisasi separator untuk Storage
            $relativePath = str_replace('\\', '/', $relativePath);

            $targetPath = $fullStoragePath.DIRECTORY_SEPARATOR.$relativePath;
            File::makeDirectory(dirname($targetPath), 0755, true, true);
            File::copy($file->getPathname(), $targetPath);
        }

        // Bersihkan file temp dan ZIP upload sementara
        File::deleteDirectory($tempExtractDir);
        Storage::disk('public')->delete($zipFilePath);

        return [
            'storage_path' => $storagePath,
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
}
