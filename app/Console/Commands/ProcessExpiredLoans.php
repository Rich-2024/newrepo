<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use App\Models\SettledLoan;
use Carbon\Carbon;

class ProcessExpiredLoans extends Command
{
    protected $signature = 'loans:process-expired';
    protected $description = 'Update expired loans to inactive and move them to settled loans table';

    public function handle()
    {
        $this->info('⏳ Checking for expired loans...');

        // Mark expired loans as inactive
        $expiredLoans = Loan::where('status', 'active')
            ->where('end_date', '<', Carbon::now())
            ->get();

        foreach ($expiredLoans as $loan) {
            $loan->status = 'inactive';
            $loan->save();
        }

        $this->info("✅ Updated {$expiredLoans->count()} expired loan(s) to inactive.");

        //  Move inactive loans to SettledLoan and delete from Loan
        $inactiveLoans = Loan::where('status', 'inactive')->get();
        foreach ($inactiveLoans as $loan) {
            SettledLoan::create([
                'name'             => $loan->name,
                'contact'          => $loan->contact,
                'loan_date'        => $loan->loan_date,
                'amount'           => $loan->amount,
                 'interest_rate'    => $loan->interest_rate ?? 0,
                 'total_amount'     => $loan->total_amount,
                'daily_repayment'  => $loan->daily_repayment,
                'balance_left'     => $loan->balance_to_pay,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            // $loan->delete(); 
        }

        $this->info("✅ Moved {$inactiveLoans->count()} inactive loan(s) to SettledLoan table.");
    }
}
