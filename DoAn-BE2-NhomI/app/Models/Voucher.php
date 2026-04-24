<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';       // tên bảng trong DB
    protected $primaryKey = 'voucher_id'; // nếu khóa chính không phải 'id'
    public $timestamps = false;           // nếu bảng không có created_at, updated_at

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'usage_limit',
        'is_active'
    ];
}
