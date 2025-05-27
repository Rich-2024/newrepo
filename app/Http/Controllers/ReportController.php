<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
    use App\Models\SettledLoan;
        use App\Models\InterestSetup;

use App\Models\Repayment;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{

public function defaultersReport()
{
    $defaulters = SettledLoan::where('balance_left', '>', 0)->orderBy('settled_at', 'desc')->get();

    return view('clients.defaulters', compact('defaulters'));
}


public function repaymentHistory(Request $request)
{
    // Get the search query
    $search = $request->input('search');
  $month = (int) $request->input('month', now()->month);
$year = (int) $request->input('year', now()->year);
;

    // Fetch repayments filtered by search if provided
    $repaymentsQuery = Repayment::with('loan')
        ->whereYear('payment_date', $year)
        ->whereMonth('payment_date', $month);

    // Apply search if it's provided
    if ($search) {
        $repaymentsQuery->where(function($query) use ($search) {
            $query->whereHas('loan', function($q) use ($search) {
                $q->where('id', 'LIKE', "%$search%")
                  ->orWhere('name', 'LIKE', "%$search%");
            });
        });
    }

    // Get filtered repayments
    $repayments = $repaymentsQuery->orderByDesc('payment_date')->get();

    // Calculate totals
    $totalRepayments = $repayments->sum('amount');
    $totalLoans = Loan::all()->sum('amount');
    $balanceDue = SettledLoan::where('balance_left', '>', 0)->sum('balance_left');

    // Prepare data for the view
    $reportData = [
        'repayments' => $repayments,
        'total_loans' => $totalLoans,
        'total_repayments' => $totalRepayments,
        'balance_due' => $balanceDue,
    ];

    // Return the view with the report data
    return view('clients.reports', compact('reportData', 'month', 'year', 'search'));
}
   // Show the report generation form
   public function showForm()
    {
        return view('partials.report');
    }

    // Handle the report generation
    public function generate(Request $request)
    {
        // Validate report type
        $this->validateReportType($request);

        // Fetch loan data (adjust query if necessary)
        $loans = Loan::all();

        // Check if no loans are available
        if ($loans->isEmpty()) {
            return back()->with('error', 'No loan records available to generate the report.');
        }

        // Get the report type
        $reportType = $request->input('report_type');

        // Handle CSV generation
        if ($reportType === 'csv') {
            return $this->generateCSV($loans);
        }

        // Handle PDF generation
        if ($reportType === 'pdf') {
            return $this->generatePDF($loans);
        }

        // Return error if an invalid report type is selected
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
            fputcsv($handle, ['ID', 'Name', 'Contact', 'Loan Amount', 'Balance Left', 'Loan Date', 'Status']);
            
            // Add loan data rows
            foreach ($loans as $loan) {
                fputcsv($handle, [
                    $loan->id,
                    $loan->name,
                    $loan->contact,
                    $loan->amount,
                    $loan->balance_to_pay,
                    $loan->loan_date,
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
        // Get the business name from interest_setups
        $businessName = InterestSetup::first()->business_name ?? 'Your Business';

        // Load PDF view and pass both loans and business name
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
