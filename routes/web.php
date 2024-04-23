<?php

use App\Http\Controllers\AppraisalController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FinanceApplicationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TestBookingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/inventory', [CarController::class, 'inventory'])->name('cars.inventory');
Route::get('/inventory/{car:slug}', [CarController::class, 'show'])->name('cars.show');
Route::post('/inventory/{car}/biddings', [CarController::class, 'bid'])->name('cars.bid');

Route::get('/finance-application', [FinanceApplicationController::class, 'create'])->name('finance-application.create');
Route::post('/finance-application', [FinanceApplicationController::class, 'store'])->name('finance-application.store');

Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

Route::get('/test-booking', [TestBookingController::class, 'create'])->name('test-booking.create');
Route::post('/test-booking', [TestBookingController::class, 'store'])->name('test-booking.store');

Route::get('/appraisals', [AppraisalController::class, 'create'])->name('appraisals.create');
Route::post('/appraisals', [AppraisalController::class, 'store'])->name('appraisals.store');

Route::get('/payment-calculator', function () {
    return Inertia::render('PaymentCalculator/Index');
})->name('payment-calculator');

Route::get('/about-us', function () {
    return Inertia::render('About');
})->name('about-us');

Route::get('/contact-us', function () {
    return Inertia::render('Contacts/Create');
})->name('contact-us');

Route::get('/privacy', function () {
    return Inertia::render('PrivacyPolicy');
})->name('privacy-policy');

Route::get('/terms', function () {
    return Inertia::render('TermsOfService');
})->name('terms-of-service');

Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');

Route::prefix('admin')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
    Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/{car}/update', [CarController::class, 'update'])->name('cars.update');
    Route::patch('/cars/{car}/featured', [CarController::class, 'toggleFeatured'])->name('cars.featured');

    Route::get('/master-data', [DashboardController::class, 'masterData'])->name('master-data');
    Route::post('/master-data', [DashboardController::class, 'store'])->name('master-data.store');
    Route::put('/master-data/{id}', [DashboardController::class, 'update'])->name('master-data.update');
    Route::delete('/master-data/{id}', [DashboardController::class, 'destroy'])->name('master-data.destroy');

    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/test-booking', [TestBookingController::class, 'index'])->name('test-booking.index');

    Route::get('/finance-application', [FinanceApplicationController::class, 'index'])->name('finance-application.index');
    Route::get('/finance-application/{financeApplication}', [FinanceApplicationController::class, 'show'])->name('finance-application.show');

    Route::get('/appraisals', [AppraisalController::class, 'index'])->name('appraisals.index');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');

    Route::get('/faqs', [FaqController::class, 'adminIndex'])->name('faqs.adminIndex');
    Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
    Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
    Route::get('/faqs/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
    Route::put('/faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
    Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');
});
