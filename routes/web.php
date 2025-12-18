<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\UniversityDashboardController;
use App\Http\Controllers\AdminDashboardController;

// الصفحات العامة
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/verify', [CertificateController::class, 'verifyForm'])->name('verify');
Route::post('/verify', [CertificateController::class, 'verify'])->name('verify.post');
Route::get('/certificate/{number}', [CertificateController::class, 'show'])->name('certificate.show');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.post');

// لوحات التحكم (تتطلب تسجيل الدخول)
Route::middleware(['auth'])->group(function () {
    
    // لوحة تحكم الجامعات
    Route::prefix('university')->name('university.')->middleware('role:university_admin')->group(function () {
        Route::get('/dashboard', [UniversityDashboardController::class, 'index'])->name('dashboard');
        
        // إدارة الشهادات
        Route::prefix('certificates')->name('certificates.')->group(function () {
            Route::get('/', [UniversityDashboardController::class, 'certificatesIndex'])->name('index');
            Route::get('/create', [UniversityDashboardController::class, 'create'])->name('create');
            Route::post('/', [UniversityDashboardController::class, 'store'])->name('store');
            Route::get('/{certificate}', [UniversityDashboardController::class, 'show'])->name('show');
            Route::get('/{certificate}/edit', [UniversityDashboardController::class, 'edit'])->name('edit');
            Route::put('/{certificate}', [UniversityDashboardController::class, 'update'])->name('update');
            Route::delete('/{certificate}', [UniversityDashboardController::class, 'destroy'])->name('destroy');
        });
        
        Route::get('/logs', [UniversityDashboardController::class, 'logs'])->name('logs');
        Route::get('/export', [UniversityDashboardController::class, 'export'])->name('export');
    });
    
    // لوحة تحكم الإدارة المركزية
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // إدارة الجامعات
        Route::prefix('universities')->name('universities.')->group(function () {
            Route::get('/create', [AdminDashboardController::class, 'create'])->name('create');
            Route::post('/', [AdminDashboardController::class, 'store'])->name('store');
            Route::get('/{university}', [AdminDashboardController::class, 'show'])->name('show');
            Route::get('/{university}/edit', [AdminDashboardController::class, 'edit'])->name('edit');
            Route::put('/{university}', [AdminDashboardController::class, 'update'])->name('update');
            Route::delete('/{university}', [AdminDashboardController::class, 'destroy'])->name('destroy');
        });
        
        // إدارة المستخدمين
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        });
        
        Route::get('/statistics', [AdminDashboardController::class, 'statistics'])->name('statistics');
        Route::get('/suspicious', [AdminDashboardController::class, 'suspicious'])->name('suspicious');
        Route::get('/logs', [AdminDashboardController::class, 'logs'])->name('logs');
    });
});

require __DIR__.'/auth.php';