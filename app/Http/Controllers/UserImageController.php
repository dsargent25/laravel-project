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
    public function index()
    {

    }

    public function store(Request $request, ImageService $imageService): RedirectResponse
    {
        try{

            $request->validate([
                'user_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
            ]);

            if($request->user_image && $request->user_image->extension()){

                $extension = $request->user_image->extension();
                $filename = "user-image" . '.' . $extension;
                $folder = 'user-' . Auth::user()->id;
                $path = $folder . '/' . $filename;

                if(!$request->file('user_image')->storeAs($folder, $filename, 'public'))
                {
                    throw new Exception('User image upload failed.');

                }

                $imageService->addImageRecord($path);

                $user = Auth::user();
                $image = Image::where('filename', $path)->get();

                //If there is already a profile-image associated with the user, detach the existing one.
                if($user->images()){
                    $user->images()->detach($image);
                }

                $user->images()->attach($image);

            }

            return redirect(route('profile.edit', absolute: false));

        } catch(Exception $e) {

            \Log::info($e->getMessage());
            return redirect()->back()->withErrors(['user_image' => $e->getMessage()]);

        }

    }

    public function edit()
    {

    }

    public function update()
    {

    }


    public function destroy()
    {

    }
}
