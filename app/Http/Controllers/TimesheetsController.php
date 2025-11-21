<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
class TimesheetsController extends Controller
{
    public function index()
    {
        $timesheets = Timesheet::where('staff_id', auth()->id())->latest()->get();

        return view('staff.timesheets.index', compact('timesheets'));
    }

    public function create()
    {
        $clients = Client::where('status', 1)->get();

        return view('staff.timesheets.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'client_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'break_minutes' => 'nullable|integer',
        ]);

        // Calculate total hours
        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);
        $totalHours = $end->diffInMinutes($start);

        if ($request->break_minutes) {
            $totalHours -= $request->break_minutes;
        }

        $totalHours = round($totalHours / 60, 2);

        Timesheet::create([
            'staff_id' => auth()->id(),
            'client_id' => $request->client_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'break_minutes' => $request->break_minutes,
            'total_hours' => $totalHours,
            'notes' => $request->notes,
        ]);

        return redirect()->route('staff.timesheets.index')->with('success', 'Timesheet submitted!');
    }

    public function edit($id)
    {
        $timesheet = Timesheet::where('id', $id)->where('staff_id', auth()->id())->where('status', 'pending')->firstOrFail();

        $clients = Client::where('status', 1)->get();

        return view('staff.timesheets.edit', compact('timesheet', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $timesheet = Timesheet::where('id', $id)->where('staff_id', auth()->id())->where('status', 'pending')->firstOrFail();

        $request->validate([
            'date' => 'required',
            'client_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // Recalculate time
        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);
        $totalHours = $end->diffInMinutes($start);

        if ($request->break_minutes) {
            $totalHours -= $request->break_minutes;
        }

        $totalHours = round($totalHours / 60, 2);

        $timesheet->update([
            'date' => $request->date,
            'client_id' => $request->client_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'break_minutes' => $request->break_minutes,
            'total_hours' => $totalHours,
            'notes' => $request->notes,
        ]);

        return redirect()->route('staff.timesheets.index')->with('success', 'Timesheet updated!');
    }

    public function destroy($id)
    {
        $timesheet = Timesheet::where('id', $id)->where('staff_id', auth()->id())->where('status', 'pending')->firstOrFail();

        $timesheet->delete();

        return redirect()->route('staff.timesheets.index')->with('success', 'Timesheet deleted!');
    }
}
