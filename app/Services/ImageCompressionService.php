<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageCompressionService
{
    public static function store(UploadedFile $file, string $directory, string $disk = 'public', int $maxDimension = 1600, int $quality = 82): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        if ($extension === 'svg' || ! function_exists('imagecreatefromjpeg')) {
            return $file->store($directory, $disk);
        }

        $source = match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($file->getRealPath()),
            'png' => @imagecreatefrompng($file->getRealPath()),
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($file->getRealPath()) : false,
            'gif' => @imagecreatefromgif($file->getRealPath()),
            default => false,
        };
        if (! $source) return $file->store($directory, $disk);

        $width = imagesx($source); $height = imagesy($source);
        $scale = min(1, $maxDimension / max($width, $height));
        $newWidth = max(1, (int) round($width * $scale));
        $newHeight = max(1, (int) round($height * $scale));
        $canvas = imagecreatetruecolor($newWidth, $newHeight);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);
        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        ob_start(); imagejpeg($canvas, null, $quality); $contents = ob_get_clean();
        $path = trim($directory, '/').'/'.Str::uuid().'.jpg';
        Storage::disk($disk)->put($path, $contents);
        return $path;
    }
}
