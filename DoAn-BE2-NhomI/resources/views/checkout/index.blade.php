@extends('layouts.app')

@section('content')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background:
                linear-gradient(135deg,
                    #f5f9ff 0%,
                    #eef4ff 40%,
                    #ffffff 100%);
        }

        .checkout-wrapper {
            animation: fadeUp .6s ease;
        }

        .glass-card {

            background: rgba(255, 255, 255, .88);

            backdrop-filter: blur(18px);

            border: 1px solid rgba(255, 255, 255, .7);

            box-shadow:
                0 15px 40px rgba(15, 23, 42, .06);
        }

        .checkout-input {

            width: 100%;

            border: 1px solid #dbe2ea;

            background: #f8fafc;

            padding: 16px 18px;

            border-radius: 18px;

            outline: none;

            transition: .3s;

            font-size: 15px;
        }

        .checkout-input:focus {

            border-color: #001e40;

            background: white;

            transform: translateY(-2px);

            box-shadow:
                0 0 0 5px rgba(0, 30, 64, .08);
        }

        .delivery-card {

            border: 1px solid #dbe2ea;

            background: white;

            transition: .35s;

            position: relative;

            overflow: hidden;

            cursor: pointer;
        }

        .delivery-card:hover {

            transform: translateY(-5px);

            border-color: #001e40;

            box-shadow:
                0 15px 30px rgba(0, 30, 64, .08);
        }

        .delivery-card.active {

            border-color: #001e40;

            background: #eef5ff;
        }

        .address-card {

            border: 1px solid #e5e7eb;

            background: white;

            transition: .35s;
        }

        .address-card:hover {

            border-color: #001e40;

            transform: translateY(-3px);

            box-shadow:
                0 12px 25px rgba(0, 0, 0, .05);
        }

        .sidebar-step {
            transition: .3s;
        }

        .sidebar-step:hover {
            transform: translateX(5px);
        }

        .floating-button {

            background:
                linear-gradient(135deg,
                    #001e40,
                    #003f8a);

            transition: .35s;
        }

        .floating-button:hover {

            transform:
                translateY(-4px);

            box-shadow:
                0 15px 35px rgba(0, 30, 64, .25);
        }

        .order-summary {

            background:
                linear-gradient(180deg,
                    rgba(255, 255, 255, .95),
                    rgba(248, 250, 252, .95));
        }

        .fade-slide {
            animation: fadeSlide .5s ease;
        }

        @keyframes fadeUp {

            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeSlide {

            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="max-w-7xl mx-auto py-10 px-5 checkout-wrapper">

        <div class="grid lg:grid-cols-12 gap-8">

            {{-- SIDEBAR --}}
            <div class="lg:col-span-3">

                <div class="glass-card rounded-[32px] p-7 sticky top-24">

                    <h2 class="text-3xl font-black text-[#001e40]">
                        Checkout
                    </h2>

                    <p class="text-gray-400 mt-2 text-sm">
                        Hoàn tất đơn hàng của bạn
                    </p>

                    <div class="mt-10 space-y-5">

                        <div
                            class="sidebar-step bg-blue-50 border-l-4 border-[#001e40] rounded-3xl p-5 flex items-center gap-4">

                            <div class="text-3xl">
                                👤
                            </div>

                            <div>

                                <p class="uppercase tracking-[3px] text-xs font-black text-[#001e40]">
                                    Bước 1
                                </p>

                                <p class="font-bold text-[#001e40] mt-1">
                                    Thông tin giao hàng
                                </p>

                            </div>

                        </div>

                        <div
                            class="sidebar-step bg-white rounded-3xl p-5 flex items-center gap-4 border border-gray-100 text-gray-400">

                            <div class="text-3xl">
                                💳
                            </div>

                            <div>

                                <p class="uppercase tracking-[3px] text-xs font-black">
                                    Bước 2
                                </p>

                                <p class="font-bold mt-1">
                                    Thanh toán
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- MAIN --}}
            <div class="lg:col-span-5">

                <form action="{{ route('checkout.saveInformation') }}" method="POST">

                    @csrf

                    <div class="glass-card rounded-[32px] p-8 fade-slide">

                        <div class="flex items-center justify-between mb-10">

                            <div>

                                <h1 class="text-4xl font-black text-[#001e40]">
                                    THÔNG TIN NHẬN HÀNG
                                </h1>

                                <p class="text-gray-400 mt-2">
                                    Điền đầy đủ thông tin để tiếp tục thanh toán
                                </p>

                            </div>

                            <div
                                class="hidden md:flex w-16 h-16 rounded-2xl bg-blue-50 items-center justify-center text-3xl">
                                🚚
                            </div>

                        </div>

                        {{-- DELIVERY --}}
                        <div class="mb-10">

                            <label class="delivery-card active rounded-[28px] p-6 flex gap-5 items-start">

                                <input type="radio" checked name="delivery_type" value="home">

                                <div>

                                    <h3 class="font-black text-xl text-[#001e40]">
                                        Giao hàng tận nơi
                                    </h3>

                                    <p class="text-gray-500 text-sm mt-2 leading-6">
                                        Giao nhanh tận nơi an toàn và tiện lợi
                                    </p>

                                </div>

                            </label>

                        </div>

                        {{-- USER INFO --}}
                        <div class="grid md:grid-cols-2 gap-6 mb-8">

                            <div>

                                <label class="block text-xs uppercase tracking-[3px] font-black text-gray-500 mb-3">
                                    Họ và tên
                                </label>

                                <input type="text" name="full_name"
                                    value="{{ $oldInfo['full_name'] ?? auth()->user()->full_name }}" class="checkout-input">

                            </div>

                            <div>

                                <label class="block text-xs uppercase tracking-[3px] font-black text-gray-500 mb-3">
                                    Số điện thoại
                                </label>

                                <input type="text" name="phone" value="{{ $oldInfo['phone'] ?? auth()->user()->phone }}"
                                    class="checkout-input">

                            </div>

                        </div>

                        {{-- ADDRESS TYPE --}}
                        <div class="mb-8">

                            <label class="block text-xs uppercase tracking-[3px] font-black text-gray-500 mb-4">
                                Chọn địa chỉ
                            </label>

                            <div class="grid md:grid-cols-2 gap-5">

                                {{-- SAVED --}}
                                <label class="delivery-card active rounded-[28px] p-5 flex gap-4 items-start"
                                    id="saved_address_card">

                                    <input type="radio" name="address_type" value="saved" {{
        ($oldInfo['address_type'] ?? 'saved')
        == 'saved'
        ? 'checked'
        : ''
                                               }} onchange="toggleAddressType()">

                                    <div>

                                        <h3 class="font-black text-lg text-[#001e40]">
                                            Địa chỉ đã lưu
                                        </h3>

                                        <p class="text-gray-500 text-sm mt-1">
                                            Sử dụng địa chỉ đã lưu trước đó
                                        </p>

                                    </div>

                                </label>

                                {{-- NEW --}}
                                <label class="delivery-card rounded-[28px] p-5 flex gap-4 items-start"
                                    id="new_address_card">

                                    <input type="radio" name="address_type" value="new" {{
        ($oldInfo['address_type'] ?? '')
        == 'new'
        ? 'checked'
        : ''
                                           }} onchange="toggleAddressType()">

                                    <div>

                                        <h3 class="font-black text-lg text-[#001e40]">
                                            Địa chỉ mới
                                        </h3>

                                        <p class="text-gray-500 text-sm mt-1">
                                            Thêm địa chỉ giao hàng mới
                                        </p>

                                    </div>

                                </label>

                            </div>

                        </div>

                        {{-- SAVED ADDRESS --}}
                        <div id="savedAddressArea" class="space-y-4 w-full mt-6">

                            @foreach($addresses as $address)

                                                <label class="address-card rounded-[28px] p-5 flex gap-4 items-start cursor-pointer">

                                                    <input type="radio" name="shipping_address_id" value="{{ $address->address_id }}" {{
                                ($oldInfo['shipping_address_id']
                                    ??
                                    $addresses->first()?->address_id)

                                ==

                                $address->address_id

                                ? 'checked'
                                : ''
                                                                                                                                                                                                                                                                   }}>

                                                    <div class="flex-1 min-w-0">

                                                        <div class="flex items-center gap-3 flex-wrap">

                                                            <h3 class="font-black text-[#001e40]">
                                                                {{ $address->full_name }}
                                                            </h3>

                                                            <span class="text-sm text-gray-500">
                                                                {{ $address->phone }}
                                                            </span>

                                                        </div>

                                                        <p class="text-gray-600 mt-2 leading-7 break-words">

                                                            {{ $address->street_address }},
                                                            {{ $address->ward }},
                                                            {{ $address->district }},
                                                            {{ $address->province }}

                                                        </p>

                                                    </div>

                                                </label>

                            @endforeach

                        </div>

                        {{-- NEW ADDRESS --}}
                        <div id="newAddressArea" style="display:none;" class="mt-8">

                            <div class="grid md:grid-cols-2 gap-5">

                                <div>

                                    <label class="block text-sm font-bold mb-2">
                                        Tỉnh / Thành phố
                                    </label>

                                    <select id="province" name="province" data-selected="{{ $oldInfo['province'] ?? '' }}"
                                        class="checkout-input">

                                        <option value="">
                                            Chọn tỉnh / thành
                                        </option>

                                    </select>

                                </div>

                                <div>

                                    <label class="block text-sm font-bold mb-2">
                                        Quận / Huyện
                                    </label>

                                    <select id="district" name="district" data-selected="{{ $oldInfo['district'] ?? '' }}"
                                        class="checkout-input">

                                        <option value="">
                                            Chọn quận / huyện
                                        </option>

                                    </select>

                                </div>

                                <div>

                                    <label class="block text-sm font-bold mb-2">
                                        Phường / Xã
                                    </label>

                                    <select id="ward" name="ward" data-selected="{{ $oldInfo['ward'] ?? '' }}"
                                        class="checkout-input">

                                        <option value="">
                                            Chọn phường / xã
                                        </option>

                                    </select>

                                </div>

                                <div>

                                    <label class="block text-sm font-bold mb-2">
                                        Địa chỉ cụ thể
                                    </label>

                                    <input type="text" name="street_address" value="{{ $oldInfo['street_address'] ?? '' }}"
                                        class="checkout-input" placeholder="Số nhà, tên đường...">

                                </div>

                            </div>

                        </div>

                        {{-- NOTE --}}
                        <div class="mt-8">

                            <label class="block text-xs uppercase tracking-[3px] font-black text-gray-500 mb-3">
                                Ghi chú đơn hàng
                            </label>

                            <textarea name="note" rows="5" class="checkout-input"
                                placeholder="Ví dụ: Giao giờ hành chính..."></textarea>

                        </div>

                        {{-- BUTTON --}}
                        <button type="submit"
                            class="floating-button w-full text-white py-5 rounded-[22px] font-black text-lg mt-10">

                            TIẾP TỤC THANH TOÁN →

                        </button>

                    </div>

                </form>

            </div>

            {{-- RIGHT --}}
            <div class="lg:col-span-4">

                <div class="glass-card order-summary rounded-[32px] p-6 sticky top-24 fade-slide">

                    <div class="flex items-center justify-between mb-6">

                        <div>

                            <h2 class="text-[30px] font-black text-[#001e40] leading-none">
                                ĐƠN HÀNG
                            </h2>

                            <p class="text-sm text-gray-400 mt-2">
                                Tổng quan sản phẩm thanh toán
                            </p>
                            {{-- SUCCESS MESSAGE --}}
                            @if(session('success'))

                                        <div class="mt-4
                                bg-green-50
                                border
                                border-green-200
                                text-green-700
                                rounded-2xl
                                px-4
                                py-3
                                font-semibold">

                                            {{ session('success') }}

                                        </div>

                            @endif

                            {{-- ERROR MESSAGE --}}
                            @if(session('error'))

                                        <div class="mt-4
                                bg-red-50
                                border
                                border-red-200
                                text-red-700
                                rounded-2xl
                                px-4
                                py-3
                                font-semibold">

                                            {{ session('error') }}

                                        </div>

                            @endif
                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl">
                            🛒
                        </div>

                    </div>

                    {{-- PRODUCTS --}}
                    <div class="space-y-5">

                        @foreach($checkoutItems as $item)

                            <div class="border border-gray-100 rounded-[28px] p-5 bg-white">

                                <div class="flex gap-4">

                                    <div
                                        class="w-[105px] h-[105px] rounded-3xl overflow-hidden border bg-gray-50 flex-shrink-0">

                                        <img src="{{ asset($item['image']) }}" class="w-full h-full object-cover">

                                    </div>

                                    <div class="flex-1 min-w-0 flex flex-col justify-between">

                                        <h3 class="font-black text-[#001e40] text-[17px] leading-7">

                                            {{ $item['name'] }}

                                        </h3>

                                        <div class="flex items-center justify-between mt-5">

                                            <span class="bg-gray-100 text-gray-500 text-sm px-4 py-1 rounded-full">
                                                x{{ $item['quantity'] }}
                                            </span>

                                            <span class="font-black text-[#001e40] text-[18px] whitespace-nowrap">

                                                {{ number_format($item['price']) }}đ

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                    {{-- PRICE --}}
                    <div class="mt-7 border-t border-gray-200 pt-6 space-y-5">

                        <div class="flex items-center justify-between">

                            <span class="text-gray-500 text-lg">
                                Tạm tính
                            </span>

                            <span class="font-black text-[#001e40] text-[18px]">

                                {{ number_format($subtotal) }}đ

                            </span>

                        </div>

                        <div class="flex items-center justify-between">

                            <span class="text-gray-500 text-lg">
                                Phí vận chuyển
                            </span>

                            <span class="font-black text-[#001e40] text-[18px]">
                                <span id="shipping_fee_text">

                                    {{-- FREE SHIP --}}
                                    @if($shippingFee <= 0)

                                        FREE SHIP

                                        {{-- CÓ TÍNH PHÍ --}}
                                    @else

                                        {{ number_format($shippingFee) }}đ

                                    @endif

                                </span>

                            </span>

                        </div>
                        <div class="flex items-center justify-between gap-3">

                            <span class="text-gray-500 text-lg">
                                VAT (10%)
                            </span>

                            <span class="font-black text-[#001e40] text-[18px] text-right break-words">

                                {{ number_format($vat) }}đ

                            </span>

                        </div>
                        <div class="flex justify-between items-start">

    <div>

        <div
            class="text-gray-500">

            Giảm giá

        </div>

        @if(count(session('discount_details', [])) > 0)

            <div
                class="mt-2
                    space-y-1">

                @foreach(session('discount_details',[]) as $item)

                    <div
                        class="flex
                            items-center
                            justify-between
                            gap-4
                            text-sm">

                        <span
                            class="text-gray-400">

                            {{ $item['code'] }}

                        </span>

                        <span
                            class="text-red-400">

                            -{{ number_format($item['amount']) }}đ

                        </span>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

    <div
        class="text-red-500
            font-bold">

        -{{ number_format($discount) }}đ

    </div>

</div>
                    </div>
                    {{-- VOUCHER --}}
                    <div class="mt-6">

                        <div class="w-full
                    bg-white
                    border
                    border-gray-200
                    rounded-[28px]
                    p-5">

                            {{-- TOP --}}
                            <div class="flex
                        items-start
                        justify-between
                        gap-4">

                                <div>

                                    <h3 class="font-black
                                text-[#001e40]
                                text-lg">

                                        Voucher giảm giá

                                    </h3>

                                    <p class="text-sm
                                text-gray-400
                                mt-1">

                                        Tối đa 3 mã • mỗi loại 1 mã

                                    </p>

                                </div>

                                <button type="button" onclick="openVoucherModal()" class="text-[#001e40]
                            font-bold
                            whitespace-nowrap">

                                    Chọn >

                                </button>

                            </div>

                            {{-- APPLIED --}}
                            @if(count(session('applied_coupons', [])) > 0)

                                <div class="flex
                                flex-wrap
                                gap-2
                                mt-4">

                                    @foreach(session('applied_coupons', []) as $coupon)

                                        <div class="bg-green-100
                                            text-green-700
                                            px-3
                                            py-2
                                            rounded-full
                                            text-sm
                                            font-bold
                                            flex
                                            items-center
                                            gap-2">

                                            <span>

                                                {{ $coupon['code'] }}

                                            </span>

                                            <form onclick="event.stopPropagation()" action="{{ route('checkout.removeVoucher') }}"
                                                method="POST">

                                                @csrf

                                                <input type="hidden" name="code" value="{{ $coupon['code'] }}">

                                                <button type="submit" class="text-red-500
                                                    hover:text-red-700">

                                                    ✕

                                                </button>

                                            </form>

                                        </div>

                                    @endforeach

                                </div>

                            @endif

                        </div>

                    </div>
                    {{-- ================= MODAL ================= --}}
                    <div id="voucherModal" class="fixed inset-0
                bg-black/40
                hidden
                items-center
                justify-center
                z-50">

                        <div class="bg-white
                    w-[720px]
                    max-w-[95%]
                    rounded-3xl
                    overflow-hidden">

                            {{-- HEADER --}}
                            <div class="border-b
                        px-6
                        py-5
                        flex
                        items-center
                        justify-between">

                                <h2 class="text-3xl
                            font-black">

                                    Chọn Voucher

                                </h2>

                                <button type="submit" class="w-5
                h-5
                flex
                items-center
                justify-center
                text-red-500
                hover:text-red-700
                hover:bg-red-100
                rounded-full
                transition
                font-black
                leading-none">

                                    ×

                                </button>

                            </div>

                            {{-- BODY --}}
                            <div class="p-6
                        max-h-[600px]
                        overflow-y-auto
                        space-y-10">

                                {{-- ================= SHIPPING ================= --}}
                                <div>

                                    <h3 class="font-black
                                text-xl
                                mb-4">

                                        Mã miễn phí vận chuyển

                                    </h3>

                                    <div class="space-y-4">

                                        @foreach($shippingVouchers as $index => $voucher)

                                                                            <div class="
                                                                            shipping-item
                                                                            {{
                                                $index >= 2
                                                &&
                                                !collect(
                                                    session(
                                                        'applied_coupons',
                                                        []
                                                    )
                                                )->contains(
                                                        'voucher_id',
                                                        $voucher->voucher_id
                                                    )
                                                ? 'hidden'
                                                : ''
                                            }}
                                                                        ">

                                                                                <label class="border
                                                                                rounded-2xl
                                                                                p-5
                                                                                flex
                                                                                justify-between
                                                                                items-center
                                                                                cursor-pointer">

                                                                                    <div>

                                                                                        <div class="font-black
                                                                                        text-[#001e40]
                                                                                        text-lg">

                                                                                            {{ $voucher->code }}

                                                                                        </div>

                                                                                        <div class="text-gray-500
                                                                                        mt-1">

                                                                                            Giảm ship
                                                                                            {{ number_format($voucher->value) }}đ

                                                                                        </div>

                                                                                    </div>

                                                                                    <input type="radio" name="shipping_voucher" class="voucher-radio"
                                                                                        data-type="shipping" value="{{ $voucher->voucher_id }}" @checked(
                                                                                            collect(
                                                                                                session(
                                                                                                    'applied_coupons',
                                                                                                    []
                                                                                                )
                                                                                            )->contains(
                                                                                                    'voucher_id',
                                                                                                    $voucher->voucher_id
                                                                                                )
                                                                                        )>

                                                                                </label>

                                                                            </div>

                                        @endforeach

                                    </div>

                                    @if(count($shippingVouchers) > 2)

                                            <button type="button" onclick="toggleVoucher(
                                            'shipping'
                                        )" class="mt-4
                                            text-[#001e40]
                                            font-bold">

                                                <span id="shipping-text">

                                                    Xem thêm

                                                </span>

                                            </button>

                                    @endif

                                </div>

                                {{-- ================= PERCENT ================= --}}
                                <div>

                                    <h3 class="font-black
                                text-xl
                                mb-4">

                                        Mã giảm %

                                    </h3>

                                    <div class="space-y-4">

                                        @foreach($percentVouchers as $index => $voucher)

                                                                            <div class="
                                                                            percent-item
                                                                            {{
                                                $index >= 2
                                                &&
                                                !collect(
                                                    session(
                                                        'applied_coupons',
                                                        []
                                                    )
                                                )->contains(
                                                        'voucher_id',
                                                        $voucher->voucher_id
                                                    )
                                                ? 'hidden'
                                                : ''
                                            }}
                                                                        ">

                                                                                <label class="border
                                                                                rounded-2xl
                                                                                p-5
                                                                                flex
                                                                                justify-between
                                                                                items-center
                                                                                cursor-pointer">

                                                                                    <div>

                                                                                        <div class="font-black
                                                                                        text-[#001e40]
                                                                                        text-lg">

                                                                                            {{ $voucher->code }}

                                                                                        </div>

                                                                                        <div class="text-gray-500
                                                                                        mt-1">

                                                                                            Giảm
                                                                                            {{ $voucher->value }}%

                                                                                        </div>

                                                                                    </div>

                                                                                    <input type="radio" name="percent_voucher" class="voucher-radio"
                                                                                        data-type="percent" value="{{ $voucher->voucher_id }}"
                                                                                        @checked(collect(session('applied_coupons', []))->contains('voucher_id', $voucher->voucher_id))>

                                                                                </label>

                                                                            </div>

                                        @endforeach

                                    </div>

                                    @if(count($percentVouchers) > 2)

                                            <button type="button" onclick="toggleVoucher(
                                            'percent'
                                        )" class="mt-4
                                            text-[#001e40]
                                            font-bold">

                                                <span id="percent-text">

                                                    Xem thêm

                                                </span>

                                            </button>

                                    @endif

                                </div>

                                {{-- ================= FIXED ================= --}}
                                <div>

                                    <h3 class="font-black
                                text-xl
                                mb-4">

                                        Mã giảm tiền

                                    </h3>

                                    <div class="space-y-4">

                                        @foreach($fixedVouchers as $index => $voucher)

                                                                        <div class="fixed-item {{$index >= 2 && !collect(session('applied_coupons', []))
                                            ->contains('voucher_id', $voucher->voucher_id) ? 'hidden' : ''}}">

                                                                            <label class="border
                                                                            rounded-2xl
                                                                            p-5
                                                                            flex
                                                                            justify-between
                                                                            items-center
                                                                            cursor-pointer">

                                                                                <div>

                                                                                    <div class="font-black
                                                                                    text-[#001e40]
                                                                                    text-lg">

                                                                                        {{ $voucher->code }}

                                                                                    </div>

                                                                                    <div class="text-gray-500
                                                                                    mt-1">

                                                                                        Giảm
                                                                                        {{ number_format($voucher->value) }}đ

                                                                                    </div>

                                                                                </div>

                                                                                <input type="radio" name="fixed_voucher" class="voucher-radio"
                                                                                    data-type="fixed" value="{{ $voucher->voucher_id }}"
                                                                                    @checked(collect(session('applied_coupons', []))->contains('voucher_id', $voucher->voucher_id))>

                                                                            </label>

                                                                        </div>

                                        @endforeach

                                    </div>

                                    @if(count($fixedVouchers) > 2)

                                            <button type="button" onclick="toggleVoucher(
                                            'fixed'
                                        )" class="mt-4
                                            text-[#001e40]
                                            font-bold">

                                                <span id="fixed-text">

                                                    Xem thêm

                                                </span>

                                            </button>

                                    @endif

                                </div>

                            </div>

                            {{-- FOOTER --}}
                            <div class="border-t
                        p-6
                        flex
                        justify-end
                        gap-4">

                                <button type="button" onclick="closeVoucherModal()" class="px-8
                            py-3
                            border
                            rounded-xl">

                                    Trở lại

                                </button>

                                <form action="{{ route('checkout.applyVoucherList') }}" method="POST">

                                    @csrf

                                    <input type="hidden" id="selected_vouchers" name="selected_vouchers">

                                    <button type="submit" class="bg-[#ee4d2d]
                                text-white
                                px-8
                                py-3
                                rounded-xl
                                font-bold">

                                        Đồng ý

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>
                    {{-- TOTAL --}}
                    <div class="mt-7 bg-[#001e40] rounded-[32px] p-6 text-white">

                        <div class="flex flex-col gap-4">

                            <div>

                                <p class="uppercase tracking-[4px] text-[11px] text-blue-200">
                                    Tổng thanh toán
                                </p>

                                <p class="text-blue-100 text-sm mt-2">
                                    Đã bao gồm VAT & phí vận chuyển
                                </p>

                            </div>

                            <div class="text-[38px] font-black leading-none whitespace-nowrap">

                                <span id="total_text">

                                    {{ number_format($total) }}đ

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        function openVoucherModal() {

            document
                .getElementById(
                    'voucherModal'
                )
                .classList
                .remove(
                    'hidden'
                );

            document
                .getElementById(
                    'voucherModal'
                )
                .classList
                .add(
                    'flex'
                );
        }

        function closeVoucherModal() {

            document
                .getElementById(
                    'voucherModal'
                )
                .classList
                .remove(
                    'flex'
                );

            document
                .getElementById(
                    'voucherModal'
                )
                .classList
                .add(
                    'hidden'
                );
        }

        function toggleVoucher(type) {

            const items =
                document.querySelectorAll(
                    '.' + type + '-item'
                );

            const text =
                document.getElementById(
                    type + '-text'
                );

            let expanded =
                text.innerText
                ===
                'Thu gọn';

            items.forEach(

                (item, index) => {

                    if (index >= 2) {

                        item.classList.toggle(
                            'hidden',
                            expanded
                        );
                    }
                }
            );

            text.innerText =
                expanded
                    ?
                    'Xem thêm'
                    :
                    'Thu gọn';
        }

        let selected = {};

        document
            .querySelectorAll(
                '.voucher-radio'
            )
            .forEach(radio => {

                if (radio.checked) {

                    selected[
                        radio.dataset.type
                    ] = radio.value;
                }

                radio.addEventListener(

                    'change',

                    function () {

                        selected[
                            this.dataset.type
                        ] = this.value;

                        document
                            .getElementById(
                                'selected_vouchers'
                            )
                            .value =
                            JSON.stringify(
                                Object.values(
                                    selected
                                )
                            );
                    }
                );
            });

        document
            .getElementById(
                'selected_vouchers'
            )
            .value =
            JSON.stringify(
                Object.values(
                    selected
                )
            );

        function toggleAddressType() {

            let saved =
                document.querySelector(
                    'input[name="address_type"][value="saved"]'
                );

            let savedArea =
                document.getElementById(
                    'savedAddressArea'
                );

            let newArea =
                document.getElementById(
                    'newAddressArea'
                );

            let savedCard =
                document.getElementById(
                    'saved_address_card'
                );

            let newCard =
                document.getElementById(
                    'new_address_card'
                );

            if (saved.checked) {

                savedArea.style.display =
                    'block';

                newArea.style.display =
                    'none';

                savedCard.classList.add(
                    'active'
                );

                newCard.classList.remove(
                    'active'
                );

            } else {

                savedArea.style.display =
                    'none';

                newArea.style.display =
                    'block';

                newCard.classList.add(
                    'active'
                );

                savedCard.classList.remove(
                    'active'
                );
            }
        }

        const province =
            document.getElementById(
                'province'
            );

        const district =
            document.getElementById(
                'district'
            );

        const ward =
            document.getElementById(
                'ward'
            );

        /*
        |--------------------------------------------------------------------------
        | LOAD PROVINCES
        |--------------------------------------------------------------------------
        */
        async function loadProvinces() {

            const response =
                await fetch(
                    'https://provinces.open-api.vn/api/p/'
                );

            const data =
                await response.json();

            province.innerHTML =
                '<option value="">Chọn tỉnh / thành</option>';

            data.forEach(item => {

                let option =
                    new Option(
                        item.name,
                        item.name
                    );

                option.dataset.code =
                    item.code;

                if (
                    province.dataset.selected
                    ==
                    item.name
                ) {
                    option.selected = true;
                }

                province.options.add(
                    option
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | LOAD DISTRICTS
        |--------------------------------------------------------------------------
        */
        async function loadDistricts(provinceName) {

            district.length = 1;

            ward.length = 1;

            const response =
                await fetch(
                    'https://provinces.open-api.vn/api/p/'
                );

            const provinces =
                await response.json();

            const provinceData =
                provinces.find(
                    p => p.name == provinceName
                );

            if (!provinceData) return;

            const districtResponse =
                await fetch(
                    `https://provinces.open-api.vn/api/p/${provinceData.code}?depth=2`
                );

            const data =
                await districtResponse.json();

            data.districts.forEach(item => {

                let option =
                    new Option(
                        item.name,
                        item.name
                    );

                option.dataset.code =
                    item.code;

                if (
                    district.dataset.selected
                    ==
                    item.name
                ) {
                    option.selected = true;
                }

                district.options.add(
                    option
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | LOAD WARDS
        |--------------------------------------------------------------------------
        */
        async function loadWards(districtName) {

            ward.length = 1;

            const response =
                await fetch(
                    'https://provinces.open-api.vn/api/d/'
                );

            const districts =
                await response.json();

            const districtData =
                districts.find(
                    d => d.name == districtName
                );

            if (!districtData) return;

            const wardResponse =
                await fetch(
                    `https://provinces.open-api.vn/api/d/${districtData.code}?depth=2`
                );

            const data =
                await wardResponse.json();

            data.wards.forEach(item => {

                let option =
                    new Option(
                        item.name,
                        item.name
                    );

                if (
                    ward.dataset.selected
                    ==
                    item.name
                ) {
                    option.selected = true;
                }

                ward.options.add(
                    option
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE SHIPPING FEE
        |--------------------------------------------------------------------------
        */
        async function updateShippingFee(provinceName) {

            if (!provinceName) return;

            try {

                const response =
                    await fetch(

                        "{{ route('shipping.fee') }}",

                        {
                            method: "POST",

                            headers: {

                                "Content-Type":
                                    "application/json",

                                "X-CSRF-TOKEN":
                                    "{{ csrf_token() }}"
                            },

                            body: JSON.stringify({

                                province: provinceName
                            })
                        }
                    );

                const data =
                    await response.json();

                let shippingText =
                    document.getElementById(
                        'shipping_fee_text'
                    );

                let shippingFee =
                    Number(data.fee);

                if (shippingFee <= 0) {

                    shippingText.innerHTML =
                        'FREE SHIP';

                } else {

                    shippingText.innerHTML =
                        new Intl.NumberFormat(
                            'vi-VN'
                        ).format(shippingFee)
                        + 'đ';
                }

                /*
                |--------------------------------------------------------------------------
                | TOTAL
                |--------------------------------------------------------------------------
                */
                let subtotal =
                                {{ $subtotal }};

                let vat =
                    subtotal * 0.1;

                let total =
                    subtotal
                    + vat
                    + shippingFee
                    - {{ $discount }};

                document.getElementById(
                    'total_text'
                ).innerHTML =

                    new Intl.NumberFormat(
                        'vi-VN'
                    ).format(total)

                    + 'đ';

            } catch (error) {

                console.log(error);

            }
        }

        /*
        |--------------------------------------------------------------------------
        | CHANGE PROVINCE
        |--------------------------------------------------------------------------
        */
        province.addEventListener(

            'change',

            async function () {

                await loadDistricts(
                    this.value
                );

                updateShippingFee(
                    this.value
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | CHANGE DISTRICT
        |--------------------------------------------------------------------------
        */
        district.addEventListener(

            'change',

            async function () {

                await loadWards(
                    this.value
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | CHANGE SAVED ADDRESS
        |--------------------------------------------------------------------------
        */
        document.querySelectorAll(
            'input[name="shipping_address_id"]'
        ).forEach(radio => {

            radio.addEventListener(

                'change',

                async function () {

                    const label =
                        this.closest('label');

                    const addressText =
                        label.querySelector('p')
                            .innerText;

                    let arr =
                        addressText.split(',');

                    let province =
                        arr[arr.length - 1]
                            .trim();

                    updateShippingFee(
                        province
                    );
                }
            );
        });

        /*
        |--------------------------------------------------------------------------
        | INIT
        |--------------------------------------------------------------------------
        */
        window.addEventListener(

            'load',

            async function () {

                toggleAddressType();

                await loadProvinces();

                let selectedProvince =
                    province.dataset.selected;

                let selectedDistrict =
                    district.dataset.selected;

                let selectedWard =
                    ward.dataset.selected;

                if (selectedProvince) {

                    province.value =
                        selectedProvince;

                    await loadDistricts(
                        selectedProvince
                    );
                }

                if (selectedDistrict) {

                    district.value =
                        selectedDistrict;

                    await loadWards(
                        selectedDistrict
                    );
                }

                if (selectedWard) {

                    ward.value =
                        selectedWard;
                }

            }
        );

    </script>
@endsection