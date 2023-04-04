<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- <meta http-equiv="Cache-control" content="no-cache"> --}}
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv='expires' content='-1'>
  <meta http-equiv='pragma' content='no-cache'>

  <title>Encuestas</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

  <script src="https://kit.fontawesome.com/4a8a06bcc2.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
</head>

<body>

  <header class="bg-primary">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        {{-- Logo --}}
        <div class="py-3">
          <img src={{ url('/img/logo.png') }} width="150" alt="">
        </div>

        {{-- Session --}}
        <div>
          @if (Route::has('login'))
            <div>
              @auth
                {{-- <a href="{{ url('/dashboard') }}" class="text-white">Dashboard</a> --}}
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                  @csrf

                  <x-dropdown-link class="text-white" :href="route('logout')"
                    onclick="event.preventDefault();
                    this.closest('form').submit();">
                    {{-- Cerrar Sesion --}}
                    <i class="bi bi-box-arrow-right" style="font-size: 2rem"></i>
                  </x-dropdown-link>
                </form>
              @else
                <a href="{{ route('login') }}" class="text-white">Login</a>
                @if (Route::has('register'))
                  <a href="{{ route('register') }}" class="text-white">Register</a>
                @endif
              @endauth
            </div>
          @endif
        </div>
      </div>
    </div>
  </header>

  @if ($role == 'tutor')
    <x-tutor :horaries="$horaries" :horarytimes="$horaryTimes"></x-tutor>
  @else
    <x-alumn :cycleactive="$cycleActive" :coursesurveysent="$courseSurveySent"></x-alumn>
  @endif
</body>

</html>
