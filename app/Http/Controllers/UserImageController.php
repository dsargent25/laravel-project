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
                'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
            ]);

            if($request->user_image && $request->user_image->extension()){

                $extension = $request->user_image->extension();
                $filename = "user-image" . '.' . $extension;
                $folder = 'user-' . Auth::user()->id;
                $path = $folder . '/' . $filename;
                $fileContents = $request->user_image->get();
                $path = $request->file('user_image')->storeAs($folder, $filename, 'public');

                if(!Storage::disk('public')->put($path, $fileContents))
                {
                    throw new Exception('User image upload failed.');

                }

                $imageService->addImageRecord($path);

            }

            return redirect(route('/profile', absolute: false));

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
