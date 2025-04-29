<?php

use Illuminate\Support\Facades\Route;

// アロー関数で書くとこうなる
Route::get('/hello-world', fn() => view('hello_world'));

// 連想配列
Route::get('/hello', fn() => view('hello', [
    'name' => '山田',
    'course' => 'Laravel'
]));

// 最初に表示される画面
Route::get('/', fn() => view('index'));

Route::get('/curriculum', fn() => view('curriculum'));
