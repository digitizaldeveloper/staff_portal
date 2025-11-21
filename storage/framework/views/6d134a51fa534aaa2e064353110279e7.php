
<?php $__env->startSection('page-heading', 'Edit Client'); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden mx-auto">
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-xl font-bold text-gray-900">Edit Client</h1>
        </div>
        <a href="<?php echo e(route('admin.clients.index')); ?>" class="text-gray-600 hover:underline">Back</a>
    </div>

    <div class="px-6 py-6">
        <?php if($errors->any()): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($e); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.clients.update', $client->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                <input name="name" value="<?php echo e(old('name', $client->name)); ?>" class="w-full border border-gray-300 p-2 rounded focus:ring" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input name="email" value="<?php echo e(old('email', $client->email)); ?>" class="w-full border border-gray-300 p-2 rounded focus:ring" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                <input name="phone" value="<?php echo e(old('phone', $client->phone)); ?>" class="w-full border border-gray-300 p-2 rounded focus:ring">
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Address</label>
                <textarea name="address" class="w-full border border-gray-300 p-2 rounded focus:ring"><?php echo e(old('address', $client->address)); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 p-2 rounded focus:ring">
                    <option value="1" <?php echo e($client->status ? 'selected' : ''); ?>>Active</option>
                    <option value="0" <?php echo e(!$client->status ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>

            <div class="flex items-center gap-3">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Update Client</button>
                <a href="<?php echo e(route('admin.clients.index')); ?>" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/admin/clients/edit.blade.php ENDPATH**/ ?>