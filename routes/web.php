<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\LogicController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RepaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettledLoanController;
use App\Http\Controllers\LoanFineController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;

// Default route to homepage
Route::get('/dashboard/view', [LogicController::class, 'view'])->name('view.dash');
Route::get('/dashboard',[ViewController::class, 'dashboard'])->name('dashboard');
Route::get('/create',[ViewController::class, 'create'])->name('create');
Route::get('/repay',[ViewController::class, 'repay'])->name('repay');
Route::get('/rephistory',[LogicController::class, 'showRepaymentForm'])->name('rephis');
Route::get('/defaulters',[ViewController::class, 'defaulters'])->name('defaulter');
Route::get('/Reports/yearly',[ViewController::class, 'month'])->name('month');
Route::get('/Reports/monthly',[ViewController::class, 'year'])->name('yearly');
Route::get('/profile',[ViewController::class, 'profile'])->name('profile');
Route::get('/interest',[ViewController::class, 'interest'])->name('interest');
Route::get('/interest',[ViewController::class, 'month'])->name('reports.index');
Route::get('/set', [LogicController::class, 'interest'])->name('interest');
Route::get('/repayment', [LogicController::class, 'showRepaymentForm'])->name('rep');
Route::get('/client', [LogicController::class, 'show']);
Route::get('/clients/search', [LogicController::class, 'index'])->name('clients.index');
Route::get('/clients', [LogicController::class, 'show'])->name('clients.index');
Route::get('/clients/search', [LogicController::class, 'index'])->name('search');
Route::get('/reports/defaulters', [ReportController::class, 'defaultersReport'])->name('reports.defaulters');
Route::get('/reports/repayments', [ReportController::class, 'repaymentHistory'])->name('reports.repayments');
Route::get('password/reset', [AdminController::class, 'showLinkRequestForm']) ->name('password.request');
Route::get('/', [AdminController::class,  'welcome']);
Route::get('/statistics', [ReviewController::class, 'dashboard'])->name('stat');
Route::get('/reports/generate', [ReportController::class, 'showForm'])->name('reports.showForm');
Route::get('/settled-loans', [SettledLoanController::class, 'index'])->name('settled_loans.index');
Route::delete('/settled-loans/{id}', [SettledLoanController::class, 'destroy'])->name('settled_loans.destroy');
Route::get('/loan-fines', [LoanFineController::class, 'index'])->name('loan_fines.index');
Route::post('/loan-fines/update-settings', [LoanFineController::class, 'updateSettings'])->name('loan_fines.update_settings');
Route::get('/loan-fines/table', [LoanFineController::class, 'table'])->name('loan_fines.table');
Route::get('/fine-loans/table', [LoanFineController::class, 'fineLoansTable'])->name('fine_loans.table');
Route::get('/login', [AdminController::class,  'showLoginForm'])->name('login');
Route::get('/FinanceHubTracker/learn', [ViewController::class, 'learn'])->name('learn');

Route::post('/interest',[ViewController::class, 'month'])->name('admin.loans.store');
Route::post('/interest',[ViewController::class, 'month'])->name('client');
Route::post('/set-interest-rate', [LogicController::class, 'store'])->name('interest.store');
Route::post('/set', [ClientController::class, 'create'])->name('storeclients');
Route::post('/repayments/store', [RepaymentController::class, 'store'])->name('repayments.store');
Route::post('/repayments/store', [LoanFineController::class, 'settle'])->name('repayments.settle');

Route::post('/login', [AdminController::class,  'login']);
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
// In routes/web.php
Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');


// Route::put('/clients/update', [ClientController::class, 'update'])->name('clients.update');
Route::put('/profile',[AdminController::class, 'update'])->name('profile.update');

Route::post('/repayments', [RepaymentController::class, 'store'])->name('repayments.store');








