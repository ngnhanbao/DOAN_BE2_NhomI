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

    Route::view('/brands/create', 'admin.brands.create')->name('brands.create');

    
    // Brands
    Route::patch('brands/{id}/toggle-status', [App\Http\Controllers\Admin\BrandController::class, 'toggleStatus'])->name('brands.toggleStatus');
    Route::resource('brands', App\Http\Controllers\Admin\BrandController::class);
    
    // Vouchers
    Route::patch('vouchers/{id}/toggle-status', [VoucherController::class, 'toggleStatus'])->name('vouchers.toggleStatus');
    Route::resource('vouchers', VoucherController::class)->middleware('auth');

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

//chi tiết sản phẩm
Route::get('/product/{id}', [HomeController::class, 'detail']);


//xử lý logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


// hiển thị form đổi mật khẩu
Route::get('/password/change', [CrudUserController::class, 'showChangePassword'])->middleware('auth');

// xử lý đổi mật khẩu
Route::post('/password/change', [CrudUserController::class, 'changePassword'])->middleware('auth');



// quản lí Voucher 
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('vouchers', App\Http\Controllers\Admin\VoucherController::class);
});


// chi tiết sản phẩm
Route::get('/product-detail/{id}', [HomeController::class, 'detail']);

