<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/quiz', function () {
    return view('quiz.index');
});

// 会員登録
Route::get('/register', function () {
    return view('auth.register.index');
});
Route::post('/register', 'Auth\RegisterController@register');

// ログイン
Route::get('/login', function () {
    return view('auth.login.index');
});
Route::post('/login', 'Auth\LoginController@login');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout');
