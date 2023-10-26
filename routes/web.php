<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanceApplicationController;
use App\Http\Controllers\HomeController;
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

Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/inventory', [CarController::class, 'inventory'])->name('cars.inventory');
Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
Route::get('/inventory/{car}', [CarController::class, 'show'])->name('cars.show');
Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
Route::put('/cars/{car}/update', [CarController::class, 'update'])->name('cars.update');
Route::patch('/cars/{car}/featured', [CarController::class, 'setAsFeatured'])->name('cars.featured');

Route::get('/master-data', [DashboardController::class, 'masterData'])->name('master-data');
Route::post('/master-data', [DashboardController::class, 'store'])->name('master-data.store');
Route::put('/master-data/{id}', [DashboardController::class, 'update'])->name('master-data.update');
Route::delete('/master-data/{id}', [DashboardController::class, 'destroy'])->name('master-data.destroy');

Route::get('/finance-application', [FinanceApplicationController::class, 'create']);
Route::post('/finance-application', [FinanceApplicationController::class, 'store'])->name('finance-application.store');

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

Route::get('/payment-calculator', function () {
    return Inertia::render('PaymentCalculator/Index');
})->name('payment-calculator');

Route::get('/about-us', function () {
    return Inertia::render('About');
})->name('about-us');

Route::get('/contact-us', function () {
    return Inertia::render('Contacts/Create');
})->name('contact-us');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
