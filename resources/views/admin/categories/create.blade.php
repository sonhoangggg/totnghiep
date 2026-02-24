@extends('admin.layout')

@section('title', 'Thêm danh mục')

@section('content')
<form method="POST" action="/admin/categories" enctype="multipart/form-data">
    @csrf

    <div class="max-w-5xl mx-auto space-y-6">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a class="hover:text-primary" href="/admin">Trang chủ</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <a class="hover:text-primary" href="/admin/categories">Danh mục</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-gray-900 font-semibold">Thêm danh mục mới</span>
        </nav>

        <div>
            <h1 class="text-3xl font-black tracking-tight mb-2 text-[#181611]">Thêm danh mục sản phẩm</h1>
            <p class="text-gray-500">Tạo danh mục mới để phân loại sản phẩm trong hệ thống Bee Phone.</p>
        </div>

        @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <p class="font-bold mb-2">Có lỗi khi tạo danh mục:</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 flex flex-col gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-2 mb-6 text-primary">
                        <span class="material-symbols-outlined">info</span>
                        <h3 class="text-lg font-bold text-[#181611]">Thông tin chung</h3>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-gray-700">Tên danh mục <span class="text-red-500">*</span></label>
                            <input class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-primary p-3" name="name" value="{{ old('name') }}" placeholder="Nhập tên danh mục (ví dụ: iPhone, Laptop Gaming...)" type="text" required />
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-gray-700">Đường dẫn (Slug)</label>
                            <div class="flex gap-2">
                                <input id="slug-input" class="flex-1 rounded-lg border-gray-200 focus:border-primary focus:ring-primary p-3 bg-gray-50" name="slug" value="{{ old('slug') }}" placeholder="iphone-15-pro-max" type="text" required />
                                <button id="slug-generate" class="px-4 bg-gray-100 rounded-lg hover:bg-gray-200 text-sm font-medium" type="button">Tự động</button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-gray-700">Danh mục cha</label>
                            <select class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-primary p-3" name="parent_id">
                                <option value="">-- Chọn danh mục cha (Không có) --</option>
                                @foreach($categories as $c)
                                <option value="{{ $c->id }}" {{ old('parent_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-gray-700">Mô tả</label>
                            <textarea class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-primary p-3" name="description" rows="4" placeholder="Mô tả ngắn cho danh mục...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-2 mb-6 text-primary">
                        <span class="material-symbols-outlined">image</span>
                        <h3 class="text-lg font-bold text-[#181611]">Hình ảnh &amp; Biểu tượng</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="block text-sm font-semibold mb-3 text-gray-700">Ảnh Thumbnail (1:1)</p>
                            <label class="border-2 border-dashed border-gray-200 rounded-xl p-8 flex flex-col items-center justify-center bg-gray-50 hover:bg-primary/5 transition-colors cursor-pointer group">
                                <span class="material-symbols-outlined text-gray-400 group-hover:text-primary text-4xl mb-2">add_photo_alternate</span>
                                <span class="text-sm text-gray-500 group-hover:text-primary">Tải lên ảnh</span>
                                <input class="hidden" type="file" name="thumbnail" accept="image/*" />
                            </label>
                        </div>
                        <div>
                            <p class="block text-sm font-semibold mb-3 text-gray-700">Banner danh mục (16:9)</p>
                            <label class="border-2 border-dashed border-gray-200 rounded-xl p-8 flex flex-col items-center justify-center bg-gray-50 hover:bg-primary/5 transition-colors cursor-pointer group h-[120px]">
                                <span class="material-symbols-outlined text-gray-400 group-hover:text-primary text-4xl mb-2">panorama</span>
                                <span class="text-sm text-gray-500 group-hover:text-primary">Tải lên banner</span>
                                <input class="hidden" type="file" name="banner" accept="image/*" />
                            </label>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold mb-2 text-gray-700">Biểu tượng (Icon Menu)</label>
                            <input id="icon-input" type="hidden" name="icon" value="{{ old('icon') }}" />
                            <div class="flex flex-wrap gap-4">
                                <button class="w-12 h-12 flex items-center justify-center rounded-lg border-2 border-primary bg-primary/10 text-primary" type="button" data-icon-value="smartphone">
                                    <span class="material-symbols-outlined">smartphone</span>
                                </button>
                                <button class="w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-200 hover:border-primary hover:bg-primary/5 transition-colors" type="button" data-icon-value="laptop_mac">
                                    <span class="material-symbols-outlined text-gray-500">laptop_mac</span>
                                </button>
                                <button class="w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-200 hover:border-primary hover:bg-primary/5 transition-colors" type="button" data-icon-value="watch">
                                    <span class="material-symbols-outlined text-gray-500">watch</span>
                                </button>
                                <button class="w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-200 hover:border-primary hover:bg-primary/5 transition-colors" type="button" data-icon-value="headphones">
                                    <span class="material-symbols-outlined text-gray-500">headphones</span>
                                </button>
                                <button class="w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-200 hover:border-primary hover:bg-primary/5 transition-colors" type="button" data-icon-value="tablet">
                                    <span class="material-symbols-outlined text-gray-500">tablet</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2 text-primary">
                            <span class="material-symbols-outlined">filter_list</span>
                            <h3 class="text-lg font-bold text-[#181611]">Thuộc tính lọc (Nâng cao)</h3>
                        </div>
                        <a class="flex items-center gap-1 px-3 py-1.5 bg-primary/10 text-primary rounded-lg text-sm font-bold hover:bg-primary/20 transition-colors" href="/admin/product-attributes/create">
                            <span class="material-symbols-outlined text-sm">add</span> Thêm thuộc tính
                        </a>
                    </div>
                    <div class="overflow-hidden rounded-lg border border-gray-100">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="px-4 py-3 font-bold">Tên thuộc tính</th>
                                    <th class="px-4 py-3 font-bold">Giá trị hiển thị</th>
                                    <th class="px-4 py-3 font-bold text-right">Hiển thị lọc</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($attributes as $attr)
                                <tr>
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-medium text-gray-800">{{ $attr->name }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($attr->values->take(6) as $value)
                                            <span class="px-2 py-0.5 bg-gray-100 rounded-md text-xs">{{ $value->value }}</span>
                                            @empty
                                            <span class="text-xs text-gray-400">Chưa có giá trị</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input class="sr-only peer" type="checkbox" name="attributes[]" value="{{ $attr->id }}" {{ in_array($attr->id, old('attributes', [])) ? 'checked' : '' }} />
                                            <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-primary"></div>
                                            <div class="absolute left-[2px] top-[2px] h-5 w-5 bg-white rounded-full transition-all peer-checked:translate-x-5"></div>
                                        </label>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-6 text-center text-sm text-gray-500">Chưa có thuộc tính nào.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-2 mb-6 text-primary">
                        <span class="material-symbols-outlined">settings</span>
                        <h3 class="text-lg font-bold text-[#181611]">Hiển thị</h3>
                    </div>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-bold text-gray-700">Menu chính</p>
                                <p class="text-xs text-gray-500">Hiển thị trên thanh điều hướng</p>
                            </div>
                            <input type="hidden" name="menu_enabled" value="0" />
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input class="sr-only peer" type="checkbox" name="menu_enabled" value="1" {{ old('menu_enabled') ? 'checked' : '' }} />
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-primary"></div>
                                <div class="absolute left-[2px] top-[2px] h-5 w-5 bg-white rounded-full transition-all peer-checked:translate-x-5"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-bold text-gray-700">Trang chủ</p>
                                <p class="text-xs text-gray-500">Hiển thị mục nổi bật ở home</p>
                            </div>
                            <input type="hidden" name="home_enabled" value="0" />
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input class="sr-only peer" type="checkbox" name="home_enabled" value="1" {{ old('home_enabled') ? 'checked' : '' }} />
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-primary"></div>
                                <div class="absolute left-[2px] top-[2px] h-5 w-5 bg-white rounded-full transition-all peer-checked:translate-x-5"></div>
                            </label>
                        </div>
                        <hr class="border-gray-100" />
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-700">Thứ tự sắp xếp</label>
                            <input class="w-full rounded-lg border-gray-200 focus:border-primary focus:ring-primary p-2" type="number" name="sort_order" value="{{ old('sort_order', 1) }}" min="0" />
                            <p class="text-[11px] text-gray-400 mt-1">Số nhỏ hơn sẽ đứng trước</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-2 mb-4 text-primary">
                        <span class="material-symbols-outlined">search_check</span>
                        <h3 class="text-lg font-bold text-[#181611]">Tối ưu SEO</h3>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-400 mb-1">Thẻ tiêu đề</label>
                            <input class="w-full text-xs rounded border-gray-200" name="seo_title" value="{{ old('seo_title') }}" placeholder="Bee Phone - [Tên danh mục]" type="text" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-400 mb-1">Mô tả (Meta Description)</label>
                            <textarea class="w-full text-xs rounded border-gray-200" name="seo_description" placeholder="Mô tả danh mục giúp cải thiện kết quả tìm kiếm..." rows="3">{{ old('seo_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sticky bottom-6 bg-white border border-gray-200 rounded-xl px-6 py-4 flex items-center justify-between">
            <div class="hidden sm:flex items-center gap-2 text-sm text-gray-500">
                <span class="material-symbols-outlined text-lg">info</span>
                <span>Tất cả thay đổi chưa được lưu</span>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <a class="flex-1 sm:flex-none px-8 py-2.5 rounded-lg border border-gray-300 font-bold text-gray-600 hover:bg-gray-50 text-center" href="/admin/categories">Hủy</a>
                <button class="flex-1 sm:flex-none px-10 py-2.5 rounded-lg bg-primary text-black font-black hover:bg-[#e2b120] shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2" type="submit">
                    <span class="material-symbols-outlined text-xl">save</span> Tạo danh mục
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const nameInput = document.querySelector('input[name="name"]');
        const slugInput = document.getElementById('slug-input');
        const slugButton = document.getElementById('slug-generate');
        const iconInput = document.getElementById('icon-input');
        const iconButtons = document.querySelectorAll('[data-icon-value]');

        if (!nameInput || !slugInput || !slugButton) {
            return;
        }

        const slugify = (text) => {
            return text
                .toString()
                .normalize('NFD')
                .replace(/\p{Diacritic}/gu, '')
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/[\s-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        };

        slugButton.addEventListener('click', () => {
            slugInput.value = slugify(nameInput.value || '');
        });

        if (iconInput && iconButtons.length) {
            iconButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const value = btn.dataset.iconValue || '';
                    iconInput.value = value;
                    iconButtons.forEach((b) => b.classList.remove('border-primary', 'bg-primary/10', 'text-primary'));
                    btn.classList.add('border-primary', 'bg-primary/10', 'text-primary');
                });
            });
        }
    });
</script>
@endpush