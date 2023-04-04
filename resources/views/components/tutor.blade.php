<div class="container mt-3">
  @auth
    <div class="mt-3 text-success fw-bold">{{ Auth::user()->email }}</div>
  @endauth

  {{-- Table Tutor --}}
  <div class="mt-3">
    <table class="table table-striped table-hover">
      <tr class="bg-success">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
  integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  // Data
  let url = "http://127.0.0.1:8000/";
  // console.log(url);
  let horaryTimes = @json($horaryTimes);
  // console.log(horaryTimes);
  let timeRunning = new Date();

  // Forece Clean Cache
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
        console.log(timeRunningNow);
        console.log(timeHoraryActive);
        console.log("reload");
        handleHardReload(url);
      }
    });
  }

  setInterval(refreshWeb, 1000);

  // Radiobutton On/Off
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
