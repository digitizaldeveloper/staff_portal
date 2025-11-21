<?php

namespace App\Observers;

use App\Models\Timesheet;
use App\Models\Notification;

class TimesheetObserver
{
    /**
     * Handle the Timesheet "updated" event to detect status changes.
     */
    public function updated(Timesheet $timesheet): void
    {
        // Check if status was changed
        if ($timesheet->isDirty('status')) {
            $oldStatus = $timesheet->getOriginal('status');
            $newStatus = $timesheet->status;

            try {
                // Only create notification if status changed to approved or rejected
                if ($newStatus === 'approved' && $oldStatus !== 'approved') {
                    Notification::create([
                        'user_id' => $timesheet->staff_id,
                        'type' => 'timesheet_approved',
                        'title' => 'Timesheet Approved',
                        'message' => 'Your timesheet for ' . ($timesheet->date ?? 'the selected date') . ' has been approved.',
                        'data' => [
                            'timesheet_id' => $timesheet->id,
                            'date' => $timesheet->date ?? null,
                        ],
                    ]);
                } elseif ($newStatus === 'rejected' && $oldStatus !== 'rejected') {
                    Notification::create([
                        'user_id' => $timesheet->staff_id,
                        'type' => 'timesheet_rejected',
                        'title' => 'Timesheet Rejected',
                        'message' => 'Your timesheet for ' . ($timesheet->date ?? 'the selected date') . ' has been rejected. ' . ($timesheet->admin_notes ? 'Reason: ' . $timesheet->admin_notes : 'Please contact admin for details.'),
                        'data' => [
                            'timesheet_id' => $timesheet->id,
                            'date' => $timesheet->date ?? null,
                            'admin_notes' => $timesheet->admin_notes ?? null,
                        ],
                    ]);
                }
            } catch (\Exception $e) {
                // Avoid breaking the request if notification creation fails
            }
        }
    }
}
