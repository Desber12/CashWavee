<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;   

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect('/dashboard');
})->name('home');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Logout
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Group route yang butuh login
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource Product (cukup sekali di sini saja)
    Route::resource('product', ProductController::class);

    // Resource Order
    Route::resource('order', OrderController::class);

    // Resource User
    Route::resource('user', UserController::class)->names([
        'index'   => 'user.index',
        'create'  => 'user.create',
        'store'   => 'user.store',
        'show'    => 'user.show',
        'edit'    => 'user.edit',
        'update'  => 'user.update',
        'destroy' => 'user.destroy',
    ]);
});

 /*// Admin Dashboard
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
}); */

// User Dashboard
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

// Auth routes (dari Breeze/Jetstream)
require __DIR__ . '/auth.php';
