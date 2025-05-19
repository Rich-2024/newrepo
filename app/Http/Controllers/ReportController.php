<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
    use App\Models\SettledLoan;
use App\Models\Repayment;
class ReportController extends Controller
{

public function defaultersReport()
{
    $defaulters = SettledLoan::where('balance_left', '>', 0)->orderBy('settled_at', 'desc')->get();

    return view('clients.defaulters', compact('defaulters'));
}


public function repaymentHistory(Request $request)
{
    $month = $request->input('month', now()->month);
    $year = $request->input('year', now()->year);

    // Fetch repayments for the selected month and year
    $repayments = Repayment::with('loan')
        ->whereYear('payment_date', $year)
        ->whereMonth('payment_date', $month)
        ->orderByDesc('payment_date')
        ->get();

    // Total amount repaid in the selected period
    $totalRepayments = $repayments->sum('amount');

    // Total loans from repayment-associated loans
    // $totalLoans = $repayments->pluck('loan')->unique('id')->sum('amount');
     $totalLoans = Loan::all()->sum('amount');

    // Fetch balance due from unsettled loans (i.e., balance_left > 0)
    $balanceDue = SettledLoan::where('balance_left', '>', 0)->sum('balance_left');

    $reportData = [
        'repayments' => $repayments,
        'total_loans' => $totalLoans,
        'total_repayments' => $totalRepayments,
        'balance_due' => $balanceDue,
    ];

    return view('clients.reports', compact('reportData', 'month', 'year'));
}

}
