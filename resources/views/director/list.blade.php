@foreach ($cycles as $cycle)
  <tr>
    <td class="text-secondary">{{ $cycle->codigo_final }}</td>
    <td class="text-secondary">{{ $cycle->apellido_tutor }} {{ $cycle->nombre_tutor }}</td>
    <td style="width: 110px;">
      <span
        @if ($cycle->proceso == 'Por encuestar') class="small text-info"
      @elseif ($cycle->proceso == 'Encuestando')
        class="small text-warning"
      @elseif ($cycle->proceso == 'No encuestado')
      class="small text-danger"
      @else
        class="small text-success" @endif>
        {{ $cycle->proceso }}
      </span>
    </td>
    <td>
      <div class="form-check form-switch d-flex justify-content-center position-relative">
        <div class="radio__loading position-absolute"></div>

        <input class="form-check-input horaryActive @if ($cycle->estado == 1) theone @endif" type="checkbox"
          name="horaryActive" onclick="activeStatus(this,{{ $cycle->dni_tutor }},'{{ $cycle->codigo_final }}')"
          value="{{ $cycle->estado }}" @if ($cycle->estado == 1) checked @endif>
      </div>
    </td>
    <td class="text-center text-secondary">
      <small>{{ $cycle->quantity }}</small>
    </td>
  </tr>
@endforeach

<script>
  // data
  status = @json($status);
</script>
