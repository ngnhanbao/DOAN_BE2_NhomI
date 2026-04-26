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
// Quản trị viên
// ---------------------------------------------------
Route::prefix('admin')->name('admin.')->group(function () {
    // Categories
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    
    // Brands
    Route::resource('brands', App\Http\Controllers\Admin\BrandController::class);
    Route::patch('brands/{id}/toggle-status', [App\Http\Controllers\Admin\BrandController::class, 'toggleStatus'])->name('brands.toggleStatus');
    
    // Vouchers
    Route::get('vouchers', [VoucherController::class, 'index'])->name('vouchers.index');
    Route::resource('vouchers', VoucherController::class)->except(['index']);
    Route::patch('vouchers/{id}/toggle-status', [VoucherController::class, 'toggleStatus'])->name('vouchers.toggleStatus');
});

// ---------------------------------------------------
// Xác thực & Người dùng
// ---------------------------------------------------
// hiển thị form login
Route::get('/login', [CrudUserController::class, 'showLogin'])->name('login');
// xử lý login khi submit form
Route::post('/login', [CrudUserController::class, 'login']);

// hiển thị form đăng ký
Route::get('/register', [CrudUserController::class, 'showRegister']);
// xử lý đăng ký
Route::post('/register', [CrudUserController::class, 'register']);

// xử lý logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// hiển thị form đổi mật khẩu
Route::get('/password/change', [CrudUserController::class, 'showChangePassword'])->middleware('auth');
// xử lý đổi mật khẩu
Route::post('/password/change', [CrudUserController::class, 'changePassword'])->middleware('auth');

// chi tiết sản phẩm
Route::get('/product-detail/{id}', [HomeController::class, 'detail']);