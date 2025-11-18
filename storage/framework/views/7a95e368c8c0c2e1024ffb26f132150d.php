<!doctype html>
<html lang="en" class="h-full bg-gray-50">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?php echo $__env->yieldContent('title','Admin Dashboard'); ?></title>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: { 50:'#eef4ff',100:'#d9e6ff',500:'#2f74ff',600:'#2563eb',700:'#1e4fc7' }
          },
          boxShadow: {
            soft: '0 2px 8px rgba(0,0,0,0.06)',
          }
        }
      }
    }
  </script>

  <?php echo $__env->yieldPushContent('styles'); ?>
  <?php echo $__env->yieldContent('head'); ?>
</head>
<body class="h-full">
<?php
  // Allow children to control layout parts
  $showSidebar = trim($__env->yieldContent('sidebar', '1')) !== '0';
  $showTopbar  = trim($__env->yieldContent('topbar',  '1')) !== '0';
?>

  <div class="min-h-screen flex">

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

    
    <div class="px-3 pt-2 text-[11px] uppercase tracking-wider text-gray-500">Staff</div>

    <a href="<?php echo e(route('staff.profile-timesheets')); ?>"
       class="block px-3 py-2 rounded-lg <?php echo e(request()->routeIs('staff.profile-timesheets') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50'); ?>">
      🙍 Profile & Timesheets
    </a>

    <a href="<?php echo e(route('staff.timesheets-payslips')); ?>"
       class="block px-3 py-2 rounded-lg <?php echo e(request()->routeIs('staff.timesheets-payslips') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50'); ?>">
      🕒 Timesheets & Payslips
    </a>

    <a href="<?php echo e(route('staff.payslips-personal')); ?>"
       class="block px-3 py-2 rounded-lg <?php echo e(request()->routeIs('staff.payslips-personal') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50'); ?>">
      🧾 My Payslips
    </a>

    <a href="<?php echo e(route('staff.certifications')); ?>"
       class="block px-3 py-2 rounded-lg <?php echo e(request()->routeIs('staff.certifications') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50'); ?>">
      🎓 Certifications & Notifications
    </a>

    
    <div class="px-3 pt-4 text-[11px] uppercase tracking-wider text-gray-500">Admin</div>

    <a href="<?php echo e(route('admin.staff-management')); ?>"
       class="block px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.staff-management') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50'); ?>">
      👥 Staff Management
    </a>

    <a href="<?php echo e(route('admin.timesheets')); ?>"
       class="block px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.timesheets') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50'); ?>">
      📋 Timesheets Review
    </a>

    <a href="<?php echo e(route('admin.payroll')); ?>"
       class="block px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.payroll') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50'); ?>">
      💸 Payroll / Payslips
    </a>

    <a href="<?php echo e(route('admin.jobs-applications')); ?>"
       class="block px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.jobs-applications') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50'); ?>">
      📄 Jobs & Applications
    </a>

  <?php echo $__env->yieldSection(); ?>
</nav>



        <?php if (! empty(trim($__env->yieldContent('sidebar-footer')))): ?>
          <div class="mt-6 pt-4 border-t border-gray-200">
            <?php echo $__env->yieldContent('sidebar-footer'); ?>
          </div>
        <?php endif; ?>
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
    <?php endif; ?>

    <!-- Main Content -->
    <main class="flex-1 min-w-0">
      <?php if($showTopbar): ?>
        <!-- Topbar -->
        <header class="border-b border-gray-200 bg-white p-4 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <?php if($showSidebar): ?>
              <button class="lg:hidden rounded-lg border px-3 py-1.5 text-sm hover:bg-gray-50" id="btnOpenDrawer">Menu</button>
            <?php endif; ?>
            <h1 class="text-xl font-semibold truncate">
              <?php echo $__env->yieldContent('page-heading','Dashboard'); ?>
            </h1>
            <?php if (! empty(trim($__env->yieldContent('breadcrumbs')))): ?>
              <div class="hidden md:block text-xs text-gray-500 pl-2">
                <?php echo $__env->yieldContent('breadcrumbs'); ?>
              </div>
            <?php endif; ?>
          </div>
          <div class="flex items-center gap-3">
            <?php echo $__env->yieldContent('topbar-right'); ?>
            <div class="hidden md:block">
              <input type="text" placeholder="Search..."
                     class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:ring-2 focus:ring-brand-500" />
            </div>
            <img src="https://i.pravatar.cc/40" alt="Avatar" class="h-9 w-9 rounded-full border" />
          </div>
        </header>
      <?php endif; ?>

      <!-- Flash / Alerts -->
      <?php if(session('status') || $errors->any()): ?>
        <div class="p-4">
          <?php if(session('status')): ?>
            <div class="mb-3 rounded-lg bg-green-50 text-green-700 px-4 py-2 text-sm ring-1 ring-inset ring-green-600/20">
              <?php echo e(session('status')); ?>

            </div>
          <?php endif; ?>
          <?php if($errors->any()): ?>
            <div class="rounded-lg bg-red-50 text-red-700 px-4 py-2 text-sm ring-1 ring-inset ring-red-600/20">
              <ul class="list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><?php echo e($e); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <!-- Main slot -->
      <div class="p-6">
        <?php echo $__env->yieldContent('content'); ?>
      </div>

      <!-- Footer -->
      <footer class="p-4 text-center text-xs text-gray-500">
        <?php echo $__env->yieldContent('footer','© ' . now()->year . ' Admin. All rights reserved.'); ?>
      </footer>
    </main>
  </div>

  <?php echo $__env->yieldPushContent('scripts'); ?>

  
  <script>
    (function () {
      const openBtn = document.getElementById('btnOpenDrawer');
      const drawer  = document.getElementById('mobileDrawer');
      if (!openBtn || !drawer) return;
      const closeEls = drawer.querySelectorAll('[data-drawer-close]');

      openBtn.addEventListener('click', () => drawer.classList.remove('hidden'));
      closeEls.forEach(el => el.addEventListener('click', () => drawer.classList.add('hidden')));
    })();
  </script>
</body>
</html>
<?php /**PATH C:\laragon\www\staff-portal\resources\views/layouts/app.blade.php ENDPATH**/ ?>