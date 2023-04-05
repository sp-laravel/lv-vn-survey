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
        <th class="text-white">INICIO</th>
        <th class="text-white">FIN</th>
        <th class="text-white">DOCENTE</th>
        <th class="text-white">CURSO</th>
        <th class="text-white">AULA</th>
        <th class="text-white">ESTADO</th>
        <th class="text-center text-white">ACTIVAR</th>
      </tr>

      @foreach ($horaries as $horary)
        <tr>
          <td class="text-secondary">{{ $horary->h_fin }}</td>
          <td class="text-secondary">{{ $horary->h_inicio }}</td>
          <td class="text-secondary">{{ $horary->docente }}</td>
          <td class="text-secondary">{{ $horary->asignatura }}</td>
          <td class="text-secondary">{{ $horary->aula }}</td>
          <td style="width: 110px;"
            @if ($horary->proceso == 'Por tomar') class="text-danger"
              @elseif ($horary->proceso == 'Encuestando')
                class="text-warning"
              @else
                class="text-success" @endif>
            <span>
              {{ $horary->proceso }}
            </span>
          </td>
          <td>
            <div class="form-check form-switch d-flex justify-content-center position-relative">
              <div class="radio__loading position-absolute"></div>
              <input class="form-check-input horaryActive @if ($horary->estado == 1) theone @endif"
                type="checkbox" name="horaryActive" onclick="activeStatus(this,{{ $horary->id }})"
                value="{{ $horary->id }}" @if ($horary->estado == 1) checked @endif>
            </div>
          </td>
        </tr>
      @endforeach
  </div>
</div>

<div class="token">
  <form action="{{ route('horary') }}">
    {{-- <input type="button" class="button" onclick="updateHoraryStatus()" value="Send"> --}}
  </form>
  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
  integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  // Data
  // let url = @json(url()->current());
  let horaryTimes = @json($horaryTimes);
  let horaryIds = @json($horaryIds);
  let timeRunning = new Date();
  // console.log(horaryTimes);

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

  // Refresh Web by horary
  function refreshWeb() {
    let x = new Date()
    let ampm = x.getHours() >= 12 ? '' : '';
    hours = x.getHours();
    hours = hours.toString().length == 1 ? 0 + hours.toString() : hours;

    let minutes = x.getMinutes().toString()
    minutes = minutes.length == 1 ? 0 + minutes : minutes;
    let seconds = x.getSeconds().toString()
    seconds = seconds.length == 1 ? 0 + seconds : seconds;
    let month = (x.getMonth() + 1).toString();
    month = month.length == 1 ? 0 + month : month;

    let dt = x.getDate().toString();
    dt = dt.length == 1 ? 0 + dt : dt;

    // console.log(`${hours}:${minutes}:${seconds}`);

    let hoursTemp = x.getHours();
    let minutesTemp = x.getMinutes();
    let secondsTemp = x.getSeconds();
    timeRunning.setHours(hoursTemp, minutesTemp, secondsTemp);
    let timeRunningNow = timeRunning.toLocaleTimeString();

    horaryTimes.forEach(time => {
      let timeHorary = new Date();
      let timeTemp = time.split(':');
      let extractHour = timeTemp[0];
      let extractMinute = timeTemp[1];

      timeHorary.setHours(extractHour, extractMinute, 00);
      let timeHoraryActive = timeHorary.toLocaleTimeString();

      if (timeRunningNow == timeHoraryActive) {
        console.log("reload");
        handleHardReload(url);
      }
    });
  }

  setInterval(refreshWeb, 1000);

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
        status: status,
        ids: horaryIds
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
