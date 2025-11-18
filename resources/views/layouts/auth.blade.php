<!doctype html>
<html lang="en" class="h-full bg-gray-50">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title','Login')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: { 50:'#eef4ff',100:'#d9e6ff',500:'#2f74ff',700:'#1e4fc7' }
          }
        }
      }
    }
  </script>
  @stack('styles')
</head>
<body class="h-full flex items-center justify-center bg-gray-50">
  <div class="w-full max-w-md bg-white shadow rounded-xl p-8">
    @yield('content')
  </div>
  @stack('scripts')
</body>
</html>
