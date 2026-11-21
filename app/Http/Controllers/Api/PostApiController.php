<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostApiController extends Controller
{
    // GET /api/posts  → latest posts (public)
    public function index()
    {
        $posts = Post::with('user:id,name')->latest()->paginate(10);
        return response()->json($posts);
    }

    // GET /api/posts/my  → current user’s posts
    public function myPosts()
    {
        $posts = Auth::user()->posts()->with('user:id,name')->latest()->paginate(10);
        return response()->json($posts);
    }

    // POST /api/posts  → create new post
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
            'image' => 'nullable|image|max:3000|mimes:jpg,jpeg,png,webp',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('post_images', 'public');
        }

        $post = Auth::user()->posts()->create([
            'title' => strip_tags($request->title),
            'body'  => strip_tags($request->body),
            'image' => $path,
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'post'    => $post->load('user:id,name'),
        ], 201);
    }

    // PUT /api/posts/{post}
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
            'image' => 'nullable|image|max:3000|mimes:jpg,jpeg,png,webp',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $path = $post->image;
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('post_images', 'public');
        }

        $post->update([
            'title' => strip_tags($request->title),
            'body'  => strip_tags($request->body),
            'image' => $path,
        ]);

        return response()->json([
            'message' => 'Post updated successfully',
            'post'    => $post->load('user:id,name'),
        ]);
    }

    // DELETE /api/posts/{post}
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}