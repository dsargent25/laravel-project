<?php

namespace App\Service;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{

    public function downloadImageFromUrl($url, $user_id){

        $imageContent = file_get_contents($url);
        if($imageContent === false)
            {
                throw new \Exception("Could not access image from URL.");

            }

        $basename = pathinfo($url)['basename'];

        try{
            Storage::disk('public')->put($basename, $imageContent);
        } catch(\Throwable $e) {
            \Log::info('Image failed to download.');
        }

        $this->createUserImage($basename, $user_id);

    }

    public function createUserImage($basename, $user_id){

        $userDirectory = storage_path("app/public/user-{$user_id}");
        if (!file_exists($userDirectory)) {
            mkdir($userDirectory, 0755, true);
        }

        $newFilepath = storage_path("app/public/user-{$user_id}/{$basename}");
        $oldFilepath = storage_path("app/public/{$basename}");
        $symbolicFilepath = "user-{$user_id}/{$basename}";

        rename($oldFilepath,$newFilepath);

        Image::updateOrCreate(
            ['user_id' => $user_id],
            [
                'filename' => $symbolicFilepath,
                'image_role' => 'profile'
            ]
        );
    }

}
