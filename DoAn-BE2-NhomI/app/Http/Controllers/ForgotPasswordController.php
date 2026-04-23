<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * 1. Hiển thị Form để người dùng nhập Email
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * 2. Xử lý gửi Link Reset vào Email của người dùng
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Kiểm tra định dạng email và xem email có tồn tại trong DB không
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email này chưa được đăng ký trên hệ thống B-Tris.'
        ]);

        // Sử dụng Password Broker của Laravel để gửi link (đã cấu hình Gmail SMTP)
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'B-Tris đã gửi liên kết đặt lại mật khẩu vào hòm thư của bạn!'])
            : back()->withErrors(['email' => 'Đã có lỗi xảy ra, vui lòng thử lại sau.']);
    }

    /**
     * 3. Hiển thị Form để người dùng nhập Mật khẩu mới (từ Link Email)
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * 4. Xử lý lưu Mật khẩu mới vào Database
     */
    public function resetPassword(Request $request)
    {
        // Validate mật khẩu mới (phải khớp và đủ 8 ký tự)
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Thực hiện cập nhật mật khẩu
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Băm mật khẩu mới trước khi lưu
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        // Trả về thông báo kết quả
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Mật khẩu của bạn đã được cập nhật!')
            : back()->withErrors(['email' => [__($status)]]);
    }
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6', 'email' => 'required|email']);

        $otpData = DB::table('otps')->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$otpData || now()->gt($otpData->expires_at)) {
            return back()->withErrors(['otp' => 'Mã OTP không đúng hoặc đã hết hạn!']);
        }

        // Nếu đúng, cho phép sang trang đặt lại mật khẩu
        return redirect()->route('password.reset', ['email' => $request->email]);
    }
}
