<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('index');
// });

Route::prefix('post')->group(function() {
    Route::controller(PostController::class)->group(function() {
        Route::get('/', 'index')->name('all_post');

        Route::post('/create', 'create_post')->name('create');
        Route::get('/post/{id}', 'get_post')->name('get_post');
        Route::put('/update_post/{id}', 'update_post')->name('update_post');
        Route::delete('/delete_post/{id}', 'delete_post')->name('delete_post');

        Route::post('/comment/{post_id}/{commenter_id}', 'comment_post')->name('comment_post');
        Route::post('/like/{post_id}/{liker_id}', 'like_post')->name('like_post');
    });
});

Route::prefix('user')->group(function() {
    Route::controller(UserController::class)->group(function() {
        Route::get('/login', 'login')->name('login');
        Route::post('/authenticate', 'authenticate')->name('authenticate');

        Route::get('/register', 'register')->name('register');
        Route::post('/create_user', 'create_user')->name('create_user');
    });
});