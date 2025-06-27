<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
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
}
