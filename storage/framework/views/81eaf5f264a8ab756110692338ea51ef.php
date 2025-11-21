

<?php $__env->startSection('page-heading', 'Notifications'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Notifications</h1>
        
        <?php if($notifications->count() > 0): ?>
            <div class="flex gap-2">
                <form action="<?php echo e(route('notifications.mark-all-read')); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                        Mark All as Read
                    </button>
                </form>
                <form action="<?php echo e(route('notifications.clear-all')); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm" onclick="return confirm('Are you sure?')">
                        Clear All
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <?php if($notifications->count() > 0): ?>
        <div class="space-y-3">
            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white border-l-4 <?php echo e($notification->isRead() ? 'border-gray-300' : 'border-blue-500'); ?> rounded-lg p-4 flex justify-between items-start hover:shadow-md transition">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-semibold <?php echo e($notification->isRead() ? 'text-gray-600' : 'text-gray-900'); ?>">
                                <?php echo e($notification->title); ?>

                            </h3>
                            <?php if(!$notification->isRead()): ?>
                                <span class="inline-block w-3 h-3 bg-blue-500 rounded-full"></span>
                            <?php endif; ?>
                        </div>
                        
                        <p class="text-gray-600 mt-1"><?php echo e($notification->message); ?></p>
                        
                        <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">
                            <span class="inline-block px-2 py-1 bg-gray-100 rounded text-xs font-medium">
                                <?php echo e(ucfirst(str_replace('_', ' ', $notification->type))); ?>

                            </span>
                            <time><?php echo e($notification->created_at->diffForHumans()); ?></time>
                        </div>
                    </div>

                    <div class="flex gap-2 ml-4">
                        <?php if(!$notification->isRead()): ?>
                            <form action="<?php echo e(route('notifications.mark-read', $notification)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm px-2 py-1 hover:bg-blue-50 rounded" title="Mark as read">
                                    ✓
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <form action="<?php echo e(route('notifications.destroy', $notification)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm px-2 py-1 hover:bg-red-50 rounded" title="Delete">
                                ✕
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <?php echo e($notifications->links()); ?>

        </div>
    <?php else: ?>
        <div class="bg-gray-50 rounded-lg p-12 text-center">
            <p class="text-gray-600 text-lg">You have no notifications yet.</p>
        </div>
    <?php endif; ?>
</div>

<script>
    // Auto-refresh unread count every 10 seconds
    function refreshNotifications() {
        fetch('<?php echo e(route("notifications.unread-count")); ?>')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('notification-badge');
                if (badge) {
                    if (data.unread_count > 0) {
                        badge.textContent = data.unread_count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }
            });
    }

    // Refresh on page load
    refreshNotifications();
    
    // Refresh every 10 seconds
    setInterval(refreshNotifications, 10000);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/notifications/index.blade.php ENDPATH**/ ?>