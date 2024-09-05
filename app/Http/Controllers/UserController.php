<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chirp;
use Illuminate\Http\Request;
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

}
