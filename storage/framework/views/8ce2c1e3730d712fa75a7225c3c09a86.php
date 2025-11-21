

<?php $__env->startSection('page-heading', 'My Certifications'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto p-6 space-y-6">

    <div class="rounded-2xl border border-gray-200 bg-white px-6 py-5 shadow-sm">
        <h2 class="text-2xl font-semibold text-gray-900">My Certifications</h2>
        <p class="text-sm text-gray-500">Monitor compliance status and keep documents up to date.</p>
    </div>

    <div class="grid grid-cols-1 gap-6">

        <?php $__empty_1 = true; $__currentLoopData = $certs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $badgeMap = [
                'valid' => 'bg-emerald-100 text-emerald-700',
                'expired' => 'bg-rose-100 text-rose-700',
                'warning' => 'bg-amber-100 text-amber-700',
            ];
            $badgeClass = $badgeMap[$cert->status] ?? 'bg-gray-100 text-gray-600';
        ?>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900"><?php echo e($cert->name); ?></h3>
                    <p class="text-sm text-gray-500">#<?php echo e($cert->number); ?></p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold <?php echo e($badgeClass); ?>">
                    <span class="h-2 w-2 rounded-full bg-current"></span>
                    <?php echo e(ucfirst($cert->status)); ?>

                </span>
            </div>

            <dl class="mt-4 grid gap-4 text-sm text-gray-600 sm:grid-cols-3">
                <div>
                    <dt class="font-semibold text-gray-500">Issued</dt>
                    <dd class="text-gray-900"><?php echo e($cert->issue_date); ?></dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-500">Expiry</dt>
                    <dd class="text-gray-900"><?php echo e($cert->expiry_date); ?></dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-500">Document</dt>
                    <dd>
                        <?php if($cert->document): ?>
                            <a href="<?php echo e(asset($cert->document)); ?>" target="_blank"
                               class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700">
                                View approved file
                            </a>
                        <?php else: ?>
                            <span class="text-gray-400">Not uploaded</span>
                        <?php endif; ?>
                    </dd>
                </div>
            </dl>

            <div class="mt-6 rounded-2xl border border-gray-100 bg-gray-50 p-4">
                <form action="/staff/certifications/upload/<?php echo e($cert->id); ?>" method="POST" enctype="multipart/form-data" class="space-y-3">
                    <?php echo csrf_field(); ?>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Upload updated document</label>
                        <input type="file" name="document"
                               class="block w-full rounded-2xl border border-dashed border-gray-300 bg-white px-4 py-3 text-sm text-gray-600 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <button class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700">
                        Upload for review
                    </button>
                </form>

                <?php if($cert->pending_document): ?>
                    <p class="mt-3 text-sm font-semibold text-amber-600">Pending admin approval…</p>
                <?php elseif(!$cert->pending_document && $cert->status == 'rejected'): ?>
                    <p class="mt-3 text-sm font-semibold text-rose-600">Previous document was rejected. Please upload a new one.</p>
                <?php endif; ?>
            </div>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="rounded-2xl border border-dashed border-gray-200 bg-white p-10 text-center text-sm text-gray-500">
                No certifications have been linked to your profile yet.
            </div>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/staff/certifications.blade.php ENDPATH**/ ?>