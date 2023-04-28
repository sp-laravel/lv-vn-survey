@foreach ($alumns as $alumn)
  <li class="d-flex justify-content-between ml-0">
    <div>{{ $alumn->apellido_alumno }}
      {{ $alumn->nombre_alumno }}
    </div>
    <span>
      {{ $alumn->codigo_final }}
    </span>
  </li>
@endforeach
{{-- {{ $surveyedsList[0] }} --}}
