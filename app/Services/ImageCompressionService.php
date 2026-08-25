<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use InvalidArgumentException;
use RuntimeException;

class ImageCompressionService
{
    private const MAX_WIDTH = 1200;

    private const MAX_FILE_SIZE = 1048576;

    private const INITIAL_QUALITY = 85;

    private const MIN_QUALITY = 30;

    private const THUMBNAIL_MAX_WIDTH = 640;

    private const THUMBNAIL_MAX_FILE_SIZE = 262144;

    private const THUMBNAIL_INITIAL_QUALITY = 82;

    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver);
    }

    public function compress(UploadedFile $file, string $directory, string $disk = 'public'): string
    {
        $image = $this->manager->decodeBinary(file_get_contents($file->getRealPath()));

        if ($image->width() > self::MAX_WIDTH) {
            $image->scale(width: self::MAX_WIDTH);
        }

        $quality = self::INITIAL_QUALITY;
        $filename = uniqid().'.webp';
        $tempPath = sys_get_temp_dir().'/'.$filename;

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

    public function compressStoredThumbnail(string $sourcePath, string $disk = 'public'): string
    {
        $storage = Storage::disk($disk);
        $sourcePath = Str::ltrim($sourcePath, '/');
        $contents = $storage->get($sourcePath);
        $mimeType = (new \finfo(FILEINFO_MIME_TYPE))->buffer($contents);

        if (! in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            throw new InvalidArgumentException("Unsupported thumbnail type: {$mimeType}");
        }

        $image = $this->manager->decodeBinary($contents);

        if ($image->width() > self::THUMBNAIL_MAX_WIDTH) {
            $image->scale(width: self::THUMBNAIL_MAX_WIDTH);
        }

        $quality = self::THUMBNAIL_INITIAL_QUALITY;

        do {
            $encoded = $image->encode(new WebpEncoder($quality));

            if (strlen((string) $encoded) <= self::THUMBNAIL_MAX_FILE_SIZE) {
                break;
            }

            $quality -= 5;
        } while ($quality >= self::MIN_QUALITY);

        $directory = Str::contains($sourcePath, '/') ? Str::beforeLast($sourcePath, '/') : '';
        $basename = Str::slug(pathinfo($sourcePath, PATHINFO_FILENAME)) ?: 'thumbnail';
        $hash = substr(hash('sha256', $contents.'|'.self::THUMBNAIL_MAX_WIDTH), 0, 12);
        $filename = "{$basename}-{$hash}.webp";
        $storedPath = $directory ? "{$directory}/{$filename}" : $filename;

        if (! $storage->put($storedPath, (string) $encoded, ['visibility' => 'public'])) {
            throw new RuntimeException("Unable to store optimized thumbnail: {$storedPath}");
        }

        return $storedPath;
    }
}
