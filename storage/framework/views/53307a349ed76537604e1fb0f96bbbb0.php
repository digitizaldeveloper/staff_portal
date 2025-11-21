

<?php $__env->startSection('page-heading', 'Find Your Dream Job'); ?>

<?php $__env->startSection('content'); ?>

<?php
    use Illuminate\Support\Str;
?>

<div class="mx-auto max-w-6xl px-4 py-10 space-y-6">

    <div class="rounded-3xl border border-gray-200 bg-gradient-to-r from-emerald-50 to-white px-8 py-10 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-6">
            <div>
                <p class="text-sm uppercase tracking-wide text-emerald-600">Open Positions</p>
                <h1 class="mt-2 text-3xl font-semibold text-gray-900">Find your next role</h1>
                <p class="mt-3 text-gray-600">
                    Browse curated opportunities and apply with confidence. We highlight clear job details so you can focus on what matters.
                </p>
            </div>
            <div class="rounded-2xl border border-emerald-200 bg-white px-6 py-4 text-center shadow-sm">
                <p class="text-4xl font-bold text-emerald-600"><?php echo e($jobs->count()); ?></p>
                <p class="text-sm font-medium text-gray-500">Listings live</p>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($jobs->count() === 0): ?>
        <div class="rounded-3xl border border-dashed border-gray-200 bg-white px-10 py-12 text-center text-gray-500 shadow-sm">
            No jobs available right now. Check back soon or follow us for future updates.
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="group flex h-full flex-col rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-emerald-200 hover:shadow-lg">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-400">Position</p>
                            <h2 class="mt-1 text-xl font-semibold text-gray-900 group-hover:text-emerald-600">
                                <?php echo e($job->title); ?>

                            </h2>
                        </div>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                            <?php echo e($job->type); ?>

                        </span>
                    </div>

                    <dl class="mt-4 space-y-3 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-400">📍</span>
                            <span><?php echo e($job->location ?? 'Location not listed'); ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-400">💰</span>
                            <span><?php echo e($job->salary ?: 'Salary not disclosed'); ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-400">🗓</span>
                            <span>Posted <?php echo e(optional($job->created_at)->diffForHumans() ?? 'recently'); ?></span>
                        </div>
                    </dl>

                    <p class="mt-4 flex-1 text-sm text-gray-600 line-clamp-3">
                        <?php echo e(Str::limit($job->description, 140)); ?>

                    </p>

                    <a href="<?php echo e(route('view_job', $job->id)); ?>"
                       class="mt-5 inline-flex items-center justify-center rounded-full bg-emerald-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                        View Details
                    </a>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/all_jobs.blade.php ENDPATH**/ ?>