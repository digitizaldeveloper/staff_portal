@extends('layouts.app')

@section('page-heading', 'Admin Dashboard')

@section('content')
@php
    use Illuminate\Support\Carbon;

    $stats = array_merge([
        'staff'        => 0,
        'clients'      => 0,
        'jobs'         => 0,
        'timesheets'   => 0,
        'pending'      => 0,
    ], $metrics ?? []);

    $recentStaff       = collect($staff ?? [])->take(5);
    $recentJobs        = collect($jobs ?? [])->take(5);
    $pendingTimesheets = collect($timesheets ?? [])->where('status', 'pending')->take(5);
@endphp

<div class="space-y-6">

    <div class="rounded-3xl border border-gray-200 bg-gradient-to-r from-indigo-600 to-purple-500 px-8 py-10 text-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-6">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-indigo-200">Overview</p>
                <h1 class="mt-3 text-3xl font-semibold">Control room</h1>
                <p class="mt-2 text-indigo-100">
                    Monitor staff activity, client requests, and open jobs from a single pane.
                </p>
            </div>
            <div class="rounded-2xl border border-white/30 bg-white/10 px-6 py-4 text-center">
                <p class="text-4xl font-bold">{{ $stats['pending'] }}</p>
                <p class="text-sm font-medium text-indigo-100">Pending approvals</p>
            </div>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Active staff</p>
            <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $stats['staff'] }}</p>
            <p class="text-xs text-emerald-600 mt-1">All active and onboarded members</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Clients</p>
            <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $stats['clients'] }}</p>
            <p class="text-xs text-indigo-600 mt-1">Including active contracts</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Open jobs</p>
            <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $stats['jobs'] }}</p>
            <p class="text-xs text-amber-600 mt-1">Visible on careers page</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Pending timesheets</h2>
                    <p class="text-sm text-gray-500">Approve or reject latest submissions.</p>
                </div>
                <a href="{{ route('staff.timesheets.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                    Manage →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-6 py-3 text-left">Staff</th>
                            <th class="px-6 py-3 text-left">Date</th>
                            <th class="px-6 py-3 text-left">Client</th>
                            <th class="px-6 py-3 text-left">Hours</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($pendingTimesheets as $ts)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ data_get($ts, 'staff.name', 'Staff member') }}</div>
                                    <div class="text-xs text-gray-400">#{{ str_pad($ts['id'] ?? 0, 4, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td class="px-6 py-4">{{ Carbon::parse($ts['date'] ?? now())->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    {{ data_get($ts, 'client.name', 'Client #' . ($ts['client_id'] ?? '')) }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ number_format(data_get($ts, 'total_hours', 0), 2) }} hrs</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">
                                    No timesheets waiting for review.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Newly onboarded staff</h2>
                <p class="text-sm text-gray-500">Welcome them before first shift.</p>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse($recentStaff as $member)
                    <li class="px-6 py-4">
                        <p class="font-semibold text-gray-900">{{ $member['name'] ?? 'Name withheld' }}</p>
                        <p class="text-sm text-gray-500">{{ $member['role'] ?? 'Staff' }}</p>
                        <p class="text-xs text-gray-400 mt-1">
                            Joined {{ Carbon::parse($member['created_at'] ?? now())->diffForHumans() }}
                        </p>
                    </li>
                @empty
                    <li class="px-6 py-10 text-center text-sm text-gray-500">
                        No recent hires to display.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Latest job posts</h2>
                    <p class="text-sm text-gray-500">Highlight roles on careers page.</p>
                </div>
                <a href="{{ route('admin.jobs.index') ?? '#' }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                    Manage →
                </a>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse($recentJobs as $job)
                    <li class="px-6 py-4">
                        <div class="font-semibold text-gray-900">{{ $job['title'] ?? 'Untitled role' }}</div>
                        <p class="text-sm text-gray-500">
                            {{ $job['location'] ?? 'Location TBD' }} • {{ $job['type'] ?? 'Contract' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            Posted {{ Carbon::parse($job['created_at'] ?? now())->diffForHumans() }}
                        </p>
                    </li>
                @empty
                    <li class="px-6 py-10 text-center text-sm text-gray-500">
                        No job posts yet. Create one to attract applicants.
                    </li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Quick actions</h2>
                <p class="text-sm text-gray-500">Perform common admin tasks faster.</p>
            </div>
            <div class="grid gap-4 px-6 py-6 md:grid-cols-2">
                <a href="{{ route('admin.blogs.create') ?? '#' }}"
                   class="flex flex-col gap-2 rounded-2xl border border-gray-200 p-4 hover:border-emerald-200 hover:bg-emerald-50">
                    <span class="text-lg">✍️</span>
                    <p class="font-semibold text-gray-900">New blog post</p>
                    <p class="text-xs text-gray-500">Share announcements or updates</p>
                </a>
                <a href="{{ route('admin.jobs.create') ?? '#' }}"
                   class="flex flex-col gap-2 rounded-2xl border border-gray-200 p-4 hover:border-blue-200 hover:bg-blue-50">
                    <span class="text-lg">📋</span>
                    <p class="font-semibold text-gray-900">Create job</p>
                    <p class="text-xs text-gray-500">Add openings to careers page</p>
                </a>
                <a href="{{ route('admin.staff.index') ?? '#' }}"
                   class="flex flex-col gap-2 rounded-2xl border border-gray-200 p-4 hover:border-violet-200 hover:bg-violet-50">
                    <span class="text-lg">👥</span>
                    <p class="font-semibold text-gray-900">Manage staff</p>
                    <p class="text-xs text-gray-500">Edit roles & availability</p>
                </a>
                <a href="{{ route('admin.contact_enquiries') }}"
                   class="flex flex-col gap-2 rounded-2xl border border-gray-200 p-4 hover:border-amber-200 hover:bg-amber-50">
                    <span class="text-lg">📨</span>
                    <p class="font-semibold text-gray-900">Review enquiries</p>
                    <p class="text-xs text-gray-500">Respond to contact form</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
