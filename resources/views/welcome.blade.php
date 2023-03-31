<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Encuestas</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
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
                    Cerrar Sesion
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


  <div class="container">
    @auth
      <div class="mt-3 text-success fw-bold">{{ Auth::user()->email }}</div>
    @endauth

    <div class="">
      {{-- {{ $newDate = date('l') }} --}}
    </div>

    <div class="mt-3">
      <table class="table table-striped table-hover">
        <tr class="bg-success">
          <th class="text-white">INICIO</th>
          <th class="text-white">FIN</th>
          <th class="text-white">DOCENTE</th>
          <th class="text-white">CURSO</th>
          <th class="text-white">AULA</th>
          <th class="text-white">ESTADO</th>
          <th class="text-white text-center">ACTIVAR</th>
        </tr>

        @foreach ($horaries as $horary)
          <tr>
            <td class="text-secondary">{{ $horary->h_fin }}</td>
            <td class="text-secondary">{{ $horary->h_inicio }}</td>
            <td class="text-secondary">{{ $horary->docente }}</td>
            <td class="text-secondary">{{ $horary->asignatura }}</td>
            <td class="text-secondary">{{ $horary->aula }}</td>
            <td style="width: 110px;"
              @if ($horary->status == 'Por tomar') class="text-danger"
              @elseif ($horary->status == 'Encuestando')
                class="text-warning"
              @else
                class="text-success" @endif>
              <span>
                {{ $horary->status }}
              </span>
            </td>
            <td>
              <div class="form-check form-switch d-flex justify-content-center">
                <input class="form-check-input" type="radio" name="flexRadioDefault"
                  value="{{ $horary->aula . '","' . $horary->id }}">
              </div>
            </td>
          </tr>
        @endforeach
    </div>
  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
    integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $("input:radio").on("click", function(e) {
      let inp = $(this); //cache the selector
      if (inp.is(".theone")) { //see if it has the selected class
        inp.prop("checked", false).removeClass("theone");
        return;
      }
      $("input:radio[name='" + inp.prop("name") + "'].theone").removeClass("theone");
      inp.addClass("theone");
    });
  </script>
</body>

</html>
