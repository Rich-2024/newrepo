<?php

namespace App\Http\Controllers;

    use App\Models\Loan;
use App\Models\Repayment;
use Illuminate\Http\Request;

class RepaymentController extends Controller
{

public function store(Request $request)
{
    // dd($request->all());
    $request->validate([
        'loan_id'      => 'required|exists:loans,id',
        'amount'       => 'required|numeric|min:1',
        'payment_date' => 'required|date',
        'note'         => 'nullable|string|max:1000',
    ]);

    try {
        $repayment = Repayment::create([
            'loan_id'      => $request->loan_id,
            'amount'       => $request->amount,
            'payment_date' => $request->payment_date,
            'note'         => $request->note,
        ]);
    } catch (\Exception $e) {
        logger()->error('Repayment insert failed: ' . $e->getMessage());
        return back()->with('error', 'Repayment creation failed.');
    }

    $loan = Loan::find($request->loan_id);
    if ($loan) {
        $totalRepaid = Repayment::where('loan_id', $loan->id)->sum('amount');
        $loan->balance_to_pay = max(0, round($loan->total_amount - $totalRepaid, 2));
        $loan->save();
    }

    return redirect()->back()->with('success', 'Repayment successfully recorded.');
}
}