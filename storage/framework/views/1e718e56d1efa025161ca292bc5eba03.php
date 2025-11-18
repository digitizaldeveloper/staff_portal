

<?php $__env->startSection('title','Payslips & Personal Details'); ?>
<?php $__env->startSection('page-heading','Payslips & Personal Details'); ?>

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

  // ---- Dummy user (read-only personal details) ----
  $user = (object)[
    'name'   => 'Ali Raza',
    'email'  => 'ali.raza@example.com',
    'phone'  => '+92 300 0000000',
    'cnic'   => '42101-1234567-1',
    'dob'    => Carbon::parse('1996-04-10'),
    'gender' => 'Male',
    'address'=> 'House 12, Block B, Gulshan-e-Iqbal, Karachi',
    'joining'=> Carbon::parse('2024-06-15'),
    'emp_id' => 'EMP-0123',
    'avatar' => null,
    'bank'   => (object)[
      'title' => 'Meezan Bank',
      'iban'  => 'PK12MEZN0000000001234567',
      'acc'   => 'Ali Raza'
    ],
    'emergency' => (object)[
      'name'  => 'Ahmed Raza',
      'relation' => 'Brother',
      'phone' => '+92 300 1112233'
    ],
  ];

  // ---- Dummy payslips (uploaded by Admin) ----
  $payslips = [
    ['id'=>531,'period'=>'Sep 2025','issued'=>Carbon::parse('2025-09-30'),'gross'=>120000,'deductions'=>14500,'net'=>105500,'url_view'=>'#','url_download'=>'#'],
    ['id'=>530,'period'=>'Aug 2025','issued'=>Carbon::parse('2025-08-31'),'gross'=>118000,'deductions'=>14800,'net'=>103200,'url_view'=>'#','url_download'=>'#'],
    ['id'=>529,'period'=>'Jul 2025','issued'=>Carbon::parse('2025-07-31'),'gross'=>118000,'deductions'=>15000,'net'=>103000,'url_view'=>'#','url_download'=>'#'],
  ];

  // ---- Dummy certifications (read-only) ----
  $certs = [
    ['name'=>'PSIRA / Security Guard','no'=>'SG-2025-1122','issued'=>Carbon::parse('2025-01-10'),'expires'=>Carbon::parse('2026-01-10')],
    ['name'=>'First Aid Level 1','no'=>'FA-7710','issued'=>Carbon::parse('2024-11-05'),'expires'=>Carbon::parse('2026-11-05')],
  ];

  $expBadge = function(Carbon $expires) {
    $days = now()->diffInDays($expires, false);
    if ($days < 0) return 'bg-red-50 text-red-700 ring-red-600/20';
    if ($days <= 30) return 'bg-amber-50 text-amber-800 ring-amber-600/20';
    return 'bg-green-50 text-green-700 ring-green-600/20';
  };
?>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
  <!-- Payslips -->
  <section class="lg:col-span-2 bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="p-5 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h3 class="text-base font-semibold text-gray-900">Payslips</h3>
        <p class="text-xs text-gray-500">Download/view payslips uploaded by Admin.</p>
      </div>
      <form method="GET" class="flex items-center gap-2">
        <input type="text" name="q" placeholder="Search period (e.g., Sep 2025)"
               class="w-56 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
        <button class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50" type="submit">Filter</button>
      </form>
    </div>

    <div class="p-5 overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
          <tr class="text-left text-gray-600">
            <th class="px-4 py-2">Period</th>
            <th class="px-4 py-2">Issued</th>
            <th class="px-4 py-2">Gross</th>
            <th class="px-4 py-2">Deductions</th>
            <th class="px-4 py-2">Net</th>
            <th class="px-4 py-2 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <?php $__empty_1 = true; $__currentLoopData = $payslips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td class="px-4 py-2 font-medium text-gray-900"><?php echo e($p['period']); ?></td>
              <td class="px-4 py-2 text-gray-600"><?php echo e($p['issued']->format('d M Y')); ?></td>
              <td class="px-4 py-2"><?php echo e(number_format($p['gross'])); ?></td>
              <td class="px-4 py-2"><?php echo e(number_format($p['deductions'])); ?></td>
              <td class="px-4 py-2 font-medium"><?php echo e(number_format($p['net'])); ?></td>
              <td class="px-4 py-2 text-right">
                <div class="inline-flex items-center gap-1">
                  <a href="<?php echo e($p['url_view']); ?>" class="rounded-md border px-2 py-1 hover:bg-gray-50">View</a>
                  <a href="<?php echo e($p['url_download']); ?>" class="rounded-md bg-brand-600 text-white px-2 py-1 hover:bg-brand-700">Download</a>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="6" class="px-4 py-8 text-center text-gray-500">No payslips available yet.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

      
      <div class="mt-4 flex justify-end">
        <nav class="inline-flex gap-1">
          <button class="px-3 py-1.5 text-sm rounded border hover:bg-gray-50">Prev</button>
          <button class="px-3 py-1.5 text-sm rounded border bg-gray-100">1</button>
          <button class="px-3 py-1.5 text-sm rounded border hover:bg-gray-50">2</button>
          <button class="px-3 py-1.5 text-sm rounded border hover:bg-gray-50">Next</button>
        </nav>
      </div>
    </div>
  </section>

  <!-- Personal Details (read-only) -->
  <section class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="p-5 border-b border-gray-200">
      <h3 class="text-base font-semibold text-gray-900">Personal Details</h3>
      <p class="text-xs text-gray-500">These details are managed by Admin.</p>
    </div>

    <div class="p-5 space-y-4">
      <div class="flex items-center gap-4">
        <img src="<?php echo e($user->avatar ?? 'https://i.pravatar.cc/80'); ?>" class="h-16 w-16 rounded-full ring-2 ring-brand-100" alt="Avatar">
        <div>
          <p class="text-lg font-semibold text-gray-900"><?php echo e($user->name); ?></p>
          <p class="text-xs text-gray-500">Employee ID: <span class="font-mono"><?php echo e($user->emp_id); ?></span></p>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-3 text-sm">
        <div class="rounded-lg bg-gray-50 p-3">
          <p class="text-gray-500">Email</p>
          <p class="font-medium break-all"><?php echo e($user->email); ?></p>
        </div>
        <div class="rounded-lg bg-gray-50 p-3">
          <p class="text-gray-500">Phone</p>
          <p class="font-medium"><?php echo e($user->phone); ?></p>
        </div>
        <div class="rounded-lg bg-gray-50 p-3">
          <p class="text-gray-500">CNIC</p>
          <p class="font-medium"><?php echo e($user->cnic); ?></p>
        </div>
        <div class="rounded-lg bg-gray-50 p-3">
          <p class="text-gray-500">Date of Birth</p>
          <p class="font-medium"><?php echo e($user->dob->format('d M Y')); ?> (<?php echo e($user->dob->age); ?> yrs)</p>
        </div>
        <div class="rounded-lg bg-gray-50 p-3">
          <p class="text-gray-500">Gender</p>
          <p class="font-medium"><?php echo e($user->gender); ?></p>
        </div>
        <div class="rounded-lg bg-gray-50 p-3">
          <p class="text-gray-500">Home Address</p>
          <p class="font-medium"><?php echo e($user->address); ?></p>
        </div>
        <div class="rounded-lg bg-gray-50 p-3">
          <p class="text-gray-500">Joining Date</p>
          <p class="font-medium"><?php echo e($user->joining->format('d M Y')); ?></p>
        </div>
      </div>

      <div class="rounded-lg border border-gray-200 p-3">
        <p class="text-sm font-semibold text-gray-900 mb-2">Bank Details</p>
        <div class="grid grid-cols-1 gap-2 text-sm">
          <p><span class="text-gray-500">Bank:</span> <span class="font-medium"><?php echo e($user->bank->title); ?></span></p>
          <p><span class="text-gray-500">Account Title:</span> <span class="font-medium"><?php echo e($user->bank->acc); ?></span></p>
          <p class="break-all"><span class="text-gray-500">IBAN:</span> <span class="font-medium"><?php echo e($user->bank->iban); ?></span></p>
        </div>
      </div>

      <div class="rounded-lg border border-gray-200 p-3">
        <p class="text-sm font-semibold text-gray-900 mb-2">Emergency Contact</p>
        <div class="grid grid-cols-1 gap-2 text-sm">
          <p><span class="text-gray-500">Name:</span> <span class="font-medium"><?php echo e($user->emergency->name); ?></span></p>
          <p><span class="text-gray-500">Relation:</span> <span class="font-medium"><?php echo e($user->emergency->relation); ?></span></p>
          <p><span class="text-gray-500">Phone:</span> <span class="font-medium"><?php echo e($user->emergency->phone); ?></span></p>
        </div>
      </div>

      <div class="rounded-lg border border-gray-200 p-3">
        <p class="text-sm font-semibold text-gray-900 mb-3">Certifications (Read-only)</p>
        <ul class="space-y-2">
          <?php $__currentLoopData = $certs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $cls = $expBadge($c['expires']); ?>
            <li class="flex items-center justify-between rounded-lg bg-gray-50 p-3">
              <div>
                <p class="font-medium text-gray-900"><?php echo e($c['name']); ?></p>
                <p class="text-xs text-gray-500">No: <?php echo e($c['no']); ?> • Issued: <?php echo e($c['issued']->format('d M Y')); ?></p>
              </div>
              <span class="text-[11px] rounded-md px-2 py-1 ring-1 ring-inset <?php echo e($cls); ?>">
                Expires <?php echo e($c['expires']->diffForHumans()); ?>

              </span>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>

      <div class="flex items-center justify-end gap-2 pt-2">
        <button type="button" class="rounded-lg border px-3 py-2 text-sm text-gray-700 hover:bg-gray-50" disabled>Edit (Locked)</button>
        <button type="button" class="rounded-lg bg-brand-600 text-white px-3 py-2 text-sm hover:bg-brand-700">Request Update</button>
      </div>
    </div>
  </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u879844399/domains/darkgreen-cassowary-727973.hostingersite.com/public_html/staff_portal/resources/views/staff/payslips-personal.blade.php ENDPATH**/ ?>