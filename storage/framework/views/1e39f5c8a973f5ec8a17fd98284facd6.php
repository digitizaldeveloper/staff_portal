 <?php
  // Allow children to control layout parts
  $showSidebar = trim($__env->yieldContent('sidebar', '1')) !== '0';
  $showTopbar  = trim($__env->yieldContent('topbar',  '1')) !== '0';
?>
 <?php if($showSidebar): ?>
      <!-- Sidebar -->
      <aside class="hidden lg:block w-72 bg-white border-r border-gray-200 p-4">
        <?php $__env->startSection('sidebar-header'); ?>
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold">Admin Panel</h2>
            <span class="text-[11px] rounded-md bg-brand-50 text-brand-700 ring-1 ring-inset ring-brand-100 px-2 py-0.5">
              v1.0
            </span>
          </div>
        <?php echo $__env->yieldSection(); ?>

       
        <nav class="space-y-2 text-sm">
  <?php $__env->startSection('sidebar'); ?>

    
    <div class="px-3 pt-2 text-[11px] uppercase tracking-wider text-gray-500">Admin Navigation</div>

    

    <a href=""
       class="block px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.jobs-applications') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50'); ?>">
      📄 Jobs & Applications
    </a>

  <?php echo $__env->yieldSection(); ?>
</nav>



        
      </aside>
    <?php endif; ?>

    <!-- Mobile Sidebar (drawer) -->
    <?php if($showSidebar): ?>
      <div id="mobileDrawer" class="fixed inset-0 z-50 hidden lg:hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-black/30" data-drawer-close></div>
        <aside class="absolute left-0 top-0 h-full w-72 bg-white border-r border-gray-200 p-4 shadow-soft">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold">Admin Panel</h2>
            <button class="rounded-md border px-2 py-1 text-sm hover:bg-gray-50" data-drawer-close>✕</button>
          </div>
          <nav class="space-y-2 text-sm">
            <?php echo $__env->yieldContent('sidebar'); ?>
          </nav>
          <?php if (! empty(trim($__env->yieldContent('sidebar-footer')))): ?>
            <div class="mt-6 pt-4 border-t border-gray-200">
              <?php echo $__env->yieldContent('sidebar-footer'); ?>
            </div>
          <?php endif; ?>
        </aside>
      </div>
    <?php endif; ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>