<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; 

// Khai báo đường dẫn trang chủ 
Route::get('/', [HomeController::class, 'index'])->name('home');

// ---------------------------------------------------
// Các route của Trung, Trang, Thực sẽ viết tiếp xuống đây...
// ---------------------------------------------------