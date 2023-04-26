@foreach ($horaries as $horary)
  <tr>
    <td class="text-secondary">{{ $horary->h_fin }}</td>
    <td class="text-secondary">{{ $horary->h_inicio }}</td>
    <td class="text-secondary">{{ $horary->docente }}</td>
    <td class="text-secondary">{{ $horary->asignatura }}</td>
    <td class="text-secondary">{{ $horary->aula }}</td>
    <td style="width: 110px;">
      <span
        @if ($horary->proceso == 'Por encuestar') class="small text-info"
      @elseif ($horary->proceso == 'Encuestando')
        class="small text-warning"
      @elseif ($horary->proceso == 'No encuestado')
      class="small text-danger"
      @else
        class="small text-success" @endif>
        {{ $horary->proceso }}
      </span>
    </td>
    <td>
      <div class="form-check form-switch d-flex justify-content-center position-relative">
        <div class="radio__loading position-absolute bg-primary"></div>
        <input class="form-check-input horaryActive @if ($horary->estado == 1) theone @endif" type="checkbox"
          name="horaryActive" onclick="activeStatus(this,{{ $horary->id }})" value="{{ $horary->id }}"
          @if ($horary->estado == 1) checked @endif>
      </div>
    </td>
    <td class="text-secondary">
      <a data-bs-toggle="modal" data-bs-target="#modal-survey" data-aula="{{ $horary->aula }}"
        data-curso="{{ $horary->asignatura }}" data-docente="{{ $horary->docente }}" class="text-primary loadSurveyed"
        style="cursor: pointer;text-decoration: none;"><small>{{ $horary->quantity }}</small>
      </a>
    </td>
  </tr>
@endforeach

<script>
  // data
  status = @json($status);
</script>
