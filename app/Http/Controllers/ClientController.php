<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\InterestSetup;
use App\Models\SettledLoan;
use Carbon\Carbon;


class ClientController extends Controller
{
public function create(Request $request)
{
    // Validate the form input
    $validated = $request->validate([
        'clients.*.name'      => 'required|string|max:255',
        'clients.*.contact'   => 'required|string|max:255',
        'clients.*.amount'    => 'required|numeric|min:1000',
        'clients.*.loan_date' => 'required|date',
    ]);

    // Get the latest interest configuration
    $interest = InterestSetup::latest()->first();
    if (!$interest) {
        return redirect()->back()->with('error', 'Interest configuration not found.');
    }

    $rate = $interest->interest_rate;
    $loanDuration = $interest->loan_duration;

    $loanData = [];
    $errors = [];

    // Process each client's data
    foreach ($validated['clients'] as $clientData) {
        // Check for duplicates by contact
        $existingClient = Loan::where('contact', $clientData['contact'])->first();

        if ($existingClient) {
            $errors[] = "Client with contact {$clientData['contact']} already exists: {$existingClient->name}";
            continue;
        }

        $amount = $clientData['amount'];

        // Calculate repayment values
        $interestAmount = ($rate / 100) * $amount;
        $totalToPay = $amount + $interestAmount;
        $dailyRepayment = $totalToPay / $loanDuration;

        // Prepare loan data for insertion
        $loanData[] = [
            'name'             => $clientData['name'],
            'contact'          => $clientData['contact'],
            'amount'           => $amount,
            'loan_date'        => $clientData['loan_date'],
            'interest_rate'    => $rate,
            'total_amount'     => round($totalToPay, 2),
             'balance_to_pay'   => round($totalToPay, 2),
            'daily_repayment'  => round($dailyRepayment, 2),
            'created_at'       => now(),
            'updated_at'       => now(),
        ];
    }

    // Insert loans into the database
    if (count($loanData) > 0) {
        Loan::insert($loanData);
        // Automatically check and shift inactive loans to the settled table
        $this->moveInactiveLoansToSettled();
        return redirect()->back()->with('success', 'Loans created successfully.');
    }

    if (count($errors) > 0) {
        return redirect()->back()->withErrors($errors);
    }

    return redirect()->back()->with('error', 'No new loans were added.');
}

// This function moves inactive loans to settled table immediately
private function moveInactiveLoansToSettled()
{
    $inactiveLoans = Loan::where('status', 'inactive')->get();
    
    foreach ($inactiveLoans as $loan) {
        // Transfer inactive loans to settled table
        SettledLoan::create([
            'name' => $loan->name,
            'contact' => $loan->contact,
            'loan_date' => $loan->loan_date,
            'amount' => $loan->amount,
            'interest_rate' => $loan->interest_rate,
            'total_amount' => $loan->total_amount,
            'daily_repayment' => $loan->daily_repayment,
            'balance_left' => $loan->balance_to_pay,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Optionally, delete or mark the loan as settled in the Loan table
        $loan->delete();
    }
}
//update clien
public function update(Request $request)
{
    $request->validate([
        'loan_id' => 'required|exists:loans,id',
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
    ]);

    $loan = Loan::find($request->loan_id);

    if ($loan) {
        $loan->name = $request->name;
        $loan->contact = $request->phone;
        $loan->save();

        return redirect()->back()->with('success', 'Client updated successfully.');
    }

    return redirect()->back()->with('error', 'Loan not found.');
}

}

// public function create(Request $request)
// {
//     $validated = $request->validate([
//         'clients.*.name'      => 'required|string|max:255',
//         'clients.*.contact'   => 'required|string|max:255',
//         'clients.*.amount'    => 'required|numeric|min:1000',
//         'clients.*.loan_date' => 'required|date',
//     ]);

//     // ✅ Get latest interest configuration
//     $interest = InterestSetup::latest()->first();
//     if (!$interest) {
//         return redirect()->back()->with('error', 'Interest configuration not found.');
//     }

//     $rate = $interest->interest_rate;
//     $loanDuration = $interest->loan_duration;

//     $loanData = [];
//     $errors = [];

//     foreach ($validated['clients'] as $clientData) {
//         // Check for duplicates by contact
//         $existingClient = Loan::where('contact', $clientData['contact'])->first();

//         if ($existingClient) {
//             $errors[] = "Client with contact {$clientData['contact']} already exists: {$existingClient->name}";
//             continue;
//         }

//         $amount = $clientData['amount'];

//         // ✅ Calculate repayment values
//         $interestAmount = ($rate / 100) * $amount;
//         $totalToPay = $amount + $interestAmount;
//         $dailyRepayment = $totalToPay / $loanDuration;

//         // ✅ Prepare loan data
//         $loanData[] = [
//             'name'             => $clientData['name'],
//             'contact'          => $clientData['contact'],
//             'amount'           => $amount,
//             'loan_date'        => $clientData['loan_date'],
//             'interest_rate'    => $rate,
//             'total_amount'     => round($totalToPay, 2),
//             'daily_repayment'  => round($dailyRepayment, 2),
//             'created_at'       => now(),
//             'updated_at'       => now(),
//         ];
//     }

//     if (count($loanData) > 0) {
//         // Insert the new loan(s) into the database
//         Loan::insert($loanData);

//         // Now, check for any loans that should be moved to the settled table
//         $inactiveLoans = Loan::where('status', 'inactive')->get();

//         foreach ($inactiveLoans as $inactiveLoan) {
//             // Prepare data for inserting into settled_loans table
//             $settledLoanData = [
//                 'name'             => $inactiveLoan->name,
//                 'contact'          => $inactiveLoan->contact,
//                 'amount'           => $inactiveLoan->amount,
//                 'loan_date'        => $inactiveLoan->loan_date,
//                 'interest_rate'    => $inactiveLoan->interest_rate,
//                 'total_amount'     => $inactiveLoan->total_amount,
//                 'daily_repayment'  => $inactiveLoan->daily_repayment,
//                 'balance_left'     => $inactiveLoan->balance_to_pay, // Moving the balance
//                 'created_at'       => now(),
//                 'updated_at'       => now(),
//             ];

//             // Insert the data into the settled_loans table
//             SettledLoan::create($settledLoanData);

//             // Optionally, delete the loan from the Loan table if you no longer need it there
//             $inactiveLoan->delete();
//         }

//         // After everything is done, show the success message
//         return redirect()->back()->with('success', 'Loans created successfully.');
//     }

//     // If no loans were added, show an error message
//     if (count($errors) > 0) {
//         return redirect()->back()->withErrors($errors);
//     }

//     return redirect()->back()->with('error', 'No new loans were added.');
// }
// }