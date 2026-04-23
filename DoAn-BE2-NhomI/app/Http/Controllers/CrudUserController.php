<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request; // dùng để lấy dữ liệu từ form
use Illuminate\Support\Facades\Auth; // dùng cho login/logout

class CrudUserController extends Controller
{
    // hiển thị form login
public function showLogin()
{
    return view('auth.login'); // trả về file giao diện login
}

// xử lý login
public function login(Request $request)
{
    // lấy dữ liệu người dùng nhập
    $login = $request->identifier; // email hoặc username
    $password = $request->password; // mật khẩu

    // kiểm tra người dùng nhập email hay username
    $field = filter_var($login, FILTER_VALIDATE_EMAIL) 
            ? 'email'     // nếu là email → dùng cột email
            : 'username'; // nếu không → dùng username

    // thử đăng nhập
    if (Auth::attempt([
        $field => $login,     // email hoặc username
        'password' => $password, // mật khẩu người dùng nhập
        'is_active' => 1      // chỉ cho login nếu active = 1
    ])) {

        // nếu đúng → chuyển về trang chủ
        return redirect('/');
    }

    // nếu sai → quay lại form + báo lỗi
    return back()->with('error', 'Sai tài khoản hoặc mật khẩu');
}

}