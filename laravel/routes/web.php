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

// トップページ
Route::get('/', function () {
    return view('index');
});

// クイズページ
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
})->name('login');
Route::post('/login', 'Auth\LoginController@login');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout');

Route::post('/insertRanking', 'Web\RankingController@insertRanking');

// マイページ
Route::get('/mypage', function () {
    return view('mypage.index');
})->middleware('auth');

// キーワード
Route::get('/keyword', function () {
    return view('keyword.index');
});
