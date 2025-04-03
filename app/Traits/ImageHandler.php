<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait ImageHandler
{
    /**
     * Handle image upload and return the image path.
     *
     * @param  \Illuminate\Http\UploadedFile  $image
     * @param  string  $folder
     * @return string
     */
    public function handleImageUpload($image, $folder = 'uploads')
    {
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path($folder), $filename);
        return $folder . '/' . $filename;
    }

    /**
     * Delete an image from the storage.
     *
     * @param  string  $imagePath
     * @return void
     */
    public function deleteImage($imagePath)
    {
        if (File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }
    }
}
