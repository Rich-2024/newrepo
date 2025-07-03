<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
use App\Models\Repayment;
use Illuminate\Support\Facades\DB;

use App\Notifications\LoanStatusUpdated;

class LoanController extends Controller
{
    public function updateStatus(Request $request, $loanId)
    {
        // Validate incoming request data
        $request->validate([
            'status' => 'required|string',
        ]);

        // Find the loan by ID
        $loan = Loan::findOrFail($loanId);
        // Update loan status
        $loan->status = $request->input('status');
        $loan->save();

        // Get the user who owns the loan
        $user = User::findOrFail($loan->user_id);

        // Send SMS notification to user about loan status update
        $user->notify(new LoanStatusUpdated($loan));

        return response()->json([
            'message' => 'Loan status updated and SMS notification sent.',
            'loan' => $loan,
        ]);
    }

public function report()
{
    $userId = Auth::id(); // get current logged in user ID

    // Total loans issued and count for the logged-in user
    $loanStats = Loan::where('user_id', $userId)
        ->where('status', 'active')
        ->select(
            DB::raw('COUNT(*) as total_loans'),
            DB::raw('SUM(amount) as total_loan_amount'),
            DB::raw('SUM(balance_to_pay) as total_balance_to_pay')
        )
        ->first();

    // Total repayments received for this user's loans
    // Assuming repayments table links to loans via loan_id
    $totalRepayments = Repayment::whereHas('loan', function($q) use ($userId) {
        $q->where('user_id', $userId);
    })->sum('amount');

    // Get all active loans for the user to show in details table
    $loans = Loan::where('user_id', $userId)->where('status', 'active')->get();

    return view('business.loan_report', compact('loanStats', 'totalRepayments', 'loans'));
}
}
