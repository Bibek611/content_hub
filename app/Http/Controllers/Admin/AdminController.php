<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware to restrict access to admin users only
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->role === 'admin') {
                return $next($request);
            }

            abort(403, 'Access denied. Admins only.');
        });
    }

    public function index()
    {
        return view('admin.dashboard');
    }
}
