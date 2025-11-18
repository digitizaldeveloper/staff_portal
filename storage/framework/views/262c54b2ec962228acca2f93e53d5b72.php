

<?php $__env->startSection('title','Payroll Management'); ?>
<?php $__env->startSection('page-heading','Payroll Management'); ?>

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

  // ===== Dummy Staff =====
  $staff = collect([
    ['id'=>1,'name'=>'Ali Raza','email'=>'ali.raza@example.com'],
    ['id'=>2,'name'=>'Hina Fatima','email'=>'hina.f@example.com'],
    ['id'=>3,'name'=>'Ahmed Khan','email'=>'ahmed.khan@example.com'],
  ]);

  // ===== Dummy Payslips (existing) =====
  $payslips = collect([
    ['id'=>901,'user_id'=>1,'user'=>'Ali Raza','period'=>'Sep 2025','issued'=>Carbon::parse('2025-09-30'),'gross'=>120000,'deductions'=>14500,'net'=>105500,'url'=>'#'],
    ['id'=>900,'user_id'=>2,'user'=>'Hina Fatima','period'=>'Sep 2025','issued'=>Carbon::parse('2025-09-30'),'gross'=>98000,'deductions'=>9000,'net'=>89000,'url'=>'#'],
    ['id'=>899,'user_id'=>3,'user'=>'Ahmed Khan','period'=>'Aug 2025','issued'=>Carbon::parse('2025-08-31'),'gross'=>110000,'deductions'=>12000,'net'=>98000,'url'=>'#'],
  ]);

  $currency = fn($v) => number_format($v);
?>

<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
  
  <section class="xl:col-span-1 bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="p-5 border-b border-gray-200">
      <h3 class="text-base font-semibold text-gray-900">Upload Payslip</h3>
      <p class="text-xs text-gray-500">Upload payslips for staff (PDF). Net = Gross − Deductions.</p>
    </div>

    <form action="#" method="POST" enctype="multipart/form-data" class="p-5 space-y-4" id="payslipForm">
      <?php echo csrf_field(); ?>
      <div>
        <label class="block text-sm text-gray-600 mb-1">Employee</label>
        <select name="user_id" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500" required>
          <option value="">— Select employee —</option>
          <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($u['id']); ?>"><?php echo e($u['name']); ?> — <?php echo e($u['email']); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-sm text-gray-600 mb-1">Pay Period</label>
          <input type="text" name="period" placeholder="e.g., Sep 2025" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500" required>
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Issue Date</label>
          <input type="date" name="issued" value="<?php echo e(now()->format('Y-m-d')); ?>" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500" required>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div>
          <label class="block text-sm text-gray-600 mb-1">Gross</label>
          <input type="number" name="gross" min="0" step="1" placeholder="0" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500" required>
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Deductions</label>
          <input type="number" name="deductions" min="0" step="1" placeholder="0" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500" required>
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Net (auto)</label>
          <input type="number" name="net" min="0" step="1" placeholder="0" class="w-full rounded-lg border border-gray-300 px-3 py-2 bg-gray-50" readonly>
        </div>
      </div>

      <div>
        <label class="block text-sm text-gray-600 mb-1">Payslip PDF</label>
        <div id="dropzone" class="w-full rounded-lg border-2 border-dashed border-gray-300 p-5 text-center text-sm text-gray-600 hover:border-brand-500 cursor-pointer">
          <p>Drag & drop the PDF here, or click to browse.</p>
          <input type="file" name="file" id="fileInput" accept="application/pdf" class="hidden" required>
        </div>
        <p class="mt-1 text-xs text-gray-500">Max 5 MB. Only PDF allowed.</p>
        <div id="fileName" class="mt-2 text-xs text-gray-700 hidden"></div>
      </div>

      <div class="flex items-center justify-end gap-2">
        <button type="button" class="rounded-lg border px-4 py-2 text-sm hover:bg-gray-50">Clear</button>
        <button type="submit" class="rounded-lg bg-brand-600 text-white px-4 py-2 text-sm hover:bg-brand-700">Upload Payslip</button>
      </div>
    </form>
  </section>

  
  <section class="xl:col-span-2 bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="p-5 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h3 class="text-base font-semibold text-gray-900">Payslips</h3>
        <p class="text-xs text-gray-500">Uploaded payslips by period and employee.</p>
      </div>
      <div class="flex items-center gap-2">
        <button id="btnExportPayslips" class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50">Export CSV</button>
      </div>
    </div>

    <div class="p-5 overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
          <tr class="text-left text-gray-600">
            <th class="px-4 py-2">Employee</th>
            <th class="px-4 py-2">Period</th>
            <th class="px-4 py-2">Issued</th>
            <th class="px-4 py-2">Gross</th>
            <th class="px-4 py-2">Deductions</th>
            <th class="px-4 py-2">Net</th>
            <th class="px-4 py-2 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100" id="payslipsBody">
          <?php $__currentLoopData = $payslips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr data-id="<?php echo e($p['id']); ?>">
              <td class="px-4 py-2">
                <div class="font-medium text-gray-900"><?php echo e($p['user']); ?></div>
                <div class="text-xs text-gray-500">#U<?php echo e(str_pad($p['user_id'],3,'0',STR_PAD_LEFT)); ?></div>
              </td>
              <td class="px-4 py-2"><?php echo e($p['period']); ?></td>
              <td class="px-4 py-2 text-gray-600"><?php echo e($p['issued']->format('d M Y')); ?></td>
              <td class="px-4 py-2"><?php echo e($currency($p['gross'])); ?></td>
              <td class="px-4 py-2"><?php echo e($currency($p['deductions'])); ?></td>
              <td class="px-4 py-2 font-medium"><?php echo e($currency($p['net'])); ?></td>
              <td class="px-4 py-2 text-right">
                <div class="inline-flex items-center gap-1">
                  <a href="<?php echo e($p['url']); ?>" class="rounded-md border px-2 py-1 hover:bg-gray-50">View</a>
                  <a href="<?php echo e($p['url']); ?>" class="rounded-md bg-brand-600 text-white px-2 py-1 hover:bg-brand-700">Download</a>
                  <button class="rounded-md border px-2 py-1 hover:bg-gray-50" data-delete>Delete</button>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>

      
      <div class="mt-4 flex justify-end">
        <nav class="inline-flex gap-1">
          <button class="px-3 py-1.5 text-sm rounded border hover:bg-gray-50">Prev</button>
          <button class="px-3 py-1.5 text-sm rounded border bg-gray-100">1</button>
          <button class="px-3 py-1.5 text-sm rounded border hover:bg-gray-50">2</button>
          <button class="px-3 py-1.5 text-sm rounded border hover:bg-gray-50">Next</button>
        </nav>
      </div>
    </div>
  </section>
</div>


<div class="mt-6 bg-white border border-gray-200 rounded-xl overflow-hidden">
  <div class="p-5 border-b border-gray-200">
    <h3 class="text-base font-semibold text-gray-900">Bulk Upload (CSV) — Optional</h3>
    <p class="text-xs text-gray-500">Columns: user_id,period,issued(YYYY-MM-DD),gross,deductions,net,pdf_url</p>
  </div>
  <div class="p-5 flex items-center gap-2">
    <input type="file" id="csvInput" accept=".csv" class="rounded-lg border px-3 py-2 text-sm">
    <button id="btnParseCsv" class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50">Parse (Demo)</button>
    <button id="btnDownloadCsvTemplate" class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50">Download Template</button>
  </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
  // Auto-calc Net
  const grossInput = document.querySelector('input[name="gross"]');
  const dedInput   = document.querySelector('input[name="deductions"]');
  const netInput   = document.querySelector('input[name="net"]');

  function recalcNet() {
    const g = Number(grossInput.value || 0);
    const d = Number(dedInput.value || 0);
    const n = Math.max(g - d, 0);
    netInput.value = Math.round(n);
  }
  grossInput?.addEventListener('input', recalcNet);
  dedInput?.addEventListener('input', recalcNet);

  // Drag & drop for PDF
  const drop = document.getElementById('dropzone');
  const fileInput = document.getElementById('fileInput');
  const fileName = document.getElementById('fileName');
  drop?.addEventListener('click', () => fileInput.click());
  drop?.addEventListener('dragover', (e) => { e.preventDefault(); drop.classList.add('border-brand-500'); });
  drop?.addEventListener('dragleave', () => drop.classList.remove('border-brand-500'));
  drop?.addEventListener('drop', (e) => {
    e.preventDefault();
    drop.classList.remove('border-brand-500');
    if (e.dataTransfer.files.length) {
      const f = e.dataTransfer.files[0];
      if (f.type !== 'application/pdf') return alert('Only PDF allowed.');
      fileInput.files = e.dataTransfer.files;
      fileName.textContent = `Selected: ${f.name} (${Math.round(f.size/1024)} KB)`;
      fileName.classList.remove('hidden');
    }
  });
  fileInput?.addEventListener('change', (e) => {
    const f = e.target.files[0];
    if (!f) return;
    if (f.type !== 'application/pdf') { alert('Only PDF allowed.'); fileInput.value=''; return; }
    fileName.textContent = `Selected: ${f.name} (${Math.round(f.size/1024)} KB)`;
    fileName.classList.remove('hidden');
  });

  // Dummy submit
  document.getElementById('payslipForm')?.addEventListener('submit', (e) => {
    e.preventDefault();
    alert('Payslip uploaded (demo). In real app, this posts to server and refreshes table.');
  });

  // Delete row (demo)
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('button[data-delete]');
    if (!btn) return;
    if (!confirm('Delete this payslip?')) return;
    const tr = btn.closest('tr');
    tr?.remove();
  });

  // Export CSV (demo)
  document.getElementById('btnExportPayslips')?.addEventListener('click', () => {
    const rows = [...document.querySelectorAll('#payslipsBody tr')].map(tr => {
      const tds = tr.querySelectorAll('td');
      return [
        tds[0].querySelector('.font-medium').textContent.trim(),
        tds[1].textContent.trim(),
        tds[2].textContent.trim(),
        tds[3].textContent.trim().replace(/,/g,''),
        tds[4].textContent.trim().replace(/,/g,''),
        tds[5].textContent.trim().replace(/,/g,''),
      ];
    });
    const header = 'employee,period,issued,gross,deductions,net\n';
    const csv = header + rows.map(r => r.map(v=>`"${String(v).replaceAll('"','""')}"`).join(',')).join('\n');
    downloadCSV(csv, 'payslips.csv');
  });

  // CSV Template
  document.getElementById('btnDownloadCsvTemplate')?.addEventListener('click', () => {
    const csv = 'user_id,period,issued,gross,deductions,net,pdf_url\n' +
                '1,Sep 2025,2025-09-30,120000,14500,105500,https://example.com/ali_sep_2025.pdf\n';
    downloadCSV(csv, 'payslips_template.csv');
  });

  // Parse CSV (demo only)
  document.getElementById('btnParseCsv')?.addEventListener('click', () => {
    const file = document.getElementById('csvInput').files[0];
    if (!file) return alert('Select a CSV file first.');
    const reader = new FileReader();
    reader.onload = () => {
      const lines = reader.result.split(/\r?\n/).filter(Boolean);
      alert(`Parsed ${Math.max(lines.length - 1, 0)} row(s) (demo). In real app, this would upload to server.`);
    };
    reader.readAsText(file);
  });

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u461551961/domains/wponline.io/public_html/staff_portal/resources/views/admin/payroll.blade.php ENDPATH**/ ?>