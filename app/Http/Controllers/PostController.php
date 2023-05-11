<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;

class PostController extends Controller
{
    // CRUD
    public function index(Request $request) {
        $posts = Post::with('comments')->get();
        return $posts ? response()->json(['posts' => $posts]) : response()->json(['error' => 'No Post Found']);
    }

    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'caption' => 'required|string|max:255',
        ]);

        // Create the post
        $post = new Post();
        $post->poster_id = auth()->user()->id;
        $post->image = '-';
        $post->caption = $request->input('caption');
        $post->save();

        // Store the image in storage/app/public/images directory
        $image = $validated['image'];
        $filename = $post->id . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('images', $filename, 'public');

        // Update the post's image
        $post->image = $path;
        $post->save();

        return response()->json([
            'message' => 'Post with ID ' . $post->id . ' created successfully',
            'id' => $post->id
        ]);
    }

    public function show(Request $request, $post_id)
    {
        $posts = Post::with('comments')->where('id', $post_id)->get();
        return $posts ? response()->json(['posts' => $posts]) : response()->json(['error' => 'Post not found']);
    }

    public function update(Request $request, $id)
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

    public function destroy(Request $request, $id)
    {
        $post = Post::find($id);

        if (auth()->user()->id != $post->poster->id) {
            // return redirect()->back()->with('error', 'You are not authorized to delete this post');
            return response()->json([
                'message' => 'You are not authorized to delete this post'
            ]);
        }

        $post->delete();

        // return redirect()->route('post.all_post');
        return response()->json([
            'message' => 'Post ' . $post->id . ' deleted successfully',
            'status' => 'success'
        ]);
    }

    // Comment
    public function comment(Request $request, $post_id)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->commenter_id = auth()->user()->id;
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
        if ($Like::where('liker_id', auth()->user()->id)->where('post_id', $post_id)->first()) {
            return response()->json([
                'error' => 'You have liked this post'
            ]);
        }
        
        $like = new Like();
        $like->liker_id = auth()->user()->id;
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
        $like = Like::where('liker_id', auth()->user()->id)->where('post_id', $post_id)->first();

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