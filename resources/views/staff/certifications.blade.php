@extends('layouts.app')

@section('page-heading', 'My Certifications')
@section('content')
<div class="max-w-6xl mx-auto p-6 space-y-6">

    <div class="rounded-2xl border border-gray-200 bg-white px-6 py-5 shadow-sm">
        <h2 class="text-2xl font-semibold text-gray-900">My Certifications</h2>
        <p class="text-sm text-gray-500">Monitor compliance status and keep documents up to date.</p>
    </div>

    <div class="grid grid-cols-1 gap-6">

        @forelse($certs as $cert)
        @php
            $badgeMap = [
                'valid' => 'bg-emerald-100 text-emerald-700',
                'expired' => 'bg-rose-100 text-rose-700',
                'warning' => 'bg-amber-100 text-amber-700',
            ];
            $badgeClass = $badgeMap[$cert->status] ?? 'bg-gray-100 text-gray-600';
        @endphp
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">{{ $cert->name }}</h3>
                    <p class="text-sm text-gray-500">#{{ $cert->number }}</p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClass }}">
                    <span class="h-2 w-2 rounded-full bg-current"></span>
                    {{ ucfirst($cert->status) }}
                </span>
            </div>

            <dl class="mt-4 grid gap-4 text-sm text-gray-600 sm:grid-cols-3">
                <div>
                    <dt class="font-semibold text-gray-500">Issued</dt>
                    <dd class="text-gray-900">{{ $cert->issue_date }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-500">Expiry</dt>
                    <dd class="text-gray-900">{{ $cert->expiry_date }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-500">Document</dt>
                    <dd>
                        @if($cert->document)
                            <a href="{{ asset($cert->document) }}" target="_blank"
                               class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700">
                                View approved file
                            </a>
                        @else
                            <span class="text-gray-400">Not uploaded</span>
                        @endif
                    </dd>
                </div>
            </dl>

            <div class="mt-6 rounded-2xl border border-gray-100 bg-gray-50 p-4">
                <form action="/staff/certifications/upload/{{ $cert->id }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700">Upload updated document</label>
                        <input type="file" name="document"
                               class="block w-full rounded-2xl border border-dashed border-gray-300 bg-white px-4 py-3 text-sm text-gray-600 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <button class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700">
                        Upload for review
                    </button>
                </form>

                @if($cert->pending_document)
                    <p class="mt-3 text-sm font-semibold text-amber-600">Pending admin approval…</p>
                @elseif(!$cert->pending_document && $cert->status == 'rejected')
                    <p class="mt-3 text-sm font-semibold text-rose-600">Previous document was rejected. Please upload a new one.</p>
                @endif
            </div>

        </div>
        @empty
            <div class="rounded-2xl border border-dashed border-gray-200 bg-white p-10 text-center text-sm text-gray-500">
                No certifications have been linked to your profile yet.
            </div>
        @endforelse

    </div>
</div>
@endsection
