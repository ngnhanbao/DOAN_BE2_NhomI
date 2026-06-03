<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $primaryKey = 'image_id';
    public $timestamps = false;

    protected $fillable = ['product_id', 'image_url', 'sort_order', 'is_primary'];

    public function getImageUrlAttribute($value)
    {
        // Normalize stored paths and provide a fallback when file is missing
        if (!$value) {
            return '/images/products/default.png';
        }

        $path = $value;
        if (strpos($path, '/storage/products/') === 0) {
            $path = str_replace('/storage/products/', '/products/', $path);
        }

        $trimmed = ltrim($path, '/');
        $full = public_path($trimmed);
        if (file_exists($full)) {
            return '/' . $trimmed;
        }

        return '/images/products/default.png';
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
