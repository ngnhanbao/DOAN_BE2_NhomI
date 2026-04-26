<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Carbon;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::query();
        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand_id', $request->search);
        }

        $brands = $query->paginate(10);
        
        // KPI statistics
        $stats = [
            'total' => Brand::count(),
            'active' => Brand::where('is_active', 1)->count(),
            'inactive' => Brand::where('is_active', 0)->count(),
        ];

        return view('admin.brands.index', compact('brands', 'stats'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:brands,slug',
            'logo_url' => 'nullable|url',
        ]);

        Brand::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'logo_url' => $request->logo_url,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Thêm thương hiệu mới thành công!');
    }

    public function show(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.show', compact('brand'));
    }

    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, string $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:brands,slug,' . $id . ',brand_id',
            'logo_url' => 'nullable|url',
        ]);

        $brand->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'logo_url' => $request->logo_url,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Cập nhật thương hiệu thành công!');
    }

    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        
        return redirect()->route('admin.brands.index')->with('success', 'Đã xóa thương hiệu thành công!');
    }

    public function toggleStatus(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->is_active = !$brand->is_active;
        $brand->save();

        $status = $brand->is_active ? 'Hoạt động' : 'Đang ẩn';
        return redirect()->back()->with('success', "Đã chuyển trạng thái thương hiệu \"{$brand->name}\" sang {$status}.");
    }
}
