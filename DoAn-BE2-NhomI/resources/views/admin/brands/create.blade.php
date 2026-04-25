@extends('admin.layouts.app')

@section('content')
<div class="space-y-6 pb-10" x-data="{
    name: '',
    slug: '',
    logoUrl: '',
    description: '',
    isActive: true,
    generateSlug() {
        if(!this.slug) {
            this.slug = this.name.toLowerCase().replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a')
                .replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e')
                .replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i')
                .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o')
                .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u')
                .replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y')
                .replace(/đ/gi, 'd')
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }
    }
}">
    
    <!-- Breadcrumb & Header section -->
    <div class="flex flex-col gap-2">
        <div class="flex items-center text-sm font-medium">
            <span class="text-gray-500">Admin</span> 
            <span class="mx-2 text-gray-400">›</span> 
            <a href="{{ route('admin.brands.index') }}" class="text-blue-600 hover:underline">Thương hiệu</a>
            <span class="mx-2 text-gray-400">›</span> 
            <span class="text-[#0A2540] font-bold">Thêm mới</span>
        </div>
        
        <div class="flex items-center justify-between mt-2">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.brands.index') }}" class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h1 class="text-2xl font-bold text-[#0A2540]">Thêm thương hiệu mới</h1>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.brands.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-bold transition-colors text-sm shadow-sm">
                    Danh sách
                </a>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 mt-6">
        <!-- Form Section (Left Column) -->
        <div class="lg:w-2/3 space-y-6">
            <form action="{{ route('admin.brands.store') }}" method="POST" id="brandForm" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                @csrf
                <div class="flex items-center gap-2 mb-6">
                    <i data-lucide="edit" class="w-5 h-5 text-[#0A2540]"></i>
                    <h2 class="text-lg font-bold text-[#0A2540]">Thông tin cơ bản</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Tên thương hiệu -->
                    <div>
                        <label for="name" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Tên thương hiệu</label>
                        <input type="text" id="name" name="name" x-model="name" @input="generateSlug" class="w-full bg-[#F4F5F7] border border-transparent focus:border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-0 focus:bg-white transition-colors text-[#0A2540] placeholder-gray-400" placeholder="Ví dụ: NVIDIA, Intel..." required>
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Đường dẫn thân thiện (Slug)</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-transparent bg-gray-100 text-gray-500 text-sm">
                                brand/
                            </span>
                            <input type="text" id="slug" name="slug" x-model="slug" class="flex-1 bg-[#F4F5F7] border border-transparent focus:border-gray-300 rounded-r-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-0 focus:bg-white transition-colors text-[#0A2540] placeholder-gray-400" placeholder="nvidia-corporation" required>
                        </div>
                        @error('slug') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- URL Logo -->
                <div class="mb-6">
                    <label for="logo_url" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">URL Logo thương hiệu</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                            <i data-lucide="link" class="w-4 h-4"></i>
                        </div>
                        <input type="url" id="logo_url" name="logo_url" x-model="logoUrl" class="w-full bg-[#F4F5F7] border border-transparent focus:border-gray-300 rounded-lg pl-11 pr-4 py-2.5 text-sm focus:outline-none focus:ring-0 focus:bg-white transition-colors text-[#0A2540] placeholder-gray-400" placeholder="https://domain.com/logo.png">
                    </div>
                    @error('logo_url') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Mô tả -->
                <div class="mb-8">
                    <label for="description" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Mô tả thương hiệu</label>
                    <textarea id="description" name="description" x-model="description" rows="4" class="w-full bg-[#F4F5F7] border border-transparent focus:border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-0 focus:bg-white transition-colors text-[#0A2540] placeholder-gray-400 resize-none" placeholder="Nhập mô tả chi tiết về lịch sử và định hướng của thương hiệu..."></textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Trạng thái -->
                <div class="bg-[#F8F9FA] rounded-xl p-5 mb-8 flex items-center justify-between border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-[#0A2540] shadow-sm">
                            <i data-lucide="radio" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#0A2540] text-sm">Trạng thái hoạt động</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Thương hiệu sẽ được hiển thị ngay sau khi kích hoạt</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" x-model="isActive" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0A2540]"></div>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-4">
                    <button type="submit" class="flex-1 bg-[#0A2540] hover:bg-[#113255] text-white py-3 rounded-lg font-bold transition-colors shadow-sm flex items-center justify-center gap-2">
                        <i data-lucide="save" class="w-5 h-5"></i> LƯU THƯƠNG HIỆU
                    </button>
                    <a href="{{ route('admin.brands.index') }}" class="px-8 py-3 bg-white border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 font-bold transition-colors shadow-sm text-center">
                        HỦY BỎ
                    </a>
                </div>
            </form>

            <div class="grid grid-cols-2 gap-6 mt-6">
                <div class="bg-[#F4F5F7] rounded-xl p-5 flex items-center gap-4 border border-gray-200">
                    <div class="text-gray-400">
                        <i data-lucide="history" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-500 uppercase">KHỞI TẠO</p>
                        <p class="text-sm font-bold text-[#0A2540]">Hệ thống (Tự động)</p>
                    </div>
                </div>
                <div class="bg-[#F4F5F7] rounded-xl p-5 flex items-center gap-4 border border-gray-200">
                    <div class="text-gray-400">
                        <i data-lucide="clock" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-500 uppercase">NGÀY TẠO</p>
                        <p class="text-sm font-bold text-[#0A2540]">{{ now()->format('d/m/Y - H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Section (Right Column) -->
        <div class="lg:w-1/3 space-y-6 sticky top-6 self-start">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Preview Header/Cover -->
                <div class="h-48 bg-[#0A2540] relative flex items-center justify-center overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 20px 20px;"></div>
                    
                    <div class="relative z-10 w-24 h-24 bg-[#113255] rounded-2xl flex items-center justify-center border border-[#1e4d82] shadow-xl overflow-hidden p-2">
                        <template x-if="logoUrl">
                            <img :src="logoUrl" class="w-full h-full object-contain" @@error="$event.target.style.display='none'; $refs.fallbackIcon.style.display='flex'">
                        </template>
                        <div x-ref="fallbackIcon" :class="{'hidden': logoUrl}" class="w-full h-full flex flex-col items-center justify-center text-[#2A5C96]">
                            <i data-lucide="image" class="w-8 h-8 mb-1"></i>
                        </div>
                    </div>
                    
                    <div class="absolute bottom-4 left-0 right-0 flex justify-center">
                        <span class="bg-white text-[#0A2540] text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-md">
                            LIVE PREVIEW
                        </span>
                    </div>
                </div>

                <!-- Preview Content -->
                <div class="p-6 text-center">
                    <div class="flex items-center justify-center gap-2 mb-1">
                        <h3 class="text-2xl font-black text-[#0A2540] truncate" x-text="name || 'Tên thương hiệu'"></h3>
                        <span x-show="isActive" class="bg-[#E2F6EA] text-[#0FAF62] text-[10px] font-bold px-2 py-0.5 rounded uppercase">ACTIVE</span>
                        <span x-show="!isActive" class="bg-[#F0F2F5] text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded uppercase">HIDDEN</span>
                    </div>
                    <p class="text-blue-600 text-sm mb-4 font-mono truncate" x-text="'brand/' + (slug || 'slug-preview')"></p>
                    
                    <p class="text-sm text-gray-500 italic mb-6 line-clamp-3 min-h-[60px]" x-text="description || 'Mô tả của thương hiệu sẽ xuất hiện ở đây để khách hàng có thể hiểu thêm về giá trị và chất lượng sản phẩm...'"></p>

                    <div class="grid grid-cols-2 border-t border-gray-100 pt-5">
                        <div class="border-r border-gray-100">
                            <p class="text-2xl font-black text-[#0A2540]">0</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">SẢN PHẨM</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-[#0A2540]">0.0</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">ĐÁNH GIÁ</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hướng dẫn -->
            <div class="bg-[#0A2540] rounded-xl p-6 text-white shadow-md">
                <div class="flex items-center gap-2 mb-4">
                    <i data-lucide="info" class="w-5 h-5 text-blue-400"></i>
                    <h3 class="font-bold text-sm uppercase tracking-wider">Hướng dẫn thiết lập</h3>
                </div>
                
                <ul class="space-y-4 text-sm text-gray-300">
                    <li class="flex gap-3">
                        <span class="w-5 h-5 rounded-full bg-[#1e4d82] flex items-center justify-center flex-shrink-0 text-xs font-bold text-white mt-0.5">1</span>
                        <p>Sử dụng logo có nền trong suốt (PNG/SVG) để đạt hiệu quả thẩm mỹ cao nhất.</p>
                    </li>
                    <li class="flex gap-3">
                        <span class="w-5 h-5 rounded-full bg-[#1e4d82] flex items-center justify-center flex-shrink-0 text-xs font-bold text-white mt-0.5">2</span>
                        <p>Slug nên ngắn gọn, không dấu và sử dụng gạch nối ngang.</p>
                    </li>
                    <li class="flex gap-3">
                        <span class="w-5 h-5 rounded-full bg-[#1e4d82] flex items-center justify-center flex-shrink-0 text-xs font-bold text-white mt-0.5">3</span>
                        <p>Mô tả tối ưu cho SEO nên có độ dài từ 150-300 ký tự.</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
