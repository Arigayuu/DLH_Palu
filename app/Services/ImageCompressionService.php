<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageCompressionService
{
    public function compressAndStore(UploadedFile $file, string $directory = 'laporan'): string
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->decode($file->getRealPath());

        $image->scaleDown(width: 1200, height: 1200);

        $quality = 80;
        $encoded = $image->encode(new JpegEncoder($quality));

        while (strlen((string) $encoded) > 500 * 1024 && $quality > 20) {
            $quality -= 10;
            $encoded = $image->encode(new JpegEncoder($quality));
        }

        $filename = Str::uuid() . '.jpg';
        $path = $directory . '/' . $filename;
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }
}
