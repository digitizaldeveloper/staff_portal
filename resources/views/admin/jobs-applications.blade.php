@extends('layouts.app')

@section('title', 'Job Board Management')
@section('page-heading', 'Job Board Management')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🏠 Dashboard</a>
    <a href="{{ route('admin.timesheets') }}" class="block px-3 py-2 rounded-lg bg-gray-100 font-medium">🕒 Timesheets</a>
    <a href="{{ route('admin.staff-management') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🧑‍💼 Staff</a>
    <a href="{{ route('admin.payroll') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">🧾 Payroll</a>
    <a href="{{ route('admin.jobs-applications') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50">💼 Jobs &
        Applications</a>
    <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-50">⚙️ Settings</a>
@endsection

@section('content')
    @php
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
    @endphp

    <div class="space-y-6">
        {{-- Toolbar --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-base font-semibold text-gray-900">Jobs</h3>
                <p class="text-xs text-gray-500">Create, edit, publish, and delete job postings.</p>
            </div>
            <div class="flex items-center gap-2">
                <button id="btnExportJobs" class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50">Export Jobs
                    CSV</button>
                <button id="btnNewJob" class="rounded-lg bg-brand-600 text-white px-3 py-2 text-sm hover:bg-brand-700">+ New
                    Job</button>
            </div>
        </div>

        {{-- Jobs Table --}}
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
                    @foreach ($jobs as $job)
                        <tr>
                            <td class="px-4 py-2 font-medium text-gray-900">
                                {{ $job['title'] }}
                                <div class="text-xs text-gray-500">/jobs/{{ $job['slug'] }}</div>
                            </td>
                            <td class="px-4 py-2">{{ $job['company'] }}</td>
                            <td class="px-4 py-2">{{ $job['location'] }}</td>
                            <td class="px-4 py-2">{{ $job['type'] }}</td>
                            <td class="px-4 py-2">
                                <span
                                    class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusBadge($job['status']) }}">
                                    {{ ucfirst($job['status']) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-gray-600">{{ $job['posted_at']->format('d M Y') }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ $job['deadline']->format('d M Y') }}</td>
                            <td class="px-4 py-2 text-right">
                                <a href="#apps"
                                    class="rounded-md border px-2 py-1 hover:bg-gray-50">{{ $job['applications'] }}</a>
                            </td>
                            <td class="px-4 py-2 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <button class="rounded-md border px-2 py-1 hover:bg-gray-50"
                                        data-edit="{{ $job['id'] }}">Edit</button>
                                    @if ($job['status'] !== 'published')
                                        <button class="rounded-md bg-green-600 text-white px-2 py-1 hover:bg-green-700"
                                            data-publish="{{ $job['id'] }}">Publish</button>
                                    @else
                                        <button class="rounded-md bg-amber-600 text-white px-2 py-1 hover:bg-amber-700"
                                            data-unpublish="{{ $job['id'] }}">Unpublish</button>
                                    @endif
                                    <button class="rounded-md border px-2 py-1 hover:bg-gray-50"
                                        data-duplicate="{{ $job['id'] }}">Duplicate</button>
                                    <button class="rounded-md bg-red-600 text-white px-2 py-1 hover:bg-red-700"
                                        data-delete="{{ $job['id'] }}">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Candidates --}}
        <div id="apps" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-base font-semibold text-gray-900">Candidate Applications</h3>
                <p class="text-xs text-gray-500">View CVs and details. Shortlist or export candidate data.</p>
            </div>
            <div class="flex items-center gap-2">
                <button id="btnExportCandidates" class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50">Export
                    Candidates CSV</button>
                <button id="btnExportShortlisted" class="rounded-lg border px-3 py-2 text-sm hover:bg-gray-50">Export
                    Shortlisted</button>
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
                    @foreach ($applications as $a)
                        <tr>
                            <td class="px-4 py-2">
                                <div class="font-medium text-gray-900">{{ $a['name'] }}</div>
                                <div class="text-xs text-gray-500">#{{ $a['id'] }}</div>
                            </td>
                            <td class="px-4 py-2">
                                <div class="text-gray-900">{{ $a['job_title'] }}</div>
                                <div class="text-xs text-gray-500">Job ID: {{ $a['job_id'] }}</div>
                            </td>
                            <td class="px-4 py-2">{{ $a['experience'] }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ $a['submitted_at']->format('d M Y, h:i A') }}</td>
                            <td class="px-4 py-2">
                                <div class="text-xs text-gray-600">{{ $a['email'] }}</div>
                                <div class="text-xs text-gray-600">{{ $a['phone'] }}</div>
                            </td>
                            <td class="px-4 py-2 max-w-[320px]">
                                <p class="line-clamp-2 text-gray-700">{{ $a['cover'] }}</p>
                            </td>
                            <td class="px-4 py-2 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ $a['cv_url'] }}" class="rounded-md border px-2 py-1 hover:bg-gray-50">View
                                        CV</a>
                                    <button class="rounded-md border px-2 py-1 hover:bg-gray-50"
                                        data-view="{{ $a['id'] }}">View</button>
                                    <button
                                        class="rounded-md {{ $a['shortlisted'] ? 'bg-amber-600 text-white hover:bg-amber-700' : 'bg-brand-600 text-white hover:bg-brand-700' }} px-2 py-1"
                                        data-shortlist="{{ $a['id'] }}">
                                        {{ $a['shortlisted'] ? 'Unshortlist' : 'Shortlist' }}
                                    </button>
                                    <button class="rounded-md border px-2 py-1 hover:bg-gray-50"
                                        data-export-one="{{ $a['id'] }}">Export</button>
                                    <button class="rounded-md bg-red-600 text-white px-2 py-1 hover:bg-red-700"
                                        data-delete-app="{{ $a['id'] }}">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @php
      $jobRows = $jobs->map(function($j) {
        return [
            $j['id'],
            $j['title'],
            $j['company'],
            $j['location'],
            $j['type'],
            $j['status'],
            $j['posted_at']->format('Y-m-d'),
            $j['deadline']->format('Y-m-d'),
            $j['applications'],
        ];
    });

    $candidateRows = $applications->map(function($a) {
        return [
            $a['id'],
            $a['job_id'],
            $a['job_title'],
            $a['name'],
            $a['email'],
            $a['phone'],
            $a['experience'],
            $a['submitted_at']->format('Y-m-d H:i'),
            $a['shortlisted'] ? 'yes' : 'no',
        ];
    });

    $shortlistedRows = $applications->filter(fn($a) => $a['shortlisted'])->values()->map(function($a) {
        return [
            $a['id'],
            $a['job_id'],
            $a['job_title'],
            $a['name'],
            $a['email'],
            $a['phone'],
            $a['experience'],
            $a['submitted_at']->format('Y-m-d H:i'),
            'yes',
        ];
    });
    @endphp 
    {{-- ===== Minimal JS (inline) to simulate actions & CSV exports (dummy) ===== --}}
    @push('scripts')
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
  const rows = @json($jobRows);
  const csv = `id,title,company,location,type,status,posted_at,deadline,applications\n` +
    rows.map(row => row.map(v => `"${String(v).replaceAll('"', '""')}"`).join(',')).join('\n');
  downloadCSV(csv, 'jobs.csv');
}

if (el.id === 'btnExportCandidates') {
  const rows = @json($candidateRows);
  const csv = `id,job_id,job_title,name,email,phone,experience,submitted_at,shortlisted\n` +
    rows.map(row => row.map(v => `"${String(v).replaceAll('"', '""')}"`).join(',')).join('\n');
  downloadCSV(csv, 'candidates.csv');
}

if (el.id === 'btnExportShortlisted') {
  const rows = @json($shortlistedRows);
  const csv = `id,job_id,job_title,name,email,phone,experience,submitted_at,shortlisted\n` +
    rows.map(row => row.map(v => `"${String(v).replaceAll('"', '""')}"`).join(',')).join('\n');
  downloadCSV(csv, 'shortlisted.csv');
}


                if (el.hasAttribute('data-export-one')) {
                    const id = el.getAttribute('data-export-one');
                    alert(`Export candidate #${id} (demo).`);
                }
            });

            function downloadCSV(content, filename) {
                const blob = new Blob([content], {
                    type: 'text/csv;charset=utf-8;'
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }
        </script>
    @endpush
@endsection
