

<?php $__env->startSection('title','Job Board Management'); ?>
<?php $__env->startSection('page-heading','Job Board Management'); ?>

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

  // ===== Dummy Jobs =====
  $jobs = collect([
    [
      'id' => 201,
      'title' => 'Security Supervisor',
      'company' => 'Protec Pvt Ltd',
      'location' => 'Karachi',
      'type' => 'Full-time',
      'salary' => 'Rs 80,000 - 100,000',
      'status' => 'published', // draft|published|closed
      'posted_at' => Carbon::parse('2025-09-15'),
      'deadline' => Carbon::parse('2025-10-20'),
      'applications' => 7,
      'slug' => 'security-supervisor',
    ],
    [
      'id' => 200,
      'title' => 'Night Shift Guard',
      'company' => 'Alpha Mall',
      'location' => 'Karachi',
      'type' => 'Contract',
      'salary' => 'Rs 55,000 - 65,000',
      'status' => 'draft',
      'posted_at' => Carbon::parse('2025-09-28'),
      'deadline' => Carbon::parse('2025-10-25'),
      'applications' => 3,
      'slug' => 'night-shift-guard',
    ],
    [
      'id' => 199,
      'title' => 'Control Room Operator',
      'company' => 'Crescent Towers',
      'location' => 'Lahore',
      'type' => 'Full-time',
      'salary' => 'Rs 70,000 - 85,000',
      'status' => 'closed',
      'posted_at' => Carbon::parse('2025-08-01'),
      'deadline' => Carbon::parse('2025-09-01'),
      'applications' => 14,
      'slug' => 'control-room-operator',
    ],
  ]);

  // ===== Dummy Applications =====
  $applications = collect([
    [
      'id' => 5011,
      'job_id' => 201,
      'job_title' => 'Security Supervisor',
      'name' => 'Ali Raza',
      'email' => 'ali.raza@example.com',
      'phone' => '+92 300 1234567',
      'cv_url' => '#',
      'cover' => '5+ yrs supervising mall security, first aid certified.',
      'experience' => '5 years',
      'submitted_at' => Carbon::parse('2025-10-01 13:45'),
      'shortlisted' => false,
    ],
    [
      'id' => 5010,
      'job_id' => 200,
      'job_title' => 'Night Shift Guard',
      'name' => 'Ahmed Khan',
      'email' => 'ahmed.khan@example.com',
      'phone' => '+92 311 2223344',
      'cv_url' => '#',
      'cover' => 'Night shift at Alpha Mall for 2 years, CR training.',
      'experience' => '3 years',
      'submitted_at' => Carbon::parse('2025-10-02 09:10'),
      'shortlisted' => true,
    ],
    [
      'id' => 5009,
      'job_id' => 199,
      'job_title' => 'Control Room Operator',
      'name' => 'Hina Fatima',
      'email' => 'hina.f@example.com',
      'phone' => '+92 322 9988776',
      'cv_url' => '#',
      'cover' => 'BSc IT, CCTV monitoring & incident logging.',
      'experience' => '4 years',
      'submitted_at' => Carbon::parse('2025-09-10 18:20'),
      'shortlisted' => false,
    ],
  ]);

  $statusBadge = fn($s) => [
    'draft' => 'bg-gray-50 text-gray-700 ring-gray-600/20',
    'published' => 'bg-green-50 text-green-700 ring-green-600/20',
    'closed' => 'bg-red-50 text-red-700 ring-red-600/20',
  ][$s] ?? 'bg-gray-50 text-gray-700 ring-gray-600/20';
?>

<div class="space-y-6">
  
  <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <h3 class="text-base font-semibold text-gray-900">Jobs</h3>
      <p class="text-xs text-gray-500">Create, edit, publish, and delete job postings.</p>
    </div>
    <div class="flex items-center gap-2">
      <button id="btnExportJobs" class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50">Export Jobs CSV</button>
      <button id="btnNewJob" class="rounded-lg bg-brand-600 text-white px-3 py-2 text-sm hover:bg-brand-700">+ New Job</button>
    </div>
  </div>

  
  <div class="bg-white border border-gray-200 rounded-xl overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-50">
        <tr class="text-left text-gray-600">
          <th class="px-4 py-2">Title</th>
          <th class="px-4 py-2">Company</th>
          <th class="px-4 py-2">Location</th>
          <th class="px-4 py-2">Type</th>
          <th class="px-4 py-2">Status</th>
          <th class="px-4 py-2">Posted</th>
          <th class="px-4 py-2">Deadline</th>
          <th class="px-4 py-2 text-right">Applications</th>
          <th class="px-4 py-2 text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td class="px-4 py-2 font-medium text-gray-900">
              <?php echo e($job['title']); ?>

              <div class="text-xs text-gray-500">/jobs/<?php echo e($job['slug']); ?></div>
            </td>
            <td class="px-4 py-2"><?php echo e($job['company']); ?></td>
            <td class="px-4 py-2"><?php echo e($job['location']); ?></td>
            <td class="px-4 py-2"><?php echo e($job['type']); ?></td>
            <td class="px-4 py-2">
              <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?php echo e($statusBadge($job['status'])); ?>">
                <?php echo e(ucfirst($job['status'])); ?>

              </span>
            </td>
            <td class="px-4 py-2 text-gray-600"><?php echo e($job['posted_at']->format('d M Y')); ?></td>
            <td class="px-4 py-2 text-gray-600"><?php echo e($job['deadline']->format('d M Y')); ?></td>
            <td class="px-4 py-2 text-right">
              <a href="#apps" class="rounded-md border px-2 py-1 hover:bg-gray-50"><?php echo e($job['applications']); ?></a>
            </td>
            <td class="px-4 py-2 text-right">
              <div class="inline-flex items-center gap-1">
                <button class="rounded-md border px-2 py-1 hover:bg-gray-50" data-edit="<?php echo e($job['id']); ?>">Edit</button>
                <?php if($job['status'] !== 'published'): ?>
                  <button class="rounded-md bg-green-600 text-white px-2 py-1 hover:bg-green-700" data-publish="<?php echo e($job['id']); ?>">Publish</button>
                <?php else: ?>
                  <button class="rounded-md bg-amber-600 text-white px-2 py-1 hover:bg-amber-700" data-unpublish="<?php echo e($job['id']); ?>">Unpublish</button>
                <?php endif; ?>
                <button class="rounded-md border px-2 py-1 hover:bg-gray-50" data-duplicate="<?php echo e($job['id']); ?>">Duplicate</button>
                <button class="rounded-md bg-red-600 text-white px-2 py-1 hover:bg-red-700" data-delete="<?php echo e($job['id']); ?>">Delete</button>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </div>

  
  <div id="apps" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <h3 class="text-base font-semibold text-gray-900">Candidate Applications</h3>
      <p class="text-xs text-gray-500">View CVs and details. Shortlist or export candidate data.</p>
    </div>
    <div class="flex items-center gap-2">
      <button id="btnExportCandidates" class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50">Export Candidates CSV</button>
      <button id="btnExportShortlisted" class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50">Export Shortlisted</button>
    </div>
  </div>

  <div class="bg-white border border-gray-200 rounded-xl overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-50">
        <tr class="text-left text-gray-600">
          <th class="px-4 py-2">Applicant</th>
          <th class="px-4 py-2">For Job</th>
          <th class="px-4 py-2">Experience</th>
          <th class="px-4 py-2">Submitted</th>
          <th class="px-4 py-2">Contact</th>
          <th class="px-4 py-2">Cover</th>
          <th class="px-4 py-2 text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td class="px-4 py-2">
              <div class="font-medium text-gray-900"><?php echo e($a['name']); ?></div>
              <div class="text-xs text-gray-500">#<?php echo e($a['id']); ?></div>
            </td>
            <td class="px-4 py-2">
              <div class="text-gray-900"><?php echo e($a['job_title']); ?></div>
              <div class="text-xs text-gray-500">Job ID: <?php echo e($a['job_id']); ?></div>
            </td>
            <td class="px-4 py-2"><?php echo e($a['experience']); ?></td>
            <td class="px-4 py-2 text-gray-600"><?php echo e($a['submitted_at']->format('d M Y, h:i A')); ?></td>
            <td class="px-4 py-2">
              <div class="text-xs text-gray-600"><?php echo e($a['email']); ?></div>
              <div class="text-xs text-gray-600"><?php echo e($a['phone']); ?></div>
            </td>
            <td class="px-4 py-2 max-w-[320px]">
              <p class="line-clamp-2 text-gray-700"><?php echo e($a['cover']); ?></p>
            </td>
            <td class="px-4 py-2 text-right">
              <div class="inline-flex items-center gap-1">
                <a href="<?php echo e($a['cv_url']); ?>" class="rounded-md border px-2 py-1 hover:bg-gray-50">View CV</a>
                <button class="rounded-md border px-2 py-1 hover:bg-gray-50" data-view="<?php echo e($a['id']); ?>">View</button>
                <button class="rounded-md <?php echo e($a['shortlisted'] ? 'bg-amber-600 text-white hover:bg-amber-700' : 'bg-brand-600 text-white hover:bg-brand-700'); ?> px-2 py-1" data-shortlist="<?php echo e($a['id']); ?>">
                  <?php echo e($a['shortlisted'] ? 'Unshortlist' : 'Shortlist'); ?>

                </button>
                <button class="rounded-md border px-2 py-1 hover:bg-gray-50" data-export-one="<?php echo e($a['id']); ?>">Export</button>
                <button class="rounded-md bg-red-600 text-white px-2 py-1 hover:bg-red-700" data-delete-app="<?php echo e($a['id']); ?>">Delete</button>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </div>
</div>


<?php $__env->startPush('scripts'); ?>
<script>
  // Simple confirm prompts for destructive actions
  document.addEventListener('click', (e) => {
    const el = e.target.closest('button');
    if (!el) return;

    if (el.hasAttribute('data-delete')) {
      if (!confirm('Delete this job?')) e.preventDefault();
    }
    if (el.hasAttribute('data-delete-app')) {
      if (!confirm('Delete this application?')) e.preventDefault();
    }

    // Fake publish/unpublish/shortlist toggles
    if (el.hasAttribute('data-publish')) alert('Job published (demo).');
    if (el.hasAttribute('data-unpublish')) alert('Job unpublished (demo).');
    if (el.hasAttribute('data-shortlist')) {
      const id = el.getAttribute('data-shortlist');
      const isUn = el.textContent.trim() === 'Unshortlist';
      el.textContent = isUn ? 'Shortlist' : 'Unshortlist';
      el.classList.toggle('bg-amber-600');
      el.classList.toggle('hover:bg-amber-700');
      el.classList.toggle('bg-brand-600');
      el.classList.toggle('hover:bg-brand-700');
      alert(`Application #${id} ${isUn ? 'removed from' : 'added to'} shortlist (demo).`);
    }

    if (el.id === 'btnNewJob') {
      alert('Open New Job form modal (demo).');
    }
    if (el.hasAttribute('data-edit')) {
      alert('Open Edit Job form modal (demo).');
    }

    // Dummy CSV export
    if (el.id === 'btnExportJobs') {
      const csv = `id,title,company,location,type,status,posted_at,deadline,applications\n` +
        <?php echo json_encode($jobs->map(fn($j)=>[
          $j['id'], $j['title'], $j['company']) ?>->map(row => row.map(v=>`"${String(v).replaceAll('"','""')}"`).join(',')).join('\n');
      downloadCSV(csv, 'jobs.csv');
    }
    if (el.id === 'btnExportCandidates') {
      const csv = `id,job_id,job_title,name,email,phone,experience,submitted_at,shortlisted\n` +
        <?php echo json_encode($applications->map(fn($a)=>[
          $a['id'], $a['job_id'], $a['job_title']) ?>->map(row => row.map(v=>`"${String(v).replaceAll('"','""')}"`).join(',')).join('\n');
      downloadCSV(csv, 'candidates.csv');
    }
    if (el.id === 'btnExportShortlisted') {
      const rows = <?php echo json_encode($applications->filter(fn($a)=>$a['shortlisted'])->values()->map(fn($a)=>[
        $a['id'], $a['job_id'], $a['job_title']) ?>;
      const csv = `id,job_id,job_title,name,email,phone,experience,submitted_at,shortlisted\n` +
        rows.map(row => row.map(v=>`"${String(v).replaceAll('"','""')}"`).join(',')).join('\n');
      downloadCSV(csv, 'shortlisted.csv');
    }
    if (el.hasAttribute('data-export-one')) {
      const id = el.getAttribute('data-export-one');
      alert(`Export candidate #${id} (demo).`);
    }
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\srtaff-portal\resources\views/admin/jobs-applications.blade.php ENDPATH**/ ?>