<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Payslip;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $timesheets = Timesheet::query()
            ->with('client:id,name')
            ->when($user, fn ($query) => $query->where('staff_id', $user->id))
            ->orderByDesc('date')
            ->get();

        $payslips = Payslip::query()
            ->when($user, fn ($query) => $query->where('staff_id', $user->id))
            ->latest('pay_period')
            ->get();

        $announcements = Notification::query()
            ->where(function ($query) use ($user) {
                $query->whereNull('user_id');

                if ($user) {
                    $query->orWhere('user_id', $user->id);
                }
            })
            ->latest()
            ->get()
            ->map(function (Notification $notification) {
                return [
                    'title' => $notification->title ?? ucfirst(str_replace('_', ' ', $notification->type ?? 'Update')),
                    'body'  => $notification->message ?? data_get($notification->data, 'message', ''),
                    'time'  => $notification->created_at ?? now(),
                ];
            });

        $upcomingShifts = $timesheets
            ->filter(function (Timesheet $timesheet) {
                $date = Carbon::parse($timesheet->date);
                return $date->isToday() || $date->isFuture();
            })
            ->sortBy('date')
            ->take(4)
            ->map(function (Timesheet $timesheet) {
                return [
                    'date'  => $timesheet->date,
                    'hours' => $timesheet->total_hours,
                    'site'  => optional($timesheet->client)->name ?? 'Client #' . $timesheet->client_id,
                ];
            })
            ->values();

        return view('staff.dashboard', [
            'timesheets'     => $timesheets,
            'payslips'       => $payslips,
            'announcements'  => $announcements,
            'upcomingShifts' => $upcomingShifts,
        ]);
    }
}

