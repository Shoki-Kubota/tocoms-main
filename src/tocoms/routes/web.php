<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserHobbyController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/posts.create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts.create', [PostController::class, 'store']);
    Route::get('/posts.index', [PostController::class, 'index'])->name('posts.index');
    Route::put('/posts/update/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/destroy/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/users.index', [UserController::class, 'index'])->name('users.index');

    Route::get('/search/region', [SearchController::class, 'indexbyregion'])->name('indexbyregion');
    Route::post('/search/region', [SearchController::class, 'searchbyregion'])->name('searchbyregion');
    Route::get('/search/hobby', [SearchController::class, 'indexbyhobby'])->name('indexbyhobby');
    Route::post('/search/hobby', [SearchController::class, 'searchbyhobby'])->name('searchbyhobby');
    
    Route::post('/profile.hobby', [UserHobbyController::class, 'update'])->name('hobby.update');

    Route::post('/users.follow', [UserController::class, 'follow'])->name('users.follow');
    Route::post('/users.unfollow', [UserController::class, 'unfollow'])->name('users.unfollow');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test', [RegionController::class, 'index'])->name('index');



require __DIR__.'/auth.php';
