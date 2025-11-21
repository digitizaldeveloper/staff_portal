
<?php $__env->startSection('page-heading', 'My Timesheets'); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">

    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">My Timesheets</h1>
            <p class="text-sm text-gray-500">Track submissions and approval status</p>
            </div>
        <a href="<?php echo e(route('staff.timesheets.create')); ?>"
           class="inline-flex items-center gap-2 rounded-full bg-green-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-green-700">
            <span class="text-lg leading-none">+</span>
            
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>


            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Date</th>
                        <th class="px-6 py-4 text-left font-semibold">Client / Site</th>
                        <th class="px-6 py-4 text-left font-semibold">Hours</th>
                        <th class="px-6 py-4 text-left font-semibold">Admin Note</th>
                        <th class="px-6 py-4 text-left font-semibold">Status</th>
                        <th class="px-6 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    <?php $__empty_1 = true; $__currentLoopData = $timesheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $statusStyles = [
                                'pending' => 'bg-amber-100 text-amber-700',
                                'approved' => 'bg-emerald-100 text-emerald-700',
                                'rejected' => 'bg-rose-100 text-rose-700',
                            ];
                            $badgeClass = $statusStyles[$ts->status] ?? 'bg-gray-100 text-gray-600';
                        ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900"><?php echo e(\Carbon\Carbon::parse($ts->date)->format('d M Y')); ?></div>
                                <div class="text-xs text-gray-400">#<?php echo e(str_pad($ts->id, 4, '0', STR_PAD_LEFT)); ?></div>
                            </td>
                            <td class="px-6 py-4 text-gray-900"><?php echo e($ts->client->name); ?></td>
                            <td class="px-6 py-4 font-semibold text-gray-900"><?php echo e($ts->total_hours); ?> hrs</td>
                            <td class="px-6 py-4 text-gray-500"><?php echo e($ts->admin_notes ?: '—'); ?></td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold <?php echo e($badgeClass); ?>">
                                    <span class="h-2 w-2 rounded-full bg-current"></span>
                                    <?php echo e(ucfirst($ts->status)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <?php if($ts->status == 'pending'): ?>
                                    <div class="inline-flex items-center gap-2">
                                        <a href="<?php echo e(route('staff.timesheets.edit', $ts->id)); ?>"
                                           class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm transition">
                                           <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                           </svg>
                                        </a>
                                         <button onclick="openModal(<?php echo e($ts->id); ?>)"
                                        type="button"
                                                
                                                class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <span class="text-xs font-semibold text-gray-400">Locked</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                No timesheets yet. Submit your first entry to get started.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

 



<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-80 text-center shadow-lg">
        <h2 class="text-xl font-semibold mb-2 text-gray-900">Delete timesheet?</h2>
        <p class="text-sm text-gray-600 mb-6">Are you sure you want to delete this timesheet?</p>

        <form id="deleteForm" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>

            <div class="flex justify-center gap-3">
                <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded text-sm transition">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

<!-- <script>
const modal = document.getElementById('deleteModal');
const deleteForm = document.getElementById('deleteForm');

function openDeleteModal(id) {
    modal.classList.remove('hidden');
    deleteForm.action = "/staff/timesheets/delete/" + id;
}
function closeDeleteModal() {
    modal.classList.add('hidden');
}
</script> -->
<script>
function openModal(id) {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteForm').action = '/staff/timesheets/delete/' + id;
}
function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/staff/timesheets/index.blade.php ENDPATH**/ ?>