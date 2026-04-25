<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CrudUserController;
use App\Http\Controllers\Admin\VoucherController;

// Khai báo đường dẫn trang chủ 
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route dành riêng cho Ajax tìm kiếm
Route::get('/search-ajax', [App\Http\Controllers\ProductController::class, 'searchAjax'])->name('search.ajax');
// Route hiển thị trang chi tiết sản phẩm
Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');

// ---------------------------------------------------
// Các route của Trung & Trang
// ---------------------------------------------------

// Quản trị viên
Route::prefix('admin')->name('admin.')->group(function () {
    // Categories
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);

    // Brands
    // Đặt route toggle TRƯỚC resource để tránh bị resource route đè
    Route::patch('brands/{id}/toggle-status', [App\Http\Controllers\Admin\BrandController::class, 'toggleStatus'])->name('brands.toggleStatus');
    Route::resource('brands', App\Http\Controllers\Admin\BrandController::class);
    
    // Vouchers (thêm vào group admin chung)
    Route::resource('vouchers', App\Http\Controllers\Admin\VoucherController::class)->middleware('auth');
});

// ---------------------------------------------------
// Xác thực & Người dùng
// ---------------------------------------------------

// Login
Route::get('/login', [CrudUserController::class, 'showLogin'])->name('login');
Route::post('/login', [CrudUserController::class, 'login']);

// Register
Route::get('/register', [CrudUserController::class, 'showRegister']);
Route::post('/register', [CrudUserController::class, 'register']);

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Password Change
Route::get('/password/change', [CrudUserController::class, 'showChangePassword'])->middleware('auth');
Route::post('/password/change', [CrudUserController::class, 'changePassword'])->middleware('auth');

// Chi tiết sản phẩm (fallback or user route)
Route::get('/product-detail/{id}', [HomeController::class, 'detail']);