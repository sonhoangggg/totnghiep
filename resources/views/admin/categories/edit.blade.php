@extends('admin.layout')

@section('title', 'Chỉnh sửa danh mục')

@section('content')
<div class="mb-4">
    <a href="/admin/categories" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-chevron-left"></i> Quay lại
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card-ghost">
            <form method="POST" action="/admin/categories/{{ $category->id }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Tên danh mục</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $category->name }}" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Danh mục cha</label>
                    <select name="parent_id" class="form-select">
                        <option value="">-- Không có --</option>
                        @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ old('parent_id', $category->parent_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ $category->slug }}" required>
                    @error('slug') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ $category->description }}</textarea>
                    @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Thuộc tính lọc theo danh mục</label>
                    <select name="attributes[]" class="form-select" multiple>
                        @foreach($attributes as $attr)
                        <option value="{{ $attr->id }}" {{ in_array($attr->id, old('attributes', $selectedAttributes)) ? 'selected' : '' }}>{{ $attr->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">VD: Laptop có RAM, CPU, Ổ cứng...</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Lưu thay đổi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection