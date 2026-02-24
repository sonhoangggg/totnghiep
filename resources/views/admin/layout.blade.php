<!DOCTYPE html>
<html class="light" lang="vi">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Tổng quan Quản trị Bee Phone')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#f6c12a",
                        "background-light": "#f8f8f5",
                        "background-dark": "#221e10",
                    },
                    fontFamily: {
                        "display": ["Manrope"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .admin-shell {
            display: flex;
            height: 100vh;
            overflow-x: hidden;
        }

        .admin-shell>aside {
            flex: 0 0 18rem;
        }

        .admin-shell>main {
            flex: 1 1 auto;
            min-width: 0;
        }

        body {
            font-family: 'Manrope', sans-serif;
        }

        .bg-primary {
            background-color: #f6c12a !important;
        }

        .text-primary {
            color: #f6c12a !important;
        }

        .border-primary {
            border-color: #f6c12a !important;
        }

        aside nav a {
            text-decoration: none;
        }
    </style>
</head>

<body class="bg-background-light text-[#181611] transition-colors duration-200">
    <div class="admin-shell">
        <aside class="w-72 bg-white border-r border-[#e6e3db] flex flex-col h-full shrink-0">
            <div class="p-6 flex items-center gap-3">
                <div class="bg-primary rounded-xl size-10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-white font-bold">smartphone</span>
                </div>
                <div class="flex flex-col">
                    <h1 class="text-[#181611] text-lg font-bold leading-tight">Bee Phone Admin</h1>
                    <p class="text-[#8a8060] text-xs font-medium">Hệ thống quản trị thương mại</p>
                </div>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
                <a href="/admin" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin') || request()->is('admin/dashboard') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">grid_view</span>
                    <p class="text-sm font-semibold">Tổng quan</p>
                </a>
                <a href="/admin/products" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/products*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">inventory_2</span>
                    <p class="text-sm font-semibold">Quản lý sản phẩm</p>
                </a>
                <a href="/admin/categories" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/categories*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">category</span>
                    <p class="text-sm font-semibold">Quản lý danh mục</p>
                </a>
                <a href="/admin/orders" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/orders*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">shopping_cart</span>
                    <p class="text-sm font-semibold">Quản lý đơn hàng</p>
                </a>
                <a href="/admin/return-requests" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/return-requests*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">assignment_return</span>
                    <p class="text-sm font-semibold">Quản lý đổi/trả</p>
                </a>
                <a href="/admin/payments" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/payments*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">payments</span>
                    <p class="text-sm font-semibold">Quản lý thanh toán</p>
                </a>
                <a href="/admin/wallets" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/wallets*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                    <p class="text-sm font-semibold">Quản lý ví tiền</p>
                </a>
                <a href="/admin/users" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/users*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">person</span>
                    <p class="text-sm font-semibold">Quản lý người dùng</p>
                </a>
                <a href="/admin/analytics" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/analytics*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">bar_chart</span>
                    <p class="text-sm font-semibold">Báo cáo doanh thu</p>
                </a>
                <a href="/admin/search-logs" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/search-logs*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">manage_search</span>
                    <p class="text-sm font-semibold">Lịch sử tìm kiếm</p>
                </a>
                <a href="/admin/articles" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/articles*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">article</span>
                    <p class="text-sm font-semibold">Quản lý bài viết</p>
                </a>
                <a href="/admin/reviews" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/reviews*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">star</span>
                    <p class="text-sm font-semibold">Đánh giá</p>
                </a>
                <a href="/admin/promotions" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/promotions*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">sell</span>
                    <p class="text-sm font-semibold">Khuyến mãi</p>
                </a>
                <a href="/admin/loyalty-points" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/loyalty-points*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">toll</span>
                    <p class="text-sm font-semibold">Quản lý điểm thưởng</p>
                </a>
                <a href="/admin/banners" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/banners*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">image</span>
                    <p class="text-sm font-semibold">Banner</p>
                </a>
                <a href="/admin/tickets" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/tickets*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">support_agent</span>
                    <p class="text-sm font-semibold">Hỗ trợ</p>
                </a>
                <a href="/admin/settings" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('admin/settings*') ? 'bg-primary/10 text-[#181611]' : 'text-[#5e5a4d] hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined">settings</span>
                    <p class="text-sm font-semibold">Cài đặt hệ thống</p>
                </a>
            </nav>
            <div class="p-6 border-t border-[#e6e3db]">
                <div class="flex items-center gap-3">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" data-alt="Admin profile avatar placeholder" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCEKV-9ug9g_ztDiHdD64z_bgaOtVjvpdIT9UuFjaB9wd1RzWU6WQQX29DIdcwf89shcU32d3kbS1hzEBvTQm3n-VGkR5qcHBAEcbtBCZHfxRXzFFldDUkSZzia9PwBcww32ll1b8fHZMZHwpBxU36Z-x9d0v94JMmSFh3O1CVhky-goMXqhdTVJvcOeHsK6ySjifQ2NDDOk1HTxeuQO8FOb_d0Nj4dScHmiqCSmkafYlD3IAL6o65xghjwpCpkbSWGAwoHKzmZJOw');"></div>
                    <div class="flex flex-col">
                        <p class="text-[#181611] text-sm font-bold">Quản trị viên</p>
                        <p class="text-[#8a8060] text-xs">admin@beephone.vn</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-h-0">
            <header class="h-16 bg-white border-b border-[#e6e3db] px-8 flex items-center justify-between shrink-0">
                <div class="flex-1 max-w-md">
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#8a8060] text-xl">search</span>
                        <input class="w-full bg-[#f5f3f0] border-none rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-primary/50 text-[#181611] placeholder-[#8a8060]" placeholder="Tìm kiếm nhanh đơn hàng, sản phẩm..." type="text" />
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button class="p-2 hover:bg-[#f5f3f0] rounded-full relative text-[#181611]" type="button">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-2 right-2 size-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    <button class="p-2 hover:bg-[#f5f3f0] rounded-full text-[#181611]" type="button">
                        <span class="material-symbols-outlined">help</span>
                    </button>
                    <div class="h-8 w-[1px] bg-[#e6e3db] mx-2"></div>
                    @if(session()->has('admin_id'))
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2" type="submit">
                            <span class="material-symbols-outlined text-[18px]">logout</span>
                            Đăng xuất
                        </button>
                    </form>
                    @else
                    {{-- <a href="{{ route('admin.login') }}" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-sm font-bold">Đăng nhập</a> --}}
                    @endif
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8 space-y-6">
                @if(session('success'))
                <div class="rounded-xl bg-primary/10 border border-primary/30 px-4 py-3 text-sm text-[#7a5a00]">
                    {{ session('success') }}
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('form[data-ajax-delete]').forEach((form) => {
                form.addEventListener('submit', async (event) => {
                    event.preventDefault();

                    const confirmMessage = form.dataset.confirm || 'Xóa mục này?';
                    if (!window.confirm(confirmMessage)) {
                        return;
                    }

                    const tokenInput = form.querySelector('input[name="_token"]');
                    const token = tokenInput ? tokenInput.value : '';
                    const removeSelector = form.dataset.removeSelector || '';

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                _method: 'DELETE'
                            }),
                        });

                        if (!response.ok) {
                            throw new Error('Delete failed');
                        }

                        if (removeSelector) {
                            const target = form.closest(removeSelector);
                            if (target) {
                                target.remove();
                                return;
                            }
                        }

                        window.location.reload();
                    } catch (error) {
                        window.alert('Xóa thất bại.');
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>