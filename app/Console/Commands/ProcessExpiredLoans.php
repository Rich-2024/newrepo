<?php

// namespace App\Console\Commands;

// use Illuminate\Console\Command;
// use App\Models\Loan;
// use App\Models\SettledLoan;
// use Carbon\Carbon;

// class ProcessExpiredLoans extends Command
// {
//     protected $signature = 'loans:process-expired';
//     protected $description = 'Update expired loans to inactive and move them to settled loans table';

//     public function handle()
//     {
//         $this->info('⏳ Checking for expired loans...');

//         // Mark expired loans as inactive
//         $expiredLoans = Loan::where('status', 'active')
//             ->where('end_date', '<', Carbon::now())
//             ->get();

//         foreach ($expiredLoans as $loan) {
//             $loan->status = 'inactive';
//             $loan->save();
//         }

//         $this->info("✅ Updated {$expiredLoans->count()} expired loan(s) to inactive.");

//         //  Move inactive loans to SettledLoan and delete from Loan
//         $inactiveLoans = Loan::where('status', 'inactive')->get();
//         foreach ($inactiveLoans as $loan) {
//                 \Log::info('Loan user_id: ' . var_export($loan->user_id, true));

//             SettledLoan::create([
//                 'name'             => $loan->name,
//                 'contact'          => $loan->contact,
//                 'loan_date'        => $loan->loan_date,
//                 'amount'           => $loan->amount,
//                  'interest_rate'    => $loan->interest_rate ?? 0,
//                  'total_amount'     => $loan->total_amount,
//                 'daily_repayment'  => $loan->daily_repayment,
//                 'balance_left'     => $loan->balance_to_pay,
//                  'user_id'         => $loan->user_id,

//                 'created_at'       => now(),
//                 'updated_at'       => now(),
//             ]);

//             $loan->delete();
//         }

//         $this->info("✅ Moved {$inactiveLoans->count()} inactive loan(s) to SettledLoan table.");
//     }



namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use App\Models\SettledLoan;
use App\Models\LoanCommandLog;
use Carbon\Carbon;
use Artisan;
class ProcessExpiredLoans extends Command
{
    // Accept a user ID as input
    protected $signature = 'loans:process-expired {user_id}';
    protected $description = 'Update expired loans for a specific user and move them to the settled loans table.';

    public function handle()
    {
   LoanCommandLog::where('last_ran_on', '<', now()->subDays(30))->delete();

        $userId = $this->argument('user_id');
        $today = Carbon::today();

        // Check if already processed today
        $log = LoanCommandLog::where('user_id', $userId)
            ->where('last_ran_on', $today)
            ->first();

        if ($log) {
            $this->info("⏹️ Already processed for user ID {$userId} today. Skipping.");
            return;
        }

        $this->info("⏳ Checking for expired loans for user ID: $userId");

        //  Mark expired loans as inactive
        $expiredLoans = Loan::where('user_id', $userId)
            ->where('status', 'active')
            ->where('end_date', '<', Carbon::now())
            ->get();

        foreach ($expiredLoans as $loan) {
            $loan->status = 'inactive';
            $loan->save();
        }

        $this->info("✅ Updated {$expiredLoans->count()} expired loan(s) to inactive.");

        //  Move inactive loans to SettledLoan
        $inactiveLoans = Loan::where('user_id', $userId)
            ->where('status', 'inactive')
            ->get();

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
                'user_id'          => $loan->user_id,
                 'amount_copy'      => $loan->amount,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            $loan->delete();
        }

        $this->info("✅ Moved {$inactiveLoans->count()} inactive loan(s) to settled for user ID: $userId.");

        LoanCommandLog::updateOrCreate(
            ['user_id' => $userId],
            ['last_ran_on' => $today]
        );
                Artisan::call('update:trial-status');
    }
}


