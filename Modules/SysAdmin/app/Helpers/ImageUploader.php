<?php

namespace Modules\SysAdmin\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use InvalidArgumentException;

class ImageUploader
{
    const DIR = BASE_ROOT_PATH . '/uploads/';
    const URL =   '/uploads/';
    const DISK = 'uploads';
    public static array $extensions = ['jpg', 'jpeg', 'gif', 'png', 'pdf'];

    public static function upload($file, string $date = null, $thumbnail = true): string
    {
        if ($date == null) {
            $yearMonth = now()->format('Y/m');
        } else {
            $yearMonth = date('Y/m', strtotime($date));
        }

        $folderPath = self::DIR . $yearMonth;


        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Validate file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, self::$extensions)) {
            throw new InvalidArgumentException('Invalid file type.');
        }

        // Generate unique filename
        $filename = Str::random(32) . '.' . $extension;

        // Save the image
        $image = Image::read($file);
        $image->save($folderPath . "/" . $filename, 100); // Adjust quality as needed

        if ($thumbnail == true) {
            $thumbnailPath = self::DIR . $yearMonth . '/thumbnail';
            if (!is_dir($thumbnailPath)) {
                mkdir($thumbnailPath, 0777, true);
            }

            $thumbnailPath = $thumbnailPath . "/" . $filename;
            $image->resize(250, 250)->save($thumbnailPath, 100);
        }

        // Return the stored filename
        return $filename;
    }

    public static function uploadFile($file, string $date = null, $thumbnail = true): string
    {
        if ($date == null) {
            $yearMonth = now()->format('Y/m');
        } else {
            $yearMonth = date('Y/m', strtotime($date));
        }
        $folderPath = self::DIR . $yearMonth;
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        // Validate file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, self::$extensions)) {
            throw new InvalidArgumentException('Invalid file type.');
        }
        // Generate unique filename
        $filename = Str::random(32) . '.' . $extension;
        // Save the file
        $file->move($folderPath, $filename);
        // Return the stored filename
        return $filename;
    }

    public static function getFilePath(string $filename = null, $date = null, string $type = null): string
    {
        if (empty($filename)) {
            return asset('uploads/default.jpg');
        }

        // Decide timestamp
        $timestamp = null;
        if (is_numeric($date)) {
            $timestamp = (int) $date;
        } elseif (!empty($date)) {
            $timestamp = strtotime($date);
        }

        //dd($date);

        if ($timestamp && $timestamp > 0) {
            $yearMonth = date('Y/m', $timestamp);

            $relative = $type
                ? $yearMonth . '/' . $type . '/' . $filename
                : $yearMonth . '/' . $filename;

            $disk = Storage::disk(self::DISK);

            if ($disk->exists($relative)) {
                return $disk->url($relative); // → APP_URL/uploads/2025/11/...
            }
        }

        return asset('uploads/default.jpg');
    }


    public static function getFileRootPath(string $filename, string $date, string $type = null): string
    {
        $yearMonth = date('Y/m', strtotime($date));
        if ($type !== null) {
            $file = $yearMonth . '/' . $type . '/' . $filename;
        } else {
            $file = $yearMonth . '/' . $filename;
        }
        //dd(Storage::disk('uploads')->path($file));
        if (file_exists(Storage::disk('uploads')->path($file))) {
            return BASE_ROOT_PATH . self::URL . $yearMonth . '/' . $filename;
        }
        return  BASE_ROOT_PATH . '/uploads/default.jpg';
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
        if (!$timestamp || $timestamp <= 0) {
            return false;
        }

        $yearMonth = date('Y/m', $timestamp);

        $thumb = $yearMonth . '/thumbnail/' . $filename;
        $file  = $yearMonth . '/' . $filename;

        $disk = Storage::disk('uploads');

        if ($disk->exists($file)) {
            $disk->delete($file);
        }

        if ($disk->exists($thumb)) {
            $disk->delete($thumb);
        }

        return true;
    }
}
