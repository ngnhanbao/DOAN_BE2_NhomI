<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\CrudUserController;

// Khai báo đường dẫn trang chủ 
Route::get('/', [HomeController::class, 'index'])->name('home');

// ---------------------------------------------------
// Các route của Trung, Trang, Thực sẽ viết tiếp xuống đây...
// ---------------------------------------------------
// hiển thị form login
Route::get('/login', [CrudUserController::class, 'showLogin']);

// xử lý login khi submit form
Route::post('/login', [CrudUserController::class, 'login']);
