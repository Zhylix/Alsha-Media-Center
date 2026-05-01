<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceTicketController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminServiceTicketController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\AdminPromoController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminStoreController;
use App\Http\Controllers\Admin\AdminStatsController;
use App\Http\Controllers\Admin\AdminSparepartController;
use App\Http\Controllers\Admin\AdminManagerController;
use App\Http\Controllers\SparepartController;
use Illuminate\Support\Facades\Route;

// PUBLIC ROUTES
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Spareparts
Route::get('/spareparts', [SparepartController::class, 'index'])->name('spareparts.index');
Route::get('/spareparts/{category}', [SparepartController::class, 'category'])->name('spareparts.category');
Route::get('/sparepart/{slug}', [SparepartController::class, 'show'])->name('spareparts.show');

// Services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/laptop', [ServiceController::class, 'laptop'])->name('services.laptop');
Route::get('/services/printer', [ServiceController::class, 'printer'])->name('services.printer');
Route::get('/services/pc', [ServiceController::class, 'pc'])->name('services.pc');
Route::get('/services/software', [ServiceController::class, 'software'])->name('services.software');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Service Ticket Tracking (Public)
Route::get('/tracking', [ServiceTicketController::class, 'index'])->name('tracking.index');
Route::post('/tracking', [ServiceTicketController::class, 'search'])->name('tracking.search');

// Orders
Route::get('/pesanan', [OrderController::class, 'index'])->name('order.index');
Route::post('/pesanan', [OrderController::class, 'store'])->name('order.store');
Route::get('/pesanan/success/{orderNumber}', [OrderController::class, 'success'])->name('order.success');
Route::get('/pesanan/tracking', [OrderController::class, 'trackingIndex'])->name('order.tracking');
Route::post('/pesanan/tracking', [OrderController::class, 'tracking'])->name('order.tracking.post');

// Backward compatibility
Route::get('/order/success/{orderNumber}', [OrderController::class, 'success'])->name('order.success');

// ADMIN AUTH
Route::prefix('alsha')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware(\App\Http\Middleware\AdminAuthenticated::class)->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Services CRUD (Catalog)
        Route::resource('services', AdminServiceController::class);

        // Service Tickets CRUD (Repair Tracking)
        Route::resource('service-tickets', AdminServiceTicketController::class);

        // Promos CRUD
        Route::resource('promos', AdminPromoController::class);

        // Spareparts CRUD
        Route::resource('spareparts', AdminSparepartController::class);

        // Stats CRUD
        Route::resource('stats', AdminStatsController::class)->except(['show']);

// Orders management
        Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);
        Route::post('orders/{order}/accept', [AdminOrderController::class, 'accept'])->name('orders.accept');
        Route::post('orders/{order}/reject', [AdminOrderController::class, 'reject'])->name('orders.reject');

        // Testimonials CRUD
        Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);

        // Contact messages
        Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
        Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

// Store profile
        Route::get('/store', [AdminStoreController::class, 'index'])->name('store.index');
        Route::put('/store', [AdminStoreController::class, 'update'])->name('store.update');
        Route::delete('/store/logo', [AdminStoreController::class, 'deleteLogo'])->name('store.logo.delete');
        Route::delete('/store/hero-image', [AdminStoreController::class, 'deleteHeroImage'])->name('store.hero.delete');

        // Admin Management (Only accessible by superadmin)
        Route::middleware(\App\Http\Middleware\AdminRoleMiddleware::class . ':superadmin')->group(function () {
            Route::resource('admins', AdminManagerController::class)->except(['show']);
            Route::patch('admins/{admin}/toggle', [AdminManagerController::class, 'toggleActive'])->name('admins.toggle');
        });
    });
});
