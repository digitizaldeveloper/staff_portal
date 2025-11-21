@extends('layouts.app')
@section('page-heading', 'Timesheet Details')

@section('content')
<div class="bg-white p-6 shadow rounded">

    <h2 class="text-xl font-bold mb-4">Timesheet Information</h2>

    <p><strong>Staff:</strong> {{ $sheet->staff->name }}</p>
    <p><strong>Client:</strong> {{ $sheet->client->name }}</p>
    <p><strong>Date:</strong> {{ $sheet->date }}</p>
    <p><strong>Shift:</strong> {{ $sheet->start_time }} - {{ $sheet->end_time }}</p>
    <p><strong>Break:</strong> {{ $sheet->break_time }} minutes</p>
    <p><strong>Total Hours:</strong> {{ $sheet->total_hours }} hrs</p>
    <p><strong>Notes:</strong> {{ $sheet->notes ?? '---' }}</p>

    <hr class="my-4">

    {{-- ADMIN NOTES --}}
    <form action="{{ route('admin.timesheets.notes', $sheet->id) }}" method="POST">
        @csrf

        <label class="font-semibold">Admin Notes</label>
        <textarea name="admin_notes" class="border p-2 w-full rounded">{{ $sheet->admin_notes }}</textarea>

        <button class="bg-indigo-600 text-white px-4 py-2 rounded mt-2">
            Save Notes
        </button>
    </form>

    <hr class="my-4">

    @if($sheet->status == 'pending')
        <div class="flex gap-4">
            <form action="{{ route('admin.timesheets.approve', $sheet->id) }}" method="POST">
                @csrf
                <button class="bg-green-600 text-white px-4 py-2 rounded">Approve</button>
            </form>

            <form action="{{ route('admin.timesheets.reject', $sheet->id) }}" method="POST">
                @csrf
                <button class="bg-red-600 text-white px-4 py-2 rounded">Reject</button>
            </form>
        </div>
    @else
        <p class="text-gray-600 mt-2">This timesheet is locked.</p>
    @endif
</div>
@endsection
