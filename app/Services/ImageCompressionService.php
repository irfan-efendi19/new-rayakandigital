<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ImageCompressionService
{
    private const MAX_WIDTH = 1200;

    private const MAX_FILE_SIZE = 1048576;

    private const INITIAL_QUALITY = 85;

    private const MIN_QUALITY = 30;

    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function compress(UploadedFile $file, string $directory, string $disk = 'public'): string
    {
        $image = $this->manager->decodeBinary(file_get_contents($file->getRealPath()));

        if ($image->width() > self::MAX_WIDTH) {
            $image->scale(width: self::MAX_WIDTH);
        }

        $quality = self::INITIAL_QUALITY;
        $filename = uniqid() . '.webp';
        $tempPath = sys_get_temp_dir() . '/' . $filename;

        do {
            $encoded = $image->encode(new WebpEncoder($quality));
            $encoded->save($tempPath);
            $fileSize = filesize($tempPath);
            if ($fileSize <= self::MAX_FILE_SIZE) {
                break;
            }
            $quality -= 5;
        } while ($quality >= self::MIN_QUALITY);

        $storedPath = Storage::disk($disk)->putFileAs($directory, new UploadedFile($tempPath, $filename, 'image/webp', null, true), $filename);

        @unlink($tempPath);

        return $storedPath;
    }
}
