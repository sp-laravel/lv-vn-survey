<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- <meta http-equiv="Cache-control" content="no-cache"> --}}
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv='expires' content='-1'>
  <meta http-equiv='pragma' content='no-cache'>

  @if ($role == 'tutor' || $role == 'coordinador' || $role == 'admin')
    <meta name="csrf-token" content="{{ csrf_token() }}">
  @endif


  <title>Encuestas Vonex</title>

  <!-- Icon -->
  <link rel="icon" href="{{ url('/img/favicon.ico') }}" type="image/x-icon" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

  {{-- Styles --}}
  <link rel="stylesheet" href="{{ url('/css/styles.css') }}">
  {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css"> --}}

  {{-- Scripts --}}
  <script src="https://kit.fontawesome.com/4a8a06bcc2.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
    integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <!-- LOADING -->
  <div class="loading w-100 vh-100 h-100 position-fixed justify-content-center align-items-center bg-white opacity-75">
    <div>
      {{-- <i class="fa-solid fa-ban" style="font-size: 2rem;"></i> --}}
      {{-- <i class="fa-solid fa-arrows-rotate text-secondary" style="font-size: 2rem;"></i> --}}
      <div class="spinner-border text-primary" role="status">
        <span class="sr-only"></span>
      </div>
    </div>
  </div>

  {{-- HEADER --}}
  <header class="bg-primary">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        {{-- Logo --}}
        <div class="py-3">
          <img src={{ url('/img/logo.png') }} width="150" alt="">
        </div>

        {{-- Session --}}
        <div>
          <div class="d-flex">
            {{-- <button class="m-auto btn btn-primary d-block" id="btnUpddate"> --}}
            {{-- <i class="text-warning fa-solid fa-arrow-rotate-right hover-effect" style="font-size: 2rem; cursor:pointer;"
              id="btnUpddate"></i> --}}
            {{-- </button> --}}
            @if (Route::has('login'))
              <div>
                @auth
                  {{-- <a href="{{ url('/dashboard') }}" class="text-white">Dashboard</a> --}}
                  <!-- Authentication -->
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link class="text-white" style="text-decoration: none;" :href="route('logout')"
                      onclick="event.preventDefault();
                    this.closest('form').submit();">
                      {{-- Cerrar Sesion --}}
                      {{-- <i class="bi bi-box-arrow-right" style="font-size: 2rem"></i> --}}
                      <i class="fa-solid fa-right-from-bracket hover-effect" style="font-size: 2rem"></i>
                      {{-- <span> Cerrar Sesion</span> --}}
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
    </div>
  </header>

  {{-- MAIN --}}
  @if ($role == 'tutor')
    <x-tutor :horaries="$horaries" :horarytimes="$horaryTimes" :horaryids="$horaryIds"></x-tutor>
  @elseif ($role == 'coordinador')
    <x-coordinator :cycles="$cycles"></x-coordinator>
  @elseif($role == 'alumno')
    <x-alumn :cycleactive="$cycleActive" :coursesurveysent="$courseSurveySent" :horarytimes="$horaryTimes" :type="$type" :questions="$questions"></x-alumn>
  @elseif($role == 'admin')
    <x-admin :sedes="$sedes"></x-admin>
  @endif

  <div class="update" id="btnUpddate">
    <i class="text-white fa-solid fa-arrow-rotate-right hover-effect" style="font-size: 1.5rem;"></i>
  </div>

  {{-- SCRIPTS --}}
  <script>
    let url = @json(url()->current());
  </script>
  <script src="{{ url('/js/scripts.js') }}"></script>

</body>

</html>
