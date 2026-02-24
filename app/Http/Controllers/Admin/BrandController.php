<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('name')->paginate(15);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:brands,slug',
            'description' => 'nullable|string',
        ]);

        Brand::create($validated);
        return redirect('/admin/brands')->with('success', 'Tạo thương hiệu thành công');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:brands,slug,' . $brand->id,
            'description' => 'nullable|string',
        ]);

        $brand->update($validated);
        return redirect('/admin/brands')->with('success', 'Cập nhật thương hiệu thành công');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect('/admin/brands')->with('success', 'Xóa thương hiệu thành công');
    }
}
