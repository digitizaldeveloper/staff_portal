
<?php $__env->startSection('page-heading', 'Edit Job'); ?>
<?php $__env->startSection('content'); ?>

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden max-w-4xl mx-auto">
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-2xl font-bold text-gray-900">Edit Job</h1>
        </div>
        <a href="<?php echo e(route('admin.jobs.index')); ?>" class="text-gray-600 hover:underline">Back</a>
    </div>

    <div class="px-6 py-6">
        <form action="<?php echo e(route('admin.jobs.update', $job->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Job Title</label>
                    <input type="text" name="title" value="<?php echo e(old('title', $job->title)); ?>" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Job Type</label>
                    <select name="type" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                        <option value="">Select Type</option>
                        <option value="Full-time" <?php echo e(old('type', $job->type) == 'Full-time' ? 'selected' : ''); ?>>Full-time</option>
                        <option value="Part-time" <?php echo e(old('type', $job->type) == 'Part-time' ? 'selected' : ''); ?>>Part-time</option>
                        <option value="Remote" <?php echo e(old('type', $job->type) == 'Remote' ? 'selected' : ''); ?>>Remote</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
                    <input type="text" name="location" value="<?php echo e(old('location', $job->location)); ?>" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Salary (Optional)</label>
                    <input type="text" name="salary" value="<?php echo e(old('salary', $job->salary)); ?>" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Job Description</label>
                <textarea name="description" rows="5" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring"><?php echo e(old('description', $job->description)); ?></textarea>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Update Job</button>
                <a href="<?php echo e(route('admin.jobs.index')); ?>" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/admin/jobs/edit.blade.php ENDPATH**/ ?>