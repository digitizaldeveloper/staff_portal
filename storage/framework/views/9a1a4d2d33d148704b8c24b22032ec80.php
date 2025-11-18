

<?php $__env->startSection('title','My Certifications'); ?>
<?php $__env->startSection('page-heading','My Certifications & Notifications'); ?>

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

  // Dummy certifications
  $certifications = collect([
    (object)[
      'name' => 'First Aid Level 1',
      'issued_by' => 'Red Crescent',
      'expiry_date' => Carbon::now()->addMonths(6),
    ],
    (object)[
      'name' => 'Fire Safety Training',
      'issued_by' => 'Civil Defense',
      'expiry_date' => Carbon::now()->subDays(10), // expired
    ],
    (object)[
      'name' => 'Security Guard License',
      'issued_by' => 'Govt. Authority',
      'expiry_date' => Carbon::now()->addYears(1),
    ],
  ]);

  // Dummy notifications
  $notifications = collect([
    (object)[
      'message' => 'Your First Aid certificate will expire soon.',
      'is_read' => false,
      'created_at' => Carbon::now()->subDays(2),
    ],
    (object)[
      'message' => 'New payslip available for September 2025.',
      'is_read' => true,
      'created_at' => Carbon::now()->subWeek(),
    ],
  ]);
?>

  <!-- Certifications -->
  <div class="bg-white shadow rounded-lg p-6 mb-6">
    <h2 class="text-lg font-semibold mb-4">My Certifications</h2>
    <table class="w-full border border-gray-200 text-sm">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left">Certification</th>
          <th class="px-4 py-2 text-left">Issued By</th>
          <th class="px-4 py-2 text-left">Expiry Date</th>
          <th class="px-4 py-2 text-left">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $certifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr class="border-t">
            <td class="px-4 py-2"><?php echo e($cert->name); ?></td>
            <td class="px-4 py-2"><?php echo e($cert->issued_by); ?></td>
            <td class="px-4 py-2"><?php echo e($cert->expiry_date->format('d M Y')); ?></td>
            <td class="px-4 py-2">
              <?php if($cert->expiry_date->isPast()): ?>
                <span class="text-red-600 font-medium">Expired</span>
              <?php else: ?>
                <span class="text-green-600 font-medium">Valid</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="4" class="px-4 py-3 text-center text-gray-500">No certifications found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Notifications -->
  <div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-semibold mb-4">Notifications</h2>
    <ul class="space-y-3">
      <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <li class="p-3 border rounded-lg <?php echo e($note->is_read ? 'bg-gray-50' : 'bg-yellow-50'); ?>">
          <p class="text-sm"><?php echo e($note->message); ?></p>
          <p class="text-xs text-gray-500"><?php echo e($note->created_at->diffForHumans()); ?></p>
        </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <li class="text-gray-500 text-sm">No notifications yet.</li>
      <?php endif; ?>
    </ul>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\staff-portal\resources\views/staff/certifications.blade.php ENDPATH**/ ?>