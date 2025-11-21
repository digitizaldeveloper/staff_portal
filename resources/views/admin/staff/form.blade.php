@extends('layouts.app')

@section('page-heading', $member ? 'Edit Staff Member' : 'Add Staff Member')

@section('content')

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden mx-auto">
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-xl font-bold text-gray-900">{{ $member ? 'Edit Staff Member' : 'Add Staff Member' }}</h1>
        </div>
        <a href="{{ route('admin.staff.index') }}" class="text-gray-600 hover:underline">Back</a>
    </div>

    <div class="px-6 py-6">
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc ml-4 text-sm">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ $member ? route('admin.staff.update', $member->id) : route('admin.staff.store') }}" method="POST">

            @csrf
            @if($member)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $member->name ?? '') }}" class="w-full border border-gray-300 p-2 rounded focus:ring" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $member->email ?? '') }}" class="w-full border border-gray-300 p-2 rounded focus:ring" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 p-2 rounded focus:ring">
                    <option value="Active" {{ old('status', $member->status ?? '') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status', $member->status ?? '') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Password
                    @if($member)
                        <span class="text-gray-500 text-sm">(Leave blank to keep old password)</span>
                    @endif
                </label>
                <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded focus:ring">
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 p-2 rounded focus:ring">
            </div>

            <div class="flex items-center gap-3">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">{{ $member ? 'Update Staff Member' : 'Create Staff Member' }}</button>
                <a href="{{ route('admin.staff.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            </div>

        </form>

    </div>
</div>

@endsection
