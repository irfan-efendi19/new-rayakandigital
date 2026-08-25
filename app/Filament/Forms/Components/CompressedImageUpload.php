<?php

namespace App\Filament\Forms\Components;

use App\Services\ImageCompressionService;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\FileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CompressedImageUpload extends FileUpload
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->image()
            ->acceptedFileTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
            ])
            ->maxSize(10240)
            ->saveUploadedFileUsing(static function (
                BaseFileUpload $component,
                TemporaryUploadedFile $file,
                ImageCompressionService $compressor,
            ): string {
                return $compressor->compress(
                    $file,
                    $component->getDirectory() ?? '',
                    $component->getDiskName(),
                );
            });
    }
}
