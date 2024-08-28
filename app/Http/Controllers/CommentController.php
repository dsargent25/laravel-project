<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CommentController extends Controller
{

    public function index()
    {
            // $comments = Comment::with('chirp')->get();
            // return view('comment.index', ['comments' => $comments]);
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
    // public function store(Request $request)
    // {
    //     // POPULATE THIS ONE
    // }

    public function store(Chirp $chirp)
    {

            Comment::create([
                'user_id' = auth()->user()->id,
            ]);

            $comment = new Comment();
            $comment->chirp_id = $chirp->id;
            $comment->content = request()->get('content');
            $comment->save();

            return redirect()->route('chirps.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        // POPULATE THIS ONE
    }
}
