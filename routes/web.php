<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\MapController as UserMapController;
use App\Http\Controllers\User\PackageController as UserPackageController;
use App\Http\Controllers\User\AccountController as UserAccountController;
use App\Http\Controllers\User\TransactionController as UserTransactionController;
use App\Http\Controllers\User\ReferralController as UserReferralController;
use App\Http\Controllers\User\SupportController as UserSupportController;
use App\Http\Controllers\User\SettingsController as UserSettingsController;

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

Route::get('/', function () {
    // For now, redirect to user dashboard. Later, add login logic.
    return redirect()->route('user.dashboard');
});

// User Routes (Later, add middleware like ['auth'])
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/map', [UserMapController::class, 'index'])->name('map');
    Route::get('/packages', [UserPackageController::class, 'index'])->name('packages'); // 'buy' section
    Route::get('/packages/details', [UserPackageController::class, 'showDetailsForm'])->name('packages.details'); // New route for details form
    Route::get('/packages/payment', [UserPackageController::class, 'showPaymentForm'])->name('packages.payment'); // New route for payment form

    Route::get('/accounts', [UserAccountController::class, 'index'])->name('accounts'); // 'account-management'
    Route::get('/transactions', [UserTransactionController::class, 'index'])->name('transactions'); // 'transaction-management'
    Route::get('/referrals', [UserReferralController::class, 'index'])->name('referrals'); // 'referral'

    Route::get('/guide', [UserSupportController::class, 'guide'])->name('guide'); // 'user-guide'
    Route::get('/support', [UserSupportController::class, 'support'])->name('support'); // 'support'

    Route::get('/profile', [UserSettingsController::class, 'profile'])->name('profile'); // 'profile'
    Route::get('/payment-info', [UserSettingsController::class, 'paymentInfo'])->name('payment-info'); // 'payment-method-info'
    Route::get('/invoice-info', [UserSettingsController::class, 'invoiceInfo'])->name('invoice-info'); // 'invoice-info'

    // Route for logout (implement controller later)
    Route::post('/logout', function() { /* Logic here */ })->name('logout');
});

// Basic Auth routes (if needed later)
// require __DIR__.'/auth.php';
