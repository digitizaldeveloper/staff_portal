

<?php $__env->startSection('page-heading', 'Edit Certification'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto p-6">
    <!-- <h2 class="text-2xl font-bold mb-6">Edit Certification</h2> -->

    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc ml-4">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.certifications.update', $cert->id)); ?>" method="POST" class="bg-white p-6 rounded shadow">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Select Staff</label>
            <select name="staff_id" class="w-full border rounded p-2">
                <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>" <?php echo e($cert->staff_id == $user->id ? 'selected' : ''); ?>>
                        <?php echo e($user->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Certification Name</label>
            <input type="text" name="name" class="w-full border rounded p-2" value="<?php echo e($cert->name); ?>">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Number / ID</label>
            <input type="text" name="number" class="w-full border rounded p-2" value="<?php echo e($cert->number); ?>">
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-semibold mb-1">Issue Date</label>
                <input type="date" name="issue_date" class="w-full border rounded p-2" value="<?php echo e($cert->issue_date); ?>">
            </div>

            <div>
                <label class="block font-semibold mb-1">Expiry Date</label>
                <input type="date" name="expiry_date" class="w-full border rounded p-2" value="<?php echo e($cert->expiry_date); ?>">
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Status</label>
            <select name="status" class="w-full border rounded p-2">
                <option value="pending" <?php echo e($cert->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="valid" <?php echo e($cert->status == 'valid' ? 'selected' : ''); ?>>Valid</option>
                <option value="expired" <?php echo e($cert->status == 'expired' ? 'selected' : ''); ?>>Expired</option>
                <option value="expiring_soon" <?php echo e($cert->status == 'expiring_soon' ? 'selected' : ''); ?>>Expiring Soon</option>
            </select>
        </div>

        <button class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
            Update Certification
        </button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/admin/certifications/edit.blade.php ENDPATH**/ ?>