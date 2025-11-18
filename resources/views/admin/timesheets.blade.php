@extends('layouts.app')

@section('title','Timesheet Management')
@section('page-heading','Timesheet Management')

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

  // ===== Dummy staff list =====
  $staff = [
    ['id'=>1,'name'=>'Ali Raza'],
    ['id'=>2,'name'=>'Hina Fatima'],
    ['id'=>3,'name'=>'Ahmed Khan'],
  ];

  // ===== Dummy timesheets (admin view) =====
  $rows = collect([
    [
      'id'=>3007,'user_id'=>1,'user'=>'Ali Raza','week_start'=>Carbon::now()->startOfWeek()->subWeeks(0),'week_end'=>Carbon::now()->endOfWeek()->subWeeks(0),
      'total'=>40.00,'status'=>'submitted','submitted_at'=>Carbon::now()->setTime(9, 30),'site'=>'Alpha Mall — Night Shift'
    ],
    [
      'id'=>3006,'user_id'=>2,'user'=>'Hina Fatima','week_start'=>Carbon::now()->startOfWeek()->subWeeks(1),'week_end'=>Carbon::now()->endOfWeek()->subWeeks(1),
      'total'=>38.00,'status'=>'approved','submitted_at'=>Carbon::now()->subDays(6)->setTime(10, 5),'site'=>'Crescent Towers — Lobby'
    ],
    [
      'id'=>3005,'user_id'=>3,'user'=>'Ahmed Khan','week_start'=>Carbon::now()->startOfWeek()->subWeeks(1),'week_end'=>Carbon::now()->endOfWeek()->subWeeks(1),
      'total'=>36.00,'status'=>'rejected','submitted_at'=>Carbon::now()->subDays(7)->setTime(11, 45),'site'=>'Harbor Gate — Gate 3'
    ],
    [
      'id'=>3004,'user_id'=>1,'user'=>'Ali Raza','week_start'=>Carbon::now()->startOfWeek()->subWeeks(2),'week_end'=>Carbon::now()->endOfWeek()->subWeeks(2),
      'total'=>40.00,'status'=>'approved','submitted_at'=>Carbon::now()->subDays(13)->setTime(10, 0),'site'=>'Alpha Mall — Night Shift'
    ],
  ]);

  $badge = fn($s) => [
    'submitted' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
    'approved'  => 'bg-green-50 text-green-700 ring-green-600/20',
    'rejected'  => 'bg-red-50 text-red-700 ring-red-600/20',
    'modified'  => 'bg-amber-50 text-amber-800 ring-amber-600/20',
    'draft'     => 'bg-gray-50 text-gray-700 ring-gray-600/20',
  ][$s] ?? 'bg-gray-50 text-gray-700 ring-gray-600/20';
@endphp

<div class="space-y-6">
  {{-- Toolbar / Filters --}}
  <div class="bg-white border border-gray-200 rounded-xl p-4">
    <form class="grid grid-cols-1 gap-3 md:grid-cols-5 items-end">
      <div class="md:col-span-2">
        <label class="block text-sm text-gray-600 mb-1">Staff</label>
        <select class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
          <option value="">All Staff</option>
          @foreach($staff as $u)
            <option value="{{ $u['id'] }}">{{ $u['name'] }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm text-gray-600 mb-1">Status</label>
        <select class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
          <option value="">Any</option>
          <option value="submitted">Submitted</option>
          <option value="approved">Approved</option>
          <option value="rejected">Rejected</option>
          <option value="modified">Modified</option>
        </select>
      </div>
      <div>
        <label class="block text-sm text-gray-600 mb-1">Week Start</label>
        <input type="date" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
      </div>
      <div class="flex gap-2">
        <button class="rounded-lg border px-4 py-2 text-sm hover:bg-gray-50 w-full">Filter</button>
        <button type="button" id="btnExportTS" class="rounded-lg border px-4 py-2 text-sm hover:bg-gray-50 w-full">Export CSV</button>
      </div>
    </form>
  </div>

  {{-- Table --}}
  <div class="bg-white border border-gray-200 rounded-xl overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-50">
        <tr class="text-left text-gray-600">
          <th class="px-4 py-2"><input type="checkbox" id="chkAll"></th>
          <th class="px-4 py-2">Employee</th>
          <th class="px-4 py-2">Week</th>
          <th class="px-4 py-2">Site</th>
          <th class="px-4 py-2">Submitted</th>
          <th class="px-4 py-2">Total Hours</th>
          <th class="px-4 py-2">Status</th>
          <th class="px-4 py-2 text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @foreach($rows as $r)
          <tr>
            <td class="px-4 py-2"><input type="checkbox" class="chkRow" value="{{ $r['id'] }}"></td>
            <td class="px-4 py-2">
              <div class="font-medium text-gray-900">{{ $r['user'] }}</div>
              <div class="text-xs text-gray-500">#U{{ str_pad($r['user_id'], 3, '0', STR_PAD_LEFT) }}</div>
            </td>
            <td class="px-4 py-2">
              <div class="font-medium text-gray-900">
                {{ $r['week_start']->format('d M') }} – {{ $r['week_end']->format('d M Y') }}
              </div>
              <div class="text-xs text-gray-500">W{{ $r['week_start']->format('W') }}</div>
            </td>
            <td class="px-4 py-2 text-gray-700">{{ $r['site'] }}</td>
            <td class="px-4 py-2 text-gray-600">{{ $r['submitted_at']->format('d M Y, h:i A') }}</td>
            <td class="px-4 py-2 font-medium">{{ number_format($r['total'], 2) }}</td>
            <td class="px-4 py-2">
              <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badge($r['status']) }}">
                {{ ucfirst($r['status']) }}
              </span>
            </td>
            <td class="px-4 py-2 text-right">
              <div class="inline-flex items-center gap-1">
                <button class="rounded-md border px-2 py-1 hover:bg-gray-50" data-review="{{ $r['id'] }}">Review</button>
                <button class="rounded-md bg-green-600 text-white px-2 py-1 hover:bg-green-700" data-approve="{{ $r['id'] }}">Approve</button>
                <button class="rounded-md bg-red-600 text-white px-2 py-1 hover:bg-red-700" data-reject="{{ $r['id'] }}">Reject</button>
                <button class="rounded-md bg-amber-600 text-white px-2 py-1 hover:bg-amber-700" data-modify="{{ $r['id'] }}">Modify</button>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
      <tfoot class="bg-gray-50">
        <tr>
          <td colspan="8" class="px-4 py-3">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
              <div class="flex items-center gap-2">
                <select id="bulkAction" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
                  <option value="">Bulk actions</option>
                  <option value="approve">Approve</option>
                  <option value="reject">Reject</option>
                  <option value="export">Export selected</option>
                </select>
                <button id="applyBulk" class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-100">Apply</button>
              </div>
              <nav class="inline-flex gap-1">
                <button class="px-3 py-1.5 text-sm rounded border hover:bg-gray-50">Prev</button>
                <button class="px-3 py-1.5 text-sm rounded border bg-gray-100">1</button>
                <button class="px-3 py-1.5 text-sm rounded border hover:bg-gray-50">2</button>
                <button class="px-3 py-1.5 text-sm rounded border hover:bg-gray-50">Next</button>
              </nav>
            </div>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

{{-- ===== Review / Modify Modal (dummy) ===== --}}
<div id="tsModal" class="fixed inset-0 z-[60] hidden">
  <div class="absolute inset-0 bg-black/40"></div>
  <div class="relative mx-auto mt-10 w-full max-w-3xl">
    <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
      <div class="p-4 border-b flex items-center justify-between">
        <h4 class="text-base font-semibold text-gray-900">Review Timesheet</h4>
        <button id="btnCloseTS" class="rounded-md border px-2 py-1 text-sm hover:bg-gray-50">✕</button>
      </div>

      @php
        // Dummy per-day entries for the modal (current week)
        $weekStart = Carbon::now()->startOfWeek();
        $days = collect(range(0,6))->map(fn($i)=>$weekStart->copy()->addDays($i));
        $sites = ['Alpha Mall — Night Shift','Crescent Towers — Lobby','Harbor Gate — Gate 3'];
      @endphp

      <form class="p-4 space-y-4" action="#" method="POST">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
          <div>
            <label class="block text-sm text-gray-600 mb-1">Employee</label>
            <input type="text" class="w-full rounded-lg border border-gray-300 px-3 py-2" value="Ali Raza" disabled>
          </div>
          <div>
            <label class="block text-sm text-gray-600 mb-1">Week</label>
            <input type="text" class="w-full rounded-lg border border-gray-300 px-3 py-2" value="{{ $weekStart->format('d M') }} – {{ $weekStart->copy()->endOfWeek()->format('d M Y') }}" disabled>
          </div>
          <div>
            <label class="block text-sm text-gray-600 mb-1">Status</label>
            <select class="w-full rounded-lg border border-gray-300 px-3 py-2">
              <option>submitted</option>
              <option>approved</option>
              <option>rejected</option>
              <option selected>modified</option>
            </select>
          </div>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
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
              @foreach($days as $d)
                <tr>
                  <td class="px-3 py-2 font-medium text-gray-900">{{ $d->format('d M Y') }}</td>
                  <td class="px-3 py-2 text-gray-600">{{ $d->format('l') }}</td>
                  <td class="px-3 py-2">
                    <select class="w-full rounded border border-gray-300 px-2 py-1.5">
                      @foreach($sites as $s)
                        <option>{{ $s }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td class="px-3 py-2">
                    <input type="number" step="0.25" min="0" max="24" value="8" class="w-24 rounded border border-gray-300 px-2 py-1.5">
                  </td>
                  <td class="px-3 py-2">
                    <input type="text" placeholder="Optional" class="w-full rounded border border-gray-300 px-2 py-1.5">
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="flex items-center justify-between">
          <div class="text-sm">
            <span class="text-gray-600">Total (editable):</span>
            <input type="number" step="0.25" min="0" max="168" value="40" class="w-24 rounded border border-gray-300 px-2 py-1.5 ml-2">
          </div>
          <div class="flex items-center gap-2">
            <button type="button" class="rounded-lg border px-4 py-2 text-sm hover:bg-gray-50" id="btnRejectTS">Reject</button>
            <button type="button" class="rounded-lg bg-amber-600 text-white px-4 py-2 text-sm hover:bg-amber-700" id="btnSaveMods">Save Modifications</button>
            <button type="submit" class="rounded-lg bg-green-600 text-white px-4 py-2 text-sm hover:bg-green-700">Approve</button>
          </div>
        </div>
      </form>

      <div class="p-4 border-t text-xs text-gray-500">
        Changes are logged to the audit trail with editor, timestamp, and before/after values (demo text).
      </div>
    </div>
  </div>
</div>
@php
  $rowsData = $rows->map(function ($r) {
    return [
        $r['id'],
        $r['user'],
        $r['week_start']->format('Y-m-d'),
        $r['week_end']->format('Y-m-d'),
        $r['site'],
        $r['total'],
        $r['status'],
        $r['submitted_at']->format('Y-m-d H:i'),
    ];
});
@endphp
@push('scripts')
<script>
  // Select all
  document.getElementById('chkAll')?.addEventListener('change', e => {
    document.querySelectorAll('.chkRow').forEach(ch => ch.checked = e.target.checked);
  });

  // Bulk apply (demo)
  document.getElementById('applyBulk')?.addEventListener('click', () => {
    const ids = [...document.querySelectorAll('.chkRow:checked')].map(el => el.value);
    const action = document.getElementById('bulkAction').value;
    if (!action) return alert('Choose an action.');
    if (!ids.length) return alert('Select at least one timesheet.');
    if (action === 'export') return alert(`Exporting ${ids.length} timesheet(s) (demo).`);
    alert(`${action.toUpperCase()} ${ids.length} timesheet(s) (demo).`);
  });

  // Export CSV (dummy)
   document.getElementById('btnExportTS')?.addEventListener('click', () => {
    const rows = @json($rowsData);
    const csv = 'id,user,week_start,week_end,site,total_hours,status,submitted_at\n'
      + rows.map(r => r.map(v => `"${String(v).replaceAll('"','""')}"`).join(',')).join('\n');
    downloadCSV(csv, 'timesheets.csv');
  });

  // Review/Modify modal (demo)
  const modal = document.getElementById('tsModal');
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('button');
    if (!btn) return;
    if (btn.hasAttribute('data-review') || btn.hasAttribute('data-modify')) {
      modal.classList.remove('hidden');
    }
    if (btn.hasAttribute('data-approve')) alert('Timesheet approved (demo).');
    if (btn.hasAttribute('data-reject')) alert('Timesheet rejected (demo).');
  });
  document.getElementById('btnCloseTS')?.addEventListener('click', () => modal.classList.add('hidden'));
  document.getElementById('btnRejectTS')?.addEventListener('click', () => { alert('Timesheet rejected (demo).'); modal.classList.add('hidden'); });
  document.getElementById('btnSaveMods')?.addEventListener('click', () => { alert('Modifications saved (demo).'); modal.classList.add('hidden'); });

  function downloadCSV(content, filename) {
    const blob = new Blob([content], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = filename;
    document.body.appendChild(a); a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  }
</script>
@endpush
@endsection
