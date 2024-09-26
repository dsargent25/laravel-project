<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Service\ImageService;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, ImageService $imageService): RedirectResponse
    {

            try{

                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                    'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                ]);

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                event(new Registered($user));

                if($request->profile_image && $request->profile_image->extension()){

                $extension = $request->profile_image->extension();
                $filename = "profile-image" . '.' . $extension;
                $folder = "user-{$user->id}";
                $path = $folder . '/' . $filename;
                $fileContents = $request->profile_image->get();
                $path = $request->file('profile_image')->storeAs($folder, $filename, 'public');

                if(!Storage::disk('public')->put($path, $fileContents))
                {
                    throw new Exception('Image upload failed.');

                }

                $imageService->addUserImageRecord($user->id, $path);

                }

                Auth::login($user);

                return redirect(route('dashboard', absolute: false));

            } catch(Exception $e) {

                \Log::info($e->getMessage());
                return redirect()->back()->withErrors(['generic' => $e->getMessage()]);

            }

    }


}
