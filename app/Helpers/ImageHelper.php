<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Store an uploaded image in a specific directory and return the file path.
     */
    public static function storeImage($file, $folder)
    {
        $path = "public/{$folder}";

        // Ensure directory exists before storing image
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0775, true); // Create directory with permissions
        }

        return $file ? $file->store($folder, 'public') : null;
    }

    /**
     * Get the full URL of an image.
     */
    public static function getImageUrl($filePath)
    {
        return $filePath ? Storage::url($filePath) : null;
    }

    /**
     * Delete an existing image.
     */
    public static function deleteImage($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }

    /**
     * Update an image: delete old image and store new one.
     */
    public static function updateImage($file, $oldFilePath, $folder)
    {
        if ($file) {
            self::deleteImage($oldFilePath); // Delete old image
            return self::storeImage($file, $folder); // Store new image
        }
        return $oldFilePath; // If no new file, keep the old one
    }
}
