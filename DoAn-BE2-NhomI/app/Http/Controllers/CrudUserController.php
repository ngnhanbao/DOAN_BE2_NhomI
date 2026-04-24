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
    // ================== 1. VALIDATE ==================
    // bắt buộc nhập email + password, email phải đúng định dạng
    $request->validate([
        'email' => 'required|email',   // bắt buộc + đúng format email
        'password' => 'required'       // bắt buộc nhập mật khẩu
    ], [
        'email.required' => 'Vui lòng nhập email.',
        'email.email' => 'Định dạng email không hợp lệ.',
        'password.required' => 'Vui lòng nhập mật khẩu.'
    ]);

    // ================== 2. LẤY DỮ LIỆU ==================
    $email = $request->email;
    $password = $request->password;

    // ================== 3. KIỂM TRA USER ==================
    $user = \App\Models\User::where('email', $email)->first();

    if (!$user) {
        // không tồn tại email
        return back()
    ->with('error', 'Sai tài khoản hoặc mật khẩu')
    ->withInput();
    }

    // ================== 4. CHECK TÀI KHOẢN BỊ KHÓA ==================
    if ($user->is_active == 0) {
        return back()->with('error', 'Tài khoản của bạn đã bị khóa.');
    }

    // ================== 5. GHI NHỚ LOGIN ==================
    $remember = $request->has('remember');

    // ================== 6. ĐĂNG NHẬP ==================
    if (Auth::attempt([
        'email' => $email,
        'password' => $password
    ], $remember)) {

        return redirect('/')->with('success', 'Đăng nhập thành công!');
    }

    // ================== 7. SAI PASSWORD ==================
    return back()->with('error', 'Tài khoản hoặc mật khẩu không chính xác.');
}

}