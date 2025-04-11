<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SurveyAccountController as AdminSurveyAccountController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\ReferralController as AdminReferralController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController; // Assuming you need a settings controller

// Admin Routes (Later, add middleware like ['auth', 'admin'])
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index'); // 'admin-user-management'
    // Add routes for user create, edit, etc. later

    Route::get('/survey-accounts', [AdminSurveyAccountController::class, 'index'])->name('survey-accounts.index'); // 'admin-account-management'
    // Add routes for account create, edit, etc. later

    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index'); // 'admin-invoice-management'
    // Add routes for transaction approve, reject later

    Route::get('/referrals', [AdminReferralController::class, 'index'])->name('referrals.index'); // 'admin-referral-management'
    // Add routes for referral settings, payout later

    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index'); // 'admin-reports'

    Route::get('/permissions', [AdminRoleController::class, 'index'])->name('permissions.index'); // 'admin-permission-management'
     // Add routes for permission edit, admin user create later

    Route::get('/profile', [AdminSettingsController::class, 'profile'])->name('profile'); // 'admin-profile'
     // Add routes for profile update, password change later

     // Route for logout (implement controller later)
     Route::post('/logout', function() { /* Logic here */ })->name('logout');
});
