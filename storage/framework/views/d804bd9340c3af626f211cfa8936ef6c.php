
<?php $__env->startSection('page-heading', 'Timesheet Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white p-6 shadow rounded">

    <h2 class="text-xl font-bold mb-4">Timesheet Information</h2>

    <p><strong>Staff:</strong> <?php echo e($sheet->staff->name); ?></p>
    <p><strong>Client:</strong> <?php echo e($sheet->client->name); ?></p>
    <p><strong>Date:</strong> <?php echo e($sheet->date); ?></p>
    <p><strong>Shift:</strong> <?php echo e($sheet->start_time); ?> - <?php echo e($sheet->end_time); ?></p>
    <p><strong>Break:</strong> <?php echo e($sheet->break_time); ?> minutes</p>
    <p><strong>Total Hours:</strong> <?php echo e($sheet->total_hours); ?> hrs</p>
    <p><strong>Notes:</strong> <?php echo e($sheet->notes ?? '---'); ?></p>

    <hr class="my-4">

    
    <form action="<?php echo e(route('admin.timesheets.notes', $sheet->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <label class="font-semibold">Admin Notes</label>
        <textarea name="admin_notes" class="border p-2 w-full rounded"><?php echo e($sheet->admin_notes); ?></textarea>

        <button class="bg-indigo-600 text-white px-4 py-2 rounded mt-2">
            Save Notes
        </button>
    </form>

    <hr class="my-4">

    <?php if($sheet->status == 'pending'): ?>
        <div class="flex gap-4">
            <form action="<?php echo e(route('admin.timesheets.approve', $sheet->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button class="bg-green-600 text-white px-4 py-2 rounded">Approve</button>
            </form>

            <form action="<?php echo e(route('admin.timesheets.reject', $sheet->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button class="bg-red-600 text-white px-4 py-2 rounded">Reject</button>
            </form>
        </div>
    <?php else: ?>
        <p class="text-gray-600 mt-2">This timesheet is locked.</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/admin/timesheets/show.blade.php ENDPATH**/ ?>