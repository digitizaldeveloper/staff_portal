

<?php $__env->startSection('page-heading', 'Apply for Job'); ?>

<?php $__env->startSection('content'); ?>

<div class="mx-auto max-w-5xl px-4 py-10 space-y-6">

    <div class="rounded-3xl border border-gray-200 bg-white shadow-lg">
        <div class="rounded-t-3xl bg-gradient-to-r from-emerald-600 to-emerald-500 px-8 py-10 text-white">
            <p class="text-sm uppercase tracking-[0.2em] text-emerald-100">Apply for</p>
            <h1 class="mt-2 text-4xl font-semibold"><?php echo e($job->title); ?></h1>
            <div class="mt-5 flex flex-wrap gap-4 text-sm font-medium">
                <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-1.5">
                    <?php echo e($job->type); ?>

                </span>
                <span class="inline-flex items-center gap-1 rounded-full bg-white/15 px-4 py-1.5">
                    📍 <?php echo e($job->location ?? 'Flexible location'); ?>

                </span>
                <span class="inline-flex items-center gap-1 rounded-full bg-white/15 px-4 py-1.5">
                    💰 <?php echo e($job->salary ?: 'Salary not disclosed'); ?>

                </span>
            </div>
        </div>

        <div class="px-8 py-8 text-gray-700 leading-relaxed">
            <?php echo nl2br(e($job->description)); ?>

        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="rounded-2xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm text-rose-700 shadow-sm">
            <p class="font-semibold">Please fix the highlighted fields below.</p>
        </div>
    <?php endif; ?>

    <div class="rounded-3xl border border-gray-200 bg-white px-8 py-8 shadow-sm">
        <h2 class="text-2xl font-semibold text-gray-900">Application form</h2>
        <p class="mt-2 text-sm text-gray-500">Share your details and our recruitment team will reach out soon.</p>

        <form action="<?php echo e(route('job.apply.submit', $job->id)); ?>" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
            <?php echo csrf_field(); ?>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-gray-700" for="name">Full name</label>
                    <input type="text" name="name" id="name"
                           value="<?php echo e(old('name')); ?>"
                           class="mt-1 w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700" for="email">Email</label>
                    <input type="email" name="email" id="email"
                           value="<?php echo e(old('email')); ?>"
                           class="mt-1 w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700" for="phone">Phone</label>
                    <input type="text" name="phone" id="phone"
                           value="<?php echo e(old('phone')); ?>"
                           class="mt-1 w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700" for="resume">Resume (PDF, DOC)</label>
                    <input type="file" name="resume" id="resume"
                           class="mt-1 w-full rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-600 focus:border-emerald-500 focus:ring-emerald-500">
                    <?php $__errorArgs = ['resume'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold text-gray-700" for="message">Message (optional)</label>
                <textarea name="message" id="message" rows="4"
                          class="mt-1 w-full rounded-2xl border border-gray-200 px-4 py-3 text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                          placeholder="Tell us why you're a great fit"><?php echo e(old('message')); ?></textarea>
                <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4">
                <p class="text-sm text-gray-500">We’ll respond within 3 business days. Your data stays private.</p>
                <button class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                    Submit application
                </button>
            </div>
        </form>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/apply_job.blade.php ENDPATH**/ ?>