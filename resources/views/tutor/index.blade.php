@extends('welcome')

@section('menu')
  @if (isset($config))
    @if ($config)
      <a href="{{ route('dashboard') }}">
        <i class="text-white fa-solid fa-gear" style="font-size: 2rem; cursor:pointer;" id="btn-config"></i>
      </a>
    @endif
  @endif
@endsection

@section('content')
  <div class="container mt-3">
    {{-- Top Block --}}
    <div class="mt-4 d-flex justify-content-between align-items-center">
      <h2 class="text-primary fw-bold">DASHBOARD TUTORES</h2>
    </div>
    <div class="d-flex justify-content-between align-items-center">
      @auth
        <div class="mt-3 text-secondary">
          <div><b>EMAIL: </b>{{ Auth::user()->email }}</div>
        </div>
      @endauth
      <div>
        <i class="fa-solid fa-clipboard-question text-primary" id="questions" style="font-size: 2rem;cursor: pointer;"
          data-bs-toggle="modal" data-bs-target="#modal-questions"></i>
      </div>
    </div>

    {{-- Table --}}
    <div class="mt-3">
      <div class="table-responsive">
        <table class="table table-striped table-sm table-hover">
          <thead>
            <tr class="bg-primary">
              <th class="text-white">INICIO</th>
              <th class="text-white">FIN</th>
              <th class="text-white">DOCENTE</th>
              <th class="text-white">HORARIO</th>
              <th class="text-white">CURSO</th>
              <th class="text-white">AULA</th>
              <th class="text-white">ESTADO</th>
              <th class="text-center text-white">ACTIVAR</th>
              <th class="text-center text-white">
                <i id="reload-table" class="fa-solid fa-arrows-rotate" style="cursor: pointer;"></i>
              </th>
            </tr>
          </thead>

          <tbody id="tutorBody">
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Questions -->
  <div class="modal fade" id="modal-questions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-4 text-primary fw-bold">
            ENCUESTA A DOCENTES
            <small id="title-questions"></small>
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="questions-list">
            @foreach ($questions as $question)
              <div class="d-flex gap-1 mb-1">
                <b class="text-secondary">{{ $question->numero_pregunta }}. </b>
                <b class="text-secondary">{{ $question->pregunta }}</b>
              </div>
              <div class="d-flex gap-4 justify-content-start mb-4">
                <span class="text-secondary"></span>
                @foreach ($options as $option)
                  <span class="text-secondary">{{ $option->opcion }}</span>
                @endforeach
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Survey -->
  <div class="modal fade" id="modal-survey" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">
            ALUMNOS ENCUESTADOS
            <small id="title-survey"></small>
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul id="modal-body" class="pl-0 text-secondary" style="padding: 0 !important;">

          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ url('/js/tutor_list.js') }}"></script>
  <script>
    // Data
    let horaryTimes = @json($horaryTimes);
    let timeRunning = new Date();
    let loadingRadios;
    let dni = @json(Auth::user()->persona_dni);
    let dashboard = 'tutor';

    // Field
    let horaryChecks = document.querySelectorAll(".horaryActive");

    // Load
    $(document).ready(function() {
      showTutorList(dni, dashboard);

      // setTimeout(() => {
      //   // Div
      //   loadingRadios = document.querySelectorAll(".radio__loading");
      //   for (const loading of loadingRadios) {
      //     loading.classList.add("radio__loading--active");
      //   }
      // }, 500);

      // setTimeout(function() {
      //   for (const loading of loadingRadios) {
      //     loading.classList.remove("radio__loading--active");
      //   }
      // }, 1000);
    })

    // Show tutor List
    function showTutorList(dni, dashboard) {
      // $.get("{{ URL::to('tutor_list') }}", function(data) {
      let link = `tutor_list/${dni}/${dashboard}`;
      $.get(`{{ URL::to('${link}') }}`, function(data) {
        $('#tutorBody').empty().html(data);
      })
    }

    // Show surveyed List
    function showSurveyedList(aula, curso, docente) {
      let link = `tutor_surveyed/${aula}/${curso}/${docente}`;
      $.get(`{{ URL::to('${link}') }}`, function(data) {
        $('#modal-body').empty().html(data);
        // console.log("reload table")
      })
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
          showTutorList();
          handleHardReload(url);
        }
      });
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

    // Get List Surveyed
    $(document).on('click', '.loadSurveyed', function(event) {
      // $('#modal-survey').modal('show');
      let aula = $(this).data('aula');
      let curso = $(this).data('curso');
      let docente = $(this).data('docente');

      showSurveyedList(aula, curso, docente);
    });

    // Validate Status
    function validateStatus() {
      if (status >= 1) {
        showTutorList()
      }
    }

    // Verify Status
    setInterval(validateStatus, 30000);
    setInterval(refreshWeb, 1000);
  </script>
@endsection
