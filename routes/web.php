<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\PostController;

// Route::get('/', [PostController::class, 'publicIndex']); // 一般公開向けの投稿一覧
Route::get('/',                [PostController::class, 'publicIndex'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 管理画面用投稿機能（投稿作成・編集・削除）
    Route::prefix('dashboard')->group(function () {
        Route::resource('posts', PostController::class);
    });
});

require __DIR__ . '/auth.php';
