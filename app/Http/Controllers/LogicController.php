<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterestSetup;
use App\Models\loan;
use App\Models\Repayment;
use App\Models\SettledLoan;


class LogicController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_size' => 'required|in:Small,Medium,Large',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'loan_duration' => 'required|integer|min:1',
        ]);
    
        // Check if the combination already exists
        $exists = InterestSetup::where('interest_rate', $validatedData['interest_rate'])
            ->where('loan_duration', $validatedData['loan_duration'])
            ->exists();
    
        if ($exists) {
            return redirect()->back()
                ->withErrors(['This interest rate and loan duration combination already exists.'])
                ->withInput();
        }
    
        // Save the new record
        InterestSetup::create($validatedData);
    
        // Redirect with success (no withInput here)
        return redirect()->back()
            ->with('success', 'Interest setup has been saved successfully!');
    }
    

public function showLoanHistory()
{
    $loans = Loan::with('client')->get();
    $events = $loans->map(function($loan) {
        return [
            'title' => $loan->client->name,
            'start' => $loan->payment_date->toDateString(),
            'extendedProps' => [
                'loan' => [
                    'client_name' => $loan->client->name,
                    'amount' => $loan->amount,
                    'payment_date' => $loan->payment_date->format('d M Y'),
                    'status' => ucfirst($loan->status),
                    'note' => $loan->note,
                ]
            ]
        ];
    });

    $recentLoans = $loans->sortByDesc('payment_date')->take(5);

    return view('client-loan-history', compact('events', 'recentLoans'));
}
public function interest()
{
    // Fetch the recent setups from the database (adjust as per your database structure)
    $recentSetups = InterestSetup::latest()->paginate(0); // Or use any query that fits your data

    // Pass the $recentSetups variable to the view
    return view('setting.interest', compact('recentSetups'));
}
//display to ui
// public function view()
// {
//     $recentLoans = Loan::orderBy('created_at', 'desc')->take(5)->get();

//     $recentRepayments = Repayment::with('loan')
//         ->orderBy('created_at', 'desc')
//         ->take(5)
//         ->get();

//     $totalClients = Loan::distinct('contact')->count('contact');

//     $outstandingRepayments = Loan::where('balance_to_pay', '>', 0)
//         ->orderBy('loan_date', 'desc')
//         ->get();

//     $totalOutstanding = Loan::where('balance_to_pay', '>', 0)->sum('balance_to_pay');

//     return view('admin.dashboard', compact(
//         'recentLoans',
//         'recentRepayments',
//         'totalClients',
//         'outstandingRepayments',
//         'totalOutstanding'
//     ));
// }


public function view()
{
    $recentLoans = Loan::orderBy('created_at', 'desc')->take(15)->get();

    $recentRepayments = Repayment::with('loan')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    $totalClients = Loan::distinct('contact')->count('contact');

    $outstandingRepayments = Loan::where('balance_to_pay', '>', 0)
        ->orderBy('created_at', 'desc') // or loan_date if more appropriate
        ->get();

    $totalOutstanding = Loan::where('balance_to_pay', '>', 0)->sum('balance_to_pay');

    $activeLoansCount = Loan::where('status', 'active')->count();

    $defaulters = SettledLoan::where('balance_left', '>', 0)
        ->orderBy('created_at', 'desc') // ← added sorting
        ->get();

    $defaultersTotalOutstanding = $defaulters->sum('balance_left');

    return view('admin.dashboard', compact(
        'recentLoans',
        'recentRepayments',
        'totalClients',
        'outstandingRepayments',
        'totalOutstanding',
        'activeLoansCount',
        'defaulters',
        'defaultersTotalOutstanding'
    ));
}



public function repay(){
    
}
//repaymentform
public function showRepaymentForm()
{
    $loans = Loan::all(); // ✅ More accurate than $clients
    return view('clients.clientRep', compact('loans'));
}

//all client
public function show()
{
    $clients = Loan::all();
    $reps = Repayment::all();
 
    return view('clients.views', compact('clients', 'reps'));
}


public function index(Request $request)
{
    $search = $request->input('search');

    $clients = Loan::query()
        ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%");
            });
        })
        ->orderBy('created_at', 'desc')
        ->get();

    return view('clients.views', compact('clients'));
}



    }
    

