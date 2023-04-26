{{-- Validate Survey Sent --}}
@if ($courseSurveySent == 0)
  {{-- Validate Survey Teacher --}}
  @if (count($cycleActive) == 6 && $type == 'docente')
    <h2 class="mb-4 text-center text-primary fw-bold" style="font-size: 2rem;">ENCUESTA AL DOCENTE</h2>
    <form action=" {{ route('encuesta_docente.store') }}" method="POST" name="survey" id="survey" class=""survey>
      @csrf
      <div class="questions text-secondary">
        @foreach ($questions as $question)
          <div class="mb-4 question">
            <div class="mb-2 d-flex">
              <span class="index-list">{{ $question->numero_pregunta }}. </span>
              <b class="tagN{{ $question->numero_pregunta }}">{{ $question->pregunta }}</b>
            </div>
            <div class="my-3 form-check">
              <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                id="q{{ $question->numero_pregunta }}20" value="20">
              <label class="form-check-label" style="padding-left: 1rem;" for="q{{ $question->numero_pregunta }}20">
                Siempre
              </label>
            </div>
            <div class="my-3 form-check">
              <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                id="q{{ $question->numero_pregunta }}15" value="15">
              <label class="form-check-label" style="padding-left: 1rem;" for="q{{ $question->numero_pregunta }}15">
                Casi siempre
              </label>
            </div>
            <div class="my-3 form-check">
              <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                id="q{{ $question->numero_pregunta }}10" value="10">
              <label class="form-check-label" style="padding-left: 1rem;" for="q{{ $question->numero_pregunta }}10">
                Pocas veces
              </label>
            </div>
            <div class="my-3 form-check">
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

    <script>
      //Data 
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
    </script>

    {{-- Validate Survey Tutor --}}
  @elseif (count($cycleActive) == 3 && $type == 'tutor')
    <h2 class="mb-3 text-center text-primary fw-bold" style="font-size: 2rem;">ENCUESTA AL TUTOR</h2>
    <ul class="list-options text-primary m-auto mb-4">
      <li><span class="text-secondary">1 = </span>Nunca</li>
      <li><span class="text-secondary">2 = </span>Pocas veces</li>
      <li><span class="text-secondary">3 = </span>Regularmente</li>
      <li><span class="text-secondary">4 = </span>Casi siempre</li>
      <li><span class="text-secondary">5 = </span>Siempre</li>
    </ul>
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

            <div class="gap-2 content-radio d-flex">
              {{-- <span>Nunca</span> --}}
              <div class="my-3 form-check">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}1" value="1">
                <label class="form-check-label" style="padding-left: 1rem;" style="padding-left: 1rem;"
                  for="q{{ $question->numero_pregunta }}1">
                  1
                </label>
              </div>
              <div class="my-3 form-check">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}2" value="2">
                <label class="form-check-label" style="padding-left: 1rem;" for="q{{ $question->numero_pregunta }}2">
                  2
                </label>
              </div>
              <div class="my-3 form-check">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}3" value="3">
                <label class="form-check-label" style="padding-left: 1rem;" for="q{{ $question->numero_pregunta }}3">
                  3
                </label>
              </div>
              <div class="my-3 form-check">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}4" value="4">
                <label class="form-check-label" style="padding-left: 1rem;"
                  for="q{{ $question->numero_pregunta }}4">
                  4
                </label>
              </div>

              <div class="my-3 form-check">
                <input class="form-check-input" type="radio" name="n{{ $question->numero_pregunta }}"
                  id="q{{ $question->numero_pregunta }}5" value="5">
                <label class="form-check-label" style="padding-left: 1rem;"
                  for="q{{ $question->numero_pregunta }}5">
                  5
                </label>
              </div>
              {{-- <span>Siempre</span> --}}
            </div>
          </div>
        @endforeach
      </div>
      <input type="hidden" name="id" value="{{ $cycleActive[0] }}">
      <button type="submit" class="btn btn-primary btn-md" style="width: 150px;">Enviar</button>
    </form>

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

        if (n1.value == '' || n2.value == '' || n3.value == '' || n4.value == '' || n5.value == '' || n6.value == '' ||
          n7.value == '' || n8.value == '') {
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
