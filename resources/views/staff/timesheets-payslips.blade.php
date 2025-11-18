@extends('layouts.app')

@section('title','Timesheets & Payslips')
@section('page-heading','Timesheets & Payslips')

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

  // Dummy sites for select
  $sites = [
    ['id'=>1,'name'=>'Alpha Mall — Night Shift'],
    ['id'=>2,'name'=>'Crescent Towers — Lobby'],
    ['id'=>3,'name'=>'Harbor Gate — Gate 3'],
  ];

  // Current week dates (Mon–Sun)
  $start = Carbon::now()->startOfWeek();
  $weekDays = collect(range(0,6))->map(fn($i) => $start->copy()->addDays($i));

  // Fixed: removed leading zeros in numeric literals for setTime()
  $history = collect([
    [
      'id'=>1105,
      'start'=>Carbon::now()->startOfWeek()->subWeeks(1),
      'end'=>Carbon::now()->endOfWeek()->subWeeks(1),
      'hours'=>38,
      'status'=>'approved',
      'submitted'=>Carbon::now()->startOfWeek()->subWeeks(0)->setTime(10, 15),
    ],
    [
      'id'=>1104,
      'start'=>Carbon::now()->startOfWeek()->subWeeks(2),
      'end'=>Carbon::now()->endOfWeek()->subWeeks(2),
      'hours'=>40,
      'status'=>'submitted',
      'submitted'=>Carbon::now()->startOfWeek()->subWeeks(1)->setTime(9, 40),
    ],
    [
      'id'=>1103,
      'start'=>Carbon::now()->startOfWeek()->subWeeks(3),
      'end'=>Carbon::now()->endOfWeek()->subWeeks(3),
      'hours'=>36,
      'status'=>'rejected',
      'submitted'=>Carbon::now()->startOfWeek()->subWeeks(2)->setTime(11, 5),
    ],
    [
      'id'=>1102,
      'start'=>Carbon::now()->startOfWeek()->subWeeks(4),
      'end'=>Carbon::now()->endOfWeek()->subWeeks(4),
      'hours'=>40,
      'status'=>'approved',
      'submitted'=>Carbon::now()->startOfWeek()->subWeeks(3)->setTime(10, 0),
    ],
  ]);

  $payslips = [
    ['id'=>501,'period'=>'Sep 2025','issued'=>Carbon::parse('2025-09-30'),'gross'=>120000,'net'=>105500,'url'=>'#'],
    ['id'=>500,'period'=>'Aug 2025','issued'=>Carbon::parse('2025-08-31'),'gross'=>118000,'net'=>103200,'url'=>'#'],
    ['id'=>499,'period'=>'Jul 2025','issued'=>Carbon::parse('2025-07-31'),'gross'=>118000,'net'=>103000,'url'=>'#'],
  ];

  $badgeClass = fn($status) => [
    'draft'     => 'bg-gray-50 text-gray-700 ring-gray-600/20',
    'submitted' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
    'approved'  => 'bg-green-50 text-green-700 ring-green-600/20',
    'rejected'  => 'bg-red-50 text-red-700 ring-red-600/20',
  ][$status] ?? 'bg-gray-50 text-gray-700 ring-gray-600/20';
@endphp



<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
  <!-- Upload Worked Hours & Site Details -->
  <section class="xl:col-span-2 bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="p-5 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h3 class="text-base font-semibold text-gray-900">Upload Worked Hours & Site Details</h3>
        <p class="text-xs text-gray-500">Fill your hours for the current week ({{ $weekDays->first()->format('d M') }} – {{ $weekDays->last()->format('d M Y') }}).</p>
      </div>
      <div class="text-xs text-gray-500">Week #: <span class="font-medium">{{ $start->format('W') }}</span></div>
    </div>

    <form action="#" method="POST" class="p-5 space-y-4">
      @csrf

      <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div>
          <label class="block text-sm text-gray-600 mb-1">Week Start</label>
          <input type="date" value="{{ $weekDays->first()->format('Y-m-d') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Week End</label>
          <input type="date" value="{{ $weekDays->last()->format('Y-m-d') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Default Site (optional)</label>
          <select class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
            <option value="">— Select a site —</option>
            @foreach($sites as $s)
              <option value="{{ $s['id'] }}">{{ $s['name'] }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-50">
            <tr class="text-left text-gray-600">
              <th class="px-3 py-2">Date</th>
              <th class="px-3 py-2">Day</th>
              <th class="px-3 py-2">Site</th>
              <th class="px-3 py-2">Hours</th>
              <th class="px-3 py-2">Notes</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @foreach($weekDays as $d)
              <tr>
                <td class="px-3 py-2 font-medium text-gray-900">{{ $d->format('d M Y') }}</td>
                <td class="px-3 py-2 text-gray-600">{{ $d->format('l') }}</td>
                <td class="px-3 py-2">
                  <select class="w-full rounded-lg border border-gray-300 px-2 py-1.5 focus:ring-2 focus:ring-brand-500">
                    <option value="">— Select —</option>
                    @foreach($sites as $s)
                      <option value="{{ $s['id'] }}">{{ $s['name'] }}</option>
                    @endforeach
                  </select>
                </td>
                <td class="px-3 py-2">
                  <input type="number" step="0.25" min="0" max="24" placeholder="0" class="w-24 rounded-lg border border-gray-300 px-2 py-1.5 focus:ring-2 focus:ring-brand-500">
                </td>
                <td class="px-3 py-2">
                  <input type="text" placeholder="Optional" class="w-full rounded-lg border border-gray-300 px-2 py-1.5 focus:ring-2 focus:ring-brand-500">
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="flex items-center justify-end gap-2 pt-2">
        <button type="button" class="rounded-lg border px-4 py-2 text-sm hover:bg-gray-50">Save Draft</button>
        <button type="submit" class="rounded-lg bg-brand-600 text-white px-4 py-2 text-sm hover:bg-brand-700">Submit Timesheet</button>
      </div>
    </form>
  </section>

  <!-- Payslips -->
  <section class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="p-5 border-b border-gray-200">
      <h3 class="text-base font-semibold text-gray-900">Payslips</h3>
      <p class="text-xs text-gray-500">View & download your payslips.</p>
    </div>

    <div class="p-5">
      <ul class="space-y-3">
        @foreach($payslips as $p)
          <li class="flex items-center justify-between rounded-lg border border-gray-200 p-3">
            <div>
              <p class="font-medium text-gray-900">{{ $p['period'] }}</p>
              <p class="text-xs text-gray-500">Issued: {{ $p['issued']->format('d M Y') }}</p>
              <p class="text-xs text-gray-600 mt-1">
                Gross: <span class="font-medium">{{ number_format($p['gross']) }}</span> •
                Net: <span class="font-medium">{{ number_format($p['net']) }}</span>
              </p>
            </div>
            <div class="flex items-center gap-2">
              <a href="{{ $p['url'] }}" class="rounded-md border px-3 py-1.5 text-sm hover:bg-gray-50">View</a>
              <a href="{{ $p['url'] }}" class="rounded-md bg-brand-600 text-white px-3 py-1.5 text-sm hover:bg-brand-700">Download</a>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </section>

  <!-- Submitted Timesheet History (full width under on small screens) -->
  <section class="xl:col-span-3 bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="p-5 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h3 class="text-base font-semibold text-gray-900">Submitted Timesheet History</h3>
        <p class="text-xs text-gray-500">Your previous weeks’ submissions.</p>
      </div>
      <form method="GET" class="flex items-center gap-2">
        <input type="text" name="q" placeholder="Search week…" class="w-56 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
        <select name="status" class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
          <option value="">All statuses</option>
          <option value="approved">Approved</option>
          <option value="submitted">Submitted</option>
          <option value="rejected">Rejected</option>
          <option value="draft">Draft</option>
        </select>
        <button class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50" type="submit">Filter</button>
      </form>
    </div>

    <div class="p-5 overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
          <tr class="text-left text-gray-600">
            <th class="px-4 py-2">Week</th>
            <th class="px-4 py-2">Submitted</th>
            <th class="px-4 py-2">Total Hours</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @foreach($history as $h)
            <tr>
              <td class="px-4 py-2 font-medium text-gray-900">
                {{ $h['start']->format('d M') }} – {{ $h['end']->format('d M Y') }}
              </td>
              <td class="px-4 py-2 text-gray-600">
                {{ $h['submitted']? $h['submitted']->format('d M Y, h:i A') : '—' }}
              </td>
              <td class="px-4 py-2">{{ number_format($h['hours'], 2) }}</td>
              <td class="px-4 py-2">
                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badgeClass($h['status']) }}">
                  {{ ucfirst($h['status']) }}
                </span>
              </td>
              <td class="px-4 py-2 text-right">
                <div class="inline-flex items-center gap-1">
                  <a href="#" class="rounded-md border px-2 py-1 hover:bg-gray-50">View</a>
                  @if($h['status'] === 'approved')
                    <a href="#" class="rounded-md border px-2 py-1 hover:bg-gray-50">Download PDF</a>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>
</div>
@endsection
