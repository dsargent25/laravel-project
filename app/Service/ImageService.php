<?php

namespace App\Service;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ImageService
{

    public function createFilename($id){
        //Gets the ID and assigns it the name 'user-profile-#'. Returns new filename.
        $filename = "user-profile-{$id}";
        return($filename);
    }

    public function assignImage($destinationPath, $id){
        // Takes the file path and id and creates an image record in the Images table
        Image::updateOrCreate(
            ['user_id' => $id],
            [
                'filename' => $destinationPath,
                'image_role' => 'profile'
            ]
        );
    }

    public function downloadUrls($profileImageUrl, $id){

        //Get the image contents of the profile image url. If there are none, throw error.
        $imageContent = file_get_contents($profileImageUrl);
        if($imageContent === false)
            {
                throw new \Exception("Could not access image from URL.");

            }

        //Get the extension of the profile image url.
        $extension = pathinfo($profileImageUrl)['extension'];

        //Run the createFilename method against the id to create a unique filename. Gets the new filename as $newFilename
        $newFilename = $this->createFilename($id);

        //Combines the new filename with the extension.
        $finalFilename = "{$newFilename}.{$extension}";

        //Uses $finalFilename to construct the full path link. If either the path or data don't exist, throw error.
        $destinationPath = 'profile-images/' . $finalFilename;

        //Tries to store the file into the profile-images folder. If it can't, it logs an error.
        try{
            Storage::disk('public')->put($destinationPath, $imageContent);
        } catch(\Throwable $e) {
            \Log::info('Image failed to download.');
        }

        //Return the file path (to be used in assignImage)
        $this->assignImage($destinationPath, $id);

    }

    public function copyAllUserProfileImageUrls(){

        //Goes and grabs all users and makes an array with id and profile_image_url
        $profileImageUrlWithIds = User::all()->map->only('id', 'profile_image_url')->toArray();

        foreach ($profileImageUrlWithIds as $profileImageUrlWithId) {
            //For this instance, assign the current profile_image_url and id to variables
            $profileImageUrl = $profileImageUrlWithId['profile_image_url'];
            $id = $profileImageUrlWithId['id'];

            //If profile_image_url is not null, run the following. Otherwise go to next record.
            if ($profileImageUrl){

                //Call 'downloadUrls' method to download URLs.
                $this->downloadUrls($profileImageUrl, $id);
            }

        }
    }

}
