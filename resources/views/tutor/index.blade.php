@extends('welcome')

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
      <div></div>
    </div>

    {{-- Table --}}
    <div class="mt-3">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr class="bg-primary">
              <th class="text-white">INICIO</th>
              <th class="text-white">FIN</th>
              <th class="text-white">DOCENTE</th>
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
          <table>
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
          <ul id="modal-body">

          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('script')
  <script>
    // Data
    let horaryTimes = @json($horaryTimes);
    let timeRunning = new Date();
    let loadingRadios;

    // Div
    let reloadTable = document.querySelector('#reload-table');

    // Field
    let horaryChecks = document.querySelectorAll(".horaryActive");

    // Load
    $(document).ready(function() {
      showTutorList();

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
    function showTutorList() {
      $.get("{{ URL::to('tutor_list') }}", function(data) {
        $('#tutorBody').empty().html(data);
        // console.log("reload table")
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
          title: `Solo una encuesta puede estar activa`,
          showConfirmButton: false,
          timer: 3000
        })
      } else {
        // for (const loading of loadingRadios) {
        //   loading.classList.add("radio__loading--active");
        // }
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
        showTutorList();
        // setTimeout(function() {
        //   for (const loading of loadingRadios) {
        //     loading.classList.remove("radio__loading--active");
        //   }
        // }, 2000);
      }
    }

    // Get List Surveyed
    $(document).on('click', '.loadSurveyed', function(event) {
      // $('#modal-survey').modal('show');
      let aula = $(this).data('aula');
      let curso = $(this).data('curso');
      let docente = $(this).data('docente');

      showSurveyedList(aula, curso, docente);
    });

    // Update Table
    reloadTable.addEventListener('click', function() {
      showTutorList();
    })

    // Verify Status
    setInterval(validateStatus, 30000);

    // Validate Status
    function validateStatus() {
      if (status >= 1) {
        showTutorList()
      }
    }
  </script>
@endsection
