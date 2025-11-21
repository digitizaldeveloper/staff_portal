

<?php $__env->startSection('page-heading', 'Find Your Dream Job'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-6xl mx-auto mt-10">

    <h1 class="text-3xl font-bold mb-6">Latest Jobs</h1>

    <?php if($jobs->count() == 0): ?>
        <p class="text-gray-600">No jobs available right now.</p>
    <?php endif; ?>

    <!-- Jobs Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">

                <h2 class="text-xl font-semibold mb-2">
                    <?php echo e($job->title); ?>

                </h2>

                <div class="text-gray-600 text-sm mb-3">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">
                        <?php echo e($job->type); ?>

                    </span>
                </div>

                <p class="text-gray-600 text-sm flex items-center gap-1">
                    📍 <?php echo e($job->location); ?>

                </p>

                <p class="text-gray-700 mt-2">
                    💰 <?php echo e($job->salary ? $job->salary : 'Not Mentioned'); ?>

                </p>

                <p class="mt-3 text-gray-600 text-sm line-clamp-3">
                    <?php echo e(Str::limit($job->description, 120)); ?>

                </p>

                <a href=""
                   class="mt-4 inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                    View Details
                </a>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/view_jobs.blade.php ENDPATH**/ ?>