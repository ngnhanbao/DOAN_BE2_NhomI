<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // class dùng cho login

class User extends Authenticatable
{
    protected $table = 'users'; // tên bảng trong database

    protected $primaryKey = 'user_id'; // khóa chính không phải id mà là user_id

    public $incrementing = true; // khóa chính tự tăng
    public $timestamps = false; // Bỏ qua updated_at và created_at tự động của Laravel

    // các cột cho phép insert/update
    protected $fillable = [
        'email',
        'username',
        'full_name',
        'password_hash',
        'role',
        'is_active'
    ];

    // ẩn khi trả dữ liệu ra ngoài
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    //cho Laravel biết password nằm ở đâu
    public function getAuthPassword()
    {
        return $this->password_hash; // dùng cột password_hash thay vì password
    }
}