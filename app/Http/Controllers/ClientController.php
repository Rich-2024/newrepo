<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
use App\Models\InterestSetup;
use App\Models\SettledLoan;
use Carbon\Carbon;


class ClientController extends Controller
{

public function create(Request $request)
{
    $validated = $request->validate([
        'clients.*.name'      => 'required|string|max:255',
        'clients.*.contact'   => 'required|string|max:255',
        'clients.*.amount'    => 'required|numeric|min:1000',
        'clients.*.loan_date' => 'required|date',
    ]);
        $userId = Auth::id();

    $interest = InterestSetup::latest()->first();

    if (!$interest) {
        return redirect()->back()->with('success', 'Interest configuration not set,please set interest rate first.');
    }

    // Extract interest rate and loan duration (in days)
    $rate = $interest->interest_rate;
    $loanDuration = $interest->loan_duration;

    $loanData = [];
    $errors = [];

    // Loop through each client and process their loan
    foreach ($validated['clients'] as $clientData) {
$existingClient = Loan::where('contact', $clientData['contact'])
                      ->where('user_id', $userId)
                      ->first();

if ($existingClient) {
    $errors[] = "Client with contact {$clientData['contact']} already have a pending Active loan: {$existingClient->name}";
    continue;
}


        // Get the loan amount from the form
        $amount = $clientData['amount'];

        //  Calculate interest, total repayable amount, and daily repayment
        $interestAmount = ($rate / 100) * $amount;
        $totalToPay = $amount + $interestAmount;
        $dailyRepayment = $totalToPay / $loanDuration;

        //  Calculate the loan's end date based on the loan_date and loan_duration
        $loanDate = Carbon::parse($clientData['loan_date']);
        $loanEndDate = $loanDate->copy()->addDays($loanDuration);

        //  Prepare data for the loan to be inserted into the database
        $loanData[] = [
              'user_id' => Auth::id(),
            'name'             => $clientData['name'],
            'contact'          => $clientData['contact'],
            'amount'           => $amount,
            'loan_date'        => $loanDate->toDateString(),
            'End_date'         => $loanEndDate->toDateString(),
            'interest_rate'    => $rate,
            'loan_duration'    => $loanDuration,
            'total_amount'     => round($totalToPay, 2),
            'balance_to_pay'   => round($totalToPay, 2),
            'daily_repayment'  => round($dailyRepayment, 2),
            'status'           => 'active',
            'created_at'       => now(),
            'updated_at'       => now(),
        ];
    }

    if (count($loanData) > 0) {
        Loan::insert($loanData);

        //  Check for expired loans and update their status to 'inactive'
        $this->updateLoanStatusIfExpired();

        // Automatically move inactive loans to the settled table
        $this->moveInactiveLoansToSettled();

        return redirect()->back()->with('success', 'Loans created successfully.');
    }

    //  Return any errors from skipped clients due to duplicate contact
    if (count($errors) > 0) {
        return redirect()->back()->withErrors($errors);
    }

    return redirect()->back()->with('error', 'No new loans were added.');
}

private function moveInactiveLoansToSettled()
{
    $inactiveLoans = Loan::where('status', 'inactive')->get();

    foreach ($inactiveLoans as $loan) {
            \Log::info('Loan user_id: ' . var_export($loan->user_id, true));

        SettledLoan::create([
            'name'             => $loan->name,
            'contact'          => $loan->contact,
            'loan_date'        => $loan->loan_date,
            'amount'           => $loan->amount,
             'interest_rate'    => $loan->interest_rate,
            'total_amount'     => $loan->total_amount,
            'daily_repayment'  => $loan->daily_repayment,
            'balance_left'     => $loan->balance_to_pay,
             'user_id'         => $loan->user_id,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

     $loan->delete();
    }
}

private function updateLoanStatusIfExpired()
{
    // Get the current date
    $currentDate = Carbon::now();

    //Find all loans where the end date has passed and the loan is still active
    $loans = Loan::where('status', 'active') // Assuming active status means loan is still running
                 ->where('end_date', '<', $currentDate)
                 ->get();

    foreach ($loans as $loan) {
        $loan->status = 'inactive'; // Set to 'inactive' after loan duration has expired
        $loan->save();
    }
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name'   => 'required|string|max:255',
        'phone'  => 'required|string|max:20',
    ]);

    $loan = Loan::findOrFail($id);

    $loan->name = $validated['name'];
    $loan->contact = $validated['phone'];
    $loan->save();

    return redirect()->back()->with('success', 'Client information updated successfully.');
}
}

