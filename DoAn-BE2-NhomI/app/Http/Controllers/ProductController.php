<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Hàm hỗ trợ chuyển đổi ký tự Full-width sang Half-width
     */
    private function normalizeSearchQuery($str)
    {
        // Danh sách ký tự Full-width (Zen-kaku) và tương ứng Half-width (Han-kaku)
        $fullwidth = [
            'ａ','ｂ','ｃ','ｄ','ｅ','ｆ','ｇ','ｈ','ｉ','ｊ','ｋ','ｌ','ｍ','ｎ','ｏ','ｐ','ｑ','ｒ','ｓ','ｔ','ｕ','ｖ','ｗ','ｘ','ｙ','ｚ',
            'Ａ','Ｂ','Ｃ','Ｄ','Ｅ','Ｆ','Ｇ','Ｈ','Ｉ','Ｊ','Ｋ','Ｌ','Ｍ','Ｎ','Ｏ','Ｐ','Ｑ','Ｒ','Ｓ','Ｔ','Ｕ','Ｖ','Ｗ','Ｘ','Ｙ','Ｚ',
            '０','１','２','３','４','５','６','７','８','９', '　'
        ];
        $halfwidth = [
            'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            '0','1','2','3','4','5','6','7','8','9', ' '
        ];

        return str_replace($fullwidth, $halfwidth, $str);
    }

    public function searchAjax(Request $request)
    {
        $rawQuery = $request->get('query', '');

        // 1. Chuẩn hóa từ khóa: Ép Full-width về Half-width
        $query = $this->normalizeSearchQuery($rawQuery);

        // 2. Lọc sản phẩm theo tên khớp với từ khóa đã chuẩn hóa
        $products = DB::table('products')
            ->where('name', 'LIKE', "%{$query}%")
            ->select('product_id', 'name', 'base_price')
            ->limit(6)
            ->get();

        return response()->json($products);
    }

    public function show($id)
    {
        $product = DB::table('products')->where('product_id', $id)->first();

        if (!$product) {
            abort(404);
        }

        $images = DB::table('product_images')->where('product_id', $id)->get();
        $variants = DB::table('product_variants')->where('product_id', $id)->get();

        return view('products.show', compact('product', 'images', 'variants'));
    }
}