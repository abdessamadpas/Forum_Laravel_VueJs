<?php

namespace App\Http\Controllers;

use  App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    public function index(){
    $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(10);
    return response()->json($posts);
    }

    public function store(Request $request)
    {
          $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id', //  validate user existence
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $post = Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => $request->input('user_id'),
            'image' => $request->file('image') ? $request->file('image')->store('post_images', 'public') : null, // Handle image upload if provided
        ]);
  

        return response()->json($post, 201);
    }

    public function show($id)
    {
        $post = Post::with('user')->find($id);
        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }
        return response()->json($post);
    }
    public function delete($id){
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }
        $post->delete();
        return response()->json([
            'message' => 'Post deleted successfully'
        ], 200);

    }
    public function update($id, Request $request){
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }
        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
        return response()->json([
            'message' => 'Post updated successfully'
        ], 200);
    }
}
