<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FileUploadService
{
    public function uploadFile(UploadedFile $file, string $folder = 'uploads')
    {
        try {
            $result = Cloudinary::upload($file->getRealPath(), [
                'folder' => $folder,
            ]);

            return [
                'success' => true,
                'url' => $result->getSecurePath(),
                'public_id' => $result->getPublicId(),
            ];
        } catch (\Exception $e) {
            Log::error('File upload failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'File upload failed: ' . $e->getMessage(),
            ];
        }
    }
}
