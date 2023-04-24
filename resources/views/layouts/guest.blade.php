<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Encuestas Login Vonex</title>

  <!-- Icon -->
  <link rel="icon" href="{{ url('/img/favicon.ico') }}" type="image/x-icon" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased text-gray-900">
  <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0">

    <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
      <div class="py-5">
        <a href="/">
          {{-- <x-application-logo class="w-20 h-20 text-gray-500 fill-current" /> --}}
          <img src={{ url('/img/logo_blue.png') }} width="200" alt="" class="mx-auto">
          <h3 class="py-0 text-center fw-bold" style="color: #0053A3;font-size: 1.5rem;">ENCUESTAS</h3>
        </a>
      </div>

      {{ $slot }}
    </div>
  </div>
</body>

</html>
