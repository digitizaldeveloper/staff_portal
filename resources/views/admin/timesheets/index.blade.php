@extends('layouts.app')
@section('page-heading', 'Timesheets')

@section('content')
<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">

    {{-- Header Section Inside Card --}}
    <div class="px-6 py-6 border-b border-gray-200">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-xl font-bold text-gray-900">Timesheets</h1>
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="px-6 py-6 border-b border-gray-200 bg-gray-50">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Staff</label>
                <select name="staff_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">All Staff</option>
                    @foreach($staff as $user)
                        <option value="{{ $user->id }}" 
                            {{ request('staff_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Client</label>
                <select name="client_id" class="w-full border border-gray-300 rounded p-2">
                    <option value="">All Clients</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}"
                            {{ request('client_id') == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">From</label>
                <input type="date" name="from" value="{{ request('from') }}" class="w-full border border-gray-300 p-2 rounded">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">To</label>
                <input type="date" name="to" value="{{ request('to') }}" class="w-full border border-gray-300 p-2 rounded">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 p-2 rounded">
                    <option value="">All</option>
                    <option value="pending"  {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="md:col-span-5 flex gap-2">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm transition">Filter</button>

                <a href="{{ route('admin.timesheets.export') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm transition">
                   Export CSV
                </a>
            </div>

        </form>
    </div>

    {{-- TIMESHEET TABLE --}}
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Staff</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Client</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Date</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Hours</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Status</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            @foreach ($timesheets as $sheet)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $sheet->staff->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $sheet->client->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $sheet->date }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $sheet->total_hours }} hrs</td>
                <td class="px-6 py-4 text-sm">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                        @if($sheet->status=='pending') bg-yellow-100 text-yellow-800
                        @elseif($sheet->status=='approved') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($sheet->status) }}
                    </span>
                </td>

                <td class="px-6 py-4 text-sm">
                    <a href="{{ route('admin.timesheets.show', $sheet->id) }}"
                       class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded text-sm transition">
                       View
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>
@endsection
