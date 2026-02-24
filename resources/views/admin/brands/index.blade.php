@extends('admin.layout')

@section('title', 'Quản lý thương hiệu')
@section('subtitle', 'Danh sách thương hiệu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Danh sách thương hiệu</h5>
    <a href="/admin/brands/create" class="btn btn-sm btn-primary">
        <i class="bi bi-plus-lg"></i> Thêm mới
    </a>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Slug</th>
                <th>Mô tả</th>
                <th class="text-end">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($brands as $brand)
            <tr>
                <td>#{{ $brand->id }}</td>
                <td>{{ $brand->name }}</td>
                <td><code>{{ $brand->slug }}</code></td>
                <td>{{ Str::limit($brand->description, 50) }}</td>
                <td class="text-end">
                    <a href="/admin/brands/{{ $brand->id }}/edit" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="/admin/brands/{{ $brand->id }}" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Chắc chắn xóa?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-4">Chưa có dữ liệu</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $brands->links() }}
@endsection