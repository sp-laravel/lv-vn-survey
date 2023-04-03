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
      <th class="text-white text-center">ACTIVAR</th>
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
