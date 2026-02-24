@extends('admin.layout')

@section('title', 'Quản lý Danh mục và Thương hiệu')
@section('subtitle', 'Tổ chức cấu trúc sản phẩm và thiết lập các bộ lọc tìm kiếm cho toàn bộ hệ thống.')

@section('content')
@php
$active = $activeCategory ?? ($categoryTree->first()?->children->first() ?? $categoryTree->first());
$activeAttributeIds = $active?->attributes->pluck('id')->all() ?? [];
@endphp

<div class="flex flex-wrap items-end justify-between gap-4 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <div class="flex flex-col gap-1">
        <p class="text-[#181611] text-3xl font-black leading-tight tracking-tight">Quản lý Danh mục và Thương hiệu</p>
        <p class="text-gray-500 text-sm font-normal">Tổ chức cấu trúc sản phẩm và thiết lập các bộ lọc tìm kiếm cho toàn bộ hệ thống.</p>
    </div>
    <div class="flex gap-3">
        <button class="flex items-center justify-center rounded-lg h-10 px-4 bg-gray-100 text-gray-700 text-sm font-bold hover:bg-gray-200 transition-colors" type="button">
            <span class="material-symbols-outlined mr-2">upload_file</span>
            Xuất dữ liệu
        </button>
        <a href="/admin/categories/create" class="flex items-center justify-center rounded-lg h-10 px-5 bg-primary text-black text-sm font-bold hover:brightness-105 transition-all shadow-md">
            <span class="material-symbols-outlined mr-2">add_circle</span>
            Thêm Danh mục mới
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="flex border-b border-gray-100 px-6">
        <button class="flex items-center gap-2 border-b-2 border-primary text-primary py-4 px-2 font-bold text-sm" type="button">
            <span class="material-symbols-outlined text-[20px]">account_tree</span>
            Cấu trúc Danh mục
        </button>
        <a href="/admin/brands" class="flex items-center gap-2 border-b-2 border-transparent text-gray-500 hover:text-primary py-4 px-6 font-bold text-sm transition-colors">
            <span class="material-symbols-outlined text-[20px]">verified</span>
            Quản lý Thương hiệu
        </a>
    </div>

    <div class="flex flex-col lg:flex-row min-h-[600px]">
        <div class="w-full lg:w-1/3 border-r border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Cây Danh mục</h3>
                <button class="text-primary text-xs font-bold hover:underline" type="button">Mở rộng tất cả</button>
            </div>
            <div class="space-y-1">
                @forelse($categoryTree as $parent)
                <div class="group flex flex-col">
                    <div class="flex items-center justify-between py-2 px-3 rounded-lg {{ $active && $active->id === $parent->id ? 'bg-gray-50 border-l-4 border-primary' : 'hover:bg-gray-50' }}">
                        <a class="flex items-center gap-2" href="/admin/categories?category={{ $parent->id }}">
                            <span class="material-symbols-outlined text-gray-400 text-[18px]">{{ $parent->children->count() ? 'keyboard_arrow_down' : 'keyboard_arrow_right' }}</span>
                            <span class="material-symbols-outlined text-primary text-[20px]">category</span>
                            <span class="text-sm font-bold text-gray-900">{{ $parent->name }}</span>
                        </a>
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a class="p-1 text-gray-400 hover:text-primary" href="/admin/categories/create?parent_id={{ $parent->id }}" title="Thêm danh mục con">
                                <span class="material-symbols-outlined text-[18px]">add</span>
                            </a>
                            <a class="p-1 text-gray-400 hover:text-blue-500" href="/admin/categories/{{ $parent->id }}/edit" title="Chỉnh sửa">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                        </div>
                    </div>
                    @if($parent->children->count())
                    <div class="pl-6 mt-1 space-y-1">
                        @foreach($parent->children as $child)
                        <div class="group/sub flex items-center justify-between py-2 px-3 rounded-lg border border-transparent hover:border-gray-200 transition-colors {{ $active && $active->id === $child->id ? 'bg-primary/5 text-primary' : '' }}">
                            <a class="flex items-center gap-2" href="/admin/categories?category={{ $child->id }}">
                                <span class="material-symbols-outlined text-gray-400 text-[18px]">keyboard_arrow_right</span>
                                <span class="text-sm font-medium {{ $active && $active->id === $child->id ? 'text-primary' : 'text-gray-700' }}">{{ $child->name }}</span>
                            </a>
                            <div class="flex gap-1 opacity-0 group-hover/sub:opacity-100 transition-opacity">
                                <a class="p-1 text-gray-400 hover:text-primary" href="/admin/categories/create?parent_id={{ $child->id }}" title="Thêm danh mục con">
                                    <span class="material-symbols-outlined text-[18px]">add</span>
                                </a>
                                <a class="p-1 text-gray-400 hover:text-blue-500" href="/admin/categories/{{ $child->id }}/edit" title="Chỉnh sửa">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-sm text-gray-500">Chưa có danh mục.</div>
                @endforelse
            </div>
        </div>

        <div class="flex-1 p-6 bg-gray-50/30">
            <div class="flex flex-wrap items-center justify-between mb-6 gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="text-primary">{{ $active?->name ?? 'Danh mục' }}</span>
                        <span class="material-symbols-outlined text-gray-400">chevron_right</span>
                        Gán thuộc tính lọc
                    </h3>
                    <p class="text-xs text-gray-500 font-medium">Chọn các thuộc tính kỹ thuật để hiển thị làm bộ lọc cho danh mục này.</p>
                </div>
                <a href="/admin/attributes/create" class="flex items-center justify-center rounded-lg h-9 px-4 bg-white border border-gray-200 text-gray-700 text-xs font-bold hover:shadow-sm transition-all">
                    <span class="material-symbols-outlined mr-1 text-[18px]">add</span>
                    Thêm thuộc tính mới
                </a>
            </div>

            <form id="category-attribute-form" method="POST" action="{{ $active ? route('categories.attributes.sync', $active) : '#' }}">
                @csrf
                <div class="overflow-x-auto rounded-xl border border-gray-100 bg-white">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tên Thuộc tính</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Giá trị gợi ý</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Hiển thị lọc</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($allAttributes ?? [] as $attribute)
                            @php
                            $isChecked = in_array($attribute->id, $activeAttributeIds, true);
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 text-sm font-bold text-gray-900">{{ $attribute->name }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse($attribute->values->take(6) as $value)
                                        <span class="px-2 py-0.5 bg-primary/10 text-primary text-[10px] font-bold rounded">{{ $value->value }}</span>
                                        @empty
                                        <span class="text-xs text-gray-400">Chưa có giá trị</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <label class="relative inline-flex items-center {{ $active ? 'cursor-pointer' : 'cursor-not-allowed opacity-60' }}">
                                        <input class="sr-only peer" name="attributes[]" type="checkbox" value="{{ $attribute->id }}" {{ $isChecked ? 'checked' : '' }} {{ $active ? '' : 'disabled' }} />
                                        <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:bg-primary transition-colors"></div>
                                        <div class="absolute left-1 top-1 size-3 bg-white rounded-full transition-all peer-checked:translate-x-4"></div>
                                    </label>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <a class="text-gray-400 hover:text-primary transition-colors" href="/admin/product-attributes/{{ $attribute->id }}/edit" title="Chỉnh sửa">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <form class="inline" method="POST" action="/admin/product-attributes/{{ $attribute->id }}" onsubmit="return confirm('Chắc chắn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-gray-400 hover:text-red-500 transition-colors ml-2" type="submit" title="Xóa">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">Chưa có thuộc tính nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="mt-10 border-t border-gray-200 pt-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Thương hiệu liên kết</h3>
                    <a class="text-primary text-sm font-bold flex items-center gap-1" href="/admin/brands">Xem tất cả <span class="material-symbols-outlined text-[16px]">arrow_forward</span></a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($brands->take(3) as $brand)
                    <div class="bg-white p-4 rounded-xl border border-gray-100 flex flex-col items-center gap-2 group hover:border-primary transition-colors cursor-pointer shadow-sm">
                        <div class="size-12 rounded-lg bg-gray-50 flex items-center justify-center overflow-hidden">
                            <span class="text-sm font-black text-gray-600">{{ strtoupper(mb_substr($brand->name, 0, 2)) }}</span>
                        </div>
                        <span class="text-xs font-bold text-gray-700">{{ $brand->name }}</span>
                    </div>
                    @endforeach
                    <a class="bg-white p-4 rounded-xl border border-gray-100 flex flex-col items-center gap-2 group hover:border-primary transition-colors cursor-pointer shadow-sm" href="/admin/brands/create">
                        <div class="size-12 rounded-lg bg-gray-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-gray-300">add</span>
                        </div>
                        <span class="text-xs font-bold text-gray-400">Thêm mới</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="bg-white rounded-xl p-4 flex flex-wrap justify-between items-center border border-gray-100 gap-4">
    <div class="flex gap-6">
        <div class="flex items-center gap-2">
            <span class="size-2 bg-green-500 rounded-full animate-pulse"></span>
            <span class="text-xs text-gray-500 font-medium">Hệ thống: Ổn định</span>
        </div>
        <div class="flex items-center gap-2 text-xs text-gray-500 font-medium">
            <span class="material-symbols-outlined text-[16px]">update</span>
            Thay đổi cuối: {{ now()->format('H:i d/m/Y') }}
        </div>
    </div>
    <div class="flex gap-2">
        <button class="h-9 px-4 rounded-lg bg-gray-100 text-xs font-bold text-gray-700" type="reset" form="category-attribute-form">Hủy bỏ</button>
        <button class="h-9 px-6 rounded-lg bg-primary text-black text-xs font-bold shadow-sm hover:brightness-105 transition-all" type="submit" form="category-attribute-form" {{ $active ? '' : 'disabled' }}>Lưu mọi thay đổi</button>
    </div>
</footer>
@endsection