@foreach ($cycles as $cycle)
  <tr>
    <td class="text-secondary">{{ $cycle->codigo_final }}</td>
    <td class="text-secondary">{{ $cycle->apellido_tutor }} {{ $cycle->apellido_tutor }}</td>
    <td>
      <div class="form-check form-switch d-flex justify-content-center position-relative">
        <div class="radio__loading position-absolute"></div>

        <input class="form-check-input horaryActive @if ($cycle->estado == 1) theone @endif" type="checkbox"
          name="horaryActive" onclick="activeStatus(this,{{ $cycle->dni_tutor }},'{{ $cycle->codigo_final }}')"
          value="{{ $cycle->estado }}" @if ($cycle->estado == 1) checked @endif>
      </div>
    </td>
  </tr>
@endforeach