<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminShipmentController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminStoreController;
use Illuminate\Support\Facades\Route;

// ===================== PUBLIC ROUTES =====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/shipment', [ShipmentController::class, 'index'])->name('shipment');
Route::get('/payment', [PaymentController::class, 'index'])->name('payment');

// Services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/laptop', [ServiceController::class, 'laptop'])->name('services.laptop');
Route::get('/services/printer', [ServiceController::class, 'printer'])->name('services.printer');
Route::get('/services/hp', [ServiceController::class, 'hp'])->name('services.hp');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Orders
Route::get('/order', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success/{orderNumber}', [OrderController::class, 'success'])->name('order.success');
Route::get('/order/track', [OrderController::class, 'track'])->name('order.track');

// ===================== ADMIN AUTH (HIDDEN URL) =====================
Route::prefix('alsha')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware(\App\Http\Middleware\AdminAuthenticated::class)->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Services CRUD
        Route::resource('services', AdminServiceController::class);

        // Orders management
        Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);

        // Shipment options CRUD
        Route::resource('shipments', AdminShipmentController::class)->except(['show']);

        // Payment methods CRUD
        Route::resource('payments', AdminPaymentController::class)->except(['show']);

        // Testimonials CRUD
        Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);

        // Contact messages
        Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
        Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

        // Store profile
        Route::get('/store', [AdminStoreController::class, 'index'])->name('store.index');
        Route::put('/store', [AdminStoreController::class, 'update'])->name('store.update');
    });
});
