<?php

namespace App\Service;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{

    public function downloadImageFromUrl($url, $filename, $folder){

        $success = false;

        $imageContent = file_get_contents($url);

        $extension = pathinfo($url, PATHINFO_EXTENSION);

        if($imageContent === false)
        {
            throw new \Exception("Could not access image from URL.");
        }

        if(!Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder, 0775, true);
        }

        $path = $folder . '/' . $filename . '.' . $extension;

        try{
            $success = Storage::disk('public')->put($path, $imageContent);
        } catch(\Throwable $e) {
            \Log::info('Image failed to download.');
        }

        if($success) {
            return $path;
        } else {
            return false;
        }
    }

    public function addUserImageRecord($user_id, $path){
        Image::updateOrCreate(
            ['user_id' => $user_id],
            [
                'filename' => $path,
                'image_role' => 'profile'
            ]
        );
    }

}
