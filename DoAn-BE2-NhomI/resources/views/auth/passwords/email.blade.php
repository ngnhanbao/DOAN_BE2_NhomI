<!DOCTYPE html>
<html class="light" lang="vi">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Quên mật khẩu - B-Tris</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#001e40",
                        "primary-container": "#003366",
                        "primary-fixed-dim": "#a7c8ff",
                        "on-surface": "#191c1e",
                        "on-surface-variant": "#43474f",
                        "outline-variant": "#c3c6d1",
                        "error": "#ba1a1a",
                        "surface-container": "#eceef0",
                    },
                    "fontFamily": {
                        "body": ["Inter"],
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #001e40;
        }

        .main-gradient-bg {
            background: radial-gradient(circle at 70% 30%, #003366 0%, #001e40 100%);
            position: relative;
            overflow: hidden;
        }

        .grid-overlay {
            background-image: radial-gradient(rgba(167, 200, 255, 0.1) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .tech-glow-1 {
            position: absolute;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(167, 200, 255, 0.1) 0%, transparent 70%);
            top: -100px;
            left: -100px;
            pointer-events: none;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.6);
        }

        .vibrant-btn {
            background: linear-gradient(90deg, #003366 0%, #001e40 100%);
            box-shadow: 0 10px 20px -5px rgba(0, 51, 102, 0.5);
        }

        .vibrant-btn:hover {
            background: linear-gradient(90deg, #004080 0%, #002a5a 100%);
            transform: translateY(-2px);
        }

        .image-cover {
            background: linear-gradient(rgba(0, 30, 64, 0.8), rgba(0, 30, 64, 0.8)), url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=1000');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="main-gradient-bg text-on-surface antialiased min-h-screen font-body">
    <div class="fixed inset-0 grid-overlay opacity-50 z-0"></div>
    <div class="tech-glow-1 z-0"></div>

    <main class="min-h-screen flex relative z-10">
        <div class="hidden lg:flex w-1/2 image-cover items-center justify-center p-12 relative overflow-hidden">
            <div class="relative z-10 max-w-lg space-y-8">
                <img alt="B-Tris Logo" class="w-full max-w-sm drop-shadow-[0_0_30px_rgba(167,200,255,0.5)]" src="https://lh3.googleusercontent.com/aida/ADBb0ugktx_Q3y781mWkD-1yk16rNWqvhMLL2wP97pNK8BpOZ5KuT-XqfXv25_Wg_2AWt1-SbDq8Jhg5zCio8aOdOCc1IDlLRk6Sfr8BhwJSQXUq1iiUJlBY3zXCsmMvIMiL_qWAxFMdlHuenwXoz9iOIzEdDqVszI28phX9HbYMjxaiRw9kXY6W11fVjEkyMJvbn7-zuPeRcSipj0OWxURccwifkh0wGjVkL1sfkmd6OJRft9rr65ID7B6E_fy1a5417PMX_P6zsc9g2A" />
                <div class="space-y-4">
                    <h2 class="text-5xl font-black text-white tracking-tighter uppercase">Precision Engineering</h2>
                    <p class="text-primary-fixed-dim text-lg leading-relaxed font-medium">Hệ thống quản trị và vận hành toàn diện dành cho hệ sinh thái kỹ thuật chính xác B-Tris.</p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 md:p-12">
            <div class="w-full max-w-[500px] space-y-10">
                <div class="glass-panel p-8 md:p-12 rounded-[2rem]">
                    <div class="mb-10">
                        <h3 class="text-2xl font-black text-primary uppercase tracking-tight">QUÊN MẬT KHẨU</h3>
                        <p class="text-sm text-on-surface-variant font-medium mt-1">Vui lòng nhập email để nhận mã OTP xác thực.</p>
                    </div>

                    {{-- Thông báo thành công --}}
                    @if (session('status'))
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 text-sm font-bold rounded">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="space-y-2">
                            <label class="block text-[11px] font-black uppercase tracking-[0.2em] text-primary" for="email">EMAIL CỦA BẠN</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-0 pointer-events-none text-outline-variant group-focus-within:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-xl">mail</span>
                                </div>
                                <input class="w-full bg-transparent border-b-2 @error('email') border-error @else border-outline-variant/30 @enderror focus:border-primary focus:ring-0 transition-all pl-8 py-3 text-on-surface placeholder:text-outline-variant/50 outline-none font-medium"
                                    id="email" name="email" value="{{ old('email') }}" placeholder="example@b-tris.com" required type="email" />
                            </div>
                            @error('email')
                            <p class="text-error text-[10px] font-bold uppercase mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button class="vibrant-btn w-full text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-sm transition-all duration-300 active:scale-[0.98]" type="submit">
                            GỬI MÃ XÁC NHẬN
                        </button>
                    </form>

                    <div class="mt-10 pt-10 border-t border-surface-container flex flex-col items-center">
                        <a class="text-primary font-black hover:underline uppercase tracking-widest text-[11px] flex items-center gap-2" href="{{ route('login') }}">
                            <span class="material-symbols-outlined text-sm">arrow_back</span>
                            Quay lại đăng nhập
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="fixed top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary via-inverse-primary to-surface-tint z-50"></div>
</body>

</html>