

<?php $__env->startSection('page-heading', $job->title); ?>

<?php $__env->startSection('content'); ?>

<?php
    use Illuminate\Support\Str;
?>

<div class="mx-auto max-w-5xl px-4 py-10 space-y-6">

    <div class="rounded-3xl border border-gray-200 bg-white shadow-lg">
        <div class="rounded-t-3xl bg-gradient-to-r from-emerald-600 to-emerald-500 px-8 py-10 text-white">
            <p class="text-sm uppercase tracking-[0.2em] text-emerald-100">Featured role</p>
            <h1 class="mt-3 text-4xl font-semibold"><?php echo e($job->title); ?></h1>
            <div class="mt-6 flex flex-wrap gap-4 text-sm font-medium">
                <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-1.5">
                    <?php echo e($job->type); ?>

                </span>
                <span class="inline-flex items-center gap-1 rounded-full bg-white/15 px-4 py-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                    <?php echo e($job->location ?? 'Flexible location'); ?>

                </span>
                <span class="inline-flex items-center gap-1 rounded-full bg-white/15 px-4 py-1.5">
                    💰 <?php echo e($job->salary ?: 'Salary not disclosed'); ?>

                </span>
            </div>
        </div>

        <div class="px-8 py-8">
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                <span>Posted <?php echo e(optional($job->created_at)->diffForHumans() ?? 'recently'); ?></span>
                <span class="text-gray-300">•</span>
                <span>Job ID: <span class="font-mono text-gray-700">#<?php echo e(Str::padLeft($job->id, 4, '0')); ?></span></span>
            </div>

            <div class="mt-6 space-y-6 text-gray-700 leading-relaxed">
                <?php echo nl2br(e($job->description)); ?>

            </div>

            <div class="mt-10 flex flex-wrap items-center gap-4 border-t border-gray-100 pt-6">
                <a href="<?php echo e(route('apply_job', $job->id)); ?>"
                   class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-6 py-3 text-base font-semibold text-white shadow-md transition hover:bg-emerald-700">
                    Apply Now
                </a>
                <a href="<?php echo e(route('all_jobs')); ?>"
                   class="inline-flex items-center justify-center rounded-full border border-gray-300 px-6 py-3 text-base font-semibold text-gray-700 hover:bg-gray-50">
                    Back to listings
                </a>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white px-6 py-5 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900">Need help before applying?</h2>
        <p class="mt-2 text-sm text-gray-600">
            Our recruitment team can answer questions about this role, the hiring process, or required documents.
        </p>
        <a href="<?php echo e(route('contact.store')); ?>"
           class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700">
            Contact support →
        </a>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/view_job.blade.php ENDPATH**/ ?>