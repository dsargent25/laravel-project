<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Chirp;
use App\Models\Comment;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Service\ImageService;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('chirps.index',[
	        'chirps' => Chirp::with('user')->latest()->get(),

	]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ImageService $imageService): RedirectResponse

    {

        try{

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        if($request->chirp_image && exif_imagetype($request->chirp_image) === false){
            throw new \Exception("The image is not valid.");
        }

        $submittedChirp = $request->user()->chirps()->create($validated);

        if(!$submittedChirp){
            throw new \Exception("The chirp couldn't be submitted.");
        }

        if($request->chirp_image){

            $uploadedFile = $request->chirp_image;
            $folder = $imageService->getUserFolder($request->user());
            $extension = $uploadedFile->extension();
            $filename = "chirp-{$submittedChirp->id}-image.{$extension}";

            $image = $imageService->uploadImage($uploadedFile, $folder, $filename);

            $submittedChirp->images()->sync([$image->id]);

        }

        return redirect(route('chirps.index'));


        } catch(Exception $e){
            \Log::info($e->getMessage());
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }


    public function latest(): View
    {
        $pastSevenDays = Carbon::now()->subDays(7);
        $chirps = Chirp::latest()->where('created_at', '>', $pastSevenDays)->get();
        return view('chirps.latest', ['chirps' => $chirps]);

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        Gate::authorize('update', $chirp);

        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp, ImageService $imageService): RedirectResponse
    {

        try{

            Gate::authorize('update', $chirp);

            $validated = $request->validate([
                'message' => 'required|string|max:255',
            ]);


            if($request->chirp_image && exif_imagetype($request->chirp_image) === false){
                throw new \Exception("The image is not valid.");
            }

            $chirp->update($validated);

            if(!$chirp){
                throw new \Exception("The chirp could not be updated.");
            }

            if($request->chirp_image){

                $uploadedFile = $request->chirp_image;
                $folder = $imageService->getUserFolder($request->user());
                $extension = $uploadedFile->extension();
                $basename = "chirp-{$chirp->id}-image";
                $filename = $basename . '.' . $extension;

                //Checks if there is an old image record.
                $oldImageRecord = $chirp->images->first();

                if($oldImageRecord){

                    //Deletes Last File in Dir for Chirp Image
                    if($imageService->deleteFileAtPath($oldImageRecord->filename) === false){
                        throw new Exception("Last chirp image file was not deleted properly.");
                    }

                    //Delete Last Image Record For Chirp Image
                    if($imageService->deleteImageRecord($oldImageRecord) === false){
                        throw new Exception("Last chirp image record was not deleted properly.");
                    }

                }

                $image = $imageService->uploadImage($uploadedFile, $folder, $filename);

                $chirp->images()->sync([$image->id]);


            }

            return redirect(route('chirps.index'));


            } catch(Exception $e){
                \Log::info($e->getMessage());
                return redirect()->back()->withErrors(['message' => $e->getMessage()]);
            }


    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp, ImageService $imageService): RedirectResponse
    {
        try{

        Gate::authorize('delete', $chirp);

        $chirpImage = $chirp->images->first();

        if($chirpImage){

            $chirpImageFileDeleteStatus = $imageService->deleteFileAtPath($chirpImage->filename);

            if ($chirpImageFileDeleteStatus === false){
                throw new \Exception("There is still a chirp-image in the user's image directory after attempting to delete.");
            }

            $chirpImage->delete();

        }

        $chirp->delete();

        return redirect(route('chirps.index'));


        } catch(\Throwable $e) {
            \Log::info($e->getMessage());
            //Find place where the error shows up in view
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);

        }
    }

}
