

<?php $__env->startSection('title','Admin Dashboard'); ?>
<?php $__env->startSection('page-heading','Admin Dashboard'); ?>

<?php $__env->startSection('sidebar'); ?>
<a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🏠 Dashboard</a>
<a href="<?php echo e(route('admin.timesheets')); ?>" class="block px-3 py-2 rounded-lg bg-gray-100 font-medium">🕒 Timesheets</a>
<a href="<?php echo e(route('admin.staff-management')); ?>" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🧑‍💼 Staff</a>
<a href="<?php echo e(route('admin.payroll')); ?>" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🧾 Payroll</a>
<a href="<?php echo e(route('admin.jobs-applications')); ?>" class="block px-3 py-2 rounded-lg hover:bg-gray-50">💼 Jobs & Applications</a>
<a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-50">⚙️ Settings</a>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
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
?>


<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
  <?php $__currentLoopData = $kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="rounded-xl border border-gray-200 bg-white p-4">
      <div class="flex items-center justify-between">
        <p class="text-sm text-gray-600"><?php echo e($k['label']); ?></p>
        <span class="text-[11px] rounded-md bg-brand-50 text-brand-700 ring-1 ring-inset ring-brand-100 px-2 py-0.5">Live</span>
      </div>
      <div class="mt-2 flex items-end justify-between">
        <p class="text-2xl font-semibold text-gray-900"><?php echo e($k['value']); ?></p>
        
        <svg viewBox="0 0 100 24" class="h-6 w-24">
          <polyline fill="none" stroke="currentColor" stroke-width="2" class="text-brand-500"
            points="<?php echo e($i===0?'0,18 20,12 40,14 60,9 80,11 100,6':($i===1?'0,10 20,12 40,8 60,14 80,9 100,12':($i===2?'0,14 20,16 40,12 60,9 80,13 100,10':'0,12 20,10 40,14 60,8 80,12 100,7'))); ?>" />
        </svg>
      </div>
      <p class="mt-1 text-xs text-gray-500"><?php echo e($k['delta']); ?></p>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
  
  <section class="xl:col-span-2 rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="p-4 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h3 class="text-base font-semibold text-gray-900">Timesheets</h3>
        <p class="text-xs text-gray-500">Review staff-submitted timesheets.</p>
      </div>
      <div class="flex items-center gap-2">
        <a href="<?php echo e(url('/admin/timesheets')); ?>" class="rounded-lg border px-3 py-1.5 text-sm hover:bg-gray-50">Open Manager</a>
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
          <?php $__currentLoopData = $recentTimesheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td class="px-4 py-2 font-medium text-gray-900"><?php echo e($r['user']); ?></td>
              <td class="px-4 py-2"><?php echo e($r['week']); ?></td>
              <td class="px-4 py-2"><?php echo e(number_format($r['hours'],2)); ?></td>
              <td class="px-4 py-2 text-gray-600"><?php echo e($r['at']->format('d M Y, h:i A')); ?></td>
              <td class="px-4 py-2">
                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?php echo e($badge($r['status'])); ?>">
                  <?php echo e(ucfirst($r['status'])); ?>

                </span>
              </td>
              <td class="px-4 py-2 text-right">
                <div class="inline-flex items-center gap-1">
                  <a href="<?php echo e(url('/admin/timesheets')); ?>" class="rounded-md border px-2 py-1 hover:bg-gray-50">Review</a>
                  <?php if($r['status']==='submitted'): ?>
                    <button class="rounded-md bg-green-600 text-white px-2 py-1 hover:bg-green-700">Approve</button>
                    <button class="rounded-md bg-red-600 text-white px-2 py-1 hover:bg-red-700">Reject</button>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>
  </section>

  
  <section class="rounded-xl border border-gray-200 bg-white p-4">
    <h3 class="text-base font-semibold text-gray-900">Quick Actions</h3>
    <div class="mt-3 grid grid-cols-1 gap-2">
      <a href="<?php echo e(url('/admin/staff')); ?>" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>➕ Add Staff</span><span class="text-xs text-gray-500">Users</span>
      </a>
      <a href="<?php echo e(url('/admin/jobs')); ?>" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>📝 Post New Job</span><span class="text-xs text-gray-500">Jobs</span>
      </a>
      <a href="<?php echo e(url('/admin/payroll')); ?>" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>📄 Upload Payslip</span><span class="text-xs text-gray-500">Payroll</span>
      </a>
      <a href="<?php echo e(url('/admin/timesheets')); ?>" class="flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50">
        <span>✅ Approve Timesheets</span><span class="text-xs text-gray-500">Timesheets</span>
      </a>
    </div>
  </section>
</div>


<div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
  
  <section class="rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="p-4 border-b border-gray-200 flex items-center justify-between">
      <h3 class="text-base font-semibold text-gray-900">Latest Applications</h3>
      <a href="<?php echo e(url('/admin/jobs')); ?>" class="text-sm text-brand-700 hover:underline">View all</a>
    </div>
    <ul class="p-4 space-y-3">
      <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="flex items-center justify-between rounded-lg border p-3">
          <div>
            <p class="font-medium text-gray-900"><?php echo e($a['name']); ?></p>
            <p class="text-xs text-gray-500"><?php echo e($a['job']); ?> • <?php echo e($a['submitted']->diffForHumans()); ?></p>
          </div>
          <div class="flex items-center gap-2">
            <a href="<?php echo e($a['cv']); ?>" class="rounded-md border px-2 py-1 hover:bg-gray-50 text-sm">View CV</a>
            <button class="rounded-md bg-brand-600 text-white px-2 py-1 hover:bg-brand-700 text-sm">Shortlist</button>
          </div>
        </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </section>

  
  <section class="rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="p-4 border-b border-gray-200 flex items-center justify-between">
      <h3 class="text-base font-semibold text-gray-900">Certification Alerts</h3>
      <a href="<?php echo e(url('/admin/staff')); ?>" class="text-sm text-brand-700 hover:underline">Manage</a>
    </div>
    <ul class="p-4 space-y-3">
      <?php $__currentLoopData = $expiring; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $cls = $expCls($c['expires']); ?>
        <li class="flex items-center justify-between rounded-lg border p-3">
          <div>
            <p class="font-medium text-gray-900"><?php echo e($c['staff']); ?></p>
            <p class="text-xs text-gray-500"><?php echo e($c['cert']); ?> — Expires <?php echo e($c['expires']->format('d M Y')); ?></p>
          </div>
          <span class="text-[11px] rounded-md px-2 py-1 ring-1 ring-inset <?php echo e($cls); ?>">
            <?php echo e(now()->diffInDays($c['expires'], false) < 0 ? 'Expired' : 'Upcoming'); ?>

          </span>
        </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </section>

  
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u461551961/domains/wponline.io/public_html/staff_portal/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>