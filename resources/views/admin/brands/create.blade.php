@extends('admin.layout')

@section('title', 'Thêm thương hiệu')

@section('content')
<div class="mb-4">
    <a href="/admin/brands" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-chevron-left"></i> Quay lại
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card-ghost">
            <form method="POST" action="/admin/brands">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Tên thương hiệu</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}">
                    @error('slug') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description') }}</textarea>
                    @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Tạo thương hiệu
                </button>
            </form>
        </div>
    </div>
</div>
@endsection