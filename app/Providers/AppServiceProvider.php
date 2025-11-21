<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Payslip;
use App\Models\Timesheet;
use App\Observers\PayslipObserver;
use App\Observers\TimesheetObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers
        Payslip::observe(PayslipObserver::class);
        Timesheet::observe(TimesheetObserver::class);
    }
}
