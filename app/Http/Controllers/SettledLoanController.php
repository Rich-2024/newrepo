<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
   use App\Models\SettledLoan;
class SettledLoanController extends Controller
{

public function index(Request $request)
{
    // Retrieve and sanitize filter input
    $month  = $request->input('month');
    $year   = $request->input('year');
    $client = trim($request->input('client'));

    // Start the query

    $query = SettledLoan::query();

    // Filter by month if valid (1-12)
    if (!empty($month) && is_numeric($month) && $month >= 1 && $month <= 12) {
        $query->whereMonth('settled_at', intval($month));
    }

    // Filter by year if
    if (!empty($year) && is_numeric($year) && $year >= 2000 && $year <= date('Y') + 1) {
        $query->whereYear('settled_at', intval($year));
    }

    // Filter by client name (case-insensitive, partial match)
    if (!empty($client)) {
        $query->where('name', 'like', '%' . $client . '%');
    }

    // Order and paginate the results
    $settledLoans = $query->orderBy('settled_at', 'desc')->paginate(10);

    // Maintain query params in pagination links
    $settledLoans->appends([
        'month'  => $month,
        'year'   => $year,
        'client' => $client,
    ]);

    return view('settled_loans.index', compact('settledLoans', 'month', 'year', 'client'));
}

public function destroy($id)
{
    $loan = SettledLoan::findOrFail($id);
    $clientName = $loan->name; 
    $loan->delete();

    return redirect()->back()->with('success', "Settled loan for {$clientName} was deleted successfully.");
}


}
