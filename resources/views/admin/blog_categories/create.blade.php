@extends('layouts.app')
@section('page-heading', 'Create Blog Category')

@section('content')

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden mx-auto">
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-xl font-bold text-gray-900">Create Blog Category</h1>
        </div>
        <a href="{{ route('admin.blog_categories.index') }}" class="text-gray-600 hover:underline">Back</a>
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

        <form action="{{ route('admin.blog_categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border border-gray-300 p-2 rounded focus:ring" placeholder="Enter category title">
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full border border-gray-300 p-2 rounded focus:ring" placeholder="Enter description">{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save Category</button>
                <a href="{{ route('admin.blog_categories.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
