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

        //If the image isn't a valid one.
        if($request->chirp_image && exif_imagetype($request->chirp_image) === false){
            throw new \Exception("The image is not valid.");
        }

        //Submit the chirp without the image first (so I can get the Chirp ID)
        $submittedChirp = $request->user()->chirps()->create($validated);

        //If the chirp wasn't created.
        if(!$submittedChirp){
            throw new \Exception("The chirp couldn't be submitted.");
        }

        //If there is an image do this, otherwise continue the text chirp.
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
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete', $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'));
    }

}
