@extends('layouts.app')

@section('page-heading', 'Staff Dashboard')

@section('content')
@php
    use Illuminate\Support\Carbon;

    $user = auth()->user();

    $timesheetCollection   = collect($timesheets ?? []);
    $payslipCollection     = collect($payslips ?? []);
    $announcementCollection = collect($announcements ?? []);

    $upcomingShifts = collect($upcomingShifts ?? [])->take(4);

    $metrics = [
        'timesheets' => [
            'label' => 'Timesheets submitted',
            'value' => $timesheetCollection->count(),
            'trend' => '+2 this month',
            'color' => 'text-emerald-600'
        ],
        'hours' => [
            'label' => 'Hours logged',
            'value' => number_format($timesheetCollection->sum('total_hours'), 1),
            'trend' => 'Across all shifts',
            'color' => 'text-blue-600'
        ],
        'payslips' => [
            'label' => 'Payslips available',
            'value' => $payslipCollection->count(),
            'trend' => 'View latest payments',
            'color' => 'text-violet-600'
        ],
    ];
@endphp

<div class="space-y-6">

    {{-- Greeting --}}
    <div class="rounded-3xl border border-gray-200 bg-gradient-to-br from-emerald-50 to-white p-8 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-6">
            <div>
                <p class="text-sm uppercase tracking-wide text-emerald-600">Welcome back</p>
                <h1 class="mt-2 text-3xl font-semibold text-gray-900">
                    {{ $user?->name ?? 'Team member' }}
                </h1>
                <p class="mt-1 text-gray-600">
                    Here’s a quick view of your shifts, hours and payroll.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('staff.timesheets.create') }}"
                   class="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-700">
                    <span class="text-lg leading-none">+</span> New timesheet
                </a>
                <a href="{{ route('staff.timesheets.index') }}"
                   class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-5 py-2 text-sm font-semibold text-gray-700 hover:bg-white">
                    View history
                </a>
            </div>
        </div>
    </div>

    {{-- Metrics --}}
    <div class="grid gap-4 md:grid-cols-3">
        @foreach($metrics as $metric)
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">{{ $metric['label'] }}</p>
                <p class="mt-3 text-3xl font-semibold text-gray-900 {{ $metric['color'] }}">
                    {{ $metric['value'] }}
                </p>
                <p class="mt-1 text-xs text-gray-400">{{ $metric['trend'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Timesheets --}}
        <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Recent timesheets</h2>
                    <p class="text-sm text-gray-500">Latest submissions awaiting review.</p>
                </div>
                <a href="{{ route('staff.timesheets.index') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                    View all →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-6 py-3 text-left">Date</th>
                            <th class="px-6 py-3 text-left">Client / Site</th>
                            <th class="px-6 py-3 text-left">Hours</th>
                            <th class="px-6 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($timesheetCollection->take(5) as $ts)
                            @php
                                $statusStyles = [
                                    'pending' => 'bg-amber-100 text-amber-800',
                                    'approved' => 'bg-emerald-100 text-emerald-700',
                                    'rejected' => 'bg-rose-100 text-rose-700',
                                ];
                                $badgeClass = $statusStyles[$ts['status'] ?? ''] ?? 'bg-gray-100 text-gray-600';
                            @endphp
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">
                                        {{ Carbon::parse($ts['date'] ?? now())->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400">#{{ str_pad($ts['id'] ?? 0, 4, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ data_get($ts, 'client.name', data_get($ts, 'client_name', '—')) }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    {{ number_format(data_get($ts, 'total_hours', 0), 2) }} hrs
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClass }}">
                                        <span class="h-2 w-2 rounded-full bg-current"></span>
                                        {{ ucfirst($ts['status'] ?? 'pending') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">
                                    No timesheets to show yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Upcoming Shifts --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Upcoming shifts</h2>
                <p class="text-sm text-gray-500">Stay prepared for your next assignment.</p>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse($upcomingShifts as $shift)
                    <li class="px-6 py-4">
                        <div class="font-semibold text-gray-900">
                            {{ Carbon::parse($shift['date'] ?? now())->format('D, d M Y') }}
                        </div>
                        <p class="text-sm text-gray-500">
                            {{ Carbon::parse($shift['date'] ?? now())->format('h:i A') }} • {{ $shift['hours'] ?? 8 }} hrs
                        </p>
                        <p class="text-sm text-gray-600 mt-1">{{ $shift['site'] ?? 'TBA site' }}</p>
                    </li>
                @empty
                    <li class="px-6 py-10 text-center text-sm text-gray-500">
                        No future shifts assigned yet.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Recent Payslips --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Recent payslips</h2>
                <p class="text-sm text-gray-500">Download your latest salary statements.</p>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse($payslipCollection->take(4) as $slip)
                    <li class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="font-semibold text-gray-900">
                                {{ $slip['period'] ?? Carbon::parse($slip['created_at'] ?? now())->format('M Y') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                Issued {{ Carbon::parse($slip['created_at'] ?? now())->format('d M Y') }}
                            </p>
                        </div>
                        <a href="{{ asset('payslips/' . ($slip['file_path'] ?? '')) }}"
                           class="rounded-full bg-emerald-50 px-4 py-1.5 text-xs font-semibold text-emerald-600 hover:bg-emerald-100">
                            Download
                        </a>
                    </li>
                @empty
                    <li class="px-6 py-10 text-center text-sm text-gray-500">
                        Payslips will appear here once available.
                    </li>
                @endforelse
            </ul>
        </div>

        {{-- Announcements --}}
        <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Announcements</h2>
                <p class="text-sm text-gray-500">Latest updates from HR and operations.</p>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse($announcementCollection->take(5) as $note)
                    <li class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-gray-900">{{ $note['title'] ?? 'Notice' }}</p>
                            <span class="text-xs text-gray-400">
                                {{ Carbon::parse($note['time'] ?? now())->diffForHumans() }}
                            </span>
                        </div>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $note['body'] ?? 'Details coming soon.' }}
                        </p>
                    </li>
                @empty
                    <li class="px-6 py-10 text-center text-sm text-gray-500">
                        You’ll see announcements here once posted.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection