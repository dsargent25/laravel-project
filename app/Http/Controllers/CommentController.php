<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CommentController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
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


    public function show(Comment $comment)
    {
        //
    }


    public function edit(Comment $comment)
    {
        //
    }


    public function update(Request $request, Comment $comment)
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
