<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Bắt buộc phải có dòng này để gọi Database

class HomeController extends Controller
{
    public function index()
    {
        // Tự động lấy 8 sản phẩm MỚI NHẤT dựa trên thời gian tạo (created_at)
        // Kết hợp với ảnh đại diện chính (is_primary)
        $newProducts = DB::table('products')
            ->join('product_images', 'products.product_id', '=', 'product_images.product_id')
            ->where('product_images.is_primary', 1)
            ->select('products.*', 'product_images.image_url')
            ->orderBy('products.created_at', 'desc') // Sắp xếp mới nhất lên đầu
            ->limit(8) // Chỉ lấy 8 sản phẩm để hiển thị lưới 2x4 hoặc 4x2
            ->get();

        return view('home.index', compact('newProducts'));
    }
}
