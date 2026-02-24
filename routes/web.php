<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ArticleCategoryController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\ReturnRequestController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\LoyaltyPointController;
use App\Http\Controllers\Admin\SearchLogController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ProductAttributeController as AdminProductAttributeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Middleware\AdminAuth;

Route::get('/', function () {
    return view('welcome');
});

// API routes were moved to routes/api.php so admin web routes remain distinct.

// Admin auth routes
Route::get('admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin web routes (protected by simple session-based auth middleware)
Route::prefix('admin')->middleware(AdminAuth::class)->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);

    // Admin CRUD resources
    Route::resource('products', AdminProductController::class);
    Route::post('products/{product}/toggle-active', [AdminProductController::class, 'toggleActive'])->name('products.toggle_active');

    Route::post('products/{product}/media', [AdminProductController::class, 'uploadMedia'])->name('products.media.upload');
    Route::post('products/{product}/media/reorder', [AdminProductController::class, 'reorderMedia'])->name('products.media.reorder');
    Route::post('products/media/{media}/set-primary', [AdminProductController::class, 'setPrimary'])->name('products.media.set_primary');
    Route::delete('products/media/{media}', [AdminProductController::class, 'deleteMedia'])->name('products.media.delete');
    Route::get('products/{product}/variants', [AdminProductController::class, 'variants'])->name('products.variants.index');
    Route::get('products/{product}/variants/create', [AdminProductController::class, 'variantsCreate'])->name('products.variants.create');
    Route::post('products/{product}/variants', [AdminProductController::class, 'storeVariant'])->name('products.variants.store');
    Route::get('products/{product}/variants/{variant}/edit', [AdminProductController::class, 'variantsEdit'])->name('products.variants.edit');
    Route::put('products/{product}/variants/{variant}', [AdminProductController::class, 'updateVariant'])->name('products.variants.update');
    Route::get('products/{product}/variants/{variant}/delete', [AdminProductController::class, 'variantsDelete'])->name('products.variants.delete');
    Route::delete('products/{product}/variants/{variant}', [AdminProductController::class, 'destroyVariant'])->name('products.variants.destroy');
    // Product attributes management
    Route::resource('product-attributes', AdminProductAttributeController::class);
    Route::post('product-attributes/{productAttribute}/values', [AdminProductAttributeController::class, 'addValue'])->name('product-attributes.values.add');
    Route::put('product-attributes/{productAttribute}/values/{value}', [AdminProductAttributeController::class, 'updateValue'])->name('product-attributes.values.update');
    Route::delete('product-attributes/{productAttribute}/values/{value}', [AdminProductAttributeController::class, 'deleteValue'])->name('product-attributes.values.delete');
    Route::resource('brands', BrandController::class);
    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/attributes', [CategoryController::class, 'syncAttributes'])->name('categories.attributes.sync');
    Route::resource('users', UserController::class);
    Route::post('users/{user}/lock', [UserController::class, 'toggleLock'])->name('users.lock');
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset_password');
    Route::get('users/{user}/activities', [UserController::class, 'activities'])->name('users.activities');
    Route::resource('orders', OrderController::class, ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
    Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('orders/{order}/return', [OrderController::class, 'confirmReturn'])->name('orders.return');
    Route::get('orders/{order}/print', [OrderController::class, 'print'])->name('orders.print');
    Route::resource('payments', PaymentController::class, ['only' => ['index', 'show', 'edit', 'update']]);
    Route::resource('reviews', ReviewController::class, ['only' => ['index', 'show', 'destroy', 'update']]);
    Route::resource('articles', ArticleController::class)->except(['show']);
    Route::get('articles/{article}', [ArticleController::class, 'edit'])->name('articles.show');
    Route::resource('article-categories', ArticleCategoryController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('tickets', TicketController::class, ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
    Route::resource('return-requests', ReturnRequestController::class, ['only' => ['index', 'show', 'edit', 'update']]);

    // New controllers for missing modules
    Route::resource('wallets', WalletController::class, ['only' => ['index', 'show', 'edit', 'update']]);
    Route::post('wallets/{wallet}/deposits/{transaction}/approve', [WalletController::class, 'approveDeposit'])->name('wallets.deposits.approve');
    Route::post('wallets/{wallet}/withdrawals/{transaction}/approve', [WalletController::class, 'approveWithdraw'])->name('wallets.withdrawals.approve');
    Route::resource('loyalty-points', LoyaltyPointController::class);
    Route::post('loyalty-points/config', [LoyaltyPointController::class, 'saveConfig'])->name('loyalty-points.config');
    Route::post('loyalty-points/redeem', [LoyaltyPointController::class, 'redeem'])->name('loyalty-points.redeem');
    Route::post('loyalty-points/redemptions/{redemption}/approve', [LoyaltyPointController::class, 'approveRedemption'])->name('loyalty-points.redemptions.approve');
    Route::post('loyalty-points/redemptions/{redemption}/reject', [LoyaltyPointController::class, 'rejectRedemption'])->name('loyalty-points.redemptions.reject');
    Route::resource('search-logs', SearchLogController::class, ['only' => ['index', 'show', 'destroy']]);
    Route::resource('order-statuses', OrderStatusController::class, ['only' => ['index', 'show', 'destroy']]);
    Route::get('databoard', [AnalyticsController::class, 'index'])->name('databoard.index');

    // Settings (single page, not full resource)
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
