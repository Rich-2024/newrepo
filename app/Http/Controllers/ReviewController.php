<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\SettledLoan;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id(); // Get current user

        $totalLoans = Loan::where('user_id', $userId)->count();
        $activeLoans = Loan::where('user_id', $userId)->where('status', 'active')->get();
        $inactiveLoans = Loan::where('user_id', $userId)->where('status', 'inactive')->get();
        $settledLoans = SettledLoan::where('user_id', $userId)->get();

        $totalLoanAmount = $activeLoans->sum('total_amount');
        $totalRepaid = $activeLoans->sum(fn($loan) => $loan->total_amount - $loan->balance_to_pay);
        $totalOutstanding = Loan::where('user_id', $userId)->where('balance_to_pay', '>', 0)->sum('balance_to_pay');

        $repaymentRate = $totalLoanAmount > 0 ? round(($totalRepaid / $totalLoanAmount) * 100, 2) : 0;

        $overdueLoans = $activeLoans->filter(fn($loan) => Carbon::parse($loan->End_date)->isPast());
        $overduePercentage = $totalLoans > 0 ? round(($overdueLoans->count() / $totalLoans) * 100, 2) : 0;

        $totalSettledLoans = SettledLoan::where('user_id', $userId)->count();
        $defaulters = SettledLoan::where('user_id', $userId)
            ->where('balance_left', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $defaultersPercentage = $totalSettledLoans > 0
            ? round(($defaulters->count() / $totalSettledLoans) * 100, 2)
            : 0;

        $fineRate = Setting::where('key', 'fine_rate')->first()->value ?? 0;
        $fineEndDate = Setting::where('key', 'fine_end_date')->first()->value ?? now()->toDateString();

        $finedLoans = $settledLoans->filter(fn($loan) => $loan->balance_left > 0);
        $totalFine = 0;
        $collectedFine = 0;

        foreach ($finedLoans as $loan) {
            $created = Carbon::parse($loan->created_at)->startOfDay();
            $end = Carbon::parse($fineEndDate)->startOfDay();
            $days = $created->diffInDays($end);
            $fine = ($fineRate / 100) * $loan->balance_left * $days;
            $totalFine += $fine;
            $collectedFine += $loan->fine_paid ?? 0;
        }

        $fineCollectionRate = $totalFine > 0 ? round(($collectedFine / $totalFine) * 100, 2) : 0;

        $thisMonth = Loan::where('user_id', $userId)->whereMonth('created_at', now()->month)->count();
        $lastMonth = Loan::where('user_id', $userId)->whereMonth('created_at', now()->subMonth()->month)->count();
        $growth = $lastMonth > 0 ? round((($thisMonth - $lastMonth) / $lastMonth) * 100, 2) : ($thisMonth > 0 ? 100 : 0);

        $recommendations = [];

        if ($repaymentRate >= 90) $recommendations[] = "Excellent repayment rate. Consider expanding lending operations.";
        elseif ($repaymentRate < 50) $recommendations[] = "Low repayment rate. Re-evaluate creditworthiness assessments.";

        if ($overduePercentage > 20) $recommendations[] = "High number of overdue loans. Strengthen your collection strategy.";
        if ($fineCollectionRate < 50 && $totalFine > 0) $recommendations[] = "Fine collection is low. Improve enforcement or communication.";
        if ($defaultersPercentage > 15) $recommendations[] = "Too many defaulters. Review loan approval and follow-up processes.";
        if ($growth < 0) $recommendations[] = "Negative growth. Analyze market trends and revise outreach.";

        return view('admin.statistic', compact(
            'repaymentRate',
            'overduePercentage',
            'defaultersPercentage',
            'fineCollectionRate',
            'growth',
            'recommendations',
            'totalLoans',
            'totalOutstanding',
            'totalRepaid',
            'totalFine',
            'collectedFine',
            'activeLoans',
            'overdueLoans',
            'defaulters',
            'settledLoans'
        ));
    }
}
