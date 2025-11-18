@extends('layouts.auth')

@section('title','Login')

@section('content')
  <h1 class="text-2xl font-bold text-center mb-6 text-brand-700">Admin Login</h1>

  @if ($errors->any())
    <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-600">
      <ul class="list-disc list-inside">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}" class="space-y-5">
    @csrf
    <div>
      <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
      <input id="email" type="email" name="email" required autofocus
             class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500" />
    </div>

    <div>
      <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
      <input id="password" type="password" name="password" required
             class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-brand-500" />
    </div>

    <div class="flex items-center justify-between">
      <label class="flex items-center text-sm">
        <input type="checkbox" name="remember" class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
        <span class="ml-2 text-gray-600">Remember me</span>
      </label>
      <a href="#" class="text-sm text-brand-600 hover:underline">Forgot password?</a>
      {{-- <a href="{{ route('password.request') }}" class="text-sm text-brand-600 hover:underline">Forgot password?</a> --}}
    </div>

    <button type="submit"
            class="w-full bg-brand-600 text-white py-2 px-4 rounded-lg hover:bg-brand-700 focus:ring-2 focus:ring-brand-500">
      Login
    </button>
  </form>
@endsection
