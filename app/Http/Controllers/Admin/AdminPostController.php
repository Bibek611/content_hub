<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPostController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Access denied. Admins only.');
            }
            return $next($request);
        });
    }
    /**
     * Show all posts.
     */
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show a single post.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Edit a post.
     */
    public function edit(Post $post)
    {
        $users = User::all();

        return view('admin.posts.edit', compact('post', 'users'));
    }

    /**
     * Update a post.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|file|max:3000|mimes:png,jpg,jpeg,webp',
            'user_id' => 'required|exists:users,id',
        ]);

        // Keep the existing image if no new image is uploaded.
        $path = $post->image;

        // Upload a new image if provided.
        if ($request->hasFile('image')) {

            // Delete the old image.
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            // Store the new image.
            $path = $request->file('image')->store(
                'post_images',
                'public'
            );
        }

        // Update the post details.
        $post->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'image' => $path,
            'user_id' => $validated['user_id'],
        ]);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Delete a post.
     */
    public function destroy(Post $post)
    {
        // Delete the post image if it exists.
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post deleted successfully!');
    }
}
