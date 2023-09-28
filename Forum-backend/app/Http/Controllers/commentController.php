<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class commentController extends Controller
{
    public function index(){
        $comments = Comment::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($comments);
    }
    public function show($id){
        $comments = Comment::with('user')->find($id);
        if (!$comments) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }
        return response()->json($comments);
    }
    public function store(Request $request)
    {
          $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id', //  validate user existence
            'post_id' => 'required|exists:posts,id', //  validate post existence
        ]);

        $comment = Comment::create([
            'content' => $request->input('content'),
            'user_id' => $request->input('user_id'),
            'post_id' => $request->input('post_id'),
        ]);
  

        return response()->json($comment, 201);
    }
     public function delete($id){
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }
        $comment->delete();
        return response()->json([
            'message' => 'Comment deleted successfully'
        ], 200); 
    }
    public function update($id, Request $request){
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }
        $comment->update([
            'content' => $request->input('content'),
        ]);
        return response()->json($comment, 200);
    }
}
