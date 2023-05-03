@foreach ($alumns as $alumn)
  <li class="d-flex justify-content-between ml-0">
    <div>{{ $alumn->apellido_alumno }}
      {{ $alumn->nombre_alumno }}
    </div>
    <span>
      @if ($alumn->codigo_final == 'si')
        <i class="fa-solid fa-check text-success"></i>
      @else
        <i class="fa-solid fa-xmark text-danger"></i>
      @endif
      {{-- {{ $alumn->codigo_final }} --}}
    </span>
  </li>
@endforeach
{{-- {{ $surveyedsList[0] }} --}}
