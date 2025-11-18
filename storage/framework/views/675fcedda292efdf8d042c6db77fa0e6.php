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
            brand: { 50:'#eef4ff',100:'#d9e6ff',500:'#2f74ff',700:'#1e4fc7' }
          }
        }
      }
    }
  </script>

  <?php echo $__env->yieldPushContent('styles'); ?>
  <?php echo $__env->yieldContent('head'); ?>
</head>
<body class="h-full">
  <div class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 p-4">
      <?php $__env->startSection('sidebar-header'); ?>
        <h2 class="text-lg font-bold mb-6">Admin Panel</h2>
      <?php echo $__env->yieldSection(); ?>

      <nav class="space-y-2 text-sm">
        <?php $__env->startSection('sidebar'); ?>
          <a href="#" class="block px-3 py-2 rounded-lg bg-gray-100 font-medium">🏠 Dashboard</a>
          <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-50">📦 Products</a>
          <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🧑‍💼 Users</a>
          <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🧾 Orders</a>
          <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-50">⚙️ Settings</a>
        <?php echo $__env->yieldSection(); ?>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1">
      <!-- Topbar -->
      <header class="border-b border-gray-200 bg-white p-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold"><?php echo $__env->yieldContent('page-heading','Dashboard'); ?></h1>
        <div class="flex items-center gap-3">
          <?php echo $__env->yieldContent('topbar-right'); ?>
          <input type="text" placeholder="Search..."
                 class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:ring-2 focus:ring-brand-500" />
          <img src="https://i.pravatar.cc/40" alt="Avatar" class="h-9 w-9 rounded-full border" />
        </div>
      </header>

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
</body>
</html>
<?php /**PATH C:\laragon\www\srtaff-portal\resources\views/welcome.blade.php ENDPATH**/ ?>