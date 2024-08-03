<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait StoreVideoTrait
{
    public static function store($video, $location): string
    {
        // Ensure $video is an UploadedFile instance
        if (!$video instanceof UploadedFile) {
            throw new \InvalidArgumentException('Invalid file provided');
        }

        // Open a stream to the uploaded file
        $stream = fopen($video->path(), 'r');

        if (!$stream) {
            throw new \RuntimeException('Failed to open stream');
        }

        // Generate a unique filename
        $fileNameToStore = time() . '_' . uniqid() . '.' . $video->extension();

        // Store the file stream to storage
        Storage::disk('public')->put($location . '/' . $fileNameToStore, $stream);

        // Close the stream
        fclose($stream);

        // Return the URL to the stored file
        return Storage::url($location . '/' . $fileNameToStore);
    }
}
