@extends('layouts.app')

@section('title','Staff Dashboard')
@section('page-heading','Staff Dashboard')

@section('sidebar')
<a href="{{ route('staff.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🏠 Dashboard</a>
<a href="{{ route('staff.profile-timesheets') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🙍 Profile & Timesheets</a>
<a href="{{ route('staff.timesheets-payslips') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🕒 Timesheets & Payslips</a>
<a href="{{ route('staff.payslips-personal') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🧾 Payslips & Personal</a>
<a href="{{ route('staff.certifications') }}" class="block px-3 py-2 rounded-lg bg-gray-100 font-medium">🎓 Certifications</a>

@endsection

@section('content')
@php
  use Illuminate\Support\Carbon;

  // -------- Dummy user snapshot --------
  $user = (object)[
    'name' => 'Ali Raza',
    'role' => 'Security Staff',
    'employee_code' => 'EMP-0123',
  ];

  // -------- Current week summary --------
  $weekStart = Carbon::now()->startOfWeek(); // Monday
  $weekEnd   = Carbon::now()->endOfWeek();   // Sunday
  $weekLabel = $weekStart->format('d M').' – '.$weekEnd->format('d M Y');

  $timesheet = (object)[
    'status' => 'draft', // draft|submitted|approved|rejected
    'hours'  => 16.00,
    'last_saved' => Carbon::now()->subHours(2)->setTime(Carbon::now()->hour, Carbon::now()->minute),
    'submitted_at' => null,
  ];

  // Badge helper
  $badge = fn($s) => [
    'draft'     => 'bg-gray-50 text-gray-700 ring-gray-600/20',
    'submitted' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
    'approved'  => 'bg-green-50 text-green-700 ring-green-600/20',
    'rejected'  => 'bg-red-50 text-red-700 ring-red-600/20',
  ][$s] ?? 'bg-gray-50 text-gray-700 ring-gray-600/20';

  // -------- Site assignments --------
  $assignments = [
    ['site'=>'Alpha Mall — Night Shift','role'=>'Guard','since'=>Carbon::parse('2025-01-10')],
    ['site'=>'Crescent Towers — Lobby','role'=>'Relief','since'=>Carbon::parse('2025-06-01')],
  ];

  // -------- Next shifts (dummy upcoming) --------
  $nextShifts = [
    ['date'=>Carbon::now()->addDay(0)->setTime(22, 0),'site'=>'Alpha Mall — Gate A','hours'=>8],
    ['date'=>Carbon::now()->addDay(1)->setTime(22, 0),'site'=>'Alpha Mall — Gate A','hours'=>8],
    ['date'=>Carbon::now()->addDay(3)->setTime(8, 0),'site'=>'Crescent Towers — Lobby','hours'=>8],
  ];

  // -------- Recent payslips --------
  $payslips = [
    ['period'=>'Sep 2025','issued'=>Carbon::parse('2025-09-30'),'net'=>105500,'url'=>'#'],
    ['period'=>'Aug 2025','issued'=>Carbon::parse('2025-08-31'),'net'=>103200,'url'=>'#'],
  ];

  // -------- Announcements --------
  $ann = [
    ['title'=>'Safety Drill — Alpha Mall','body'=>'Mandatory briefing before next shift.','time'=>Carbon::now()->subHours(5)],
    ['title'=>'Payroll Update','body'=>'September payslips are available.','time'=>Carbon::now()->subDay()],
  ];
@endphp

{{-- Greeting + Quick Links --}}
<div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
  <section class="lg:col-span-2 rounded-xl border border-gray-200 bg-white p-5">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm text-gray-600">Welcome back,</p>
        <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
        <p class="text-xs text-gray-500">Employee ID: <span class="font-mono">{{ $user->employee_code }}</span> • Role: {{ $user->role }}</p>
      </div>
      <img src="https://i.pravatar.cc/64" class="h-14 w-14 rounded-full border" alt="Avatar">
    </div>

    <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
      <a href="{{ url('/staff/timesheets/create') }}" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>➕ New Timesheet</span><span class="text-xs text-gray-500">This week</span>
      </a>
      <a href="{{ url('/staff/timesheets') }}" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>🕒 My Timesheets</span><span class="text-xs text-gray-500">History</span>
      </a>
      <a href="{{ url('/staff/payslips') }}" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>🧾 Payslips</span><span class="text-xs text-gray-500">Download</span>
      </a>
      <a href="{{ url('/staff/profile') }}" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>🙍 Profile</span><span class="text-xs text-gray-500">Update</span>
      </a>
    </div>
  </section>

  <section class="rounded-xl border border-gray-200 bg-white p-5">
    <h3 class="text-base font-semibold text-gray-900">This Week</h3>
    <p class="mt-1 text-xs text-gray-500">{{ $weekLabel }} • W{{ $weekStart->format('W') }}</p>

    <div class="mt-3 grid grid-cols-2 gap-3">
      <div class="rounded-lg bg-gray-50 p-3">
        <p class="text-xs text-gray-500">Logged Hours</p>
        <p class="text-2xl font-semibold">{{ number_format($timesheet->hours,2) }}</p>
      </div>
      <div class="rounded-lg bg-gray-50 p-3">
        <p class="text-xs text-gray-500">Status</p>
        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badge($timesheet->status) }}">{{ ucfirst($timesheet->status) }}</span>
      </div>
    </div>

    <div class="mt-3 text-xs text-gray-500">
      @if($timesheet->status==='draft')
        Last saved {{ $timesheet->last_saved->diffForHumans() }}.
      @elseif($timesheet->submitted_at)
        Submitted {{ $timesheet->submitted_at->format('d M Y, h:i A') }}.
      @endif
    </div>

    <div class="mt-3 flex items-center gap-2">
      @if($timesheet->status==='draft')
        <a href="{{ url('/staff/timesheets/create') }}" class="rounded-lg bg-brand-600 text-white px-3 py-1.5 text-sm hover:bg-brand-700">Continue Timesheet</a>
      @else
        <a href="{{ url('/staff/timesheets') }}" class="rounded-lg border px-3 py-1.5 text-sm hover:bg-gray-50">View Timesheets</a>
      @endif
    </div>
  </section>
</div>

{{-- Main Grid --}}
<div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
  {{-- Site Assignments & Next Shifts --}}
  <section class="xl:col-span-2 rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="p-5 border-b border-gray-200 flex items-center justify-between">
      <h3 class="text-base font-semibold text-gray-900">Site Assignments & Next Shifts</h3>
      <a href="{{ url('/staff/profile') }}" class="text-sm text-brand-700 hover:underline">View Profile</a>
    </div>
    <div class="p-5 grid grid-cols-1 lg:grid-cols-2 gap-5">
      <div>
        <p class="text-sm font-semibold text-gray-900 mb-2">Assignments</p>
        <ul class="space-y-2">
          @foreach($assignments as $as)
            <li class="flex items-center justify-between rounded-lg border p-3">
              <div>
                <p class="font-medium text-gray-900">{{ $as['site'] }}</p>
                <p class="text-xs text-gray-500">Role: {{ $as['role'] }} • Since: {{ $as['since']->format('d M Y') }}</p>
              </div>
              <span class="text-[11px] rounded-md bg-brand-50 text-brand-700 ring-1 ring-inset ring-brand-100 px-2 py-0.5">
                Active
              </span>
            </li>
          @endforeach
        </ul>
      </div>

      <div>
        <p class="text-sm font-semibold text-gray-900 mb-2">Next Shifts</p>
        <ul class="space-y-2">
          @foreach($nextShifts as $s)
            <li class="flex items-center justify-between rounded-lg border p-3">
              <div>
                <p class="font-medium text-gray-900">{{ $s['date']->format('D, d M Y') }}</p>
                <p class="text-xs text-gray-500">Start: {{ $s['date']->format('h:i A') }} • {{ $s['hours'] }} hrs • {{ $s['site'] }}</p>
              </div>
              <a href="{{ url('/staff/timesheets/create') }}" class="rounded-md border px-2 py-1 text-sm hover:bg-gray-50">Log</a>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </section>

  {{-- Payslips --}}
  <section class="rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="p-5 border-b border-gray-200 flex items-center justify-between">
      <h3 class="text-base font-semibold text-gray-900">Recent Payslips</h3>
      <a href="{{ url('/staff/payslips') }}" class="text-sm text-brand-700 hover:underline">View all</a>
    </div>
    <ul class="p-5 space-y-3">
      @foreach($payslips as $p)
        <li class="flex items-center justify-between rounded-lg border p-3">
          <div>
            <p class="font-medium text-gray-900">{{ $p['period'] }}</p>
            <p class="text-xs text-gray-500">Issued: {{ $p['issued']->format('d M Y') }}</p>
          </div>
          <div class="flex items-center gap-2">
            <span class="text-sm font-medium">{{ number_format($p['net']) }}</span>
            <a href="{{ $p['url'] }}" class="rounded-md border px-2 py-1 text-sm hover:bg-gray-50">View</a>
            <a href="{{ $p['url'] }}" class="rounded-md bg-brand-600 text-white px-2 py-1 text-sm hover:bg-brand-700">Download</a>
          </div>
        </li>
      @endforeach
      @if(empty($payslips))
        <li class="text-sm text-gray-500">No payslips yet.</li>
      @endif
    </ul>
  </section>
</div>

{{-- Bottom Grid --}}
<div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
  {{-- Announcements --}}
  <section class="rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="p-5 border-b border-gray-200">
      <h3 class="text-base font-semibold text-gray-900">Announcements</h3>
    </div>
    <ul class="p-5 space-y-3 text-sm">
      @foreach($ann as $a)
        <li class="rounded-lg border p-3">
          <p class="font-medium text-gray-900">{{ $a['title'] }}</p>
          <p class="text-gray-700 mt-1">{{ $a['body'] }}</p>
          <p class="text-xs text-gray-500 mt-1">{{ $a['time']->diffForHumans() }}</p>
        </li>
      @endforeach
    </ul>
  </section>

  {{-- Quick Help --}}
  <section class="rounded-xl border border-gray-200 bg-white p-5">
    <h3 class="text-base font-semibold text-gray-900">Quick Help</h3>
    <ul class="mt-3 list-disc list-inside text-sm text-gray-700 space-y-1">
      <li>To submit hours, open <a class="text-brand-700 hover:underline" href="{{ url('/staff/timesheets/create') }}">New Timesheet</a>.</li>
      <li>Update personal info in <a class="text-brand-700 hover:underline" href="{{ url('/staff/profile') }}">Profile</a>.</li>
      <li>Download your latest salary slip in <a class="text-brand-700 hover:underline" href="{{ url('/staff/payslips') }}">Payslips</a>.</li>
    </ul>
  </section>
</div>
@endsection
