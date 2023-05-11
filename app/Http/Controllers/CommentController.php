<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return response()->json([
            'comments' => $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $post_id)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->commenter_id = auth()->user()->id;
        $comment->post_id = $post_id;
        $comment->content = $validated['comment'];
        $comment->save();
        
        return response()->json([
            // 'message' => 'Comment with ID ' . $comment->id . ' created successfully',
            'comment' => "test"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $post_id)
    {
        $comment = Comment::with('commenter')->where('post_id', $post_id)->get();
        return response()->json([
            'comments' => $comment
        ]);
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
        //
    }
}
