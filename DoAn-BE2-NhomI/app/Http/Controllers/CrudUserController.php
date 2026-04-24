<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request; // dùng để lấy dữ liệu từ form
use Illuminate\Support\Facades\Auth; // dùng cho login/logout
use Illuminate\Support\Facades\Hash; // đổi mật khẩu 

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
public function showChangePassword()
{
    return view('auth.change_password');
}

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ], [
        'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
        'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
        'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
        'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
    ]);

    $user = Auth::user();

    // kiểm tra mật khẩu hiện tại
    if (!Hash::check($request->current_password, $user->password_hash)) {
        return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
    }

    // cập nhật mật khẩu mới
    $user->password_hash = Hash::make($request->new_password);
    $user->save();

    // đăng xuất session cũ để tránh lỗi
    Auth::logout();

    // chuyển về trang login
    return redirect('/login')->with('success', 'Đổi mật khẩu thành công! Vui lòng đăng nhập lại.');
}


}