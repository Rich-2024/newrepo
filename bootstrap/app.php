<?php

// use Illuminate\Foundation\Application;
// use Illuminate\Foundation\Configuration\Exceptions;
// use Illuminate\Foundation\Configuration\Middleware;
// use Illuminate\Console\Scheduling\Schedule;
// use App\Console\Commands\ProcessExpiredLoans;

// return Application::configure()
//     ->withRouting(
//         web: __DIR__.'/../routes/web.php',
//         api: __DIR__.'/../routes/api.php',
//         commands: __DIR__.'/../routes/console.php',
//     )
//     ->withMiddleware(function (Middleware $middleware) {
//         // Register your global or route-specific middleware here
//     })
//     ->withCommands([
//         ProcessExpiredLoans::class, // Register your Artisan command
//     ])
//     ->withSchedule(function (Schedule $schedule) {
//         $schedule->command('loans:process-expired')
//                  ->everyMinute(); // You can change this to daily(), hourly(), etc.
//     })
//     ->withExceptions(function (Exceptions $exceptions) {
//         // Add custom exception handlers if needed
//     })
//     ->create();


use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ProcessExpiredLoans;
use App\Http\Middleware\CheckTrialAccess;

return Application::configure()
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register CheckTrialAccess as a global middleware
        $middleware->append(CheckTrialAccess::class);
    })
    ->withCommands([
        ProcessExpiredLoans::class, // Register your Artisan command
    ])
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('loans:process-expired')
                 ->everyMinute(); // You can change this to daily(), hourly(), etc.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Add custom exception handlers if needed
    })
    ->create();
