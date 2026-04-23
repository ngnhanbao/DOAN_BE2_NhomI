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

    // thử đăng nhập bằng email
    if (Auth::attempt([
        'email' => $login,
        'password' => $password, // mật khẩu người dùng nhập
        'is_active' => 1      // chỉ cho login nếu active = 1
    ])) {

        // nếu đúng → chuyển về trang chủ
        return redirect('/');
    }

    // nếu sai → quay lại form + báo lỗi
    return back()->with('error', 'Sai tài khoản hoặc mật khẩu');
}

public function showRegister()
{
    return view('auth.register');
}

public function register(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:100',
        'email' => 'required|string|email|max:100|unique:users',
        'phone' => 'required|string|max:20',
        'password' => 'required|string|min:6|confirmed',
    ], [
        'full_name.required' => 'Vui lòng nhập họ và tên.',
        'email.required' => 'Vui lòng nhập email.',
        'email.email' => 'Email không hợp lệ.',
        'email.unique' => 'Email này đã được đăng ký.',
        'phone.required' => 'Vui lòng nhập số điện thoại.',
        'password.required' => 'Vui lòng nhập mật khẩu.',
        'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
    ]);

    User::create([
        'full_name' => $request->full_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password_hash' => \Illuminate\Support\Facades\Hash::make($request->password),
        'role' => 'user',
        'is_active' => 1
    ]);

    return redirect('/login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
}

}