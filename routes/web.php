<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\LogicController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RepaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettledLoanController;

// Default route to homepage
Route::get('/', [LogicController::class, 'view']);
Route::get('/dashboard',[ViewController::class, 'dashboard'])->name('dashboard');
Route::get('/create',[ViewController::class, 'create'])->name('create');
Route::get('/repay',[ViewController::class, 'repay'])->name('repay');
Route::get('/rephistory',[LogicController::class, 'showRepaymentForm'])->name('rephis');
Route::get('/defaulters',[ViewController::class, 'defaulters'])->name('defaulter');
Route::get('/Reports/yearly',[ViewController::class, 'month'])->name('month');
Route::get('/Reports/monthly',[ViewController::class, 'year'])->name('yearly');
Route::get('/profile',[ViewController::class, 'month'])->name('profile');
Route::get('/interest',[ViewController::class, 'interest'])->name('interest');
Route::get('/interest',[ViewController::class, 'month'])->name('reports.index');
Route::get('/set', [LogicController::class, 'interest'])->name('interest');
Route::get('/repayment', [LogicController::class, 'showRepaymentForm'])->name('rep');
Route::get('/client', [LogicController::class, 'show']);
Route::get('/clients', [LogicController::class, 'index'])->name('clients.index');
Route::get('/clients', [LogicController::class, 'show'])->name('clients.index');
Route::get('/clients/search', [LogicController::class, 'index'])->name('search');

Route::post('/interest',[ViewController::class, 'month'])->name('admin.loans.store');
Route::post('/interest',[ViewController::class, 'month'])->name('client');
Route::post('/set-interest-rate', [LogicController::class, 'store'])->name('interest.store');
Route::post('/set', [ClientController::class, 'create'])->name('storeclients');
Route::post('/repayments/store', [RepaymentController::class, 'store'])->name('repayments.store');

Route::get('/reports/defaulters', [ReportController::class, 'defaultersReport'])->name('reports.defaulters');
Route::get('/reports/repayments', [ReportController::class, 'repaymentHistory'])->name('reports.repayments');

Route::get('/settled-loans', [SettledLoanController::class, 'index'])->name('settled_loans.index');
Route::delete('/settled-loans/{id}', [SettledLoanController::class, 'destroy'])->name('settled_loans.destroy');

Route::put('/clients/update', [ClientController::class, 'update'])->name('clients.update');









