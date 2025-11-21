<?php

namespace App\Observers;

use App\Models\Payslip;
use App\Models\Notification;

class PayslipObserver
{
    /**
     * Handle the Payslip "created" event.
     */
    public function created(Payslip $payslip): void
    {
        // Create a notification for the staff member who owns the payslip
        try {
            Notification::create([
                'user_id' => $payslip->staff_id,
                'type' => 'payslip_uploaded',
                'title' => 'New Payslip Uploaded',
                'message' => 'A new payslip for ' . ($payslip->pay_period ?? 'the selected period') . ' has been uploaded. Please review it.',
                'data' => [
                    'payslip_id' => $payslip->id,
                    'pay_period' => $payslip->pay_period ?? null,
                ],
            ]);
        } catch (\Exception $e) {
            // avoid breaking the request if notification creation fails
            // you may want to log this in production
        }
    }
}
