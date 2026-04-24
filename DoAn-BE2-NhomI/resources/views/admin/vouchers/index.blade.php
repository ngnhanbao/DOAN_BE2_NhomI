<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Quản lý Voucher - B-Tris</title>
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
                        "surface-tint": "#3a5f94",
                        "outline-variant": "#c3c6d1",
                    },
                    fontFamily: {
                        body: ["Inter", "sans-serif"],
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { font-family: 'Inter', sans-serif; background-color: #001e40; color: white; }
        .main-gradient-bg {
            background: radial-gradient(circle at 70% 30%, #003366 0%, #001e40 100%);
            position: relative;
            min-height: 100vh;
        }
        .grid-overlay {
            background-image: radial-gradient(rgba(167, 200, 255, 0.1) 1px, transparent 1px);
            background-size: 40px 40px;
            position: fixed; inset: 0; opacity: 0.5; z-index: 0; pointer-events: none;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border-radius: 1.5rem;
        }
        .table-row-hover:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .vibrant-btn {
            background: linear-gradient(90deg, #3a5f94 0%, #003366 100%);
            box-shadow: 0 10px 20px -5px rgba(0, 51, 102, 0.5);
            transition: all 0.3s ease;
        }
        .vibrant-btn:hover {
            background: linear-gradient(90deg, #4b78b5 0%, #004080 100%);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="main-gradient-bg antialiased">
    <div class="grid-overlay"></div>
    <div class="fixed top-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-400 via-indigo-500 to-blue-600 z-50"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-4xl font-black uppercase tracking-tight text-white flex items-center gap-3">
                    <span class="material-symbols-outlined text-4xl text-blue-400">local_offer</span>
                    Quản lý Voucher
                </h1>
                <p class="text-blue-200 mt-2 text-sm font-medium tracking-wide uppercase">Hệ sinh thái kỹ thuật B-Tris</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ url('/') }}" class="vibrant-btn text-white/80 px-6 py-3 rounded-xl font-bold uppercase tracking-wider text-sm flex items-center gap-2 border border-white/10 bg-transparent hover:text-white">
                    <span class="material-symbols-outlined text-lg">dashboard</span>
                    Trang chủ
                </a>
                <a href="{{ route('vouchers.create') }}" class="vibrant-btn text-white px-6 py-3 rounded-xl font-bold uppercase tracking-wider text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">add_circle</span>
                    Tạo Voucher Mới
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-500/20 border border-green-500/50 flex items-center gap-3 text-green-200">
                <span class="material-symbols-outlined">check_circle</span>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="glass-panel overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="p-5 text-xs font-black uppercase tracking-widest text-blue-300">ID</th>
                            <th class="p-5 text-xs font-black uppercase tracking-widest text-blue-300">Mã Voucher</th>
                            <th class="p-5 text-xs font-black uppercase tracking-widest text-blue-300">Loại</th>
                            <th class="p-5 text-xs font-black uppercase tracking-widest text-blue-300">Giá trị</th>
                            <th class="p-5 text-xs font-black uppercase tracking-widest text-blue-300 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($vouchers as $voucher)
                        <tr class="table-row-hover transition-colors">
                            <td class="p-5 font-medium text-white/80">#{{ $voucher->voucher_id }}</td>
                            <td class="p-5">
                                <span class="px-3 py-1 bg-blue-500/20 border border-blue-500/30 rounded-lg font-mono font-bold text-blue-300">
                                    {{ $voucher->code }}
                                </span>
                            </td>
                            <td class="p-5 font-medium">
                                @if($voucher->discount_type == 'percent')
                                    <span class="text-orange-300 flex items-center gap-1"><span class="material-symbols-outlined text-sm">percent</span> Phần trăm</span>
                                @else
                                    <span class="text-green-300 flex items-center gap-1"><span class="material-symbols-outlined text-sm">payments</span> Số tiền</span>
                                @endif
                            </td>
                            <td class="p-5 font-black text-lg">
                                {{ $voucher->discount_type == 'percent' ? $voucher->discount_value . '%' : number_format($voucher->discount_value) . ' đ' }}
                            </td>
                            <td class="p-5 text-right space-x-2">
                                <a href="{{ route('vouchers.edit', $voucher->voucher_id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-500/20 text-blue-300 hover:bg-blue-500/40 transition-colors" title="Sửa">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </a>
                                <form action="{{ route('vouchers.destroy', $voucher->voucher_id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa voucher này?');" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-500/20 text-red-300 hover:bg-red-500/40 transition-colors" title="Xóa">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if($vouchers->isEmpty())
                        <tr>
                            <td colspan="5" class="p-10 text-center text-white/50">
                                <span class="material-symbols-outlined text-5xl mb-2 opacity-50">inventory_2</span>
                                <p class="font-medium">Chưa có voucher nào trong hệ thống.</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
