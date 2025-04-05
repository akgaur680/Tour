<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class ImageHelper
{
    /**
     * Store an uploaded image in a specific directory and return the file path.
     */
    public static function storeImage($file, $folder)
    {
        if (!$file instanceof UploadedFile) {
            throw new \Exception("Invalid file instance");
        }
    
        $path = "public/{$folder}";
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0775, true);
        }
    
        $userId = Auth::id() ?? 'guest'; // fallback if no user is logged in
        $timestamp = Carbon::now()->format('Ymd_His'); // e.g., 20250405_131045
        $extension = $file->getClientOriginalExtension();
        $fileName = "{$folder}_{$userId}_{$timestamp}." . $extension;
    
        $storedPath = $file->storeAs($folder, $fileName, 'public'); // store with custom name
    
        return $storedPath; // returns: folder/filename.ext
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
            self::deleteImage($oldFilePath); // Delete the old image
            return self::storeImage($file, $folder); // Store new image
        }

        return $oldFilePath; // Return the old file path if no new file is provided
    }
}
