<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Timesheet;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminTimesheetController extends Controller
{

    /**
     * ADMIN – LIST WITH FILTERS
     */
    public function index(Request $request)
    {
        $query = Timesheet::with(['staff', 'client']);

        if ($request->staff_id) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->client_id) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->from) {
            $query->where('date', '>=', $request->from);
        }

        if ($request->to) {
            $query->where('date', '<=', $request->to);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        return view('admin.timesheets.index', [
            'timesheets' => $query->orderBy('date', 'DESC')->get(),
            'staff'      => User::where('role', 'staff')->get(),
            'clients'    => Client::all(),
        ]);
    }


    /**
     * SHOW DETAILS PAGE
     */
    public function show($id)
    {
        $sheet = Timesheet::with(['staff', 'client'])->findOrFail($id);

        return view('admin.timesheets.show', compact('sheet'));
    }


    /**
     * APPROVE TIMESHEET
     */
    public function approve($id)
    {
        $sheet = Timesheet::findOrFail($id);

        if ($sheet->status != 'pending') {
            return back()->with('error', 'This timesheet is already processed.');
        }

        $sheet->status = 'approved';
        $sheet->locked = 1; // lock after approval
        $sheet->save();

        return redirect()->route('admin.timesheets.index')
                         ->with('success', 'Timesheet approved & locked.');
    }


    /**
     * REJECT TIMESHEET
     */
    public function reject($id)
    {
        $sheet = Timesheet::findOrFail($id);

        if ($sheet->status != 'pending') {
            return back()->with('error', 'This timesheet is already processed.');
        }

        $sheet->status = 'rejected';
        $sheet->locked = 1; // lock rejections too
        $sheet->save();

        return redirect()->route('admin.timesheets.index')
                         ->with('success', 'Timesheet rejected.');
    }


    /**
     * SAVE ADMIN NOTES
     */
    public function saveNotes(Request $request, $id)
    {
        $sheet = Timesheet::findOrFail($id);

        $sheet->admin_notes = $request->admin_notes;
        $sheet->save();

        return back()->with('success', 'Admin notes updated.');
    }


    /**
     * EXPORT CSV
     */
    public function exportCSV()
    {
        $filename = "timesheets_export_" . date('Y-m-d') . ".csv";

        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');

            // CSV header
            fputcsv($handle, [
                'Staff',
                'Client',
                'Date',
                'Start Time',
                'End Time',
                'Break',
                'Total Hours',
                'Status',
                'Admin Notes'
            ]);

            // Data
            Timesheet::with(['staff', 'client'])
                ->orderBy('date', 'DESC')
                ->chunk(200, function ($rows) use ($handle) {
                    foreach ($rows as $sheet) {
                        fputcsv($handle, [
                            $sheet->staff->name,
                            $sheet->client->name,
                            $sheet->date,
                            $sheet->start_time,
                            $sheet->end_time,
                            $sheet->break_time,
                            $sheet->total_hours,
                            $sheet->status,
                            $sheet->admin_notes,
                        ]);
                    }
                });

            fclose($handle);
        });

        // Headers
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=$filename");

        return $response;
    }
}
