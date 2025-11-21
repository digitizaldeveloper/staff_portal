
<?php $__env->startSection('page-heading', 'Timesheets'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">

    
    <div class="px-6 py-6 border-b border-gray-200">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-xl font-bold text-gray-900">Timesheets</h1>
        </div>
    </div>

    
    <div class="px-6 py-6 border-b border-gray-200 bg-gray-50">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Staff</label>
                <select name="staff_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">All Staff</option>
                    <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>" 
                            <?php echo e(request('staff_id') == $user->id ? 'selected' : ''); ?>>
                            <?php echo e($user->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Client</label>
                <select name="client_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">All Clients</option>
                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($client->id); ?>"
                            <?php echo e(request('client_id') == $client->id ? 'selected' : ''); ?>>
                            <?php echo e($client->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">From</label>
                <input type="date" name="from" value="<?php echo e(request('from')); ?>" class="w-full border border-gray-300 p-2 rounded">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">To</label>
                <input type="date" name="to" value="<?php echo e(request('to')); ?>" class="w-full border border-gray-300 p-2 rounded">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 p-2 rounded">
                    <option value="">All</option>
                    <option value="pending"  <?php echo e(request('status')=='pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="approved" <?php echo e(request('status')=='approved' ? 'selected' : ''); ?>>Approved</option>
                    <option value="rejected" <?php echo e(request('status')=='rejected' ? 'selected' : ''); ?>>Rejected</option>
                </select>
            </div>

            <div class="md:col-span-5 flex gap-2">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm transition">Filter</button>

                <a href="<?php echo e(route('admin.timesheets.export')); ?>"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm transition">
                   Export CSV
                </a>
            </div>

        </form>
    </div>

    
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Staff</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Client</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Date</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Hours</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Status</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            <?php $__currentLoopData = $timesheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sheet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm text-gray-900 font-medium"><?php echo e($sheet->staff->name); ?></td>
                <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($sheet->client->name); ?></td>
                <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($sheet->date); ?></td>
                <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($sheet->total_hours); ?> hrs</td>
                <td class="px-6 py-4 text-sm">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                        <?php if($sheet->status=='pending'): ?> bg-yellow-100 text-yellow-800
                        <?php elseif($sheet->status=='approved'): ?> bg-green-100 text-green-800
                        <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                        <?php echo e(ucfirst($sheet->status)); ?>

                    </span>
                </td>

                <td class="px-6 py-4 text-sm">
                    <a href="<?php echo e(route('admin.timesheets.show', $sheet->id)); ?>"
                       class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded text-sm transition">
                       View
                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>

    </table>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/admin/timesheets/index.blade.php ENDPATH**/ ?>