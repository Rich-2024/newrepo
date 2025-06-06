<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\SettledLoan;
use App\Models\Repayment;
use App\Models\Loan;
use Carbon\Carbon;

class LoanFineController extends Controller
{
 public function index()
    {
        // Get settings
        $fineRateSetting = Setting::where('key', 'fine_rate')->first();
        $fineDurationSetting = Setting::where('key', 'fine_duration')->first();

        $rate = $fineRateSetting->value ?? 0;
        $fineDuration = $fineDurationSetting->value ?? 0;

        // Get latest update timestamp
        $lastUpdated = collect([$fineRateSetting, $fineDurationSetting])
            ->filter()
            ->sortByDesc(fn($s) => $s->updated_at)
            ->first()?->updated_at;

        // Fetch fined loans
        $loans = $this->getFineLoans($rate, $fineDuration);

        return view('setting.fine', compact('loans', 'rate', 'fineDuration', 'lastUpdated'));
    }

protected function getFineLoans($rate, $fineDuration)
{
    // Fetch loans with balance left > 0
    $loans = SettledLoan::where('balance_left', '>', 0)->get();

    $today = Carbon::today();

   $rate = floatval($rate);
$fineDuration = intval($fineDuration);

foreach ($loans as $loan) {
    $createdAt = Carbon::parse($loan->created_at)->startOfDay();
    $today = Carbon::today();
// // Convert created_at from UTC to local timezone
// $createdAt = Carbon::parse($loan->created_at)->timezone('Africa/Kampala')->startOfDay();

// // Use now() in local timezone too
// $today = Carbon::now('Africa/Kampala')->startOfDay();

    $actualOverdueDays = max(0, $createdAt->diffInDays($today));
    $overdueDays = min($actualOverdueDays, $fineDuration);
    
    $balanceLeft = floatval($loan->balance_left);

    if (!is_numeric($rate) || !is_numeric($overdueDays) || !is_numeric($balanceLeft)) {
        $loan->fine_total = 0;
        $loan->overdue_days = 0;
        continue;
    }

    $loan->overdue_days = $overdueDays;
    $loan->fine_total = $overdueDays * ($rate / 100) * $balanceLeft;
}


    return $loans;
}


    public function updateSettings(Request $request)
    {
        $request->validate([
            'rate' => 'required|numeric|min:0',
            'fine_duration' => 'required|integer|min:1'
        ]);

        Setting::updateOrCreate(
            ['key' => 'fine_rate'],
            ['value' => $request->rate]
        );

        Setting::updateOrCreate(
            ['key' => 'fine_duration'],
            ['value' => $request->fine_duration]
        );

        return redirect()->route('loan_fines.index')->with('success', 'Fine settings updated successfully!');
    }
public function fineLoansTable()
{
    // Retrieve fine rate and end date settings or fallback to defaults
    $rate = Setting::where('key', 'fine_rate')->first()->value ?? 0;
    $endDate = Setting::where('key', 'fine_end_date')->first()->value ?? now()->toDateString();

    // Get fined loans
    $loans = $this->getFineLoans($rate, $endDate);

    // Calculate fine duration (overdue days) as an integer
    $minStart = $loans->min('created_at');
    $maxEnd = Carbon::parse($endDate)->startOfDay();

    $fineDuration = floor(Carbon::parse($minStart)->diffInDays($maxEnd));

    return view('partials.fine_table', compact('loans', 'rate', 'endDate', 'fineDuration'));
}

public function settle(Request $request)
{
    $request->validate([
        'loan_id'      => 'required|exists:loans,id',
        'amount'       => 'required|numeric|min:1',
        'payment_date' => 'required|date',
        'note'         => 'nullable|string|max:1000',
    ]);

    try {
        // Create repayment linked to loans table via loan_id
        $repayment = Repayment::create([
            'loan_id'      => $request->loan_id,
            'amount'       => $request->amount,
            'payment_date' => $request->payment_date,
            'note'         => $request->note,
        ]);
    } catch (\Exception $e) {
        logger()->error('Repayment creation failed: ' . $e->getMessage());
        return back()->with('error', 'Repayment creation failed.');
    }

    $settledLoan = SettledLoan::where('id', $request->loan_id)->first();

    if ($settledLoan) {
        $totalRepaid = Repayment::where('loan_id', $request->loan_id)->sum('amount');

        $settledLoan->balance_left = max(0, round($settledLoan->total_amount - $totalRepaid, 2));

        $settledLoan->repayment_made = $totalRepaid;

        // Store the latest repayment date
        $settledLoan->last_repayment_date = $request->payment_date;

        $settledLoan->save();
    }

    return redirect()->back()->with('success', 'Repayment successfully recorded.');
}



}
