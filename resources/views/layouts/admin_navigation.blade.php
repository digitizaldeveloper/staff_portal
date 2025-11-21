 @php
  // Allow children to control layout parts
  $showSidebar = trim($__env->yieldContent('sidebar', '1')) !== '0';
  $showTopbar  = trim($__env->yieldContent('topbar',  '1')) !== '0';
@endphp
 @if($showSidebar)
      <!-- Sidebar -->
      <aside class="hidden lg:block w-72 bg-white border-r border-gray-200 p-4">
        @section('sidebar-header')
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold">Admin Panel</h2>
            <span class="text-[11px] rounded-md bg-brand-50 text-brand-700 ring-1 ring-inset ring-brand-100 px-2 py-0.5">
              v1.0
            </span>
          </div>
        @show

       
        <nav class="space-y-2 text-sm overflow-y-auto max-h-[calc(100vh-150px)] pr-2" style="scrollbar-width: thin; scrollbar-color: #d1d5db #f3f4f6;">
          <style>
            nav::-webkit-scrollbar { width: 6px; }
            nav::-webkit-scrollbar-track { background: #f3f4f6; border-radius: 3px; }
            nav::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
            nav::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
          </style>
  @section('sidebar')

    {{-- STAFF --}}
    <div class="px-3 pt-2 text-[11px] uppercase tracking-wider text-gray-500">Admin Navigation</div>

    

    {{-- Blog Categories --}}
    <div class="">
      <button type="button" class="w-full text-left flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-50" data-toggle="menu-blog-categories">
        <span class="flex items-center gap-3">
          <!-- Icon: tags -->
          <i class="fas fa-tags fa-fw text-lg text-gray-800" aria-hidden="true"></i>
          <span class="text-base text-gray-800">Blog Categories</span>
        </span>
        <svg class="w-4 h-4 text-gray-400 transform transition-transform" data-chevron-for="menu-blog-categories" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
        </svg>
      </button>
      <div id="menu-blog-categories" class="mt-2 ml-2 hidden flex-col text-sm space-y-1">
        <a href="{{ route('admin.blog_categories.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">All Categories</a>
        <a href="{{ route('admin.blog_categories.create') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">Add New Category</a>
      </div>
    </div>

    {{-- Blogs --}}
    <div class="">
      <button type="button" class="w-full text-left flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-50" data-toggle="menu-blogs">
        <span class="flex items-center gap-3">
          <!-- Icon: file-alt -->
          <i class="fas fa-file-alt fa-fw text-lg text-gray-800" aria-hidden="true"></i>
          <span class="text-base text-gray-800">Blogs</span>
        </span>
        <svg class="w-4 h-4 text-gray-400 transform transition-transform" data-chevron-for="menu-blogs" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
        </svg>
      </button>
      <div id="menu-blogs" class="mt-2 ml-2 hidden flex-col text-sm space-y-1">
        <a href="{{ route('admin.blogs.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">All Blogs</a>
        <a href="{{ route('admin.blogs.create') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">Add New Blog</a>
      </div>
    </div>

    {{-- Jobs --}}
    <div class="">
      <button type="button" class="w-full text-left flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-50" data-toggle="menu-jobs">
        <span class="flex items-center gap-3">
          <!-- Icon: briefcase -->
          <i class="fas fa-briefcase fa-fw text-lg text-gray-800" aria-hidden="true"></i>
          <span class="text-base text-gray-800">Jobs</span>
        </span>
        <svg class="w-4 h-4 text-gray-400 transform transition-transform" data-chevron-for="menu-jobs" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
        </svg>
      </button>
      <div id="menu-jobs" class="mt-2 ml-2 hidden flex-col text-sm space-y-1">
        <a href="{{ route('admin.jobs.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">All Jobs</a>
        <a href="{{ route('admin.jobs.create') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">Add Job</a>
        <a href="{{ route('admin.job.job_applications') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">Job Applications</a>
      </div>
    </div>
    {{-- Staff --}}
    <div class="">
      <button type="button" class="w-full text-left flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-50" data-toggle="menu-staff">
        <span class="flex items-center gap-3">
          <!-- Icon: users -->
          <i class="fas fa-users fa-fw text-lg text-gray-800" aria-hidden="true"></i>
          <span class="text-base text-gray-800">Staffs</span>
        </span>
        <svg class="w-4 h-4 text-gray-400 transform transition-transform" data-chevron-for="menu-staff" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
        </svg>
      </button>
      <div id="menu-staff" class="mt-2 ml-2 hidden flex-col text-sm space-y-1">
        <a href="{{ route('admin.staff.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">All Staffs</a>
        <a href="{{ route('admin.staff.create') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">Add Staff</a>
      </div>
    </div>
    {{-- client --}}
    <div class="">
      <button type="button" class="w-full text-left flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-50" data-toggle="menu-clients">
        <span class="flex items-center gap-3">
          <!-- Icon: users -->
          <i class="fas fa-users fa-fw text-lg text-gray-800" aria-hidden="true"></i>
          <span class="text-base text-gray-800">Clients</span>
        </span>
        <svg class="w-4 h-4 text-gray-400 transform transition-transform" data-chevron-for="menu-clients" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
        </svg>
      </button>
      <div id="menu-clients" class="mt-2 ml-2 hidden flex-col text-sm space-y-1">
        <a href="{{ route('admin.clients.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">All Clients</a>
        <a href="{{ route('admin.clients.create') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">Add Clients</a>
      </div>
    </div>

    {{-- Contact Enquiries --}}
    <div class="">
      <a href="{{ route('admin.contact_enquiries') }}" class="block w-full text-left flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50">
        <!-- Icon: envelope -->
        <i class="fas fa-envelope fa-fw text-lg text-gray-800" aria-hidden="true"></i>
        <span class="text-base text-gray-800">Contact Enquiries</span>
      </a>
    </div>

    {{-- Timesheets --}}
    <div class="">
      <a href="{{ route('admin.timesheets.index') }}" class="block w-full text-left flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50">
        <!-- Icon: clock -->
        <i class="fas fa-clock fa-fw text-lg text-gray-800" aria-hidden="true"></i>
        <span class="text-base text-gray-800">Timesheets Management</span>
      </a>
    </div>

    {{-- Payslips --}}
    <div class="">
      <button type="button" class="w-full text-left flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-50" data-toggle="menu-payslips">
        <span class="flex items-center gap-3">
         <!-- Icon: file-invoice -->
         <i class="fas fa-file-invoice fa-fw text-lg text-gray-800" aria-hidden="true"></i>
        <span class="text-base text-gray-800">Payslips</span>
        </span>
        <svg class="w-4 h-4 text-gray-400 transform transition-transform" data-chevron-for="menu-payslips" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
        </svg>
      </button>
      <div id="menu-payslips" class="mt-2 ml-2 hidden flex-col text-sm space-y-1">
        <a href="{{ route('admin.payslips.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">All Payslips</a>
        <a href="{{ route('admin.payslips.create') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">Add Payslips</a>
      </div>
    </div>

   
{{-- Certifications --}}
    <div class="">
      <button type="button" class="w-full text-left flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-50" data-toggle="menu-certifications">
        <span class="flex items-center gap-3">
        <!-- Icon: certificate -->
        <i class="fas fa-certificate fa-fw text-lg text-gray-800" aria-hidden="true"></i>
        <span class="text-base text-gray-800">Certifications</span>
        </span>
        <svg class="w-4 h-4 text-gray-400 transform transition-transform" data-chevron-for="menu-certifications" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
        </svg>
      </button>
      <div id="menu-certifications" class="mt-2 ml-2 hidden flex-col text-sm space-y-1">
        <a href="{{ route('admin.certifications.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">All Certifications</a>
        <a href="{{ route('admin.certifications.create') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">Add Certification</a>
      </div>
    </div>

    

  @show
</nav>



        
      </aside>
    @endif

    <!-- Mobile Sidebar (drawer) -->
    @if($showSidebar)
      <div id="mobileDrawer" class="fixed inset-0 z-50 hidden lg:hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-black/30" data-drawer-close></div>
        <aside class="absolute left-0 top-0 h-full w-72 bg-white border-r border-gray-200 p-4 shadow-soft">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold">Admin Panel</h2>
            <button class="rounded-md border px-2 py-1 text-sm hover:bg-gray-50" data-drawer-close>✕</button>
          </div>
          <nav class="space-y-2 text-sm">
            @yield('sidebar')
          </nav>
          @hasSection('sidebar-footer')
            <div class="mt-6 pt-4 border-t border-gray-200">
              @yield('sidebar-footer')
            </div>
          @endif
        </aside>
      </div>
    @endif

      <script>
        // Simple sidebar dropdown toggle for admin navigation
        (function () {
          document.querySelectorAll('[data-toggle]').forEach(btn => {
            btn.addEventListener('click', function (e) {
              e.preventDefault();
              const id = btn.getAttribute('data-toggle');
              const panel = document.getElementById(id);
              if (!panel) return;
              const chevron = document.querySelector('[data-chevron-for="' + id + '"]');
              const isHidden = panel.classList.contains('hidden');
              if (isHidden) {
                panel.classList.remove('hidden');
                if (chevron) chevron.classList.add('rotate-180');
              } else {
                panel.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
              }
            });
          });
        })();
      </script>