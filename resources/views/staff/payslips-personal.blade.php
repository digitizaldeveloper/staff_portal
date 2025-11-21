@extends('layouts.app')

@section('page-heading', 'My Payslips')
@section('content')
<div class="max-w-5xl mx-auto py-10 px-4 space-y-6">

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 px-6 py-5">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">My Payslips</h1>
                <p class="text-sm text-gray-500">Securely access and download your statements</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold">Pay Period</th>
                        <th class="px-6 py-3 text-left font-semibold">PDF</th>
                        <th class="px-6 py-3 text-left font-semibold">Uploaded</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($payslips as $payslip)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ $payslip->pay_period }}</div>
                                <div class="text-xs text-gray-400">Reference #{{ str_pad($payslip->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ asset('payslips/'.$payslip->file_path) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-2 rounded-full border border-blue-100 px-4 py-2 text-xs font-semibold text-blue-600 hover:bg-blue-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M7.5 11.25L12 15.75m0 0l4.5-4.5M12 15.75V3" />
                                    </svg>
                                    Download PDF
                                </a>
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ optional($payslip->created_at)->format('d M, Y') ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-sm text-gray-500">
                                No payslips available yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @php
            $isPaginated = is_a($payslips, \Illuminate\Pagination\AbstractPaginator::class);
        @endphp

        @if($isPaginated)
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $payslips->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
