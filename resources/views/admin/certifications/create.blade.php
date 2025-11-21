@extends('layouts.app')

@section('page-heading', 'Add Certification')
@section('content')

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden mx-auto">
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-xl font-bold text-gray-900">Add Certification</h1>
        </div>
        <a href="{{ route('admin.certifications.index') }}" class="text-gray-600 hover:underline">Back</a>
    </div>

    <div class="px-6 py-6">
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.certifications.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Select Staff</label>
                <select name="staff_id" class="w-full border border-gray-300 rounded p-2 focus:ring">
                    <option value="">-- Choose Staff --</option>
                    @foreach ($staff as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Certification Name</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded p-2 focus:ring" placeholder="White Card, First Aid, etc">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Number / ID</label>
                <input type="text" name="number" class="w-full border border-gray-300 rounded p-2 focus:ring" placeholder="ABC-123456">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Issue Date</label>
                    <input type="date" name="issue_date" class="w-full border border-gray-300 rounded p-2 focus:ring">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Expiry Date</label>
                    <input type="date" name="expiry_date" class="w-full border border-gray-300 rounded p-2 focus:ring">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Save Certification</button>
                <a href="{{ route('admin.certifications.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
