@extends('layouts.app')
@section('page-heading', 'Create Job')
@section('content')

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden max-w-4xl mx-auto">
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-2xl font-bold text-gray-900">Create Job</h1>
        </div>
        <a href="{{ route('admin.jobs.index') }}" class="text-gray-600 hover:underline">Back</a>
    </div>

    <div class="px-6 py-6">
        <form action="{{ route('admin.jobs.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Job Title</label>
                    <input type="text" name="title" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring focus:ring-blue-200" placeholder="Job title">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
                    <input type="text" name="location" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring focus:ring-blue-200" placeholder="Job location">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Job Type</label>
                    <select name="type" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                        <option value="">Select Type</option>
                        <option>Full-time</option>
                        <option>Part-time</option>
                        <option>Remote</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Salary</label>
                    <input type="number" step="0.01" name="salary" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring" placeholder="Salary (optional)">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Job Description</label>
                <textarea name="description" rows="6" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring" placeholder="Full job details..."></textarea>
            </div>

            <div class="flex items-center gap-3">
                <button class="bg-blue-600 text-white px-6 py-2 rounded shadow-sm">Save Job</button>
                <a href="{{ route('admin.jobs.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
