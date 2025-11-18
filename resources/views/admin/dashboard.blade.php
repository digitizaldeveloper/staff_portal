@extends('layouts.app')

@section('title','Admin Dashboard')
@section('page-heading','Admin Dashboard')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🏠 Dashboard</a>
<a href="{{ route('admin.timesheets') }}" class="block px-3 py-2 rounded-lg bg-gray-100 font-medium">🕒 Timesheets</a>
<a href="{{ route('admin.staff-management') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🧑‍💼 Staff</a>
<a href="{{ route('admin.payroll') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🧾 Payroll</a>
<a href="{{ route('admin.jobs-applications') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">💼 Jobs & Applications</a>
<a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-50">⚙️ Settings</a>

@endsection

@section('content')
@php
  use Illuminate\Support\Carbon;

  $kpis = [
    ['label'=>'Active Staff','value'=>48,'delta'=>'+3 this week'],
    ['label'=>'Pending Timesheets','value'=>6,'delta'=>'2 need review'],
    ['label'=>'Payslips This Month','value'=>45,'delta'=>'Sep 2025'],
    ['label'=>'Open Jobs','value'=>3,'delta'=>'7 applications'],
  ];

  $recentTimesheets = collect([
    ['user'=>'Ali Raza','week'=>'29 Sep – 05 Oct','hours'=>40,'status'=>'submitted','at'=>Carbon::now()->setTime(9,30)],
    ['user'=>'Hina Fatima','week'=>'22 – 28 Sep','hours'=>38,'status'=>'approved','at'=>Carbon::now()->subDays(2)->setTime(14,10)],
    ['user'=>'Ahmed Khan','week'=>'22 – 28 Sep','hours'=>36,'status'=>'rejected','at'=>Carbon::now()->subDays(3)->setTime(11,45)],
    ['user'=>'Bilal Ahmed','week'=>'29 Sep – 05 Oct','hours'=>41,'status'=>'submitted','at'=>Carbon::now()->setTime(10,5)],
  ]);

  $applications = collect([
    ['name'=>'Usman Tariq','job'=>'Security Supervisor','submitted'=>Carbon::now()->subHours(6),'cv'=>'#'],
    ['name'=>'Sana Iqbal','job'=>'Night Shift Guard','submitted'=>Carbon::now()->subDay(),'cv'=>'#'],
    ['name'=>'Zain Ali','job'=>'Control Room Operator','submitted'=>Carbon::now()->subDays(2),'cv'=>'#'],
  ]);

  $expiring = collect([
    ['staff'=>'Khalid Mehmood','cert'=>'First Aid L1','expires'=>Carbon::now()->addDays(9)],
    ['staff'=>'Sara Khan','cert'=>'Guard License','expires'=>Carbon::now()->addDays(27)],
    ['staff'=>'Imran Aziz','cert'=>'PSIRA','expires'=>Carbon::now()->subDays(3)],
  ]);

  $badge = fn($s) => [
    'submitted' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
    'approved'  => 'bg-green-50 text-green-700 ring-green-600/20',
    'rejected'  => 'bg-red-50 text-red-700 ring-red-600/20',
    'modified'  => 'bg-amber-50 text-amber-800 ring-amber-600/20',
  ][$s] ?? 'bg-gray-50 text-gray-700 ring-gray-600/20';

  $expCls = function (Carbon $d) {
    $days = now()->diffInDays($d, false);
    if ($days < 0) return 'bg-red-50 text-red-700 ring-red-600/20';
    if ($days <= 14) return 'bg-amber-50 text-amber-800 ring-amber-600/20';
    return 'bg-green-50 text-green-700 ring-green-600/20';
  };
@endphp

{{-- KPIs --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
  @foreach($kpis as $i => $k)
    <div class="rounded-xl border border-gray-200 bg-white p-4">
      <div class="flex items-center justify-between">
        <p class="text-sm text-gray-600">{{ $k['label'] }}</p>
        <span class="text-[11px] rounded-md bg-brand-50 text-brand-700 ring-1 ring-inset ring-brand-100 px-2 py-0.5">Live</span>
      </div>
      <div class="mt-2 flex items-end justify-between">
        <p class="text-2xl font-semibold text-gray-900">{{ $k['value'] }}</p>
        {{-- tiny inline sparkline (decorative) --}}
        <svg viewBox="0 0 100 24" class="h-6 w-24">
          <polyline fill="none" stroke="currentColor" stroke-width="2" class="text-brand-500"
            points="{{ $i===0?'0,18 20,12 40,14 60,9 80,11 100,6':($i===1?'0,10 20,12 40,8 60,14 80,9 100,12':($i===2?'0,14 20,16 40,12 60,9 80,13 100,10':'0,12 20,10 40,14 60,8 80,12 100,7')) }}" />
        </svg>
      </div>
      <p class="mt-1 text-xs text-gray-500">{{ $k['delta'] }}</p>
    </div>
  @endforeach
</div>

{{-- Main grid --}}
<div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
  {{-- Timesheets Panel --}}
  <section class="xl:col-span-2 rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="p-4 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h3 class="text-base font-semibold text-gray-900">Timesheets</h3>
        <p class="text-xs text-gray-500">Review staff-submitted timesheets.</p>
      </div>
      <div class="flex items-center gap-2">
        <a href="{{ url('/admin/timesheets') }}" class="rounded-lg border px-3 py-1.5 text-sm hover:bg-gray-50">Open Manager</a>
      </div>
    </div>
    <div class="p-4 overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
          <tr class="text-left text-gray-600">
            <th class="px-4 py-2">Employee</th>
            <th class="px-4 py-2">Week</th>
            <th class="px-4 py-2">Hours</th>
            <th class="px-4 py-2">Submitted</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @foreach($recentTimesheets as $r)
            <tr>
              <td class="px-4 py-2 font-medium text-gray-900">{{ $r['user'] }}</td>
              <td class="px-4 py-2">{{ $r['week'] }}</td>
              <td class="px-4 py-2">{{ number_format($r['hours'],2) }}</td>
              <td class="px-4 py-2 text-gray-600">{{ $r['at']->format('d M Y, h:i A') }}</td>
              <td class="px-4 py-2">
                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badge($r['status']) }}">
                  {{ ucfirst($r['status']) }}
                </span>
              </td>
              <td class="px-4 py-2 text-right">
                <div class="inline-flex items-center gap-1">
                  <a href="{{ url('/admin/timesheets') }}" class="rounded-md border px-2 py-1 hover:bg-gray-50">Review</a>
                  @if($r['status']==='submitted')
                    <button class="rounded-md bg-green-600 text-white px-2 py-1 hover:bg-green-700">Approve</button>
                    <button class="rounded-md bg-red-600 text-white px-2 py-1 hover:bg-red-700">Reject</button>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>

  {{-- Quick Actions --}}
  <section class="rounded-xl border border-gray-200 bg-white p-4">
    <h3 class="text-base font-semibold text-gray-900">Quick Actions</h3>
    <div class="mt-3 grid grid-cols-1 gap-2">
      <a href="{{ url('/admin/staff') }}" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>➕ Add Staff</span><span class="text-xs text-gray-500">Users</span>
      </a>
      <a href="{{ url('/admin/jobs') }}" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>📝 Post New Job</span><span class="text-xs text-gray-500">Jobs</span>
      </a>
      <a href="{{ url('/admin/payroll') }}" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>📄 Upload Payslip</span><span class="text-xs text-gray-500">Payroll</span>
      </a>
      <a href="{{ url('/admin/timesheets') }}" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>✅ Approve Timesheets</span><span class="text-xs text-gray-500">Timesheets</span>
      </a>
    </div>
  </section>
</div>

{{-- Secondary grid --}}
<div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
  {{-- Latest Applications --}}
  <section class="rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="p-4 border-b border-gray-200 flex items-center justify-between">
      <h3 class="text-base font-semibold text-gray-900">Latest Applications</h3>
      <a href="{{ url('/admin/jobs') }}" class="text-sm text-brand-700 hover:underline">View all</a>
    </div>
    <ul class="p-4 space-y-3">
      @foreach($applications as $a)
        <li class="flex items-center justify-between rounded-lg border p-3">
          <div>
            <p class="font-medium text-gray-900">{{ $a['name'] }}</p>
            <p class="text-xs text-gray-500">{{ $a['job'] }} • {{ $a['submitted']->diffForHumans() }}</p>
          </div>
          <div class="flex items-center gap-2">
            <a href="{{ $a['cv'] }}" class="rounded-md border px-2 py-1 hover:bg-gray-50 text-sm">View CV</a>
            <button class="rounded-md bg-brand-600 text-white px-2 py-1 hover:bg-brand-700 text-sm">Shortlist</button>
          </div>
        </li>
      @endforeach
    </ul>
  </section>

  {{-- Certification Expiry Alerts --}}
  <section class="rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="p-4 border-b border-gray-200 flex items-center justify-between">
      <h3 class="text-base font-semibold text-gray-900">Certification Alerts</h3>
      <a href="{{ url('/admin/staff') }}" class="text-sm text-brand-700 hover:underline">Manage</a>
    </div>
    <ul class="p-4 space-y-3">
      @foreach($expiring as $c)
        @php $cls = $expCls($c['expires']); @endphp
        <li class="flex items-center justify-between rounded-lg border p-3">
          <div>
            <p class="font-medium text-gray-900">{{ $c['staff'] }}</p>
            <p class="text-xs text-gray-500">{{ $c['cert'] }} — Expires {{ $c['expires']->format('d M Y') }}</p>
          </div>
          <span class="text-[11px] rounded-md px-2 py-1 ring-1 ring-inset {{ $cls }}">
            {{ now()->diffInDays($c['expires'], false) < 0 ? 'Expired' : 'Upcoming' }}
          </span>
        </li>
      @endforeach
    </ul>
  </section>

  {{-- Activity Log --}}
  <section class="rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="p-4 border-b border-gray-200">
      <h3 class="text-base font-semibold text-gray-900">Recent Activity</h3>
    </div>
    <ul class="p-4 space-y-3 text-sm">
      <li class="flex items-start gap-3">
        <span class="mt-0.5">✅</span>
        <div>
          <p class="text-gray-900">Approved 3 timesheets</p>
          <p class="text-xs text-gray-500">Today, 10:20 AM</p>
        </div>
      </li>
      <li class="flex items-start gap-3">
        <span class="mt-0.5">📄</span>
        <div>
          <p class="text-gray-900">Uploaded payslips for Sep 2025</p>
          <p class="text-xs text-gray-500">Yesterday, 5:12 PM</p>
        </div>
      </li>
      <li class="flex items-start gap-3">
        <span class="mt-0.5">📝</span>
        <div>
          <p class="text-gray-900">Posted new job “Security Supervisor”</p>
          <p class="text-xs text-gray-500">2 days ago</p>
        </div>
      </li>
    </ul>
  </section>
</div>
@endsection
