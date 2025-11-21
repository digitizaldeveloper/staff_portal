@extends('layouts.app')

@section('page-heading', 'Add Payslip')

@section('content')

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden mx-auto">
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-xl font-bold text-gray-900">Add Payslip</h1>
        </div>
        <a href="{{ route('admin.payslips.index') }}" class="text-gray-600 hover:underline">Back</a>
    </div>

    <div class="px-6 py-6">
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.payslips.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Select Staff</label>
                <select name="staff_id" class="w-full border border-gray-300 p-2 rounded focus:ring">
                    <option value="">-- Select Staff --</option>
                    @foreach($staff as $user)
                        <option value="{{ $user->id }}" {{ old('staff_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                @error('staff_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Pay Period</label>
                <input type="month" name="pay_period" value="{{ old('pay_period') }}" class="w-full border border-gray-300 p-2 rounded focus:ring">
                @error('pay_period')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Upload PDF</label>
                <input type="file" name="file" class="w-full p-2 border rounded bg-gray-50">
                @error('file')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Upload Payslip</button>
                <a href="{{ route('admin.payslips.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            </div>

        </form>
    </div>
</div>

@endsection
