<div class="container mt-3">
  <div class="d-flex justify-content-between align-items-center">
    @auth
      <div class="mt-3 text-primary fw-bold">{{ Auth::user()->email }}</div>
    @endauth
    <div>
      <button class="btn btn-primary" id="btnUpddate">
        <i class="fa-solid fa-arrow-rotate-right text-white"></i>
      </button>
    </div>
  </div>

  {{-- Table Tutor --}}
  <div class="mt-3">
    <table class="table table-striped table-hover">
      <tr class="bg-primary">
        <th class="text-white">AULA</th>
        <th class="text-white">TUTOR</th>
        <th class="text-center text-white">ACTIVAR</th>
      </tr>

      @foreach ($cycles as $cycle)
        <tr>
          <td class="text-secondary">{{ $cycle->codigo_final }}</td>
          <td class="text-secondary">{{ $cycle->apellido_tutor }} {{ $cycle->apellido_tutor }}</td>
          <td>
            <div class="form-check form-switch d-flex justify-content-center position-relative">
              <div class="radio__loading position-absolute"></div>
              <input class="form-check-input horaryActive 
                type="checkbox" name="horaryActive"
                onclick="activeStatus(this)">
            </div>
          </td>
        </tr>
      @endforeach
  </div>
</div>

<div class="token">
  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
  integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  // Data

  // Field
  // let _token = document.querySelector("#token");
  let horaryChecks = document.querySelectorAll(".horaryActive");

  // Div
  let loadingRadios = document.querySelectorAll(".radio__loading");

  // Force Clean Cache
  async function handleHardReload(url) {
    await fetch(url, {
      headers: {
        Pragma: 'no-cache',
        Expires: '-1',
        'Cache-Control': 'no-cache',
      },
    });
    window.location.href = url;
    // This is to ensure reload with url's having '#'
    window.location.reload();
  }

  // Radiobutton On/Off
  $("input:radio").on("click", function(e) {
    let inp = $(this);
    if (inp.is(".theone")) {
      inp.prop("checked", false).removeClass("theone");
      inp.checked = false;
      return;
    }
    $("input:radio[name='" + inp.prop("name") + "'].theone").removeClass("theone");
    inp.addClass("theone");
  });

  // Update Swich
  function updateHoraryStatus(idHorary, status) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
    });
    $.ajax({
      type: 'POST',
      url: '/horary',
      data: {
        id: idHorary,
      },
      success: function(data) {
        // $("#data").html(data.msg);
        console.log("exito: " + data.msg);
      },

      error: function(msg) {
        console.log(msg);
        let errors = msg.responseJSON;
      }
    });
  }

  // Change switch
  function activeStatus(element, id) {
    for (const loading of loadingRadios) {
      loading.classList.add("radio__loading--active");
    }
    let status = 0;
    if (element.classList.contains('theone')) {
      // if (element.checked) {
      status = 0;
    } else {
      status = 1;
    }
    updateHoraryStatus(id, status);
    setTimeout(function() {
      for (const loading of loadingRadios) {
        loading.classList.remove("radio__loading--active");
      }
    }, 2000);
  }
  // console.log(horaryIds);
</script>
