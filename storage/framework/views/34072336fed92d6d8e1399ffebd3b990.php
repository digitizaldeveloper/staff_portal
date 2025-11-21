

<?php $__env->startSection('page-heading', 'Add Certification'); ?>
<?php $__env->startSection('content'); ?>

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden mx-auto">
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-xl font-bold text-gray-900">Add Certification</h1>
        </div>
        <a href="<?php echo e(route('admin.certifications.index')); ?>" class="text-gray-600 hover:underline">Back</a>
    </div>

    <div class="px-6 py-6">
        <?php if($errors->any()): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul class="list-disc ml-4">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.certifications.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Select Staff</label>
                <select name="staff_id" class="w-full border border-gray-300 rounded p-2 focus:ring">
                    <option value="">-- Choose Staff --</option>
                    <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Certification Name</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded p-2 focus:ring" placeholder="White Card, First Aid, etc">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Number / ID</label>
                <input type="text" name="number" class="w-full border border-gray-300 rounded p-2 focus:ring" placeholder="ABC-123456">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Issue Date</label>
                    <input type="date" name="issue_date" class="w-full border border-gray-300 rounded p-2 focus:ring">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Expiry Date</label>
                    <input type="date" name="expiry_date" class="w-full border border-gray-300 rounded p-2 focus:ring">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Save Certification</button>
                <a href="<?php echo e(route('admin.certifications.index')); ?>" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/admin/certifications/create.blade.php ENDPATH**/ ?>