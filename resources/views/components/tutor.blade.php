<div class="container mt-3">
  {{-- Top Block --}}
  <div class="mt-4 d-flex justify-content-between align-items-center">
    <h2 class="text-primary fw-bold">ENCUESTAS TUTORES</h2>
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
    <div class="table-responsive">
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
        <table>
    </div>
  </div>
</div>

<script>
  // Data
  let horaryTimes = @json($horaryTimes);
  let horaryIds = @json($horaryIds);
  let timeRunning = new Date();

  // Field
  let horaryChecks = document.querySelectorAll(".horaryActive");

  // Div
  let loadingRadios = document.querySelectorAll(".radio__loading");

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
      // url: '/horary',
      url: url + '/horary',
      data: {
        id: idHorary,
        status: status
      },
      success: function(data) {
        // $("#data").html(data.msg);
      },

      error: function(msg) {
        console.log(msg);
        let errors = msg.responseJSON;
      }
    });
  }

  // Change switch
  function activeStatus(element, id) {
    // if ($(".horaryActive").is(":checked")) {
    if ($('.horaryActive:checked').length > 1) {
      element.checked = false;

      Swal.fire({
        icon: 'error',
        title: `Solo un Docente puede estar activo`,
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
      updateHoraryStatus(id, status);
      setTimeout(function() {
        for (const loading of loadingRadios) {
          loading.classList.remove("radio__loading--active");
        }
      }, 2000);
    }
  }
</script>
