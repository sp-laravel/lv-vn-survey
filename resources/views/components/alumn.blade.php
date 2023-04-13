{{-- Message Success Survey --}}
@if (session('success'))
  <script>
    let msgBack = @json(session('success'));
    Swal.fire({
      icon: 'success',
      title: `${msgBack}`,
      showConfirmButton: false,
      timer: 3000
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

{{-- Validate Survey Sent --}}
@if ($courseSurveySent == 0)
  {{-- Validate Survey Teacher --}}
  @if (count($cycleActive) == 6 && $type == 'docente')
    <div class="container px-4 mt-4 pb-4">
      <h2 class="mb-4 text-center text-primary fw-bold" style="font-size: 2rem;">ENCUESTA AL DOCENTE</h2>
      <form action=" {{ route('encuesta_docente.store') }}" method="POST" name="survey" id="survey"
        class=""survey>
        @csrf
        <div class="questions text-secondary">
          @foreach ($questions as $question)
            <div class="mb-4 question">
              <div class="mb-2 d-flex">
                <span class="index-list">{{ $question->numero_pregunta }}. </span>
                <b class="tagN{{ $question->numero_pregunta }}">{{ $question->pregunta }}</b>
              </div>
              <div class="form-check my-3">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}20" value="20">
                <label class="form-check-label" style="padding-left: 1rem;" for="q{{ $question->numero_pregunta }}20">
                  Siempre
                </label>
              </div>
              <div class="form-check my-3">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}15" value="15">
                <label class="form-check-label" style="padding-left: 1rem;" for="q{{ $question->numero_pregunta }}15">
                  Casi siempre
                </label>
              </div>
              <div class="form-check my-3">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}10" value="10">
                <label class="form-check-label" style="padding-left: 1rem;" for="q{{ $question->numero_pregunta }}10">
                  Pocas veces
                </label>
              </div>
              <div class="form-check my-3">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}05" value="5">
                <label class="form-check-label" style="padding-left: 1rem;" for="q{{ $question->numero_pregunta }}05">
                  Nunca
                </label>
              </div>
            </div>
          @endforeach
        </div>
        <input type="hidden" name="id" value="{{ $cycleActive[0] }}">
        <button type="submit" class="btn btn-primary btn-md" style="width: 150px;">Enviar</button>
      </form>
    </div>

    <script>
      //Data 
      let horaryTimes = @json($horaryTimes);
      let timeRunning = new Date();
      // console.log(horaryTimes);

      //Fields
      let n1 = document.survey.n1;
      let n2 = document.survey.n2;
      let n3 = document.survey.n3;
      let n4 = document.survey.n4;

      //tag
      let tn1 = document.querySelector(".tagN1");
      let tn2 = document.querySelector(".tagN2");
      let tn3 = document.querySelector(".tagN3");
      let tn4 = document.querySelector(".tagN4");

      survey.addEventListener("submit", function(e) {
        if (n1.value == '') {
          tn1.classList.add("text-danger");
          e.preventDefault()
        } else {
          tn1.classList.remove("text-danger");
        }
        if (n2.value == '') {
          tn2.classList.add("text-danger");
          e.preventDefault()
        } else {
          tn2.classList.remove("text-danger");
        }
        if (n3.value == '') {
          tn3.classList.add("text-danger");
          e.preventDefault()
        } else {
          tn3.classList.remove("text-danger");
        }
        if (n4.value == '') {
          tn4.classList.add("text-danger");
          e.preventDefault()
        } else {
          tn4.classList.remove("text-danger");
        }
        if (n1.value == '' || n2.value == '' || n3.value == '' || n4.value == '') {
          Swal.fire({
            icon: 'error',
            title: 'Debes completar el formulario',
            showConfirmButton: false,
            timer: 3000
          })
        }
      });

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
    </script>

    {{-- Validate Survey Tutor --}}
  @elseif (count($cycleActive) == 3 && $type == 'tutor')
    <div class="container px-4 mt-4 pb-4">
      <h2 class="mb-4 text-center text-primary fw-bold" style="font-size: 2rem;">ENCUESTA AL TUTOR</h2>
      <form action=" {{ route('encuesta_tutor.store') }}" method="POST" name="survey" id="survey"
        class=""survey>
        @csrf
        <div class="questions text-secondary">
          @foreach ($questions as $question)
            <div class="mb-4 question">
              <div class="mb-2 d-flex">
                <span class="index-list">{{ $question->numero_pregunta }}. </span><b
                  class="tagN{{ $question->numero_pregunta }}">{{ $question->pregunta }}</b>
              </div>

              <span>Nunca</span>
              <div class="form-check my-2">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}1" value="1">
                <label class="form-check-label" style="padding-left: 1rem;" style="padding-left: 1rem;"
                  for="q{{ $question->numero_pregunta }}1">
                  1
                </label>
              </div>
              <div class="form-check my-3">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}2" value="2">
                <label class="form-check-label" style="padding-left: 1rem;" for="q{{ $question->numero_pregunta }}2">
                  2
                </label>
              </div>
              <div class="form-check my-3">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}3" value="3">
                <label class="form-check-label" style="padding-left: 1rem;" for="q{{ $question->numero_pregunta }}3">
                  3
                </label>
              </div>
              <div class="form-check my-3">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}4" value="4">
                <label class="form-check-label" style="padding-left: 1rem;"
                  for="q{{ $question->numero_pregunta }}4">
                  4
                </label>
              </div>

              <div class="form-check my-3">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}5" value="5">
                <label class="form-check-label" style="padding-left: 1rem;"
                  for="q{{ $question->numero_pregunta }}5">
                  5
                </label>
              </div>
              <span>Siempre</span>
            </div>
          @endforeach
        </div>
        <input type="hidden" name="id" value="{{ $cycleActive[0] }}">
        <button type="submit" class="btn btn-primary btn-md" style="width: 150px;">Enviar</button>
      </form>
    </div>

    <script>
      //Fields
      let n1 = document.survey.n1;
      let n2 = document.survey.n2;
      let n3 = document.survey.n3;
      let n4 = document.survey.n4;
      let n5 = document.survey.n5;
      let n6 = document.survey.n6;
      let n7 = document.survey.n7;
      let n8 = document.survey.n8;

      //tag
      let tn1 = document.querySelector(".tagN1");
      let tn2 = document.querySelector(".tagN2");
      let tn3 = document.querySelector(".tagN3");
      let tn4 = document.querySelector(".tagN4");
      let tn5 = document.querySelector(".tagN5");
      let tn6 = document.querySelector(".tagN6");
      let tn7 = document.querySelector(".tagN7");
      let tn8 = document.querySelector(".tagN8");

      survey.addEventListener("submit", function(e) {
        if (n1.value == '') {
          tn1.classList.add("text-danger");
          e.preventDefault()
        } else {
          tn1.classList.remove("text-danger");
        }
        if (n2.value == '') {
          tn2.classList.add("text-danger");
          e.preventDefault()
        } else {
          tn2.classList.remove("text-danger");
        }
        if (n3.value == '') {
          tn3.classList.add("text-danger");
          e.preventDefault()
        } else {
          tn3.classList.remove("text-danger");
        }
        if (n4.value == '') {
          tn4.classList.add("text-danger");
          e.preventDefault()
        } else {
          tn4.classList.remove("text-danger");
        }
        if (n5.value == '') {
          tn5.classList.add("text-danger");
          e.preventDefault()
        } else {
          tn5.classList.remove("text-danger");
        }
        if (n6.value == '') {
          tn6.classList.add("text-danger");
          e.preventDefault()
        } else {
          tn6.classList.remove("text-danger");
        }
        if (n7.value == '') {
          tn7.classList.add("text-danger");
          e.preventDefault()
        } else {
          tn7.classList.remove("text-danger");
        }
        if (n8.value == '') {
          tn8.classList.add("text-danger");
          e.preventDefault()
        } else {
          tn8.classList.remove("text-danger");
        }

        if (n1.value == '' || n2.value == '' || n3.value == '' || n4.value == '') {
          Swal.fire({
            icon: 'error',
            title: 'Debes completar el formulario',
            showConfirmButton: false,
            timer: 3000
          })
        }
      });
    </script>

    {{-- Validate many active Survey --}}
  @elseif (count($cycleActive) > 6)
    <div class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 150px);">
      <div>
        <h4 class="mt-3 text-center text-secondary">HAY MAS DE UNA ENCUESTA ACTIVA</h4>
      </div>
    </div>
  @else
    <div class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 150px);">
      <div>
        <h4 class="mt-3 text-center text-secondary">NO HAY ENCUESTA ACTIVA</h4>
      </div>
    </div>
  @endif
@else
  <div class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 150px);">
    <div>
      <h4 class="mt-3 text-center text-secondary">LA ENCUESTA YA FUE ENVIADA</h4>
    </div>
  </div>
@endif
