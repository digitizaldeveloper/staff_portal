
<?php $__env->startSection('page-heading', 'Edit Blog'); ?>
<?php $__env->startSection('content'); ?>

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden max-w-5xl mx-auto">
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-2xl font-bold text-gray-900">Edit Blog</h1>
        </div>
        <a href="<?php echo e(route('admin.blogs.index')); ?>" class="text-gray-600 hover:underline">Back</a>
    </div>

    <div class="px-6 py-6">
        <form action="<?php echo e(route('admin.blogs.update', $blog->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" value="<?php echo e($blog->title); ?>" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                    <select name="category_id" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c->id); ?>" <?php if($blog->category_id == $c->id): echo 'selected'; endif; ?>><?php echo e($c->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Featured Image</label>
                    <input type="file" name="image" class="w-full border border-gray-300 px-4 py-2 rounded bg-white">
                    <?php if($blog->image): ?>
                        <img src="<?php echo e(asset('images/'.$blog->image)); ?>" class="h-20 mt-3 rounded border">
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                        <option value="">Select Status</option>
                        <option value="pending" <?php echo e(old('status', $blog->status) == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="active" <?php echo e(old('status', $blog->status) == 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="paused" <?php echo e(old('status', $blog->status) == 'paused' ? 'selected' : ''); ?>>Paused</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Short Description</label>
                <textarea name="short_description" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring"><?php echo e($blog->short_description); ?></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Content</label>
                <textarea name="content" rows="6" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring"><?php echo e($blog->content); ?></textarea>
            </div>

            <div class="flex items-center gap-3">
                <button class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
                <a href="<?php echo e(route('admin.blogs.index')); ?>" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/admin/blogs/edit.blade.php ENDPATH**/ ?>