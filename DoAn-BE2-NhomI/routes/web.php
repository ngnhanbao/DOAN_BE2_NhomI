<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CrudUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;


// Nhan Bao
// Khai báo đường dẫn trang chủ 
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route dành riêng cho Ajax tìm kiếm
Route::get('/search-ajax', [App\Http\Controllers\ProductController::class, 'searchAjax'])->name('search.ajax');
// Route hiển thị trang chi tiết sản phẩm
Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
Route::prefix('password')->group(function () {
    // Bước 1: Nhập Email
    // Sửa lại trong web.php cho khớp với Controller của bạn
Route::get('forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Bước 2: Nhập mã OTP
    Route::get('verify-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp');
    Route::post('verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify');

    // Bước 3: Đặt lại mật khẩu mới
    Route::get('reset', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset', [ForgotPasswordController::class, 'updatePassword'])->name('password.update');
});
// ---------------------------------------------------
// Các route của Trung
// ---------------------------------------------------

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
});

// ---------------------------------------------------
// Các route của Trang, Thực sẽ viết tiếp xuống đây...
// ---------------------------------------------------
// hiển thị form login
Route::get('/login', [CrudUserController::class, 'showLogin']);

// xử lý login khi submit form
Route::post('/login', [CrudUserController::class, 'login']);

// hiển thị form đăng ký
Route::get('/register', [CrudUserController::class, 'showRegister']);
// xử lý đăng ký
Route::post('/register', [CrudUserController::class, 'register']);

//chi tiết sản phẩm
Route::get('/product/{id}', [HomeController::class, 'detail']);
