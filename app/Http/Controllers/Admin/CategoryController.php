<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with(['parent', 'attributes'])->paginate(15);
        $categoryTree = Category::with(['children'])->whereNull('parent_id')->orderBy('name')->get();
        $activeCategory = null;
        $activeId = $request->query('category');
        if ($activeId) {
            $activeCategory = Category::find($activeId);
        }
        if (! $activeCategory) {
            $activeCategory = $categoryTree->first();
        }
        if (!$activeCategory) {
            $activeCategory = Category::orderBy('name')->first();
        }
        if ($activeCategory) {
            $activeCategory->load(['attributes.values', 'children']);
        }
        $allAttributes = ProductAttribute::with('values')->orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        return view('admin.categories.index', compact('categories', 'categoryTree', 'activeCategory', 'brands', 'allAttributes'));
    }

    public function syncAttributes(Request $request, Category $category)
    {
        $validated = $request->validate([
            'attributes' => 'nullable|array',
            'attributes.*' => 'exists:product_attributes,id',
        ]);

        $category->attributes()->sync($validated['attributes'] ?? []);

        return redirect()->route('categories.index', ['category' => $category->id])
            ->with('success', 'Đã cập nhật thuộc tính cho danh mục.');
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $attributes = ProductAttribute::orderBy('name')->get();
        return view('admin.categories.create', compact('categories', 'attributes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'required|string|unique:categories',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'attributes' => 'nullable|array',
            'attributes.*' => 'exists:product_attributes,id',
            'thumbnail' => 'nullable|image|max:4096',
            'banner' => 'nullable|image|max:8192',
            'icon' => 'nullable|string|max:191',
            'menu_enabled' => 'sometimes|boolean',
            'home_enabled' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
            'seo_title' => 'nullable|string|max:191',
            'seo_description' => 'nullable|string',
        ]);

        $data = $validated;
        unset($data['attributes']);

        if ($request->hasFile('thumbnail')) {
            $data['image'] = $request->file('thumbnail')->store('categories', 'public');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('categories/banners', 'public');
        }

        if (!array_key_exists('menu_enabled', $data)) {
            $data['menu_enabled'] = false;
        }

        if (!array_key_exists('home_enabled', $data)) {
            $data['home_enabled'] = false;
        }

        $category = Category::create($data);
        if (!empty($validated['attributes'])) {
            $category->attributes()->sync($validated['attributes']);
        }
        return redirect('/admin/categories')->with('success', 'Tạo danh mục thành công');
    }

    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->orderBy('name')->get();
        $attributes = ProductAttribute::orderBy('name')->get();
        $selectedAttributes = $category->attributes->pluck('id')->toArray();
        return view('admin.categories.edit', compact('category', 'categories', 'attributes', 'selectedAttributes'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'required|string|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'attributes' => 'nullable|array',
            'attributes.*' => 'exists:product_attributes,id',
            'thumbnail' => 'nullable|image|max:4096',
            'banner' => 'nullable|image|max:8192',
            'icon' => 'nullable|string|max:191',
            'menu_enabled' => 'sometimes|boolean',
            'home_enabled' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
            'seo_title' => 'nullable|string|max:191',
            'seo_description' => 'nullable|string',
        ]);

        if (!empty($validated['parent_id']) && (int) $validated['parent_id'] === (int) $category->id) {
            $validated['parent_id'] = null;
        }
        $data = $validated;
        unset($data['attributes']);

        if ($request->hasFile('thumbnail')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('thumbnail')->store('categories', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($category->banner && Storage::disk('public')->exists($category->banner)) {
                Storage::disk('public')->delete($category->banner);
            }
            $data['banner'] = $request->file('banner')->store('categories/banners', 'public');
        }

        if (!array_key_exists('menu_enabled', $data)) {
            $data['menu_enabled'] = false;
        }

        if (!array_key_exists('home_enabled', $data)) {
            $data['home_enabled'] = false;
        }

        $category->update($data);
        if (array_key_exists('attributes', $validated)) {
            $category->attributes()->sync($validated['attributes'] ?? []);
        }
        return redirect('/admin/categories')->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/admin/categories')->with('success', 'Xóa danh mục thành công');
    }
}
