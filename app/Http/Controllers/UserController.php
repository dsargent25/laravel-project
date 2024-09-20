<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{

    public function index(): View
    {

        $users = User::withCount('chirps')->latest()->get();
        return view('user.index', ['users' => $users]);

    }

    public function show($name): View
    {
        $user = User::with('chirps')->withCount('chirps')->where('name','=',$name)->first();
        return view('user.show', ['user' => $user]);

    }

    public function follow(User $user, Request $request)
    {
        $follower = Auth::user();
        $follower->follows()->attach($user);
        return back();

    }

    public function unfollow(User $user, Request $request)
    {
        $follower = Auth::user();
        $follower->follows()->detach($user);
        return back();
    }

    public function feed(User $user)
    {
        $user = Auth::user();
        $ids = $user->follows->pluck('id');
        $ids->push($user->id);
        $chirps = Chirp::latest()->whereIn('user_id', $ids)->get();

        return view('dashboard', ['chirps' => $chirps]);
    }

}
