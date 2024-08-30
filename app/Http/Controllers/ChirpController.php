<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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

    public function show(Chirp $chirp)
    {
     //   
    }


    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
		'message' => 'required|string|max:255',
	]);

	$request->user()->chirps()->create($validated);

    $userid = Auth::user()->id;
    $users = User::find($userid);
    $users->increment('chirp_count', 1 );

	return redirect(route('chirps.index'));
    }

    public function latest(Chirp $chirp): View
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

        $userid = Auth::user()->id;
        $users = User::find($userid);
        $users->decrement('chirp_count', 1 );

        return redirect(route('chirps.index'));
    }

}
