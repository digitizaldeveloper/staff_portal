@extends('layouts.app')
@section('page-heading', 'Create Blog')
@section('content')

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden max-w-5xl mx-auto">
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-2xl font-bold text-gray-900">Create Blog</h1>
        </div>
        <a href="{{ route('admin.blogs.index') }}" class="text-gray-600 hover:underline">Back</a>
    </div>

    <div class="px-6 py-6">
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring" placeholder="Enter blog title">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                    <select name="category_id" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                        <option value="">Select Category</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Featured Image</label>
                    <input type="file" name="image" class="w-full border border-gray-300 px-4 py-2 rounded bg-white">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                        <option value="">Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="paused">Paused</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Short Description</label>
                <textarea name="short_description" rows="3" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring" placeholder="Write a short description"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Content</label>
                <textarea name="content" rows="8" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring" placeholder="Write full blog content"></textarea>
            </div>

            <div class="flex items-center gap-3">
                <button class="bg-blue-600 text-white px-6 py-2 rounded shadow-sm">Save Blog</button>
                <a href="{{ route('admin.blogs.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
