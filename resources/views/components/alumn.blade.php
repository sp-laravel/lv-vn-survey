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
@if ($courseSurveySent == 0)
  @if (count($cycleActive) == 6)
    <div class="container mt-4">
      <form action=" {{ route('encuesta_docente.store') }}" method="POST" name="survey" id="survey"
        class=""survey>
        @csrf
        <div class="questions text-secondary">
          <div class="mb-4 question">
            <div class="mb-2">
              <b class="tagN1">1.¿El docente inició su clase puntualmente?</b>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n1" id="q120" value="20">
              <label class="form-check-label" for="q120">
                Siempre
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n1" id="q115" value="15">
              <label class="form-check-label" for="q115">
                Casi siempre
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n1" id="q110" value="10">
              <label class="form-check-label" for="q110">
                Pocas veces
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n1" id="q105" value="5">
              <label class="form-check-label" for="q105">
                Nunca
              </label>
            </div>
          </div>

          <div class="mb-4 question">
            <div class="mb-2">
              <b class="tagN2">2.¿Entendiste la clase?</b>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n2" id="q220" value="20">
              <label class="form-check-label" for="q220">
                Toda la clase
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n2" id="q215" value="15">
              <label class="form-check-label" for="q215">
                Casi todo
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n2" id="q210" value="10">
              <label class="form-check-label" for="q210">
                No mucho
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n2" id="q205" value="5">
              <label class="form-check-label" for="q205">
                No entendí nada
              </label>
            </div>
          </div>

          <div class="mb-4 question">
            <div class="mb-2">
              <b class="tagN3">3.¿El docente desarrolló toda la teoría de la clase y/o cómo mínimo el 70% de
                las preguntas?</b>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n3" id="q320" value="20">
              <label class="form-check-label" for="q320">
                Siempre
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n3" id="q315" value="15">
              <label class="form-check-label" for="q315">
                Casi siempre
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n3" id="q310" value="10">
              <label class="form-check-label" for="q310">
                Pocas veces
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n3" id="q305" value="5">
              <label class="form-check-label" for="q305">
                Nunca
              </label>
            </div>
          </div>

          <div class="mb-4 question">
            <div class="mb-2">
              <b class="tagN4">4.¿El docente es exigente en clase y se preocupa para que todos aprendan?</b>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n4" id="q420" value="20">
              <label class="form-check-label" for="q420">
                Siempre
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n4" id="q415" value="15">
              <label class="form-check-label" for="q415">
                Casi siempre
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n4" id="q410" value="10">
              <label class="form-check-label" for="q410">
                Pocas veces
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="n4" id="q405" value="5">
              <label class="form-check-label" for="q405">
                Nunca
              </label>
            </div>
          </div>
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
            title: 'Debes completar el formulario'
          })
        }
      });
    </script>
  @else
    <div class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 150px);">
      <h4 class="mt-5 text-center text-secondary">NO HAY ENCUESTAS</h4>
    </div>
  @endif
@else
  <div class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 150px);">
    <h4 class="mt-5 text-center text-secondary">YA SE REALIZO LA ENCUESTA</h4>
  </div>
@endif
