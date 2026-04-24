<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Thêm Voucher Mới - B-Tris</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#001e40",
                        "primary-container": "#003366",
                    },
                    fontFamily: { body: ["Inter", "sans-serif"], }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { font-family: 'Inter', sans-serif; background-color: #001e40; color: white; }
        .main-gradient-bg { background: radial-gradient(circle at 70% 30%, #003366 0%, #001e40 100%); position: relative; min-height: 100vh; }
        .grid-overlay { background-image: radial-gradient(rgba(167, 200, 255, 0.1) 1px, transparent 1px); background-size: 40px 40px; position: fixed; inset: 0; opacity: 0.5; z-index: 0; pointer-events: none; }
        .glass-panel { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); border-radius: 1.5rem; }
        .input-field { background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.75rem; padding: 1rem; color: white; width: 100%; transition: all 0.3s ease; }
        .input-field:focus { outline: none; border-color: #a7c8ff; background-color: rgba(255, 255, 255, 0.1); box-shadow: 0 0 0 4px rgba(167, 200, 255, 0.1); }
        .input-label { display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #a7c8ff; margin-bottom: 0.5rem; }
        .vibrant-btn { background: linear-gradient(90deg, #3a5f94 0%, #003366 100%); box-shadow: 0 10px 20px -5px rgba(0, 51, 102, 0.5); transition: all 0.3s ease; }
        .vibrant-btn:hover { background: linear-gradient(90deg, #4b78b5 0%, #004080 100%); transform: translateY(-2px); }
        /* Style cho select element để trông đẹp hơn trên nền tối */
        select.input-field option { background-color: #001e40; color: white; }
        /* For date inputs icon color */
        input[type="date"]::-webkit-calendar-picker-indicator { filter: invert(1); cursor: pointer; }
    </style>
</head>
<body class="main-gradient-bg antialiased flex items-center justify-center py-12 px-4">
    <div class="grid-overlay"></div>
    <div class="fixed top-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-400 via-indigo-500 to-blue-600 z-50"></div>
    
    <div class="relative z-10 w-full max-w-2xl">
        <div class="mb-8 flex items-center gap-4">
            <a href="{{ route('vouchers.index') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 transition-colors border border-white/10">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-3xl font-black uppercase tracking-tight text-white flex items-center gap-3">
                    Thêm Voucher Mới
                </h1>
                <p class="text-blue-200 mt-1 text-xs font-bold tracking-widest uppercase">Thiết lập khuyến mãi hệ thống</p>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/50 text-red-200">
                <ul class="list-disc list-inside text-sm font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="glass-panel p-8 md:p-10">
            <form method="POST" action="{{ route('vouchers.store') }}" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Code -->
                    <div class="md:col-span-2">
                        <label class="input-label">Mã Voucher</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/40">
                                <span class="material-symbols-outlined text-lg">tag</span>
                            </span>
                            <input type="text" name="code" class="input-field pl-12 uppercase font-mono font-bold tracking-wider" placeholder="VD: BTRIS2024" value="{{ old('code') }}" required>
                        </div>
                    </div>

                    <!-- Discount Type -->
                    <div>
                        <label class="input-label">Loại giảm giá</label>
                        <select name="discount_type" class="input-field cursor-pointer">
                            <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                            <option value="amount" {{ old('discount_type') == 'amount' ? 'selected' : '' }}>Số tiền (VNĐ)</option>
                        </select>
                    </div>

                    <!-- Discount Value -->
                    <div>
                        <label class="input-label">Giá trị giảm</label>
                        <input type="number" name="discount_value" class="input-field" placeholder="VD: 10 hoặc 50000" value="{{ old('discount_value') }}" required>
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label class="input-label">Ngày bắt đầu</label>
                        <input type="date" name="start_date" class="input-field" value="{{ old('start_date') }}" required>
                    </div>

                    <!-- End Date -->
                    <div>
                        <label class="input-label">Ngày kết thúc</label>
                        <input type="date" name="end_date" class="input-field" value="{{ old('end_date') }}" required>
                    </div>

                    <!-- Usage Limit -->
                    <div class="md:col-span-2">
                        <label class="input-label">Số lần sử dụng tối đa</label>
                        <input type="number" name="usage_limit" class="input-field" placeholder="Bỏ trống nếu không giới hạn" value="{{ old('usage_limit') }}">
                    </div>
                </div>

                <div class="pt-6 mt-6 border-t border-white/10 flex justify-end">
                    <button type="submit" class="vibrant-btn text-white px-8 py-4 rounded-xl font-black uppercase tracking-[0.1em] text-sm flex items-center gap-2 w-full md:w-auto justify-center">
                        <span class="material-symbols-outlined">save</span>
                        Lưu Voucher
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
