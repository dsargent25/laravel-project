<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Service\ImageService;

class UserImageController extends Controller
{

    public function store(Request $request, ImageService $imageService): RedirectResponse
    {
        try{

            $request->validate([
                'user_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
            ]);

            if($request->user_image && $request->user_image->extension()){

                $user = Auth::user();
                // This is only needed for IDE (Don't freak out)
                $user = User::find($user->id);

                $folder = $imageService->getUserFolder($user);
                $uploadedFile = $request->user_image;
                $extension = $uploadedFile->extension();
                $filename = 'user-image' . '.' . $extension;

                //remove user
                $image = $imageService->uploadImage($uploadedFile, $folder, $filename);
                $user->images()->sync([$image->id]);


            }

            return redirect(route('profile.edit', absolute: false));

        } catch(Exception $e) {

            \Log::info($e->getMessage());
            return redirect()->back()->withErrors(['user_image' => $e->getMessage()]);

        }

    }


    public function destroy(ImageService $imageService): RedirectResponse
    {
        try{

            $userImage = Auth::user()->images->first();

            if (!$userImage) {
                throw new \Exception("There is no image to delete.");
            }

            $userImageFileDeleteStatus = $imageService->deleteFileAtPath($userImage->filename);

            if ($userImageFileDeleteStatus === false){
                throw new \Exception("There is still a user-image in the user's image directory after attempting to delete.");
            }

            $userImage->delete();

            return redirect(route('profile.edit', absolute: false));

        } catch(\Throwable $e) {

            \Log::info($e->getMessage());
            return redirect()->back()->withErrors(['user_image_delete' => $e->getMessage()]);

        }

    }
}
