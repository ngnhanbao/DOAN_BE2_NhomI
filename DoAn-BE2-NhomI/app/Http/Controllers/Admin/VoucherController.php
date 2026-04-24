<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::all();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers,code',
            'discount_type' => 'required|in:percent,amount',
            'discount_value' => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Voucher::create($request->all());

        return redirect()->route('vouchers.index')->with('success', 'Tạo voucher thành công!');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->update($request->all());
        return redirect()->route('vouchers.index')->with('success', 'Cập nhật voucher thành công!');
    }

    public function destroy($id)
    {
        Voucher::destroy($id);
        return redirect()->route('vouchers.index')->with('success', 'Xóa voucher thành công!');
    }
}
