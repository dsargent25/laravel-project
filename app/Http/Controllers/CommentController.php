<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Chirp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class CommentController extends Controller
{


    public function create(Chirp $chirp)
    {
        //
    }

    public function store(Chirp $chirp)
    {
        Comment::create([
            'user_id' => Auth::user()->id,
            'chirp_id' => $chirp->id,
            'content' => request()->get('content')
        ]);

        return redirect(route('chirps.index'));
    }


    public function update()
    {
        //
    }


    public function destroy()
    {
        //
    }
}