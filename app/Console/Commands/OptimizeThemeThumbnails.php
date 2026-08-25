<?php

namespace App\Console\Commands;

use App\Models\Theme;
use App\Services\ImageCompressionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class OptimizeThemeThumbnails extends Command
{
    protected $signature = 'themes:optimize-thumbnails
                            {--dry-run : List thumbnails that would be optimized without changing files or database records}';

    protected $description = 'Convert existing theme thumbnails to optimized WebP files without requiring another upload';

    public function handle(ImageCompressionService $compressor): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $optimized = 0;
        $skipped = 0;
        $failed = 0;

        Theme::query()
            ->select(['id', 'name', 'thumbnail_portrait'])
            ->whereNotNull('thumbnail_portrait')
            ->orderBy('id')
            ->chunkById(100, function ($themes) use ($compressor, $dryRun, &$optimized, &$skipped, &$failed): void {
                foreach ($themes as $theme) {
                    $sourcePath = Str::ltrim($theme->thumbnail_portrait, '/');

                    if (Str::lower(pathinfo($sourcePath, PATHINFO_EXTENSION)) === 'webp') {
                        $skipped++;

                        continue;
                    }

                    if (Str::startsWith($sourcePath, 'images/')) {
                        $skipped++;

                        continue;
                    }

                    if (! Storage::disk('public')->exists($sourcePath)) {
                        $skipped++;
                        $this->line("Lewati {$theme->name}: file bukan thumbnail storage atau tidak ditemukan.");

                        continue;
                    }

                    if ($dryRun) {
                        $optimized++;
                        $this->line("Akan dioptimalkan: {$theme->name} ({$sourcePath})");

                        continue;
                    }

                    try {
                        $optimizedPath = $compressor->compressStoredThumbnail($sourcePath);

                        try {
                            $theme->update(['thumbnail_portrait' => $optimizedPath]);
                        } catch (Throwable $exception) {
                            Storage::disk('public')->delete($optimizedPath);

                            throw $exception;
                        }

                        $optimized++;
                        $this->info("Dioptimalkan: {$theme->name} → {$optimizedPath}");
                    } catch (Throwable $exception) {
                        $failed++;
                        report($exception);
                        $this->error("Gagal mengoptimalkan {$theme->name}: {$exception->getMessage()}");
                    }
                }
            });

        $mode = $dryRun ? 'Dry-run selesai' : 'Optimasi selesai';
        $this->newLine();
        $this->info("{$mode}. Diproses: {$optimized}; dilewati: {$skipped}; gagal: {$failed}.");

        return $failed === 0 ? self::SUCCESS : self::FAILURE;
    }
}
