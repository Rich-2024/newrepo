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
use App\Http\Controllers\ArchivedSettledLoanController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\LoanSmsController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OtpVerificationController;
use App\Http\Controllers\LoanInquiryController;
use App\Http\Controllers\LoanController;
// Public routes (like login, register, homepage)
Route::get('/', [AdminController::class,  'welcome']);
Route::get('/login', [AdminController::class,  'showLoginForm'])->name('login');
Route::post('/login', [AdminController::class,  'login']);
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Route::get('password/reset', [AdminController::class, 'showLinkRequestForm']) ->name('password.request');

Route::get('/send-bulk-sms', [LoanSmsController::class, 'showForm']);
// Show forgot password form
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/send-bulk-sms', [LoanSmsController::class, 'send']);
// Handle form submission and send reset email
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

// Show reset form
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');

// Handle reset form submission
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
// Protect all other routes with auth middleware
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    // Dashboard and views
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

    Route::get('/statistics', [ReviewController::class, 'dashboard'])->name('stat');
    Route::get('/reports/generate', [ReportController::class, 'showForm'])->name('reports.showForm');
    Route::get('/settled-loans', [SettledLoanController::class, 'index'])->name('settled_loans.index');
    Route::delete('/settled-loans/{id}', [RepaymentController::class, 'destroy'])->name('settled_loans.destroy');

    // Loan Fines (important to protect update route!)
    Route::get('/loan-fines', [LoanFineController::class, 'index'])->name('loan_fines.index');
    Route::post('/loan-fines/update-settings', [LoanFineController::class, 'updateSettings'])->name('loan_fines.update_settings');
    Route::get('/loan-fines/table', [LoanFineController::class, 'table'])->name('loan_fines.table');
    Route::get('/fine-loans/table', [LoanFineController::class, 'fineLoansTable'])->name('fine_loans.table');
 Route::get('/Repay', [RepaymentController::class, 'show'])->name('settled');
Route::get('/repayments/{id}/print', [RepaymentController::class, 'printsettled'])
    ->name('repayments.print')
    ->middleware('auth');
 Route::get('/settledLoan/{id}/settledLoan', [RepaymentController::class, 'printsettled'])->name('repayments.prints');

Route::get('/archived-settled-loans', [ArchivedSettledLoanController::class, 'index'])->name('archived_settled_loans.index');
Route::delete('/archived-settled-loans/{id}', [ArchivedSettledLoanController::class, 'destroy'])->name('archived-settled-loans.destroy');
    // Attachments
    Route::get('/loans/{loanId}/attachments', [AttachmentController::class, 'index'])->name('attachments.view');
    Route::get('/loans/{loanId}/attachments/upload', [AttachmentController::class, 'create'])->name('attachments.upload');
    Route::post('/loans/{loanId}/attachments', [AttachmentController::class, 'store'])->name('attachments.store');
Route::post('/profile/upload-picture', [AdminController::class, 'uploadPicture'])->name('profile.uploadPicture');


Route::post('/update-fine-status/{loan}', [LoanFineController::class, 'updateFineStatus'])->name('loan.updateFineStatus');

    Route::post('/interest',[ViewController::class, 'month'])->name('admin.loans.store');
    Route::post('/interest',[ViewController::class, 'month'])->name('client');
    Route::post('/set-interest-rate', [LogicController::class, 'store'])->name('interest.store');
    Route::post('/set', [ClientController::class, 'create'])->name('storeclients');
    Route::post('/repayments/store', [RepaymentController::class, 'store'])->name('repayments.store');
    Route::post('/repayments/store', [LoanFineController::class, 'settle'])->name('repayments.settle');
    Route::post('/repayments/settled', [RepaymentController::class, 'storesettled'])->name('repayments.settles');

    Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::put('/profile',[AdminController::class, 'update'])->name('profile.update');

    Route::post('/repayments', [RepaymentController::class, 'store'])->name('repayments.store');
});


// // Default route to homepage
// Route::get('/dashboard/view', [LogicController::class, 'view'])->name('view.dash');
// Route::get('/dashboard',[ViewController::class, 'dashboard'])->name('dashboard');
// Route::get('/create',[ViewController::class, 'create'])->name('create');
// Route::get('/repay',[ViewController::class, 'repay'])->name('repay');
// Route::get('/rephistory',[LogicController::class, 'showRepaymentForm'])->name('rephis');
// Route::get('/defaulters',[ViewController::class, 'defaulters'])->name('defaulter');
// Route::get('/Reports/yearly',[ViewController::class, 'month'])->name('month');
// Route::get('/Reports/monthly',[ViewController::class, 'year'])->name('yearly');
// Route::get('/profile',[ViewController::class, 'profile'])->name('profile');
// Route::get('/interest',[ViewController::class, 'interest'])->name('interest');
// Route::get('/interest',[ViewController::class, 'month'])->name('reports.index');
// Route::get('/set', [LogicController::class, 'interest'])->name('interest');
// Route::get('/repayment', [LogicController::class, 'showRepaymentForm'])->name('rep');
// Route::get('/client', [LogicController::class, 'show']);
// Route::get('/clients/search', [LogicController::class, 'index'])->name('clients.index');
// Route::get('/clients', [LogicController::class, 'show'])->name('clients.index');
// Route::get('/clients/search', [LogicController::class, 'index'])->name('search');
// Route::get('/reports/defaulters', [ReportController::class, 'defaultersReport'])->name('reports.defaulters');
// Route::get('/reports/repayments', [ReportController::class, 'repaymentHistory'])->name('reports.repayments');
// Route::get('password/reset', [AdminController::class, 'showLinkRequestForm']) ->name('password.request');
// Route::get('/', [AdminController::class,  'welcome']);
// Route::get('/statistics', [ReviewController::class, 'dashboard'])->name('stat');
// Route::get('/reports/generate', [ReportController::class, 'showForm'])->name('reports.showForm');
// Route::get('/settled-loans', [SettledLoanController::class, 'index'])->name('settled_loans.index');
// Route::delete('/settled-loans/{id}', [SettledLoanController::class, 'destroy'])->name('settled_loans.destroy');
// Route::get('/loan-fines', [LoanFineController::class, 'index'])->name('loan_fines.index');
// Route::post('/loan-fines/update-settings', [LoanFineController::class, 'updateSettings'])->name('loan_fines.update_settings');
// Route::get('/loan-fines/table', [LoanFineController::class, 'table'])->name('loan_fines.table');
// Route::get('/fine-loans/table', [LoanFineController::class, 'fineLoansTable'])->name('fine_loans.table');

// Route::get('/login', [AdminController::class,  'showLoginForm'])->name('login');
 Route::get('/FinanceHubTracker/learn', [ViewController::class, 'learn'])->name('learn');
 Route::get('/repayments/{id}/print', [RepaymentController::class, 'print'])->name('repayments.print');
 Route::get('/loans/{id}/print-issuance', [RepaymentController::class, 'printIssuance'])->name('loans.printIssuance');
 Route::get('/loans/clients', [AdminController::class, 'clientsIndex'])->name('loans.clients.index');
// Route::get('/loans/{loanId}/attachments', [AttachmentController::class, 'index'])->name('attachments.view');
// Route::get('/loans/{loanId}/attachments/upload', [AttachmentController::class, 'create'])->name('attachments.upload');
// Route::post('/loans/{loanId}/attachments', [AttachmentController::class, 'store'])->name('attachments.store');
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);
// Route::post('/interest',[ViewController::class, 'month'])->name('admin.loans.store');
// Route::post('/interest',[ViewController::class, 'month'])->name('client');
// Route::post('/set-interest-rate', [LogicController::class, 'store'])->name('interest.store');
// Route::post('/set', [ClientController::class, 'create'])->name('storeclients');
// Route::post('/repayments/store', [RepaymentController::class, 'store'])->name('repayments.store');
// Route::post('/repayments/store', [LoanFineController::class, 'settle'])->name('repayments.settle');
// Route::post('/login', [AdminController::class,  'login']);
// Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
// Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
// Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');


// // Route::put('/clients/update', [ClientController::class, 'update'])->name('clients.update');
// Route::put('/profile',[AdminController::class, 'update'])->name('profile.update');

// Route::post('/repayments', [RepaymentController::class, 'store'])->name('repayments.store');





// Route::get('/otp-request', [OtpController::class, 'showRequestForm'])->name('otp.request.form');
// Route::post('/otp-send', [OtpController::class, 'sendOtp'])->name('otp.send');
// Route::get('/otp-verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
// Route::post('/otp-verify', [OtpController::class, 'verifyOtp'])->name('otp.verify');


// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);

Route::get('/otp-verify', [OtpVerificationController::class, 'showVerifyForm'])->name('otp.verify.form');
Route::post('/otp-verify', [OtpVerificationController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/resend-otp', [OtpVerificationController::class, 'resendOtp'])->name('otp.resend');

        Route::get('/OurPricing', [ReviewController::class, 'pricing'])->name('price');
        Route::get('/OurServices', [ReviewController::class, 'service'])->name('service');
        Route::get('/Contact-us', [ReviewController::class, 'contact'])->name('contact');

Route::get('/loan-report', [LoanController::class, 'report'])->name('loan.report');

Route::get('/loan-inquiry', [LoanInquiryController::class, 'showForm'])->name('loan.inquiry');
Route::post('/loan-inquiry', [LoanInquiryController::class, 'submit'])->name('loan.inquiry.submit');
