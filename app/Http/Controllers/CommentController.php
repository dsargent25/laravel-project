<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Response;


class CommentController extends Controller
{

    public function store(Request $request, Chirp $chirp)
    {

        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'chirp_id' => $chirp->id,
            'content' => request()->get('content')
        ]);

        return Response::json([
            'comment' => $comment
        ], 200);

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
