<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; 

// Khai báo đường dẫn trang chủ 
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route dành riêng cho Ajax tìm kiếm
Route::get('/search-ajax', [App\Http\Controllers\ProductController::class, 'searchAjax'])->name('search.ajax');
// Route hiển thị trang chi tiết sản phẩm
Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');

// ---------------------------------------------------
// Các route của Trung
// ---------------------------------------------------

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
});

// ---------------------------------------------------
// Các route của Trang, Thực sẽ viết tiếp xuống đây...
// ---------------------------------------------------