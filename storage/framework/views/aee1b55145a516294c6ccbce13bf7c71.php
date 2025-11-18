

<?php $__env->startSection('title','My Profile & Timesheets'); ?>
<?php $__env->startSection('page-heading','My Profile & Timesheets'); ?>

<?php $__env->startSection('sidebar'); ?>
<a href="<?php echo e(route('staff.dashboard')); ?>" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🏠 Dashboard</a>
<a href="<?php echo e(route('staff.profile-timesheets')); ?>" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🙍 Profile & Timesheets</a>
<a href="<?php echo e(route('staff.timesheets-payslips')); ?>" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🕒 Timesheets & Payslips</a>
<a href="<?php echo e(route('staff.payslips-personal')); ?>" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🧾 Payslips & Personal</a>
<a href="<?php echo e(route('staff.certifications')); ?>" class="block px-3 py-2 rounded-lg bg-gray-100 font-medium">🎓 Certifications</a>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
  use Illuminate\Support\Carbon;

  // ---- Dummy User ----
  $user = (object) [
    'name'          => 'Ali Raza',
    'email'         => 'ali.raza@example.com',
    'id'            => 123,
    'employee_code' => 'EMP-0123',
    'phone'         => '+92 300 0000000',
    'active'        => true,
    'role'          => (object)['name' => 'Security Staff'],
    'avatar_url'    => null,
    'created_at'    => Carbon::parse('2024-06-15'),
  ];

  // ---- Dummy Site Assignments ----
  $assignments = [
    ['site' => 'Alpha Mall — Night Shift', 'role' => 'Guard', 'since' => '2025-01-10'],
    ['site' => 'Crescent Towers — Lobby', 'role' => 'Supervisor', 'since' => '2025-05-02'],
  ];

  // ---- Dummy Timesheets (last 5 weeks) ----
  $weeks = collect(range(0,4))->map(fn($i) => [
    'start' => Carbon::now()->startOfWeek()->subWeeks($i),
    'end'   => Carbon::now()->endOfWeek()->subWeeks($i),
  ])->reverse()->values();

  $statusCycle = ['approved','submitted','draft','approved','rejected'];

  $timesheets = $weeks->map(function ($w, $i) use ($statusCycle) {
    $status = $statusCycle[$i % count($statusCycle)];
    return (object) [
      'id'           => 1000 + $i,
      'week_start'   => $w['start'],
      'week_end'     => $w['end'],
      'total_hours'  => 40 - ($i % 3) * 2 + 0.0, // 40, 38, 36...
      'status'       => $status,
      'submitted_at' => in_array($status, ['submitted','approved','rejected'])
                        ? $w['end']->copy()->addDays(1)->setTime(10, 15)
                        : null,
    ];
  });
?>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
  <!-- Profile Summary -->
  <section class="lg:col-span-1 bg-white border border-gray-200 rounded-xl p-5">
    <div class="flex items-center gap-4">
      <img src="<?php echo e($user->avatar_url ?? 'https://i.pravatar.cc/80'); ?>" alt="Avatar"
           class="h-16 w-16 rounded-full ring-2 ring-brand-100">
      <div>
        <h2 class="text-lg font-semibold text-gray-900"><?php echo e($user->name); ?></h2>
        <p class="text-sm text-gray-600">
          Role: <span class="font-medium"><?php echo e($user->role->name ?? 'Staff'); ?></span>
        </p>
        <p class="text-xs text-gray-500">Employee ID: <span class="font-mono"><?php echo e($user->employee_code ?? $user->id); ?></span></p>
      </div>
    </div>

    <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
      <div class="rounded-lg bg-gray-50 p-3">
        <p class="text-gray-500">Email</p>
        <p class="font-medium break-all"><?php echo e($user->email); ?></p>
      </div>
      <div class="rounded-lg bg-gray-50 p-3">
        <p class="text-gray-500">Phone</p>
        <p class="font-medium"><?php echo e($user->phone ?? '—'); ?></p>
      </div>
      <div class="rounded-lg bg-gray-50 p-3">
        <p class="text-gray-500">Joined</p>
        <p class="font-medium"><?php echo e(optional($user->created_at)->format('d M Y')); ?></p>
      </div>
      <div class="rounded-lg bg-gray-50 p-3">
        <p class="text-gray-500">Status</p>
        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
          <?php echo e($user->active ?? true ? 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20' : 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20'); ?>">
          <?php echo e(($user->active ?? true) ? 'Active' : 'Inactive'); ?>

        </span>
      </div>
    </div>

    <div class="mt-6">
      <h3 class="text-sm font-semibold text-gray-900 mb-2">Site Assignments</h3>
      <ul class="space-y-2">
        <?php $__empty_1 = true; $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $as): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <li class="flex items-start justify-between rounded-lg border border-gray-200 p-3">
            <div>
              <p class="font-medium text-gray-900"><?php echo e($as['site'] ?? '—'); ?></p>
              <p class="text-xs text-gray-500">
                Role: <?php echo e($as['role'] ?? '—'); ?>

                <?php if(!empty($as['since'])): ?>
                  • Since: <?php echo e(\Illuminate\Support\Carbon::parse($as['since'])->format('d M Y')); ?>

                <?php endif; ?>
              </p>
            </div>
            <span class="text-[11px] rounded-md bg-brand-50 text-brand-700 ring-1 ring-inset ring-brand-100 px-2 py-0.5">
              Assigned
            </span>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <li class="text-sm text-gray-500">No site assignments yet.</li>
        <?php endif; ?>
      </ul>
    </div>
  </section>

  <!-- Timesheets -->
  <section class="lg:col-span-2 bg-white border border-gray-200 rounded-xl">
    <div class="p-5 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h3 class="text-base font-semibold text-gray-900">Timesheets</h3>
        <p class="text-xs text-gray-500">Submit worked hours and site details weekly.</p>
      </div>
      <div class="flex items-center gap-2">
        <a href="#"
           class="inline-flex items-center rounded-lg bg-brand-600 px-3 py-2 text-sm font-medium text-white hover:bg-brand-700">
          + New Timesheet
        </a>
      </div>
    </div>

    <div class="p-5">
      <div class="mb-3 flex items-center gap-2">
        <form method="GET" class="flex items-center gap-2">
          <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Search week/date…"
                 class="w-56 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
          <select name="status" class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
            <option value="">All statuses</option>
            <?php $__currentLoopData = ['draft'=>'Draft','submitted'=>'Submitted','approved'=>'Approved','rejected'=>'Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($k); ?>" <?php if(request('status')===$k): echo 'selected'; endif; ?>><?php echo e($v); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
          <button class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50" type="submit">Filter</button>
        </form>
      </div>

      <div class="overflow-x-auto">
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
            <?php $__empty_1 = true; $__currentLoopData = $timesheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td class="px-4 py-2 font-medium text-gray-900">
                  <?php echo e(\Illuminate\Support\Carbon::parse($ts->week_start)->format('d M')); ?>

                  – <?php echo e(\Illuminate\Support\Carbon::parse($ts->week_end)->format('d M Y')); ?>

                </td>
                <td class="px-4 py-2 text-gray-600">
                  <?php echo e($ts->submitted_at ? \Illuminate\Support\Carbon::parse($ts->submitted_at)->format('d M Y, h:i A') : '—'); ?>

                </td>
                <td class="px-4 py-2"><?php echo e(number_format($ts->total_hours, 2)); ?></td>
                <td class="px-4 py-2">
                  <?php
                    $badge = [
                      'draft'     => 'bg-gray-50 text-gray-700 ring-gray-600/20',
                      'submitted' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                      'approved'  => 'bg-green-50 text-green-700 ring-green-600/20',
                      'rejected'  => 'bg-red-50 text-red-700 ring-red-600/20',
                    ][$ts->status] ?? 'bg-gray-50 text-gray-700 ring-gray-600/20';
                  ?>
                  <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?php echo e($badge); ?>">
                    <?php echo e(ucfirst($ts->status)); ?>

                  </span>
                </td>
                <td class="px-4 py-2 text-right">
                  <div class="inline-flex items-center gap-1">
                    <a href="#" class="rounded-md border px-2 py-1 hover:bg-gray-50">View</a>
                    <?php if($ts->status === 'draft'): ?>
                      <a href="#" class="rounded-md border px-2 py-1 hover:bg-gray-50">Edit</a>
                      <button class="rounded-md bg-brand-600 text-white px-2 py-1 hover:bg-brand-700">Submit</button>
                    <?php endif; ?>
                    <?php if($ts->status === 'approved'): ?>
                      <a href="#" class="rounded-md border px-2 py-1 hover:bg-gray-50">Download PDF</a>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-500">No timesheets found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\staff-portal\resources\views/staff/profile-timesheets.blade.php ENDPATH**/ ?>