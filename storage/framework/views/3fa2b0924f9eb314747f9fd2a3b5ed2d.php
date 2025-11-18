

<?php $__env->startSection('title','Staff Management'); ?>
<?php $__env->startSection('page-heading','Staff Management'); ?>

<?php $__env->startSection('sidebar'); ?>
<a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🏠 Dashboard</a>
<a href="<?php echo e(route('admin.timesheets')); ?>" class="block px-3 py-2 rounded-lg bg-gray-100 font-medium">🕒 Timesheets</a>
<a href="<?php echo e(route('admin.staff-management')); ?>" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🧑‍💼 Staff</a>
<a href="<?php echo e(route('admin.payroll')); ?>" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🧾 Payroll</a>
<a href="<?php echo e(route('admin.jobs-applications')); ?>" class="block px-3 py-2 rounded-lg hover:bg-gray-50">💼 Jobs & Applications</a>
<a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-50">⚙️ Settings</a>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
  use Illuminate\Support\Carbon;

  // ===== Dummy Roles =====
  $roles = ['Admin','Supervisor','Staff'];

  // ===== Dummy Staff Accounts =====
  $staff = collect([
    [
      'id'=>1,'name'=>'Ali Raza','email'=>'ali.raza@example.com','username'=>'ali.raza',
      'role'=>'Supervisor','phone'=>'+92 300 1234567','active'=>true,'created_at'=>Carbon::parse('2024-10-01')
    ],
    [
      'id'=>2,'name'=>'Hina Fatima','email'=>'hina.f@example.com','username'=>'hina.f',
      'role'=>'Staff','phone'=>'+92 311 9988776','active'=>true,'created_at'=>Carbon::parse('2025-01-12')
    ],
    [
      'id'=>3,'name'=>'Ahmed Khan','email'=>'ahmed.khan@example.com','username'=>'ahmed.khan',
      'role'=>'Admin','phone'=>'+92 322 5566778','active'=>false,'created_at'=>Carbon::parse('2023-07-22')
    ],
  ]);

  // ===== Dummy Personal Details (for right-side editor) =====
  $selected = (object)[
    'id'=>2,'name'=>'Hina Fatima','email'=>'hina.f@example.com','username'=>'hina.f','role'=>'Staff',
    'phone'=>'+92 311 9988776','cnic'=>'42101-9876543-2','address'=>'Gulshan-e-Iqbal, Karachi',
    'joining'=>Carbon::parse('2025-01-12'),'dob'=>Carbon::parse('1998-03-21'),'gender'=>'Female',
    'certifications'=>[
      ['name'=>'First Aid Level 1','no'=>'FA-7710','issued'=>Carbon::parse('2024-11-05'),'expires'=>Carbon::parse('2026-11-05')],
      ['name'=>'Security Guard License','no'=>'SG-2025-1188','issued'=>Carbon::parse('2025-01-10'),'expires'=>Carbon::parse('2026-01-10')],
    ],
  ];

  $badge = fn($active) => $active
    ? 'bg-green-50 text-green-700 ring-green-600/20'
    : 'bg-red-50 text-red-700 ring-red-600/20';

  $expBadge = function (Carbon $expires) {
    $days = now()->diffInDays($expires, false);
    if ($days < 0) return 'bg-red-50 text-red-700 ring-red-600/20';
    if ($days <= 30) return 'bg-amber-50 text-amber-800 ring-amber-600/20';
    return 'bg-green-50 text-green-700 ring-green-600/20';
  };
?>

<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
  
  <section class="xl:col-span-2 bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="p-5 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h3 class="text-base font-semibold text-gray-900">Staff Accounts</h3>
        <p class="text-xs text-gray-500">Create and manage staff (username, password, roles).</p>
      </div>
      <div class="flex items-center gap-2">
        <button id="btnExportStaff" class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50">Export CSV</button>
        <button id="btnOpenCreate" class="rounded-lg bg-brand-600 text-white px-3 py-2 text-sm hover:bg-brand-700">+ New Staff</button>
      </div>
    </div>

    <div class="p-5 overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
          <tr class="text-left text-gray-600">
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Username</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Role</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Joined</th>
            <th class="px-4 py-2 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td class="px-4 py-2">
                <div class="font-medium text-gray-900"><?php echo e($s['name']); ?></div>
                <div class="text-xs text-gray-500"><?php echo e($s['phone']); ?></div>
              </td>
              <td class="px-4 py-2 font-mono"><?php echo e($s['username']); ?></td>
              <td class="px-4 py-2"><?php echo e($s['email']); ?></td>
              <td class="px-4 py-2"><?php echo e($s['role']); ?></td>
              <td class="px-4 py-2">
                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?php echo e($badge($s['active'])); ?>">
                  <?php echo e($s['active'] ? 'Active' : 'Inactive'); ?>

                </span>
              </td>
              <td class="px-4 py-2 text-gray-600"><?php echo e($s['created_at']->format('d M Y')); ?></td>
              <td class="px-4 py-2 text-right">
                <div class="inline-flex items-center gap-1">
                  <button class="rounded-md border px-2 py-1 hover:bg-gray-50" data-edit="<?php echo e($s['id']); ?>">Edit</button>
                  <button class="rounded-md border px-2 py-1 hover:bg-gray-50" data-resetpass="<?php echo e($s['id']); ?>">Reset Password</button>
                  <button class="rounded-md <?php echo e($s['active'] ? 'bg-amber-600 hover:bg-amber-700' : 'bg-green-600 hover:bg-green-700'); ?> text-white px-2 py-1" data-toggle-active="<?php echo e($s['id']); ?>">
                    <?php echo e($s['active'] ? 'Deactivate' : 'Activate'); ?>

                  </button>
                  <button class="rounded-md bg-red-600 text-white px-2 py-1 hover:bg-red-700" data-delete="<?php echo e($s['id']); ?>">Delete</button>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>
  </section>

  
  <section class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="p-5 border-b border-gray-200">
      <h3 class="text-base font-semibold text-gray-900">Personal Details</h3>
      <p class="text-xs text-gray-500">Update staff details (certifications, expiry dates, contact info).</p>
    </div>

    <form action="#" method="POST" class="p-5 space-y-4">
      <?php echo csrf_field(); ?>
      <div class="flex items-center gap-4">
        <img src="https://i.pravatar.cc/80?img=12" class="h-16 w-16 rounded-full ring-2 ring-brand-100" alt="Avatar">
        <div>
          <p class="text-lg font-semibold text-gray-900"><?php echo e($selected->name); ?></p>
          <p class="text-xs text-gray-500">User ID: <span class="font-mono">#<?php echo e($selected->id); ?></span></p>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-sm text-gray-600 mb-1">Email</label>
          <input type="email" value="<?php echo e($selected->email); ?>" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Phone</label>
          <input type="text" value="<?php echo e($selected->phone); ?>" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Username</label>
          <input type="text" value="<?php echo e($selected->username); ?>" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Role</label>
          <select class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option <?php if($selected->role === $r): echo 'selected'; endif; ?>><?php echo e($r); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">CNIC</label>
          <input type="text" value="<?php echo e($selected->cnic); ?>" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Date of Birth</label>
          <input type="date" value="<?php echo e($selected->dob->format('Y-m-d')); ?>" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
        </div>
        <div class="sm:col-span-2">
          <label class="block text-sm text-gray-600 mb-1">Address</label>
          <input type="text" value="<?php echo e($selected->address); ?>" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Joining Date</label>
          <input type="date" value="<?php echo e($selected->joining->format('Y-m-d')); ?>" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Gender</label>
          <select class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500">
            <?php $__currentLoopData = ['Male','Female','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option <?php if($selected->gender === $g): echo 'selected'; endif; ?>><?php echo e($g); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
      </div>

      
      <div class="rounded-lg border border-gray-200">
        <div class="flex items-center justify-between p-3 border-b">
          <p class="text-sm font-semibold text-gray-900">Certifications</p>
          <button type="button" id="btnAddCert" class="rounded-md border px-3 py-1.5 text-sm hover:bg-gray-50">+ Add</button>
        </div>
        <div class="p-3 overflow-x-auto">
          <table class="min-w-full text-sm" id="certTable">
            <thead class="bg-gray-50">
              <tr class="text-left text-gray-600">
                <th class="px-3 py-2">Name</th>
                <th class="px-3 py-2">Number</th>
                <th class="px-3 py-2">Issued</th>
                <th class="px-3 py-2">Expires</th>
                <th class="px-3 py-2">Status</th>
                <th class="px-3 py-2 text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <?php $__currentLoopData = $selected->certifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $cls = $expBadge($c['expires']); ?>
                <tr>
                  <td class="px-3 py-2">
                    <input type="text" value="<?php echo e($c['name']); ?>" class="w-full rounded border border-gray-300 px-2 py-1.5">
                  </td>
                  <td class="px-3 py-2">
                    <input type="text" value="<?php echo e($c['no']); ?>" class="w-full rounded border border-gray-300 px-2 py-1.5">
                  </td>
                  <td class="px-3 py-2">
                    <input type="date" value="<?php echo e($c['issued']->format('Y-m-d')); ?>" class="rounded border border-gray-300 px-2 py-1.5">
                  </td>
                  <td class="px-3 py-2">
                    <input type="date" value="<?php echo e($c['expires']->format('Y-m-d')); ?>" class="rounded border border-gray-300 px-2 py-1.5">
                  </td>
                  <td class="px-3 py-2">
                    <span class="inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?php echo e($cls); ?>">
                      <?php echo e(now()->diffInDays($c['expires'], false) < 0 ? 'Expired' : 'Valid'); ?>

                    </span>
                  </td>
                  <td class="px-3 py-2 text-right">
                    <button type="button" class="rounded-md border px-2 py-1 hover:bg-gray-50" data-del-row>Delete</button>
                  </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="flex items-center justify-end gap-2">
        <button type="button" class="rounded-lg border px-4 py-2 text-sm hover:bg-gray-50">Cancel</button>
        <button type="submit" class="rounded-lg bg-brand-600 text-white px-4 py-2 text-sm hover:bg-brand-700">Save Changes</button>
      </div>
    </form>
  </section>
</div>


<div id="staffModal" class="fixed inset-0 z-[60] hidden">
  <div class="absolute inset-0 bg-black/40"></div>
  <div class="relative mx-auto mt-16 w-full max-w-lg">
    <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
      <div class="p-4 border-b flex items-center justify-between">
        <h4 id="modalTitle" class="text-base font-semibold text-gray-900">Create Staff</h4>
        <button id="btnCloseModal" class="rounded-md border px-2 py-1 text-sm hover:bg-gray-50">✕</button>
      </div>
      <form action="#" method="POST" class="p-4 space-y-3">
        <?php echo csrf_field(); ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-sm text-gray-600 mb-1">Full Name</label>
            <input type="text" class="w-full rounded-lg border border-gray-300 px-3 py-2">
          </div>
          <div>
            <label class="block text-sm text-gray-600 mb-1">Username</label>
            <input type="text" class="w-full rounded-lg border border-gray-300 px-3 py-2">
          </div>
          <div class="sm:col-span-2">
            <label class="block text-sm text-gray-600 mb-1">Email</label>
            <input type="email" class="w-full rounded-lg border border-gray-300 px-3 py-2">
          </div>
          <div>
            <label class="block text-sm text-gray-600 mb-1">Password</label>
            <input type="password" class="w-full rounded-lg border border-gray-300 px-3 py-2">
          </div>
          <div>
            <label class="block text-sm text-gray-600 mb-1">Confirm Password</label>
            <input type="password" class="w-full rounded-lg border border-gray-300 px-3 py-2">
          </div>
          <div class="sm:col-span-2">
            <label class="block text-sm text-gray-600 mb-1">Role</label>
            <select class="w-full rounded-lg border border-gray-300 px-3 py-2">
              <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option><?php echo e($r); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </div>
        <div class="flex items-center justify-end gap-2 pt-2">
          <button type="button" class="rounded-lg border px-4 py-2 text-sm hover:bg-gray-50" id="btnCancelModal">Cancel</button>
          <button type="submit" class="rounded-lg bg-brand-600 text-white px-4 py-2 text-sm hover:bg-brand-700">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
  $staffRows = $staff->map(function ($s) {
      return [
          $s['id'],
          $s['name'],
          $s['username'],
          $s['email'],
          $s['role'],
          $s['phone'],
          $s['active'] ? 'yes' : 'no',
          $s['created_at']->format('Y-m-d'),
      ];
  });
?>


<?php $__env->startPush('scripts'); ?>
<script>
  // ===== Modal open/close =====
  const modal = document.getElementById('staffModal');
  document.getElementById('btnOpenCreate')?.addEventListener('click', () => {
    const t = document.getElementById('modalTitle');
    if (t) t.textContent = 'Create Staff';
    modal?.classList.remove('hidden');
  });
  document.getElementById('btnCloseModal')?.addEventListener('click', () => modal?.classList.add('hidden'));
  document.getElementById('btnCancelModal')?.addEventListener('click', () => modal?.classList.add('hidden'));




  // ===== Hoist data from Blade to JS (avoid Blade/JS syntax clashes) =====
  const STAFF_ROWS = <?php echo json_encode($staffRows, 15, 512) ?>;

  console.log('Loaded staff rows:', STAFF_ROWS);

  // ===== Inline actions (demo) =====
  document.addEventListener('click', (e) => {
    const el = e.target.closest('button');
    if (!el) return;

    if (el.hasAttribute('data-edit')) {
      const t = document.getElementById('modalTitle');
      if (t) t.textContent = 'Edit Staff';
      modal?.classList.remove('hidden');
      return;
    }

    if (el.hasAttribute('data-delete')) {
      if (!confirm('Delete this staff account?')) e.preventDefault();
      return;
    }

    if (el.hasAttribute('data-resetpass')) {
      alert('Password reset link sent (demo).');
      return;
    }

    if (el.hasAttribute('data-toggle-active')) {
      const txt = el.textContent.trim() === 'Deactivate' ? 'deactivated' : 'activated';
      alert(`User ${txt} (demo).`);
      return;
    }

    if (el.id === 'btnExportStaff') {
      const csv = 'id,name,username,email,role,phone,active,joined\n'
        + STAFF_ROWS.map(r => r.map(v => `"${String(v).replaceAll('"','""')}"`).join(',')).join('\n');
      downloadCSV(csv, 'staff.csv');
      return;
    }
  });

  // ===== Certifications table row add/delete (demo) =====
  document.getElementById('btnAddCert')?.addEventListener('click', () => {
    const tbody = document.querySelector('#certTable tbody');
    if (!tbody) return;
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td class="px-3 py-2"><input type="text" placeholder="Certification name" class="w-full rounded border border-gray-300 px-2 py-1.5"></td>
      <td class="px-3 py-2"><input type="text" placeholder="Number" class="w-full rounded border border-gray-300 px-2 py-1.5"></td>
      <td class="px-3 py-2"><input type="date" class="rounded border border-gray-300 px-2 py-1.5"></td>
      <td class="px-3 py-2"><input type="date" class="rounded border border-gray-300 px-2 py-1.5"></td>
      <td class="px-3 py-2"><span class="inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset bg-gray-50 text-gray-700 ring-gray-600/20">—</span></td>
      <td class="px-3 py-2 text-right"><button type="button" class="rounded-md border px-2 py-1 hover:bg-gray-50" data-del-row>Delete</button></td>
    `;
    tbody.appendChild(tr);
  });

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('button[data-del-row]');
    if (!btn) return;
    btn.closest('tr')?.remove();
  });

  // ===== CSV helper =====
  function downloadCSV(content, filename) {
    const blob = new Blob([content], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = filename;
    document.body.appendChild(a); a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  }
</script>
<?php $__env->stopPush(); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\staff-portal\resources\views/admin/staff-management.blade.php ENDPATH**/ ?>