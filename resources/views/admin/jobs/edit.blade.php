@extends('layouts.app')
@section('page-heading', 'Edit Job')
@section('content')

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden max-w-4xl mx-auto">
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-2xl font-bold text-gray-900">Edit Job</h1>
        </div>
        <a href="{{ route('admin.jobs.index') }}" class="text-gray-600 hover:underline">Back</a>
    </div>

    <div class="px-6 py-6">
        <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Job Title</label>
                    <input type="text" name="title" value="{{ old('title', $job->title) }}" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Job Type</label>
                    <select name="type" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                        <option value="">Select Type</option>
                        <option value="Full-time" {{ old('type', $job->type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="Part-time" {{ old('type', $job->type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="Remote" {{ old('type', $job->type) == 'Remote' ? 'selected' : '' }}>Remote</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
                    <input type="text" name="location" value="{{ old('location', $job->location) }}" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Salary (Optional)</label>
                    <input type="text" name="salary" value="{{ old('salary', $job->salary) }}" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Job Description</label>
                <textarea name="description" rows="5" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">{{ old('description', $job->description) }}</textarea>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Update Job</button>
                <a href="{{ route('admin.jobs.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
