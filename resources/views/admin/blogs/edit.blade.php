@extends('layouts.app')
@section('page-heading', 'Edit Blog')
@section('content')

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden max-w-5xl mx-auto">
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-2xl font-bold text-gray-900">Edit Blog</h1>
        </div>
        <a href="{{ route('admin.blogs.index') }}" class="text-gray-600 hover:underline">Back</a>
    </div>

    <div class="px-6 py-6">
        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" value="{{ $blog->title }}" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                    <select name="category_id" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" @selected($blog->category_id == $c->id)>{{ $c->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Featured Image</label>
                    <input type="file" name="image" class="w-full border border-gray-300 px-4 py-2 rounded bg-white">
                    @if($blog->image)
                        <img src="{{ asset('images/'.$blog->image) }}" class="h-20 mt-3 rounded border">
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">
                        <option value="">Select Status</option>
                        <option value="pending" {{ old('status', $blog->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ old('status', $blog->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="paused" {{ old('status', $blog->status) == 'paused' ? 'selected' : '' }}>Paused</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Short Description</label>
                <textarea name="short_description" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">{{ $blog->short_description }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Content</label>
                <textarea name="content" rows="6" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring">{{ $blog->content }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <button class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
                <a href="{{ route('admin.blogs.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
