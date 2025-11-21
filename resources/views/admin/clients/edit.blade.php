@extends('layouts.app')
@section('page-heading', 'Edit Client')

@section('content')

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden mx-auto">
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-xl font-bold text-gray-900">Edit Client</h1>
        </div>
        <a href="{{ route('admin.clients.index') }}" class="text-gray-600 hover:underline">Back</a>
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

        <form action="{{ route('admin.clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                <input name="name" value="{{ old('name', $client->name) }}" class="w-full border border-gray-300 p-2 rounded focus:ring" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input name="email" value="{{ old('email', $client->email) }}" class="w-full border border-gray-300 p-2 rounded focus:ring" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                <input name="phone" value="{{ old('phone', $client->phone) }}" class="w-full border border-gray-300 p-2 rounded focus:ring">
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Address</label>
                <textarea name="address" class="w-full border border-gray-300 p-2 rounded focus:ring">{{ old('address', $client->address) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 p-2 rounded focus:ring">
                    <option value="1" {{ $client->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$client->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="flex items-center gap-3">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Update Client</button>
                <a href="{{ route('admin.clients.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
