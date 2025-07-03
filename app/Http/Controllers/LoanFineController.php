<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\SettledLoan;
use App\Models\Repayment;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoanFineController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $fineRateSetting = Setting::where('key', 'fine_rate')->where('user_id', $userId)->first();
        $fineDurationSetting = Setting::where('key', 'fine_duration')->where('user_id', $userId)->first();

        $rate = $fineRateSetting->value ?? 0;
        $fineDuration = $fineDurationSetting->value ?? 0;

        $lastUpdated = collect([$fineRateSetting, $fineDurationSetting])
            ->filter()
            ->sortByDesc(fn($s) => $s->updated_at)
            ->first()?->updated_at;

        $loans = $this->getFineLoans($rate, $fineDuration, $userId);

        return view('setting.fine', compact('loans', 'rate', 'fineDuration', 'lastUpdated'));
    }

    protected function getFineLoans($rate, $fineDuration, $userId)
    {
        $loans = SettledLoan::where('balance_left', '>', 0)
            ->where('user_id', $userId)
            ->get();

        $today = Carbon::today();

        foreach ($loans as $loan) {
            $createdAt = Carbon::parse($loan->created_at)->startOfDay();
            $actualOverdueDays = max(0, $createdAt->diffInDays($today));
            $overdueDays = min($actualOverdueDays, intval($fineDuration));
            $balanceLeft = floatval($loan->balance_left);

            $loan->overdue_days = $overdueDays;
            $loan->fine_total = $overdueDays * (floatval($rate) / 100) * $balanceLeft;
        }

        return $loans;
    }

public function updateSettings(Request $request)
{
    $request->validate([
        'rate' => 'required|numeric|min:0',
        'fine_duration' => 'required|integer|min:1',
    ]);

    $userId = Auth::id(); // Automatically gets logged-in user ID

    Setting::updateOrCreate(
        ['key' => 'fine_rate', 'user_id' => $userId],
        ['value' => $request->rate]
    );

    Setting::updateOrCreate(
        ['key' => 'fine_duration', 'user_id' => $userId],
        ['value' => $request->fine_duration]
    );

    return redirect()->route('loan_fines.index')->with('success', 'Fine settings updated successfully!');
}

public function fineLoansTable()
{
    $userId = Auth::id();

    $rate = Setting::where('key', 'fine_rate')->where('user_id', $userId)->first()->value ?? 0;
    $limit = Setting::where('key', 'fine_duration')->where('user_id', $userId)->first()->value ?? 0;

    $loans = SettledLoan::where('balance_left', '>', 0)
        ->where('user_id', $userId)
        ->get();

    foreach ($loans as $loan) {
        $loanStart = Carbon::parse($loan->created_at)->startOfDay();

        // Fine applies from created_at to created_at + fine_duration
        $fineEnd = $loanStart->copy()->addDays(intval($limit));
        $now = now()->startOfDay();

        // Fineable days = days between created_at and either now or fineEnd
        $actualFineDays = max(0, $loanStart->diffInDays(min($now, $fineEnd)));

        // Store calculated fields
        $loan->overdue_days = max(0, $loanStart->diffInDays($now));
        $loan->fine_end_date = $fineEnd->toDateString();

        $dailyFine = (floatval($rate) / 100) * floatval($loan->balance_left);
        $loan->fine_total = round($dailyFine * $actualFineDays, 2);
    }


    return view('partials.fine_table', compact('loans', 'rate', 'limit'));
}

// public function fineLoansTable()
// {
//     $userId = Auth::id();

//     $rate = Setting::where('key', 'fine_rate')->where('user_id', $userId)->first()->value ?? 0;
//     $limit = Setting::where('key', 'fine_duration')->where('user_id', $userId)->first()->value ?? 0;

//     $loans = SettledLoan::where('balance_left', '>', 0)
//         ->where('user_id', $userId)
//         ->where(function ($query) {
//             // Only include loans that:
//             // a) have not already had fine applied, OR
//             // b) still within fine window
//             $query->whereNull('fine_already_charged')
//                   ->orWhere('fine_already_charged', false);
//         })
//         ->get();

//     foreach ($loans as $loan) {
//         $loanStart = Carbon::parse($loan->created_at)->startOfDay();

//         // Fine applies from created_at to created_at + fine_duration
//         $fineEnd = $loanStart->copy()->addDays(intval($limit));
//         $now = now()->startOfDay();

//         // Fineable days = days between created_at and either now or fineEnd
//         $actualFineDays = max(0, $loanStart->diffInDays(min($now, $fineEnd)));

//         // Store calculated fields
//         $loan->overdue_days = max(0, $loanStart->diffInDays($now));
//         $loan->fine_end_date = $fineEnd->toDateString();

//         $dailyFine = (floatval($rate) / 100) * floatval($loan->balance_left);
//         $loan->fine_total = round($dailyFine * $actualFineDays, 2);

//         //  New logic: store fine permanently when end date elapses and not already stored
//         if ($now->greaterThan($fineEnd) && is_null($loan->stored_fine_total)) {
//             $loan->stored_balance_left = $loan->balance_left;
//             $loan->stored_fine_total = $loan->fine_total;
//             $loan->balance_left += $loan->fine_total;
//             $loan->last_fine_applied_at = $now;
//             $loan->fine_already_charged = true; //  prevent future reprocessing
//             $loan->save();
//         }
//     }

//     return view('partials.fine_table', compact('loans', 'rate', 'limit'));
// }


    public function settle(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'note' => 'nullable|string|max:1000',
        ]);

        $loan = Loan::where('id', $request->loan_id)
            ->where('user_id', $userId)
            ->first();

        if (!$loan) {
            return back()->with('error', 'Unauthorized or loan not found.');
        }

        try {
            Repayment::create([
                'loan_id' => $request->loan_id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'note' => $request->note,
            ]);
        } catch (\Exception $e) {
            logger()->error('Repayment creation failed: ' . $e->getMessage());
            return back()->with('error', 'Repayment creation failed.');
        }

        $settledLoan = SettledLoan::where('id', $request->loan_id)
            ->where('user_id', $userId)
            ->first();

        if ($settledLoan) {
            $totalRepaid = Repayment::where('loan_id', $request->loan_id)->sum('amount');

            $settledLoan->balance_left = max(0, round($settledLoan->total_amount - $totalRepaid, 2));
            $settledLoan->repayment_made = $totalRepaid;
            $settledLoan->last_repayment_date = $request->payment_date;
            $settledLoan->save();
        }

        return redirect()->back()->with('success', 'Repayment successfully recorded.');
    }
}
