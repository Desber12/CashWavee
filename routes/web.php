<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController; // pastikan sudah ada AdminController

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect('/dashboard');
})->name('home');

// Dashboard, hanya untuk user yang sudah login dan terverifikasi
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Logout route
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Group route yang butuh autentikasi
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('produk', ProdukController::class);
    Route::resource('orders', OrderController::class);
});

// Update produk
Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');

// Routes dari Laravel Breeze/Fortify/Jetstream (auth bawaan Laravel)
require __DIR__.'/auth.php';

Route::resource('user', UserController::class)->names([
    'index'   => 'user.index',
    'create'  => 'user.create',
    'store'   => 'user.store',
    'show'    => 'user.show',
    'edit'    => 'user.edit',
    'update'  => 'user.update',
    'destroy' => 'user.destroy',
]);

// ✅ Route untuk Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// ✅ Route untuk User
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
});
