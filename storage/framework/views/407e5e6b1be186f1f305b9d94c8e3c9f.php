

<?php $__env->startSection('title','Staff Dashboard'); ?>
<?php $__env->startSection('page-heading','Staff Dashboard'); ?>

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
?>


<div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
  <section class="lg:col-span-2 rounded-xl border border-gray-200 bg-white p-5">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm text-gray-600">Welcome back,</p>
        <h2 class="text-xl font-semibold text-gray-900"><?php echo e($user->name); ?></h2>
        <p class="text-xs text-gray-500">Employee ID: <span class="font-mono"><?php echo e($user->employee_code); ?></span> • Role: <?php echo e($user->role); ?></p>
      </div>
      <img src="https://i.pravatar.cc/64" class="h-14 w-14 rounded-full border" alt="Avatar">
    </div>

    <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
      <a href="<?php echo e(url('/staff/timesheets/create')); ?>" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>➕ New Timesheet</span><span class="text-xs text-gray-500">This week</span>
      </a>
      <a href="<?php echo e(url('/staff/timesheets')); ?>" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>🕒 My Timesheets</span><span class="text-xs text-gray-500">History</span>
      </a>
      <a href="<?php echo e(url('/staff/payslips')); ?>" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>🧾 Payslips</span><span class="text-xs text-gray-500">Download</span>
      </a>
      <a href="<?php echo e(url('/staff/profile')); ?>" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>🙍 Profile</span><span class="text-xs text-gray-500">Update</span>
      </a>
    </div>
  </section>

  <section class="rounded-xl border border-gray-200 bg-white p-5">
    <h3 class="text-base font-semibold text-gray-900">This Week</h3>
    <p class="mt-1 text-xs text-gray-500"><?php echo e($weekLabel); ?> • W<?php echo e($weekStart->format('W')); ?></p>

    <div class="mt-3 grid grid-cols-2 gap-3">
      <div class="rounded-lg bg-gray-50 p-3">
        <p class="text-xs text-gray-500">Logged Hours</p>
        <p class="text-2xl font-semibold"><?php echo e(number_format($timesheet->hours,2)); ?></p>
      </div>
      <div class="rounded-lg bg-gray-50 p-3">
        <p class="text-xs text-gray-500">Status</p>
        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?php echo e($badge($timesheet->status)); ?>"><?php echo e(ucfirst($timesheet->status)); ?></span>
      </div>
    </div>

    <div class="mt-3 text-xs text-gray-500">
      <?php if($timesheet->status==='draft'): ?>
        Last saved <?php echo e($timesheet->last_saved->diffForHumans()); ?>.
      <?php elseif($timesheet->submitted_at): ?>
        Submitted <?php echo e($timesheet->submitted_at->format('d M Y, h:i A')); ?>.
      <?php endif; ?>
    </div>

    <div class="mt-3 flex items-center gap-2">
      <?php if($timesheet->status==='draft'): ?>
        <a href="<?php echo e(url('/staff/timesheets/create')); ?>" class="rounded-lg bg-brand-600 text-white px-3 py-1.5 text-sm hover:bg-brand-700">Continue Timesheet</a>
      <?php else: ?>
        <a href="<?php echo e(url('/staff/timesheets')); ?>" class="rounded-lg border px-3 py-1.5 text-sm hover:bg-gray-50">View Timesheets</a>
      <?php endif; ?>
    </div>
  </section>
</div>


<div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
  
  <section class="xl:col-span-2 rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="p-5 border-b border-gray-200 flex items-center justify-between">
      <h3 class="text-base font-semibold text-gray-900">Site Assignments & Next Shifts</h3>
      <a href="<?php echo e(url('/staff/profile')); ?>" class="text-sm text-brand-700 hover:underline">View Profile</a>
    </div>
    <div class="p-5 grid grid-cols-1 lg:grid-cols-2 gap-5">
      <div>
        <p class="text-sm font-semibold text-gray-900 mb-2">Assignments</p>
        <ul class="space-y-2">
          <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $as): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="flex items-center justify-between rounded-lg border p-3">
              <div>
                <p class="font-medium text-gray-900"><?php echo e($as['site']); ?></p>
                <p class="text-xs text-gray-500">Role: <?php echo e($as['role']); ?> • Since: <?php echo e($as['since']->format('d M Y')); ?></p>
              </div>
              <span class="text-[11px] rounded-md bg-brand-50 text-brand-700 ring-1 ring-inset ring-brand-100 px-2 py-0.5">
                Active
              </span>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>

      <div>
        <p class="text-sm font-semibold text-gray-900 mb-2">Next Shifts</p>
        <ul class="space-y-2">
          <?php $__currentLoopData = $nextShifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="flex items-center justify-between rounded-lg border p-3">
              <div>
                <p class="font-medium text-gray-900"><?php echo e($s['date']->format('D, d M Y')); ?></p>
                <p class="text-xs text-gray-500">Start: <?php echo e($s['date']->format('h:i A')); ?> • <?php echo e($s['hours']); ?> hrs • <?php echo e($s['site']); ?></p>
              </div>
              <a href="<?php echo e(url('/staff/timesheets/create')); ?>" class="rounded-md border px-2 py-1 text-sm hover:bg-gray-50">Log</a>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    </div>
  </section>

  
  <section class="rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="p-5 border-b border-gray-200 flex items-center justify-between">
      <h3 class="text-base font-semibold text-gray-900">Recent Payslips</h3>
      <a href="<?php echo e(url('/staff/payslips')); ?>" class="text-sm text-brand-700 hover:underline">View all</a>
    </div>
    <ul class="p-5 space-y-3">
      <?php $__currentLoopData = $payslips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="flex items-center justify-between rounded-lg border p-3">
          <div>
            <p class="font-medium text-gray-900"><?php echo e($p['period']); ?></p>
            <p class="text-xs text-gray-500">Issued: <?php echo e($p['issued']->format('d M Y')); ?></p>
          </div>
          <div class="flex items-center gap-2">
            <span class="text-sm font-medium"><?php echo e(number_format($p['net'])); ?></span>
            <a href="<?php echo e($p['url']); ?>" class="rounded-md border px-2 py-1 text-sm hover:bg-gray-50">View</a>
            <a href="<?php echo e($p['url']); ?>" class="rounded-md bg-brand-600 text-white px-2 py-1 text-sm hover:bg-brand-700">Download</a>
          </div>
        </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php if(empty($payslips)): ?>
        <li class="text-sm text-gray-500">No payslips yet.</li>
      <?php endif; ?>
    </ul>
  </section>
</div>


<div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
  
  <section class="rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="p-5 border-b border-gray-200">
      <h3 class="text-base font-semibold text-gray-900">Announcements</h3>
    </div>
    <ul class="p-5 space-y-3 text-sm">
      <?php $__currentLoopData = $ann; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="rounded-lg border p-3">
          <p class="font-medium text-gray-900"><?php echo e($a['title']); ?></p>
          <p class="text-gray-700 mt-1"><?php echo e($a['body']); ?></p>
          <p class="text-xs text-gray-500 mt-1"><?php echo e($a['time']->diffForHumans()); ?></p>
        </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </section>

  
  <section class="rounded-xl border border-gray-200 bg-white p-5">
    <h3 class="text-base font-semibold text-gray-900">Quick Help</h3>
    <ul class="mt-3 list-disc list-inside text-sm text-gray-700 space-y-1">
      <li>To submit hours, open <a class="text-brand-700 hover:underline" href="<?php echo e(url('/staff/timesheets/create')); ?>">New Timesheet</a>.</li>
      <li>Update personal info in <a class="text-brand-700 hover:underline" href="<?php echo e(url('/staff/profile')); ?>">Profile</a>.</li>
      <li>Download your latest salary slip in <a class="text-brand-700 hover:underline" href="<?php echo e(url('/staff/payslips')); ?>">Payslips</a>.</li>
    </ul>
  </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u461551961/domains/wponline.io/public_html/staff_portal/resources/views/staff/dashboard.blade.php ENDPATH**/ ?>