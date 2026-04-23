@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">ĐỔI MẬT KHẨU</h4>
            </div>
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('/password/change') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" class="form-control" placeholder="Nhập mật khẩu hiện tại" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu mới</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Nhập mật khẩu mới" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Xác nhận mật khẩu mới</label>
                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Đổi mật khẩu ngay</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center text-muted">
                Hãy nhớ mật khẩu mới để đăng nhập lần sau
            </div>
        </div>
    </div>
</div>
@endsection
