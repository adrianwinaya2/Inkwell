<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with('comments', 'likes')->get();
        return response()->json([
            'posts' => $posts
        ]);
    }

    // CRUD
    public function create_post(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'caption' => 'required|string|max:255',
        ]);

        // Create the post
        $post = new Post();
        $post->user_id = auth()->user()->id;
        $post->image = '-';
        $post->caption = $request->input('caption');
        $post->save();

        // Store the image in storage/app/public/images directory
        $image = $validated['image'];
        $filename = $post->id . '_' . $image->getClientOriginalExtension();
        $path = $file->storeAs('public/images', $filename);

        // Update the post's image
        $post->image = $path;
        $post->save();

        // Redirect the user to the post view page
        // return redirect()->route('post.view', [
        //     'id' => $post->id
        // ]);
        return response()->json([
            'message' => 'Post ' . $post->id . ' created successfully'
        ]);
    }

    public function get_post(Request $request, $id)
    {
        $post = Post::find($id)->with('comments', 'likes')->first();

        // Return the post view page
        // return view('post.post', [
        //     'post' => $post,
        // ]);
        return response()->json([
            'post' => $post
        ]);
    }

    public function update_post(Request $request, $id)
    {
        $post = Post::find($id);

        if (auth()->user()->id != $post->poster->id) {
            // return redirect()->back()->with('error', 'You are not authorized to update this post');
            return response()->json([
                'error' => 'You are not authorized to update this post'
            ]);
        }

        // Validate the input
        $validated = $request->validate([
            'caption' => 'required|string|max:255',
        ]);

        // Store the image in storage/app/public/posts directory
        $image = $request->file('image')->store('public/posts');

        // Update the post
        $post->caption = $request->input('caption');
        $post->save();

        // Redirect the user to the post view page
        // return redirect()->route('post.view', [
        //     'id' => $post->id
        // ]);
        return response()->json([
            'message' => 'Post ' . $post->id . ' updated successfully'
        ]);
    }

    public function delete_post(Request $request, $id)
    {
        $post = Post::find($id);

        if (auth()->user()->id != $post->poster->id) {
            // return redirect()->back()->with('error', 'You are not authorized to delete this post');
            return response()->json([
                'error' => 'You are not authorized to delete this post'
            ]);
        }

        $post->delete();

        // return redirect()->route('post.all_post');
        return response()->json([
            'message' => 'Post ' . $post->id . ' deleted successfully'
        ]);
    }

    // Comment
    public function comment(Request $request, $post_id)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $post_id;
        $comment->comment = $request->input('comment');
        $comment->save();

        // return redirect()->back();
        return response()->json([
            'message' => 'Post ' . $comment->post_id . ' commented successfully'
        ]);
    }

    // Like
    public function like(Request $request, $post_id)
    {
        if ($Like::where('user_id', auth()->user()->id)->where('post_id', $post_id)->first()) {
            return response()->json([
                'error' => 'You have liked this post'
            ]);
        }
        
        $like = new Like();
        $like->user_id = auth()->user()->id;
        $like->post_id = $post_id;
        $like->save();

        // return redirect()->back();
        return response()->json([
            'message' => 'Post ' . $$like->post_id . ' liked successfully'
        ]);
    }

    // Unlike
    public function unlike(Request $request, $post_id)
    {
        $like = Like::where('user_id', auth()->user()->id)->where('post_id', $post_id)->first();

        if (!$like) {
            return response()->json([
                'error' => 'You have not liked this post'
            ]);
        }

        $like->delete();

        // return redirect()->back();
        return response()->json([
            'message' => 'Post ' . $like->post_id . ' unliked successfully'
        ]);
    }
}