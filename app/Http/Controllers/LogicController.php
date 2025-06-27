<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

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

    // Automatically set user_id based on authenticated user
    $validatedData['user_id'] = auth()->id();

    // Check if the combination already exists for this user
    $exists = InterestSetup::where('user_id', $validatedData['user_id'])
        ->where('interest_rate', $validatedData['interest_rate'])
        ->where('loan_duration', $validatedData['loan_duration'])
        ->exists();

    if ($exists) {
        return redirect()->back()
            ->withErrors(['This interest rate and loan duration combination already exists.'])
            ->withInput();
    }

    InterestSetup::create($validatedData);

    return redirect()->back()->with('success', 'Interest setup created successfully.');
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
    $userId =auth::id();
    $recentSetups = InterestSetup::where('user_id',$userId)->latest()->paginate(10);

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


// public function view()
// {
//     $recentLoans = Loan::orderBy('created_at', 'desc')->take(15)->get();

//     $recentRepayments = Repayment::with('loan')
//         ->orderBy('created_at', 'desc')
//         ->take(5)
//         ->get();

//     $totalClients = Loan::distinct('contact')->count('contact');

//     $outstandingRepayments = Loan::where('balance_to_pay', '>', 0)
//         ->orderBy('created_at', 'desc')
//         ->get();

//     $totalOutstanding = Loan::where('balance_to_pay', '>', 0)->sum('balance_to_pay');

//     $activeLoansCount = Loan::where('status', 'active')->count();

//     $defaulters = SettledLoan::where('balance_left', '>', 0)
//         ->orderBy('created_at', 'desc')
//         ->get();

//     $defaultersTotalOutstanding = $defaulters->sum('balance_left');

//     return view('admin.dashboard', compact(
//         'recentLoans',
//         'recentRepayments',
//         'totalClients',
//         'outstandingRepayments',
//         'totalOutstanding',
//         'activeLoansCount',
//         'defaulters',
//         'defaultersTotalOutstanding'
//     ));
// }



public function view()
{
    $userId = Auth::id();

    // Recent loans for this user
    $recentLoans = Loan::where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->take(15)
        ->get();

    // Recent repayments for this user's loans
    $recentRepayments = Repayment::whereHas('loan', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with('loan')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    $totalClients = Loan::where('user_id', $userId)
        ->distinct('contact')
        ->count('contact');

    $outstandingRepayments = Loan::where('user_id', $userId)
        ->where('balance_to_pay', '>', 0)
        ->orderBy('created_at', 'desc')
        ->get();

    $totalOutstanding = Loan::where('user_id', $userId)
        ->where('balance_to_pay', '>', 0)
        ->sum('balance_to_pay');

    $activeLoansCount = Loan::where('user_id', $userId)
        ->where('status', 'active')
        ->count();

    // Defaulters
    $defaulters = SettledLoan::where('user_id', $userId)
        ->where('balance_left', '>', 0)
        ->orderBy('created_at', 'desc')
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
    $userId = Auth::id();

    // Only loans for the logged-in user
    $loans = Loan::where('user_id', $userId)->get();

    return view('clients.clientRep', compact('loans'));
}

public function show()
{
    $userId = Auth::id();

    $clients = Loan::where('user_id', $userId)->get();

    $reps = Repayment::whereHas('loan', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })->get();

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


