<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use App\Models\Loan;
use App\Models\Repayment;
use App\Models\SettledLoan;
use App\Models\SettledRepayment;
use App\Models\ArchivedSettledLoan;
use App\Models\InterestSetup;

use App\Mail\RepaymentNotification;

class RepaymentController extends Controller
{
    //
  public function store(Request $request)
{
    $request->validate([
        'loan_id'      => 'required|exists:loans,id',
        'amount'       => 'required|numeric|min:1',
        'payment_date' => 'required|date',
        'note'         => 'nullable|string|max:1000',
    ]);

    $loan = Loan::where('id', $request->loan_id)
                ->where('user_id', Auth::id())
                ->first();

    if (!$loan) {
        return back()->with('error', 'Loan not found or unauthorized access.');
    }

    // ✅ Check if repayment exceeds the balance
    if ($request->amount > $loan->balance_to_pay) {
        return back()->with('error', 'You have entered extra money that exceeds the balance left (UGX ' . number_format($loan->balance_to_pay, 2) . ').');
    }

    try {
        $repayment = Repayment::create([
            'loan_id'      => $loan->id,
            'amount'       => $request->amount,
            'payment_date' => $request->payment_date,
            'note'         => $request->note,
        ]);

        // ✅ Email notification (optional)
        Mail::to(Auth::user()->email)->send(new RepaymentNotification(
            Auth::user()->name,
            $loan->name,
            $loan->contact,
            $request->amount,
            $request->payment_date
        ));

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
// public function storesettled(Request $request)
// {
//     $request->validate([
//         'settled_loan_id' => 'required|exists:settled_loans,id',
//         'amount_copy'     => 'required|numeric|min:1',
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
//         // Insert repayment record, storing amount_copy as the repayment amount
//         SettledRepayment::create([
//             'settled_loan_id' => $loan->id,
//             'amount'          => $request->amount_copy,
//             'payment_date'    => $request->payment_date,
//             'note'            => $request->note,
//         ]);

//         // Calculate total amount repaid so far
//         $totalRepaid = SettledRepayment::where('settled_loan_id', $loan->id)->sum('amount');

//         // Calculate new balance left by subtracting total repaid from original loan amount_copy
//         $newBalance = max(0, round($loan->amount_copy - $totalRepaid, 2));

//         // Update loan fields
//         $loan->repayment_made = $totalRepaid;
//         $loan->balance_left = $newBalance;
//         $loan->last_repayment_date = $request->payment_date;

//         // Mark loan as settled if balance is zero
//         if ($newBalance == 0) {
//             $loan->status = 'settled';
//             $loan->settled_at = now();
//         }

//         $loan->save();

//         return redirect()->back()->with('success', 'Repayment successfully recorded.');
//     } catch (\Exception $e) {
//         \Log::error('Repayment failed: ' . $e->getMessage());
//         return back()->with('error', 'Repayment failed. Please try again.');
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

    // ✅ Prevent overpayment
    if ($request->amount_copy > $loan->balance_left) {
        return back()->with('error', 'You have entered extra money that exceeds the balance left (UGX ' . number_format($loan->balance_left, 2) . ').');
    }

    try {
        // ✅ Create the repayment
        $repayment = SettledRepayment::create([
            'settled_loan_id' => $loan->id,
            'amount'          => $request->amount_copy,
            'payment_date'    => $request->payment_date,
            'note'            => $request->note,
        ]);

        // ✅ Update repayment summary
        $totalRepaid = SettledRepayment::where('settled_loan_id', $loan->id)->sum('amount');
        $newBalance = max(0, round($loan->amount_copy - $totalRepaid, 2));

        $loan->repayment_made = $totalRepaid;
        $loan->balance_left = $newBalance;
        $loan->last_repayment_date = $request->payment_date;

        if ($newBalance == 0) {
            $loan->status = 'settled';
            $loan->settled_at = now();
        }

        $loan->save();

        // ✅ Send notification
        Mail::to(Auth::user()->email)->send(new RepaymentNotification(
            Auth::user()->name,        // admin_name
            $loan->name,               // client name
            $loan->contact,            // client contact
            $request->amount_copy,     // amount paid
            $request->payment_date     // payment date
        ));

        return redirect()->back()->with('success', 'Repayment successfully recorded.');
    } catch (\Exception $e) {
        \Log::error('Repayment failed: ' . $e->getMessage());
        return back()->with('error', 'Repayment failed. Please try again.');
    }
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
