

<?php $__env->startSection('page-heading', 'Edit Payslip'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto py-10 px-6">

    <h2 class="text-2xl font-semibold mb-6 text-gray-800"></h2>

    <div class="bg-white shadow rounded-lg p-6">

        <form action="<?php echo e(route('admin.payslips.update', $payslip->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

            <!-- Staff -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Select Staff</label>
                <select name="staff_id"
                        class="w-full p-2 border rounded focus:ring focus:border-blue-400">
                    <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>" <?php echo e($payslip->staff_id == $user->id ? 'selected' : ''); ?>>
                            <?php echo e($user->name); ?> (<?php echo e($user->email); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['staff_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Pay Period -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Pay Period</label>
                <input type="month" name="pay_period"
                       value="<?php echo e($payslip->pay_period); ?>"
                       class="w-full p-2 border rounded focus:ring focus:border-blue-400">
                <?php $__errorArgs = ['pay_period'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Replace PDF -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Replace PDF (optional)</label>
                <input type="file" name="file" class="w-full p-2 border rounded bg-gray-50">

                <p class="text-sm text-gray-500 mt-2">
                    Existing File: <strong><?php echo e($payslip->file_path); ?></strong>
                </p>
            </div>

            <button class="w-full py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg shadow">
                Update Payslip
            </button>

        </form>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/admin/payslips/edit.blade.php ENDPATH**/ ?>