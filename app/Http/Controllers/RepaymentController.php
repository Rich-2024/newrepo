<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Repayment;
use App\Models\InterestSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'loan_id'      => 'required|exists:loans,id',
            'amount'       => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'note'         => 'nullable|string|max:1000',
        ]);

        // ✅ Ensure the loan belongs to the logged-in user
        $loan = Loan::where('id', $request->loan_id)
                    ->where('user_id', Auth::id())
                    ->first();

        if (!$loan) {
            return back()->with('error', 'Loan not found or unauthorized access.');
        }

        try {
            $repayment = Repayment::create([
                'loan_id'      => $loan->id,
                'amount'       => $request->amount,
                'payment_date' => $request->payment_date,
                'note'         => $request->note,
            ]);
        } catch (\Exception $e) {
            logger()->error('Repayment insert failed: ' . $e->getMessage());
            return back()->with('error', 'Repayment creation failed.');
        }

        // ✅ Update the loan balance
        $totalRepaid = Repayment::where('loan_id', $loan->id)->sum('amount');
        $loan->balance_to_pay = max(0, round($loan->total_amount - $totalRepaid, 2));
        $loan->save();

        return redirect()->back()->with('success', 'Repayment successfully recorded.');
    }

    public function print($id)
    {
        $repayment = Repayment::findOrFail($id);

        // ✅ Confirm the loan attached to this repayment belongs to the logged-in user
        if ($repayment->loan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $businessName = InterestSetup::first()?->business_name ?? 'Your Business';

        return view('clients.print', compact('repayment', 'businessName'));
    }

    public function printIssuance($id)
    {
        $loan = Loan::with('user')->findOrFail($id);

        // Check that the loan belongs to the currently logged-in user
        if ($loan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $businessName = InterestSetup::latest()->first()?->business_name ?? 'Your Business';

        return view('clients.print_issuance', compact('loan', 'businessName'));
    }
}
