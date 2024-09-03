<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Chirp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;


class CommentController extends Controller
{

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


    public function destroy(Comment $comment): RedirectResponse
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return redirect(route('chirps.index'));
    }
}