
<?php $__env->startSection('page-heading', 'Blogs'); ?>
<?php $__env->startSection('content'); ?>

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
    
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h3>Blogs</h3>
        </div>
        <a href="<?php echo e(route('admin.blogs.create')); ?>"
           class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded-lg shadow-sm transition">
            + 
        </a>
    </div>

    
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">ID</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Title</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Image</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Category</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Status</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($blog->id); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-900 font-medium"><?php echo e($blog->title); ?></td>
                    <td class="px-6 py-4 text-sm">
                        <?php if($blog->image): ?>
                            <img src="<?php echo e(asset('images/'.$blog->image)); ?>" 
                                 class="h-10 w-10 rounded-lg object-cover border border-gray-200">
                        <?php else: ?>
                            <span class="text-gray-400">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($blog->category->title ?? '—'); ?></td>
                    <td class="px-6 py-4 text-sm">
                        <?php
                            $badgeClass = match($blog->status) {
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'active'  => 'bg-green-100 text-green-800',
                                'paused'  => 'bg-red-100 text-red-800',
                                default   => 'bg-gray-100 text-gray-600',
                            };
                        ?>
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?php echo e($badgeClass); ?>">
                            <?php echo e(ucfirst($blog->status)); ?>

                        </span>
                    </td>

                    <td class="px-6 py-4 text-sm flex gap-2">
                        <a href="<?php echo e(route('admin.blogs.edit', $blog->id)); ?>"
                           class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded text-sm transition">
                           <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
                        </a>
                        <button onclick="openModal(<?php echo e($blog->id); ?>)"
                                class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12" />
        </svg>
                        </button>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
     
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <?php echo e($blogs->links()); ?>

    </div>
</div>


<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-80 text-center shadow-lg">
        <h2 class="text-xl font-semibold mb-2 text-gray-900">Delete Blog?</h2>
        <p class="text-sm text-gray-600 mb-6">Are you sure you want to delete this blog?</p>

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

<script>
function openModal(id) {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteForm').action = '/admin/blogs/delete/' + id;
}
function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/admin/blogs/index.blade.php ENDPATH**/ ?>