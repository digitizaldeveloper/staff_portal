<!doctype html>
<html lang="en" class="h-full bg-gray-50">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?php echo $__env->yieldContent('title','Admin Dashboard'); ?></title>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome (for sidebar icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
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

    <?php
      $userRole = strtolower((string) optional(auth()->user())->role);
    ?>

    <?php if(auth()->check() && str_contains($userRole, 'admin')): ?>
      <?php echo $__env->make('layouts.admin_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php elseif(auth()->check() && str_contains($userRole, 'staff')): ?>
      <?php echo $__env->make('layouts.staff_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
      
      <?php echo $__env->make('layouts.staff_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
            <!-- <div class="hidden md:block">
              <input type="text" placeholder="Search..."
                     class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:ring-2 focus:ring-brand-500" />
            </div> -->

            <!-- Notifications + User dropdown -->
            <div class="flex items-center gap-3">
              <!-- Notification Bell -->
              <div class="relative">
                <button id="notifBellBtn" type="button" class="relative p-2 rounded-md hover:bg-gray-100 focus:outline-none" aria-expanded="false">
                  <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                  </svg>
                  <span id="notifBadge" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">3</span>
                </button>

                <!-- Notification dropdown (dynamic) -->
                <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-96 rounded-md shadow-soft bg-white ring-1 ring-black ring-opacity-5 z-50">
                  <div class="py-3 px-4 border-b">
                    <div class="flex items-center justify-between">
                      <p class="font-medium text-gray-900">Notifications</p>
                      <button id="markAllReadBtn" class="text-sm text-blue-600 hover:underline">Mark all as read</button>
                    </div>
                  </div>
                  <div id="notifContainer" class="max-h-72 overflow-y-auto">
                    <div class="p-4 text-center text-gray-500">Loading...</div>
                  </div>
                  <div class="p-3 border-t text-center">
                    <a href="" class="text-sm text-blue-600 hover:underline">View all notifications</a>
                  </div>
                </div>
              </div>

              <!-- User dropdown -->
              <div class="relative">
                <button id="userDropdownBtn" type="button" class="flex items-center rounded-md focus:outline-none" aria-expanded="false">
                  <img src="https://i.pravatar.cc/40" alt="Avatar" class="h-9 w-9 rounded-full border" />
                </button>

                <div id="userDropdown" class="hidden absolute right-0 mt-2 w-56 rounded-md shadow-soft bg-white ring-1 ring-black ring-opacity-5 z-50">
                  <div class="py-3 px-4 border-b">
                    <p class="font-medium text-gray-900"><?php echo e(Auth::user()->name); ?></p>
                    <p class="text-sm text-gray-500"><?php echo e(Auth::user()->role ?? 'Staff'); ?></p>
                  </div>
                  <div class="py-1">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                      <?php echo csrf_field(); ?>
                      <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Log Out</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </header>
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

  <script>
    // Dynamic Notifications System with AJAX
    (function () {
      const userBtn = document.getElementById('userDropdownBtn');
      const userMenu = document.getElementById('userDropdown');

      const notifBtn = document.getElementById('notifBellBtn');
      const notifMenu = document.getElementById('notifDropdown');
      const notifBadge = document.getElementById('notifBadge');
      const notifContainer = document.getElementById('notifContainer');
      const markAllReadBtn = document.getElementById('markAllReadBtn');

      const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

      // Utility: toggle menu visibility
      function toggleMenu(menu, btn, open) {
        if (!menu || !btn) return;
        if (open) {
          menu.classList.remove('hidden');
          btn.setAttribute('aria-expanded', 'true');
        } else {
          menu.classList.add('hidden');
          btn.setAttribute('aria-expanded', 'false');
        }
      }

      // Fetch and render notifications
      async function loadNotifications() {
        try {
          const response = await fetch('/api/notifications/recent');
          const notifications = await response.json();

          if (!Array.isArray(notifications)) {
            notifContainer.innerHTML = '<div class="p-4 text-center text-gray-500">No notifications</div>';
            return;
          }

          if (notifications.length === 0) {
            notifContainer.innerHTML = '<div class="p-4 text-center text-gray-500">No notifications</div>';
            return;
          }

          notifContainer.innerHTML = notifications.map(notif => `
            <div class="notif-item ${!notif.is_read ? 'unread' : 'read'} flex items-start justify-between px-4 py-3 border-b hover:bg-gray-50" data-id="${notif.id}">
              <div class="flex items-start gap-3">
                <span class="inline-flex items-center justify-center mt-1">
                  <svg class="w-4 h-4 ${!notif.is_read ? 'text-blue-500' : 'text-gray-300'}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM8 17a2 2 0 104 0H8z" />
                  </svg>
                </span>
                <div>
                  <p class="font-medium ${!notif.is_read ? 'text-gray-900' : 'text-gray-500'}">${escapeHtml(notif.title)}</p>
                  <p class="text-xs ${!notif.is_read ? 'text-gray-600' : 'text-gray-400'}">${escapeHtml(notif.message)}</p>
                </div>
              </div>
              <div class="flex-shrink-0 ml-4">
                <button class="mark-read text-sm text-gray-500 hover:text-blue-600" data-notif-id="${notif.id}">
                  ${!notif.is_read ? 'Make as read' : 'Read'}
                </button>
              </div>
            </div>
          `).join('');

          // Attach mark-read handlers
          notifContainer.querySelectorAll('.mark-read').forEach(btn => {
            btn.addEventListener('click', (e) => {
              e.stopPropagation();
              const notifId = btn.getAttribute('data-notif-id');
              markNotificationAsRead(notifId);
            });
          });

          // Update badge count
          updateUnreadCount();
        } catch (error) {
          console.error('Error loading notifications:', error);
          notifContainer.innerHTML = '<div class="p-4 text-center text-gray-500">Error loading notifications</div>';
        }
      }

      // Mark single notification as read
      async function markNotificationAsRead(notifId) {
        try {
          const response = await fetch(`/api/notifications/${notifId}/mark-read`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': CSRF_TOKEN,
            },
          });

          if (response.ok) {
            // Reload notifications to refresh UI
            loadNotifications();
          }
        } catch (error) {
          console.error('Error marking as read:', error);
        }
      }

      // Mark all as read
      async function markAllAsRead() {
        try {
          const response = await fetch('/api/notifications/mark-all-read', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': CSRF_TOKEN,
            },
          });

          if (response.ok) {
            loadNotifications();
          }
        } catch (error) {
          console.error('Error marking all as read:', error);
        }
      }

      // Update unread count badge
      async function updateUnreadCount() {
        try {
          const response = await fetch('/api/notifications/unread-count');
          const data = await response.json();
          const count = data.unread_count || 0;

          if (count > 0) {
            notifBadge.textContent = count;
            notifBadge.classList.remove('hidden');
          } else {
            notifBadge.classList.add('hidden');
            notifBadge.textContent = '0';
          }
        } catch (error) {
          console.error('Error updating unread count:', error);
        }
      }

      // Utility: escape HTML
      function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
      }

      // User dropdown
      if (userBtn && userMenu) {
        userBtn.addEventListener('click', function (e) {
          e.stopPropagation();
          const willOpen = userMenu.classList.contains('hidden');
          if (notifMenu) toggleMenu(notifMenu, notifBtn, false);
          toggleMenu(userMenu, userBtn, willOpen);
        });
      }

      // Notification dropdown
      if (notifBtn && notifMenu) {
        notifBtn.addEventListener('click', function (e) {
          e.stopPropagation();
          const willOpen = notifMenu.classList.contains('hidden');
          if (userMenu) toggleMenu(userMenu, userBtn, false);
          toggleMenu(notifMenu, notifBtn, willOpen);
          // Load notifications when opening
          if (willOpen) {
            loadNotifications();
          }
        });
      }

      // Mark all as read button
      if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function (e) {
          e.stopPropagation();
          markAllAsRead();
        });
      }

      // Close on outside click
      document.addEventListener('click', function () {
        if (userMenu) toggleMenu(userMenu, userBtn, false);
        if (notifMenu) toggleMenu(notifMenu, notifBtn, false);
      });

      // Close on Escape
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
          if (userMenu) toggleMenu(userMenu, userBtn, false);
          if (notifMenu) toggleMenu(notifMenu, notifBtn, false);
        }
      });

      // Initialize unread count on page load
      updateUnreadCount();
      // Refresh unread count every 30 seconds
      setInterval(updateUnreadCount, 30000);
    })();
  </script>
</body>
</html>
<?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/layouts/app.blade.php ENDPATH**/ ?>