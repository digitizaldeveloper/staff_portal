<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Job;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin overview dashboard.
     */
    public function __invoke(Request $request)
    {
        $staffQuery = User::query()->where('role', 'staff');

        $metrics = [
            'staff'      => (clone $staffQuery)->count(),
            'clients'    => Client::count(),
            'jobs'       => Job::count(),
            'timesheets' => Timesheet::count(),
            'pending'    => Timesheet::where('status', 'pending')->count(),
        ];

        $recentStaff = (clone $staffQuery)
            ->latest()
            ->select('id', 'name', 'role', 'created_at')
            ->take(5)
            ->get();

        $recentJobs = Job::query()
            ->latest()
            ->select('id', 'title', 'location', 'type', 'created_at')
            ->take(5)
            ->get();

        $pendingTimesheets = Timesheet::query()
            ->with(['staff:id,name', 'client:id,name'])
            ->where('status', 'pending')
            ->orderByDesc('date')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'metrics'    => $metrics,
            'staff'      => $recentStaff,
            'jobs'       => $recentJobs,
            'timesheets' => $pendingTimesheets,
        ]);
    }
}

