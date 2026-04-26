<?php

use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationCaseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;



Route::get('/', fn() => to_route('home.index'));
Route::get('home', [HomeController::class, 'index'])->name('home.index');
Route::get('home/{case}', [HomeController::class, 'show'])->name('home.show');



    
Route::middleware('guest')->group(function () {

    Route::get('login', [AuthController::class, 'showLoginForm']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
    
    Route::get('/register', fn() => view('auth.register'))->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])
        ->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendForgotOtp'])
        ->name('password.email');
        
    Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])
        ->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');

    Route::get('/otp-verify', [AuthController::class, 'showOtpVerifyForm'])->name('otp.verify');
    Route::post('/otp-verify', [AuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/otp-resend', [AuthController::class, 'resendOtp'])->name('otp.resend');
});



Route::middleware('auth')->group(function () {
    Route::delete('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('top_up', [WalletController::class, 'top_up'])->name('wallet.top_up');
    Route::post('donate', [WalletController::class, 'donate'])->name('wallet.donate');

    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
  
    });
    





Route::prefix('admin')->group(function () {

    Route::get('login', [AdminAuthController::class, 'showLoginForm']);
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login');
    

    Route::middleware('admin')->group(function () {
        Route::delete('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::resource('beneficiary', BeneficiaryController::class);
        Route::post('beneficiary/{beneficiary}/withdraw', [WalletController::class, 'withdraw'])
            ->name('beneficiary.withdraw');

        Route::resource('donation_case', DonationCaseController::class);
        Route::post('donation_case/{id}/restore', [DonationCaseController::class, 'restore'])->name('donation_case.restore');

        Route::resource('user', UserController::class)->only(['index', 'update']);
        Route::get('logoutAllUsers', [UserController::class, 'logoutAllUsers'])->name('Logout_All_Users');

        Route::get('transactions', [TransactionsController::class, 'index'])->name('transactions.index');
        
    });
});


