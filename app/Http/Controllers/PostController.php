<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
// use Illuminate\Routing\Controllers\HasMiddleware;
// use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(6);
        return view('posts.index', ['posts' => $posts]);
    }

    // Store a new post
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'title' => ['required', 'max:255'],
            'body'  => ['required'],
            'image' => ['nullable', 'file', 'max:3000', 'mimes:png,jpg,webp'],
        ]);

        // Store image if uploaded
        $path = null;
        if ($request->hasFile('image')) {
            $path = Storage::disk('public')->put('post_images', $request->image);
        }

        // Create the post linked to the logged-in user
        Auth::user()->posts()->create([
            'title' => $request->title,
            'body'  => $request->body,
            'image' => $path
        ]);

        // Redirect back with success message
        return back()->with('success', 'Your post has been created successfully!');
    }

    // Display an individual post
    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    // Show the form for editing a post
    public function edit(Post $post)
    {
        Gate::authorize('modify', $post);
        return view('posts.edit', ['post' => $post]);
    }

    // Update the post
    public function update(Request $request, Post $post)
    {
        // Authorizing the action
        Gate::authorize('modify', $post);

        // Validate the form data (including image)
        $request->validate([
            'title' => ['required', 'max:255'],
            'body'  => ['required'],
            'image' => ['nullable', 'file', 'max:3000', 'mimes:png,jpg,webp'],
        ]);

        $path = $post->image;

        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete old image from storage if it exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            // Store the new image
            $path = Storage::disk('public')->put('post_images', $request->image);
        }

        // Update the post in the database
        $post->update([
            'title' => $request->title,
            'body'  => $request->body,
            'image' => $path,
        ]);

        // Redirect back to dashboard with success message
        return redirect()->route('dashboard')->with('success', 'Your post was updated successfully!');
    }

    // Remove/Delete a post
    public function destroy(Post $post)
    {
        // Authorizing the action
        Gate::authorize('modify', $post);

        // Delete the post image if it exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return back()->with('delete', 'Post deleted successfully!');
    }
}