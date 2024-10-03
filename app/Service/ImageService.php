<?php

namespace App\Service;

use Exception;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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


    /**
     * @param string Takes in image path name as 'user-#/user-image.ext'.
     * Attempts to delete image from directory.
     * @return bool Returns true if the file is successfully deleted. Returns false if the file is still present in the directory.
     */

    public function deleteFileAtPath($publicPath){

        $filePath = storage_path("app/public/{$publicPath}");
        File::delete($filePath);
        if(File::exists($filePath))
        {
            return false;
        }
        return true;

    }

    public function deleteRedundantFilesAtPath($folder, $basename){

        $pattern = storage_path("app/public/{$folder}/{$basename}.*");
        $files = glob($pattern);

        if($files){
            File::delete(File::glob(storage_path("app/public/{$folder}/{$basename}*.*")));
        }

        //If there are still images of that filename in the directory.
        if(!count($files) === 0){
            return false;
        }

        return true;

    }

    public function deleteRedundantImageRecords($folder, $basename){
        $filenameString = "{$folder}/{$basename}";
        $oldUserImages = Image::where('filename', 'LIKE', "%{$filenameString}%")->get();

        if($oldUserImages){
            foreach ($oldUserImages as $oldUserImage){
                $oldUserImage->delete();
            }

        }

        //If there are still records in the images table with that filename substring.
        if(!count($oldUserImages) === 0){
            return false;
        }

        return true;

    }

}
