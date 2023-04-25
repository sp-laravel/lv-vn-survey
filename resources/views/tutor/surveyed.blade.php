@foreach ($alumns as $alumn)
  <li>
    <div>{{ $alumn->apellido_alumno }}
      {{ $alumn->nombre_alumno }}
    </div>
    <span>
      {{ $alumn->codigo_final }}
    </span>
  </li>
@endforeach
{{-- {{ $surveyedsList[0] }} --}}
