<div class="container mt-3">
  {{-- Top Block --}}
  <div class="mt-4 d-flex justify-content-between align-items-center">
    <h2 class="text-primary fw-bold">ENCUESTAS DIRECTORES</h2>
  </div>
  <div class="d-flex justify-content-between align-items-center">
    @auth
      <div class="mt-3 text-secondary">
        <div><b>EMAIL: </b>{{ Auth::user()->email }}</div>
      </div>
    @endauth
    <div></div>
  </div>

  {{-- Table --}}
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

              <input class="form-check-input horaryActive @if ($cycle->estado == 1) theone @endif"
                type="checkbox" name="horaryActive"
                onclick="activeStatus(this,{{ $cycle->dni_tutor }},'{{ $cycle->codigo_final }}')"
                value="{{ $cycle->estado }}" @if ($cycle->estado == 1) checked @endif>
            </div>
          </td>
        </tr>
      @endforeach
  </div>
</div>

<script>
  // Field
  let horaryChecks = document.querySelectorAll(".horaryActive");

  // Div
  let loadingRadios = document.querySelectorAll(".radio__loading");

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
  function updateStatus(dni, status, aula) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
    });
    $.ajax({
      type: 'POST',
      url: '/survey',
      data: {
        id: dni,
        status: status,
        aula: aula
      },
      success: function(data) {
        // $("#data").html(data.msg);
        // console.log("exito: " + data.msg);
      },

      error: function(msg) {
        console.log(msg);
        let errors = msg.responseJSON;
      }
    });
  }

  // Change switch
  function activeStatus(element, id, aula) {
    if ($('.horaryActive:checked').length > 1) {
      element.checked = false;

      Swal.fire({
        icon: 'error',
        title: `Solo un Tutor puede estar activo`,
        showConfirmButton: false,
        timer: 3000
      })
    } else {
      for (const loading of loadingRadios) {
        loading.classList.add("radio__loading--active");
      }
      let status = 0;
      if (element.classList.contains('theone')) {
        // if (element.checked) {
        element.classList.remove("theone");
        status = 0;
      } else {
        element.classList.add("theone");
        status = 1;
      }

      updateStatus(id, status, aula);
      setTimeout(function() {
        for (const loading of loadingRadios) {
          loading.classList.remove("radio__loading--active");
        }
      }, 3000);
    }
  }
</script>
