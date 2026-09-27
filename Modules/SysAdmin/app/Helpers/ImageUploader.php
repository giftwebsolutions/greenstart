<?php

namespace Modules\SysAdmin\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use InvalidArgumentException;

class ImageUploader
{
    const DISK = 'uploads';

    public static array $extensions = ['jpg', 'jpeg', 'gif', 'png', 'webp', 'pdf'];

    public static function upload($file, $date = null, $thumbnail = true): string
    {
        $yearMonth = date('Y/m', self::timestamp($date));

        $folderPath = Storage::disk(self::DISK)->path($yearMonth);

        if (! is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Validate file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (! in_array($extension, self::$extensions)) {
            throw new InvalidArgumentException('Invalid file type.');
        }

        // Generate unique filename
        $filename = Str::random(32).'.'.$extension;

        // Save the image
        // Laravel 13 also registers an `image` container binding, so using the
        // Intervention facade resolves Laravel's manager instead. Instantiate
        // Intervention explicitly to keep uploads independent of that binding.
        $image = (new ImageManager(config('image.driver', Driver::class)))->read($file);
        $image->save($folderPath.'/'.$filename, 100); // Adjust quality as needed

        if ($thumbnail == true) {
            $thumbnailPath = Storage::disk(self::DISK)->path($yearMonth.'/thumbnail');
            if (! is_dir($thumbnailPath)) {
                mkdir($thumbnailPath, 0777, true);
            }

            $thumbnailPath = $thumbnailPath.'/'.$filename;
            $image->resize(250, 250)->save($thumbnailPath, 100);
        }

        // Return the stored filename
        return $filename;
    }

    public static function uploadFile($file, $date = null, $thumbnail = true): string
    {
        $yearMonth = date('Y/m', self::timestamp($date));
        $folderPath = Storage::disk(self::DISK)->path($yearMonth);
        if (! is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        // Validate file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (! in_array($extension, self::$extensions)) {
            throw new InvalidArgumentException('Invalid file type.');
        }
        // Generate unique filename
        $filename = Str::random(32).'.'.$extension;
        // Save the file
        $file->move($folderPath, $filename);

        // Return the stored filename
        return $filename;
    }

    public static function getFilePath(?string $filename = null, $date = null, ?string $type = null): string
    {
        if (empty($filename)) {
            return asset('uploads/default.jpg');
        }

        // Decide timestamp
        $timestamp = null;
        if (is_numeric($date)) {
            $timestamp = (int) $date;
        } elseif (! empty($date)) {
            $timestamp = strtotime($date);
        }

        // dd($date);

        if ($timestamp && $timestamp > 0) {
            $yearMonth = date('Y/m', $timestamp);

            $relative = $type
                ? $yearMonth.'/'.$type.'/'.$filename
                : $yearMonth.'/'.$filename;

            $disk = Storage::disk(self::DISK);

            if ($disk->exists($relative)) {
                return $disk->url($relative); // → APP_URL/uploads/2025/11/...
            }
        }

        return asset('uploads/default.jpg');
    }

    public static function getFileRootPath(string $filename, string $date, ?string $type = null): string
    {
        $yearMonth = date('Y/m', self::timestamp($date));
        if ($type !== null) {
            $file = $yearMonth.'/'.$type.'/'.$filename;
        } else {
            $file = $yearMonth.'/'.$filename;
        }
        if (Storage::disk(self::DISK)->exists($file)) {
            return Storage::disk(self::DISK)->path($file);
        }

        return public_path('uploads/default.jpg');
    }

    public static function remove(string $date, string $filename): bool
    {
        // Handle both: Unix timestamp OR normal date string
        if (is_numeric($date)) {
            $timestamp = (int) $date;
        } else {
            $timestamp = strtotime($date);
        }

        // Fallback: if invalid date, avoid deleting wrong path
        if (! $timestamp || $timestamp <= 0) {
            return false;
        }

        $yearMonth = date('Y/m', $timestamp);

        $thumb = $yearMonth.'/thumbnail/'.$filename;
        $file = $yearMonth.'/'.$filename;

        $disk = Storage::disk('uploads');

        if ($disk->exists($file)) {
            $disk->delete($file);
        }

        if ($disk->exists($thumb)) {
            $disk->delete($thumb);
        }

        return true;
    }

    private static function timestamp($date = null): int
    {
        if ($date instanceof \DateTimeInterface) {
            return $date->getTimestamp();
        }

        if (is_numeric($date)) {
            return (int) $date;
        }

        if (! empty($date)) {
            $timestamp = strtotime((string) $date);

            if ($timestamp !== false) {
                return $timestamp;
            }
        }

        return now()->getTimestamp();
    }
}
