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
    // ✅ Step 1: Validate multiple client inputs
    $validated = $request->validate([
        'clients.*.name'      => 'required|string|max:255',
        'clients.*.contact'   => 'required|string|max:255',
        'clients.*.amount'    => 'required|numeric|min:1000',
        'clients.*.loan_date' => 'required|date',
    ]);

    // ✅ Step 2: Get the most recent interest configuration
    $interest = InterestSetup::latest()->first();

    if (!$interest) {
        return redirect()->back()->with('error', 'Interest configuration not found.');
    }

    // Extract interest rate and loan duration (in days)
    $rate = $interest->interest_rate;
    $loanDuration = $interest->loan_duration;

    $loanData = []; // Will hold the loans to insert
    $errors = [];   // Will collect any errors (e.g. duplicates)

    // ✅ Step 3: Loop through each client and process their loan
    foreach ($validated['clients'] as $clientData) {

        // 🚫 Check for existing loan with the same contact to prevent duplicates
        $existingClient = Loan::where('contact', $clientData['contact'])->first();

        if ($existingClient) {
            // Add error for duplicate client contact
            $errors[] = "Client with contact {$clientData['contact']} already exists: {$existingClient->name}";
            continue; // Skip this client
        }

        // Get the loan amount from the form
        $amount = $clientData['amount'];

        // ✅ Step 4: Calculate interest, total repayable amount, and daily repayment
        $interestAmount = ($rate / 100) * $amount;
        $totalToPay = $amount + $interestAmount;
        $dailyRepayment = $totalToPay / $loanDuration;

        // 🗓️ Step 5: Calculate the loan's end date based on the loan_date and loan_duration
        $loanDate = Carbon::parse($clientData['loan_date']); // Parse the loan date
        $loanEndDate = $loanDate->copy()->addDays($loanDuration); // Add loan duration in days

        // ✅ Step 6: Prepare data for the loan to be inserted into the database
        $loanData[] = [
            'name'             => $clientData['name'],
            'contact'          => $clientData['contact'],
            'amount'           => $amount,
            'loan_date'        => $loanDate->toDateString(),
            'End_date'         => $loanEndDate->toDateString(), // Add the calculated end date
            'interest_rate'    => $rate,
            'loan_duration'    => $loanDuration,
            'total_amount'     => round($totalToPay, 2),
            'balance_to_pay'   => round($totalToPay, 2),
            'daily_repayment'  => round($dailyRepayment, 2),
            'status'           => 'active',  // Set initial status to active
            'created_at'       => now(),
            'updated_at'       => now(),
        ];
    }

    // ✅ Step 7: Insert all prepared loan records into the database
    if (count($loanData) > 0) {
        Loan::insert($loanData);

        // ✅ Step 8: Check for expired loans and update their status to 'inactive'
        $this->updateLoanStatusIfExpired();

        // ✅ Step 9: Automatically move inactive loans to the settled table
        $this->moveInactiveLoansToSettled();

        return redirect()->back()->with('success', 'Loans created successfully.');
    }

    // 🚫 Return any errors from skipped clients due to duplicate contact
    if (count($errors) > 0) {
        return redirect()->back()->withErrors($errors);
    }

    // 🚫 If no data was inserted or errors were returned
    return redirect()->back()->with('error', 'No new loans were added.');
}

private function moveInactiveLoansToSettled()
{
    // ✅ Step 1: Find all loans marked as 'inactive'
    $inactiveLoans = Loan::where('status', 'inactive')->get();

    foreach ($inactiveLoans as $loan) {
        // ✅ Step 2: Create a record in the SettledLoan table
        SettledLoan::create([
            'name'             => $loan->name,
            'contact'          => $loan->contact,
            'loan_date'        => $loan->loan_date,
            'amount'           => $loan->amount,
             'interest_rate'    => $loan->interest_rate,
            'total_amount'     => $loan->total_amount,
            'daily_repayment'  => $loan->daily_repayment,
            'balance_left'     => $loan->balance_to_pay,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        // Optionally delete or mark the loan as settled in the original loans table
        // $loan->delete();
    }
}

private function updateLoanStatusIfExpired()
{
    // ✅ Step 1: Get the current date
    $currentDate = Carbon::now();

    // ✅ Step 2: Find all loans where the end date has passed and the loan is still active
    $loans = Loan::where('status', 'active') // Assuming active status means loan is still running
                 ->where('end_date', '<', $currentDate)
                 ->get();

    foreach ($loans as $loan) {
        // ✅ Step 3: Update loan status to 'inactive' if the loan duration has passed
        $loan->status = 'inactive'; // Set to 'inactive' after loan duration has expired
        $loan->save();
    }
}

public function update(Request $request, $id)
{
    // Validate request input
    $validated = $request->validate([
        'name'   => 'required|string|max:255',
        'phone'  => 'required|string|max:20',
    ]);

    // Find loan record by ID
    $loan = Loan::findOrFail($id);

    // Update the client info inside the loan record
    $loan->name = $validated['name'];
    $loan->contact = $validated['phone'];
    $loan->save();

    return redirect()->back()->with('success', 'Client information updated successfully.');
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