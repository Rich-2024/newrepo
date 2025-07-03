<?php

namespace App\Http\Controllers;
use App\Models\SettledRepayment;
use App\Models\SettledLoanRepayment;
use App\Models\ArchivedSettledLoan;
use App\Models\Loan;
use App\Models\Repayment;
use App\Models\InterestSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SettledLoan;
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
    //settled
//  public function storesettled(Request $request)
// {
//     $request->validate([
//         'settled_loan_id' => 'required|exists:settled_loans,id',
//         'amount'          => 'required|numeric|min:1',
//         'payment_date'    => 'required|date',
//         'note'            => 'nullable|string|max:1000',
//     ]);

//     $loan = SettledLoan::where('id', $request->settled_loan_id)
//                        ->where('user_id', Auth::id())
//                        ->first();

//     if (!$loan) {
//         return back()->with('error', 'Settled loan not found or unauthorized access.');
//     }

//     try {
//         // Insert repayment record
//         SettledRepayment::create([
//             'settled_loan_id' => $loan->id,
//             'amount'          => $request->amount,
//             'payment_date'    => $request->payment_date,
//             'note'            => $request->note,
//         ]);

//         // Sum total repayments so far
//         $totalRepaid = (float) SettledRepayment::where('settled_loan_id', $loan->id)->sum('amount');
//         $principalAmount = (float) $loan->amount;

//         // Calculate new balance ignoring interest/fines
//         $newBalance = max(0, round($principalAmount - $totalRepaid, 2));

//         // Update loan details
//         $loan->repayment_made = $totalRepaid;
//         $loan->balance_left = $newBalance;
//         $loan->last_repayment_date = $request->payment_date;

//         // Mark as settled if fully repaid
//         if ($newBalance == 0) {
//             $loan->status = 'settled';
//             $loan->settled_at = now();
//         }

//         $loan->save();

//         return redirect()->back()->with('success', 'Repayment successfully recorded.');
//     } catch (\Exception $e) {
//         \Log::error('Repayment failed: ' . $e->getMessage());
//         return back()->with('error', 'Repayment failed. Please try again. Error: ' . $e->getMessage());
//     }
// }
public function storesettled(Request $request)
{
    $request->validate([
        'settled_loan_id' => 'required|exists:settled_loans,id',
        'amount_copy'     => 'required|numeric|min:1',
        'payment_date'    => 'required|date',
        'note'            => 'nullable|string|max:1000',
    ]);

    $loan = SettledLoan::where('id', $request->settled_loan_id)
                       ->where('user_id', Auth::id())
                       ->first();

    if (!$loan) {
        return back()->with('error', 'Settled loan not found or unauthorized access.');
    }

    try {
        // Insert repayment record, storing amount_copy as the repayment amount
        SettledRepayment::create([
            'settled_loan_id' => $loan->id,
            'amount'          => $request->amount_copy,
            'payment_date'    => $request->payment_date,
            'note'            => $request->note,
        ]);

        // Calculate total amount repaid so far
        $totalRepaid = SettledRepayment::where('settled_loan_id', $loan->id)->sum('amount');

        // Calculate new balance left by subtracting total repaid from original loan amount_copy
        $newBalance = max(0, round($loan->amount_copy - $totalRepaid, 2));

        // Update loan fields
        $loan->repayment_made = $totalRepaid;
        $loan->balance_left = $newBalance;
        $loan->last_repayment_date = $request->payment_date;

        // Mark loan as settled if balance is zero
        if ($newBalance == 0) {
            $loan->status = 'settled';
            $loan->settled_at = now();
        }

        $loan->save();

        return redirect()->back()->with('success', 'Repayment successfully recorded.');
    } catch (\Exception $e) {
        \Log::error('Repayment failed: ' . $e->getMessage());
        return back()->with('error', 'Repayment failed. Please try again.');
    }
}

public function show()
{
    $repayments = SettledRepayment::with('settledLoan')
                    ->whereHas('settledLoan', function ($query) {
                        $query->where('user_id', Auth::id());
                    })
                    ->latest()
                    ->get();

    return view('business.show', compact('repayments'));
}


public function printSettled($id)
{
    $repayment = SettledRepayment::with('settledLoan')->findOrFail($id);

    // Check ownership of the loan by the authenticated user
    if ($repayment->settledLoan->user_id !== Auth::id()) {
        abort(403, 'Unauthorized access.');
    }

    // Fetch business name or fallback
    $businessName = InterestSetup::first()?->business_name ?? 'Your Business';

    return view('clients.prints', compact('repayment', 'businessName'));
}

public function destroy($id)
{
    $settledLoan = SettledLoan::findOrFail($id);

    ArchivedSettledLoan::create([
        'user_id'      => $settledLoan->user_id,
        'name'         => $settledLoan->name,
        'amount'       => $settledLoan->amount,
        'balance_left' => $settledLoan->balance_left,
        'status'       => 'archived',
    ]);

    $settledLoan->delete();

    return redirect()->route('settled_loans.index')->with('success', 'Settled loan archived successfully.');
}


}
