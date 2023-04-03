<form action=" {{ route('encuesta_docente.store') }}">
  @csrf
  <div class="questions text-secondary">
    <div class="question mb-4">
      <div class="mb-2">
        <b>1.¿El docente inició su clase puntualmente?</b>
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

    <div class="question mb-4">
      <div class="mb-2">
        <b>2.¿Entendiste la clase?</b>
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

    <div class="question mb-4">
      <div class="mb-2">
        <b>3.¿El docente desarrolló toda la teoría de la clase y/o cómo mínimo el 70% de
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

    <div class="question mb-4">
      <div class="mb-2">
        <b>4.¿El docente es exigente en clase y se preocupa para que todos aprendan?</b>
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
  <input type="hidden" name="id" value="">
  <button type="submit" class="btn btn-primary btn-md" style="width: 150px;">Enviar</button>
</form>
