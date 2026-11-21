<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminPostController;

use App\Models\Post;

// Public route: shows all posts (including admin posts) on Home
Route::get('/', function () {
    $posts = Post::with('user')->latest()->paginate(6);

    return view('posts.index', ['posts' => $posts]);
})->name('home');


// Routes that require the user to be logged in
Route::middleware('auth')->group(function () {

    // ======================
    // ADMIN ROUTES
    // ======================
    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

            Route::resource('users', AdminUserController::class)->except(['show']);
            Route::resource('posts', AdminPostController::class)->except(['show']);
        });


    // ======================
    // NORMAL USER ROUTES
    // ======================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});


// Guest routes
Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


// View a user's posts
Route::get('/{user}/posts', [DashboardController::class, 'userPosts'])->name('posts.user');
