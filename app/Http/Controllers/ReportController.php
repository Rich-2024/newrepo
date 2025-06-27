<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\SettledLoan;
use App\Models\InterestSetup;
use App\Models\Repayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function defaultersReport()
    {
        $userId = Auth::id();

        $defaulters = SettledLoan::where('user_id', $userId)
            ->where('balance_left', '>', 0)
            ->orderBy('settled_at', 'desc')
            ->get();

        return view('clients.defaulters', compact('defaulters'));
    }

    public function repaymentHistory(Request $request)
    {
        $userId = Auth::id();

        $search = $request->input('search');
        $month = (int) $request->input('month', now()->month);
        $year = (int) $request->input('year', now()->year);

        $repaymentsQuery = Repayment::with('loan')
            ->whereHas('loan', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereYear('payment_date', $year)
            ->whereMonth('payment_date', $month);

        if ($search) {
            $repaymentsQuery->where(function ($query) use ($search) {
                $query->whereHas('loan', function ($q) use ($search) {
                    $q->where('id', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%");
                });
            });
        }

        $repayments = $repaymentsQuery->orderByDesc('payment_date')->get();

        $totalRepayments = $repayments->sum('amount');
        $totalLoans = Loan::where('user_id', $userId)->sum('amount');
        $balanceDue = SettledLoan::where('user_id', $userId)
            ->where('balance_left', '>', 0)
            ->sum('balance_left');

        $reportData = [
            'repayments'        => $repayments,
            'total_loans'       => $totalLoans,
            'total_repayments'  => $totalRepayments,
            'balance_due'       => $balanceDue,
        ];

        return view('clients.reports', compact('reportData', 'month', 'year', 'search'));
    }

    public function showForm()
    {
        return view('partials.report');
    }

    // Handle the report generation
    public function generate(Request $request)
    {
        $userId = Auth::id();

        $this->validateReportType($request);

        // Only fetch loans for this user
        $loans = SettledLoan::where('user_id', $userId)->get();

        if ($loans->isEmpty()) {
            return back()->with('error', 'No loan records available to generate the report.');
        }

        $reportType = $request->input('report_type');

        if ($reportType === 'csv') {
            return $this->generateCSV($loans);
        }

        if ($reportType === 'pdf') {
            return $this->generatePDF($loans);
        }

        return back()->with('error', 'Invalid report type selected.');
    }

    // Validate report type
    private function validateReportType(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:csv,pdf',
        ]);
    }

    // Generate CSV report
    private function generateCSV($loans)
    {
        return response()->stream(function () use ($loans) {
            $handle = fopen('php://output', 'w');
            // Add the header row
            fputcsv($handle, ['ID', 'Name', 'Contact', 'Loan Amount', 'Repayment made','Balance Left', 'Loan Date','Settled Date','Status']);

            // Add loan data rows
            foreach ($loans as $loan) {
                fputcsv($handle, [
                    $loan->id,
                    $loan->name,
                    $loan->contact,
                    $loan->amount,
                      $loan->repayment_made,
                    $loan->balance_left,
                    $loan->loan_date,
                    $loan->created_at,
                   $loan->status



                ]);
            }

            fclose($handle);
        }, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=loan_report.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ]);
    }

    // Generate PDF report
    private function generatePDF($loans)
    {
        try {
            // Get the business name from interest_setups for this user or default
            $businessName = InterestSetup::first()->business_name ?? 'Your Business';

            $pdf = Pdf::loadView('partials.loan_pdf', [
                'loans' => $loans,
                'business_name' => $businessName
            ]);

            return $pdf->download('loan_report.pdf');
        } catch (\Exception $e) {
            \Log::error('Error generating PDF report: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while generating the PDF report.');
        }
    }
}
