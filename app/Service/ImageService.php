<?php

namespace App\Service;

use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Exception;

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


    //This is only used by CopyProfileImageUrls
    public function addUserImageRecord($user_id, $path){
        Image::updateOrCreate(
            [
                'filename' => $path,
                'user_id' => $user_id
            ]
        );
    }


    public function uploadImage($uploadedFile, $folder, $filename){

        if(!$uploadedFile->storeAs($folder, $filename, 'public'))
        {
            throw new \Exception('User image upload failed.');
        }

        $image = Image::updateOrCreate([
            'filename' => $folder . '/' . $filename,
        ]);

        return $image;

    }

    public function getUserFolder($user){
        $folderName = 'user-' . $user->id;
        return  $folderName;
    }

    public function convertOldProfileImagesToNew($image){

        try{

            $user = User::find($image->user_id);

            if($user->images()){
                $user->images()->detach($image);
            }

            $user->images()->attach($image);

            $pattern = '/profile/i';

            if (!$image->filename){
                throw new \Exception("There is no filename in the image record.");
            }

            $wrongNameExceptionString = "{$image->filename} already follows the new naming scheme or is wrong.";

            if(!preg_match($pattern, $image->filename)){
                throw new \Exception($wrongNameExceptionString);
            }

            $newFilename = preg_replace($pattern,'user', $image->filename);

            if(!rename(storage_path("app/public/{$image->filename}"), storage_path("app/public/{$newFilename}"))){
                throw new \Exception($wrongNameExceptionString);
            }

            Image::where('user_id', $image->user_id)->update(['filename' => $newFilename]);

        } catch(\Throwable $e) {
            \Log::info($e->getMessage());
            echo $e->getMessage() . PHP_EOL;
            return false;
        }

        return true;

    }

}
