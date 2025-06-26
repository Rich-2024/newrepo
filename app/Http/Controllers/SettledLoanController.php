<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettledLoan;
use Illuminate\Support\Facades\Auth;

class SettledLoanController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id(); // 👈 Ensure we're filtering by logged-in user

        $month  = $request->input('month');
        $year   = $request->input('year');
        $client = trim($request->input('client'));

        $query = SettledLoan::where('user_id', $userId); 

        if (!empty($month) && is_numeric($month) && $month >= 1 && $month <= 12) {
            $query->whereMonth('settled_at', intval($month));
        }

        if (!empty($year) && is_numeric($year) && $year >= 2000 && $year <= date('Y') + 1) {
            $query->whereYear('settled_at', intval($year));
        }

        if (!empty($client)) {
            $query->where('name', 'like', '%' . $client . '%');
        }

        $settledLoans = $query->orderBy('settled_at', 'desc')->paginate(10);

        $settledLoans->appends([
            'month'  => $month,
            'year'   => $year,
            'client' => $client,
        ]);

        return view('settled_loans.index', compact('settledLoans', 'month', 'year', 'client'));
    }

    public function destroy($id)
    {
        $userId = Auth::id();

        $loan = SettledLoan::where('id', $id)->where('user_id', $userId)->firstOrFail(); // 👈 Only delete if it belongs to user

        $clientName = $loan->name;
        $loan->delete();

        return redirect()->back()->with('success', "Settled loan for {$clientName} was deleted successfully.");
    }
}
