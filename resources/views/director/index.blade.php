@extends('welcome')

@section('content')
  <div class="container mt-3">
    {{-- Top Block --}}
    <div class="mt-4 d-flex justify-content-between align-items-center">
      <h2 class="text-primary fw-bold">DASHBOARD DIRECTORES</h2>
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
              <th class="text-white">AULA</th>
              <th class="text-white">TUTOR</th>
              <th class="text-center text-white">ACTIVAR</th>
              <th class="text-center text-white">
                <i id="reload-table" class="fa-solid fa-arrows-rotate" style="cursor: pointer;"></i>
              </th>
            </tr>
          </thead>

          <tbody id="directorBody">
          </tbody>
          <table>
      </div>
    </div>
  </div>
@endsection


@section('script')
  <script>
    // Data
    let loadingRadios;
    let reloadTable = document.querySelector('#reload-table');

    // Field
    let horaryChecks = document.querySelectorAll(".horaryActive");

    // Load
    $(document).ready(function() {
      showDirectorList();
      // setTimeout(() => {
      //   // Div
      //   loadingRadios = document.querySelectorAll(".radio__loading");
      // }, 500);
    })

    // Show tutor List
    function showDirectorList() {
      $.get("{{ URL::to('director_list') }}", function(data) {
        $('#directorBody').empty().html(data);
        // console.log("reload table")
      })
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
    function updateStatus(dni, status, aula) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      });
      $.ajax({
        type: 'POST',
        // url: '/survey',
        url: url + '/survey',
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

        updateStatus(id, status, aula);
        setTimeout(function() {
          // for (const loading of loadingRadios) {
          //   loading.classList.remove("radio__loading--active");
          // }
        }, 3000);
      }
    }

    reloadTable.addEventListener('click', function() {
      showDirectorList();
      console.log("reload");
    })
  </script>
@endsection
