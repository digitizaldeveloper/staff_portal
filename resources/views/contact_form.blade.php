@extends('layouts.app')

@section('page-heading', 'Contact Us')

@section('content')

<div class="mx-auto bg-white shadow-md rounded-lg p-8 mt-10">

    <h1 class="text-xl font-semibold text-gray-900">Contact Us</h1>
    <p class="text-sm text-gray-500">Get in touch with us for any questions or inquiries.</p>

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-gray-700 font-semibold mb-1">Name</label>
            <input type="text" name="name"
                   class="w-full border rounded-lg px-4 py-2"
                   value="{{ old('name') }}" required>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-1">Email</label>
            <input type="email" name="email"
                   class="w-full border rounded-lg px-4 py-2"
                   value="{{ old('email') }}" required>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-1">Phone (Optional)</label>
            <input type="text" name="phone"
                   class="w-full border rounded-lg px-4 py-2"
                   value="{{ old('phone') }}">
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-1">Message</label>
            <textarea name="message"
                      class="w-full border rounded-lg px-4 py-2 h-32"
                      required>{{ old('message') }}</textarea>
        </div>

        <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
            Send Message
        </button>
    </form>

</div>

@endsection
