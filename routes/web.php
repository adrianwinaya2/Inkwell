<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(ViewController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::get('/register', 'register')->name('register');

    Route::middleware(['auth'])->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/new_post', 'new_post')->name('new_post');
        Route::get('/post/{id}', 'view_post')->name('view_post');
    });
});

Route::group(['as' => 'post.', 'prefix' => 'post', 'middleware' => 'auth'], function() {
    Route::controller(PostController::class)->group(function() {
        // api
        Route::get('/', 'index')->name('index');

        // CRUD
        Route::post('/store', 'store')->name('store');
        Route::get('/show/{id}', 'show')->name('show');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');

        Route::post('/comment/{post_id}/{commenter_id}', 'comment_post')->name('comment_post');
        Route::post('/like/{post_id}/{liker_id}', 'like_post')->name('like_post');
    });
});

Route::group(['as' => 'comment.', 'prefix' => 'comment', 'middleware' => 'auth'], function() {
    Route::controller(CommentController::class)->group(function() {
        // api
        Route::get('/', 'index')->name('index');

        // CRUD
        Route::post('/store/{id}', 'store')->name('store');
        Route::get('/show/{id}', 'show')->name('show');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });
});


Route::group(['as' => 'user.', 'prefix' => 'user'], function() {
    Route::controller(UserController::class)->group(function() {
        Route::post('/authenticate', 'authenticate')->name('authenticate');
        Route::post('/create_user', 'create_user')->name('create_user');
        Route::post('/logout', 'logout')->middleware('auth')->name('logout');

        // api
        Route::get('/', 'show')->name('index');
        Route::get('/{id}', 'show')->name('show');
    });
});