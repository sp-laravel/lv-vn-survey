@extends('welcome')

@section('content')
  {{-- Message Success Survey --}}
  @if (session('success'))
    <script>
      let msgBack = @json(session('success'));
      Swal.fire({
        icon: 'success',
        title: `${msgBack['date']} / ${msgBack['time']}`,
        // text: `${msgBack['msg']}`,
        // showConfirmButton: false,
        // timer: 3000
      })
    </script>
  @endif
  {{-- Message Error Survey --}}
  @if (session('error'))
    <script>
      let msgBack = @json(session('error'));
      Swal.fire({
        icon: 'error',
        title: `${msgBack}`,
        showConfirmButton: false,
        timer: 3000
      })
    </script>
  @endif

  <div id="sectionForm" class="container px-4 pb-4 mt-4">
  </div>
  {{-- <button class="btn btn-primary" id="reloadTable">update</button> --}}
@endsection

@section('script')
  <script>
    let horaryTimes = @json($horaryTimes);
    let timeRunning = new Date();
    // let reloadTable = document.querySelector("#reloadTable");

    // Load
    $(document).ready(function() {
      showAlumnForm();
    })

    // Show tutor List
    function showAlumnForm() {
      $.get("{{ URL::to('alumn_form') }}", function(data) {
        $('#sectionForm').empty().html(data);
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
          showAlumnForm();
          handleHardReload(url);
        }
      });
    }

    setInterval(refreshWeb, 1000);

    // reloadTable.addEventListener('click', function() {
    //   showAlumnForm();
    //   console.log("reload");
    // })
  </script>
@endsection
