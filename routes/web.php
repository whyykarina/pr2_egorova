<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;

Route::get('/', [TopicController::class, 'index'])->name('home');

Auth::routes();

Route::resource('topics', TopicController::class)->middleware('auth');
Route::resource('comments', CommentController::class)->middleware('auth');
Route::post('/topics/{topic}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::resource('categories', CategoryController::class)->middleware('auth');

Route::get('/categories/{category:slug}/topics', [TopicController::class, 'filterByCategory'])->name('categories.topics');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');