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


  <div class="container mt-3">
    @if ($role == 'tutor')
      <x-tutor></x-tutor>
    @else
      @if (count($cycleActive) >= 1)
        <form action=" {{ route('encuesta_docente.store') }}" method="POST">
          @csrf
          <div class="questions text-secondary">
            <div class="question mb-4">
              <div class="mb-2">
                <b>1.¿El docente inició su clase puntualmente?</b>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n1" id="q120" value="20">
                <label class="form-check-label" for="q120">
                  Siempre
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n1" id="q115" value="15">
                <label class="form-check-label" for="q115">
                  Casi siempre
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n1" id="q110" value="10">
                <label class="form-check-label" for="q110">
                  Pocas veces
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n1" id="q105" value="5">
                <label class="form-check-label" for="q105">
                  Nunca
                </label>
              </div>
            </div>

            <div class="question mb-4">
              <div class="mb-2">
                <b>2.¿Entendiste la clase?</b>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n2" id="q220" value="20">
                <label class="form-check-label" for="q220">
                  Toda la clase
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n2" id="q215" value="15">
                <label class="form-check-label" for="q215">
                  Casi todo
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n2" id="q210" value="10">
                <label class="form-check-label" for="q210">
                  No mucho
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n2" id="q205" value="5">
                <label class="form-check-label" for="q205">
                  No entendí nada
                </label>
              </div>
            </div>

            <div class="question mb-4">
              <div class="mb-2">
                <b>3.¿El docente desarrolló toda la teoría de la clase y/o cómo mínimo el 70% de
                  las preguntas?</b>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n3" id="q320" value="20">
                <label class="form-check-label" for="q320">
                  Siempre
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n3" id="q315" value="15">
                <label class="form-check-label" for="q315">
                  Casi siempre
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n3" id="q310" value="10">
                <label class="form-check-label" for="q310">
                  Pocas veces
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n3" id="q305" value="5">
                <label class="form-check-label" for="q305">
                  Nunca
                </label>
              </div>
            </div>

            <div class="question mb-4">
              <div class="mb-2">
                <b>4.¿El docente es exigente en clase y se preocupa para que todos aprendan?</b>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n4" id="q420" value="20">
                <label class="form-check-label" for="q420">
                  Siempre
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n4" id="q415" value="15">
                <label class="form-check-label" for="q415">
                  Casi siempre
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n4" id="q410" value="10">
                <label class="form-check-label" for="q410">
                  Pocas veces
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="n4" id="q405" value="5">
                <label class="form-check-label" for="q405">
                  Nunca
                </label>
              </div>
            </div>
          </div>
          <input type="hidden" name="id" value="{{ $cycleActive[0] }}">
          <button type="submit" class="btn btn-primary btn-md" style="width: 150px;">Enviar</button>
        </form>
      @else
        <div class="flex justify-content-center align-items-center">
          <h4 class="text-center text-secondary mt-5">NO HAY ENCUESTAS</h4>
        </div>
      @endif
    @endif
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
