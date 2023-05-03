@extends('welcome')

@section('menu')
  {{-- @if (isset($config))
    @if ($config)
    @else
      {{ route('welcome') }}
    @endif
  @endif --}}
  <a href="{{ route('welcome') }}">
    {{-- <i class="text-white fa-solid fa-gear" id="btn-config"></i> --}}
    <i class="text-white fa-solid fa-house" style="font-size: 2rem; cursor:pointer;"></i>
  </a>
@endsection

@section('content')
  <div class="container mt-3">
    {{-- Top Block --}}
    <div class="mt-4 d-flex justify-content-between align-items-center">
      <h2 class="text-primary fw-bold">ENCUESTAS CONFIGURACIÓN</h2>
    </div>
    <div class="d-flex justify-content-between align-items-center">
      @auth
        <div class="mt-3 text-secondary">
          <div><b>EMAIL: </b>{{ Auth::user()->email }}</div>
        </div>
      @endauth
      <div></div>
    </div>

    {{-- Bottom Block --}}
    <div class="tables-group">

      {{-- ONLINE --}}
      <div class="">
        <h4 class="mt-4 text-secondary">ENCUESTAS ACTIVAS</h4>
      </div>
      <div class="mt-3 mb-5 d-flex justify-content-start gap-3">
        {{-- TUTOR --}}
        <div class="table-responsive">
          <table class="table border rounded table-striped table-hover">
            <thead>
              <th colspan="2" class="text-primary">TUTORES</th>
            </thead>
            <tbody>
              @foreach ($tutors as $tutor)
                <tr>
                  <td class="text-secondary">{{ $tutor['email_tutor'] }} :</td>
                  <td class="text-secondary">{{ $tutor['aula'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        {{-- DIRECTOR --}}
        <div class="table-responsive">
          <table class="table border rounded table-striped table-hover">
            <thead>
              <th colspan="2" class="text-primary">DIRECTOR</th>
            </thead>
            <tbody>
              @foreach ($directors as $director)
                <tr>
                  <td class="text-secondary">{{ $director->email_coordinador }}</td>
                  <td class="text-secondary">{{ $director->aula }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      @if (isset($configFull))
        @if ($configFull)
          {{-- Table Amin --}}
          <div class="">
            <h4 class="mt-4 text-secondary">GESTIÓN ADMINISTRADORES</h4>
          </div>
          <div class="mt-3 table-responsive">
            <table class="table border rounded table-striped table-hover">
              <thead>
                <tr class="bg-info ">
                  <th class="text-white">USUARIO</th>
                  <th>
                    <div class="gap-1 d-flex justify-content-end w-100">
                      <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                        data-bs-target="#modal-admin-add">
                        <i class="text-white fa-regular fa-square-plus"></i>
                      </button>
                    </div>
                  </th>
                </tr>
              </thead>
              {{-- List --}}
              <tbody id="adminBody">
              </tbody>

            </table>
          </div>
        @endif
      @endif

      {{-- Table Sede --}}
      <div class="">
        <h4 class="mt-4 text-secondary">ASIGNACIÓN DE DIRECTOR A SEDE</h4>
      </div>
      <div class="mt-3 table-responsive">
        <table class="table border rounded table-striped table-hover">
          <thead>
            <tr class="bg-info ">
              <th class="text-white">SEDE</th>
              <th class="text-white">DIRECTOR</th>
              <th>
                <div class="gap-1 d-flex justify-content-end w-100">
                  {{-- <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
              data-bs-target="#modal-sede-add">
              <i class="text-white fa-regular fa-square-plus"></i>
            </button> --}}
                </div>
              </th>
            </tr>
          </thead>
          {{-- List --}}
          <tbody id="sedeBody">
          </tbody>

        </table>
      </div>

      {{-- Table Teacher --}}
      <div class="">
        <h4 class="mt-4 text-secondary">ENCUESTAS DOCENTES</h4>
      </div>
      <div class="mt-3 table-responsive">
        <table class="table border rounded table-striped table-hover">
          <thead>
            <tr class="bg-success">
              <th class="text-white">INDICE</th>
              <th class="text-white">PREGUNTA</th>
              <th>
                <div class="gap-1 d-flex justify-content-end w-100">
                  {{-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                  data-bs-target="#modal-teacher-add">
                  <i class="text-white fa-regular fa-square-plus"></i>
                </button> --}}
                </div>
              </th>
            </tr>
          </thead>
          {{-- List --}}
          <tbody id="teacherBody">
          </tbody>
        </table>
      </div>
      <div class="mt-3 table-responsive">
        <table class="table border rounded table-striped table-hover">
          <thead>
            <tr class="bg-success">
              <th class="text-white">INDICE</th>
              <th class="text-white">OPCIÓN</th>
              <th class="text-white">VALOR</th>
              <th>
                <div class="gap-1 d-flex justify-content-end w-100">
                  <button type="button" class="btn btn-sm btn-success addOption" data-bs-toggle="modal"
                    data-bs-target="#modal-option-add" data-type="docente">
                    <i class="text-white fa-regular fa-square-plus"></i>
                  </button>
                </div>
              </th>
            </tr>
          </thead>
          {{-- List --}}
          <tbody id="optionTeacherBody">
          </tbody>
        </table>
      </div>

      {{-- Table Tutor --}}
      <div class="">
        <h4 class="mt-4 text-secondary">ENCUESTAS TUTORES</h4>
      </div>
      <div class="mt-3 table-responsive">
        <table class="table border rounded table-striped table-hover">
          <thead>
            <tr class="bg-warning">
              <th class="text-white">INDICE</th>
              <th class="text-white">PREGUNTA</th>
              <th>
                <div class="gap-1 d-flex justify-content-end w-100">
                  {{-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                  data-bs-target="#modal-tutor-add">
                  <i class="text-white fa-regular fa-square-plus"></i>
                </button> --}}
                </div>
              </th>
            </tr>
          </thead>
          {{-- List --}}
          <tbody id="tutorBody">
          </tbody>
        </table>
      </div>
      <div class="mt-3 table-responsive">
        <table class="table border rounded table-striped table-hover">
          <thead>
            <tr class="bg-warning">
              <th class="text-white">INDICE</th>
              <th class="text-white">OPCIÓN</th>
              <th class="text-white">VALOR</th>
              <th>
                <div class="gap-1 d-flex justify-content-end w-100">
                  <button type="button" class="btn btn-sm btn-warning addOption" data-bs-toggle="modal"
                    data-bs-target="#modal-option-add" data-type="tutor">
                    <i class="text-white fa-regular fa-square-plus"></i>
                  </button>
                </div>
              </th>
            </tr>
          </thead>
          {{-- List --}}
          <tbody id="optionTutorBody">
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Add Admin -->
  <div class="modal fade" id="modal-admin-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">AGREGAR ADMINISTRADOR</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ URL::to('admin_store') }}" id="addFormAdmin" method="POST">
            <div class="mb-3">
              <label for="admin">email</label>
              <input type="email" name="email" class="form-control" required>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Edit Admin -->
  <div class="modal fade" id="modal-admin-edit" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">EDITAR ADMINISTRADOR</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ URL::to('admin_update') }}" id="editFormAdmin" method="POST">
            <input type="hidden" id="id_admin" name="id">
            <div class="mb-3">
              <label for="admin">Email</label>
              <input type="email" name="email" id="email_admin" class="form-control" required>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Delete Admin -->
  <div class="modal fade" id="modal-admin-delete" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="myModalLabel">ELIMINAR ADMINISTRADOR</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5 class="text-center text-secondary">Esta seguro de eliminar el email?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="delete-admin" class="btn btn-danger">Eliminar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Add Sede -->
  <div class="modal fade" id="modal-sede-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">AGREGAR SEDE</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ URL::to('sede_store') }}" id="addFormSede" method="POST">
            <div class="mb-3">
              <label for="sede">Sede</label>
              <input type="text" name="sede" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="sede">Email</label>
              <input type="email" name="email_director" class="form-control" required>
            </div>


            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Edit Sede -->
  <div class="modal fade" id="modal-sede-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">EDITAR SEDE</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ URL::to('sede_update') }}" id="editFormSede" method="POST">
            <input type="hidden" id="id_sede" name="id">
            <div class="mb-3">
              <label for="sede">Sede</label>
              <input type="text" name="sede" id="sede" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="sede">Email</label>
              <input type="email" name="email_director" id="email_director" class="form-control" required>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Delete Sede -->
  <div class="modal fade" id="modal-sede-delete" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="myModalLabel">ELIMINAR SEDE</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5 class="text-center text-secondary">Esta seguro de eliminar la Sede?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="delete-sede" class="btn btn-danger">Eliminar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Add Teacher -->
  <div class="modal fade" id="modal-teacher-add" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">AGREGAR PREGUNTA DOCENTE</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ URL::to('teacher_store') }}" id="addFormTeacher" method="POST">
            <div class="mb-3">
              <label for="numero_pregunta">Numero de Pregunta</label>
              <input type="text" name="numero_pregunta" class="form-control"
                onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" required>
            </div>
            <div class="mb-3">
              <label for="pregunta">Pregunta</label>
              {{-- <input type="text" name="pregunta" class="form-control" required> --}}
              <textarea class="form-control" name="pregunta" cols="30" rows="5" required></textarea>
            </div>


            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Edit Teacher -->
  <div class="modal fade" id="modal-teacher-edit" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">EDITAR PREGUNTA DOCENTE</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ URL::to('teacher_update') }}" id="editFormTeacher" method="POST">
            <input type="hidden" id="id_teacher" name="id">
            <div class="mb-3">
              <label for="numero_pregunta">Numero de Pregunta</label>
              <input type="text" name="numero_pregunta" id="numero_pregunta_teacher" class="form-control"
                onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" required>
            </div>
            <div class="mb-3">
              <label for="pregunta">Pregunta</label>
              {{-- <input type="text" name="pregunta" id="pregunta_teacher" class="form-control" required> --}}
              <textarea class="form-control" name="pregunta" id="pregunta_teacher" cols="30" rows="5" required></textarea>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Delete Teacher -->
  <div class="modal fade" id="modal-teacher-delete" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="myModalLabel">ELIMINAR PREGUNTA DOCENTE</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5 class="text-center text-secondary">Esta seguro de eliminar la Pregunta?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="delete-teacher" class="btn btn-danger">Eliminar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Add Tutor -->
  <div class="modal fade" id="modal-tutor-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">AGREGAR PREGUNTA TUTOR</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ URL::to('tutor_store') }}" id="addFormTutor" method="POST">
            <div class="mb-3">
              <label for="numero_pregunta">Numero de Pregunta</label>
              <input type="text" name="numero_pregunta" class="form-control"
                onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" required>
            </div>
            <div class="mb-3">
              <label for="pregunta">Pregunta</label>
              {{-- <input type="text" name="pregunta" class="form-control" required> --}}
              <textarea class="form-control" name="pregunta" cols="30" rows="5" required></textarea>
            </div>


            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Edit Tutor -->
  <div class="modal fade" id="modal-tutor-edit" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">EDITAR PREGUNTA TUTOR</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ URL::to('tutor_update') }}" id="editFormTutor" method="POST">
            <input type="hidden" id="id_tutor" name="id">
            <div class="mb-3">
              <label for="numero_pregunta">Numero de Pregunta</label>
              <input type="text" name="numero_pregunta" id="numero_pregunta_tutor" class="form-control"
                onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" required>
            </div>
            <div class="mb-3">
              <label for="pregunta">Pregunta</label>
              {{-- <input type="text" name="pregunta" id="pregunta_tutor" class="form-control" required> --}}
              <textarea class="form-control" name="pregunta" id="pregunta_tutor" cols="30" rows="5" required></textarea>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Delete Tutor -->
  <div class="modal fade" id="modal-tutor-delete" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="myModalLabel">ELIMINAR PREGUNTA TUTOR</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5 class="text-center text-secondary">Esta seguro de eliminar la Pregunta?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="delete-tutor" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Add Option -->
  <div class="modal fade" id="modal-option-add" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-primary">AGREGAR OPCIÓN ENCUESTA <span id="title-name-add"></span></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ URL::to('option_store') }}" id="addFormOption" method="POST">
            <input type="hidden" name="type_option" id="type_option" value="">
            <div class="mb-3">
              <label for="index_option">Indice de opción</label>
              <input type="text" name="index_option" class="form-control"
                onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" required>
            </div>
            <div class="mb-3">
              <label for="name_option">Nombre de opción</label>
              <input type="text" name="name_option" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="value_option">Valor de opción</label>
              <input type="text" name="value_option" class="form-control"
                onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" required>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Edit Option -->
  <div class="modal fade" id="modal-option-edit" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">EDITAR OPCIÓN ENCUESTA <span
              id="title-name-edit"></span></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ URL::to('option_update') }}" id="editFormOption" method="POST">
            <input type="hidden" name="id" id="id_option">
            <div class="mb-3">
              <label for="index_option">Indice de opción</label>
              <input type="text" name="index_option" id="index_option" class="form-control"
                onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" required>
            </div>
            <div class="mb-3">
              <label for="name_option">Nombre de opción</label>
              <input type="text" name="name_option" id="name_option" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="value_option">Valor de opción</label>
              <input type="text" name="value_option" id="value_option" class="form-control"
                onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" required>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Delete Option -->
  <div class="modal fade" id="modal-option-delete" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="myModalLabel">ELIMINAR PREGUNTA ENCUESTA <span
              id="title-name-delete"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5 class="text-center text-secondary">Esta seguro de eliminar la opción?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="delete-option" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    // Load
    $(document).ready(function() {
      // showConfig();
    })

    // Show tutor List
    // function showConfig() {
    //   $.get("{{ URL::to('admin_show') }}", function(data) {
    //     $('#config').empty().html(data);
    //     console.log("config")
    //   })
    // }
  </script>
  <script>
    // Load
    $(document).ready(function() {
      showAdmins();
      showSedes();
      showTeachers();
      showOptions()
      showTutors();
    })

    // Token
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
    });

    // Show Amin
    function showAdmins() {
      $.get("{{ URL::to('admin_show') }}", function(data) {
        $('#adminBody').empty().html(data);
      })
    }
    // Add Admin
    $('#addFormAdmin').on('submit', function(e) {
      e.preventDefault();
      let form = $(this).serialize();
      // let urlForm = $(this).serialize();
      $.ajax({
        type: 'POST',
        url: '/admin_store',
        // url: url + '/admin_store',
        data: form,
        success: function(data) {
          $('#modal-admin-add').modal('hide');
          $('#addFormAdmin')[0].reset();
          showAdmins();
        },

        error: function(msg) {
          console.log(msg);
          let errors = msg.responseJSON;
        }
      });
    });
    // Edit Admin
    $(document).on('click', '.editAdmin', function(event) {
      event.preventDefault();
      let id = $(this).data('id');
      let email = $(this).data('email');

      $('#modal-admin-edit').modal('show');
      $('#email_admin').val(email);
      $('#id_admin').val(id);
    });
    // Update Admin
    $('#editFormAdmin').on('submit', function(e) {
      e.preventDefault();
      let form = $(this).serialize();
      let urlForm = $(this).attr('action');
      $.post(urlForm, form, function(data) {
        $('#modal-admin-edit').modal('hide');
        showAdmins();
      })
    });
    // Delete Admin
    $(document).on('click', '.deleteAdmin', function(event) {
      event.preventDefault();
      let id = $(this).data('id');
      $('#modal-admin-delete').modal('show');
      $('#delete-admin').val(id);
    });
    // Destroy Admin
    $('#delete-admin').click(function() {
      var id = $(this).val();
      $.post("{{ URL::to('admin_delete') }}", {
        id: id
      }, function() {
        $('#modal-admin-delete').modal('hide');
        showAdmins();
      })
    });


    // Show Sede
    function showSedes() {
      $.get("{{ URL::to('sede_show') }}", function(data) {
        $('#sedeBody').empty().html(data);
      })
    }
    // Add Sede
    $('#addFormSede').on('submit', function(e) {
      e.preventDefault();
      let form = $(this).serialize();
      // let urlForm = $(this).serialize();
      $.ajax({
        type: 'POST',
        // url: urlForm,
        url: url + '/sede_store',
        data: form,
        success: function(data) {
          $('#modal-sede-add').modal('hide');
          $('#addFormSede')[0].reset();
          showSedes();
        },

        error: function(msg) {
          console.log(msg);
          let errors = msg.responseJSON;
        }
      });
    });
    // Edit Sede
    $(document).on('click', '.editSede', function(event) {
      event.preventDefault();
      let id = $(this).data('id');
      let sede = $(this).data('sede');
      let email_director = $(this).data('email_director');

      $('#modal-sede-edit').modal('show');
      $('#sede').val(sede);
      $('#email_director').val(email_director);
      $('#id_sede').val(id);
    });
    // Update Sede
    $('#editFormSede').on('submit', function(e) {
      e.preventDefault();
      let form = $(this).serialize();
      let urlForm = $(this).attr('action');
      $.post(urlForm, form, function(data) {
        $('#modal-sede-edit').modal('hide');
        showSedes();
      })
    });
    // Delete Sede
    $(document).on('click', '.deleteSede', function(event) {
      event.preventDefault();
      let id = $(this).data('id');
      $('#modal-sede-delete').modal('show');
      $('#delete-sede').val(id);
    });
    // Destroy Sede
    $('#delete-sede').click(function() {
      var id = $(this).val();
      $.post("{{ URL::to('sede_delete') }}", {
        id: id
      }, function() {
        $('#modal-sede-delete').modal('hide');
        showSedes();
      })
    });


    // Show Teacher
    function showTeachers() {
      $.get("{{ URL::to('teacher_show') }}", function(data) {
        $('#teacherBody').empty().html(data);
      })
    }
    // Add Teacher
    $('#addFormTeacher').on('submit', function(e) {
      e.preventDefault();
      let form = $(this).serialize();
      // let urlForm = $(this).serialize();
      $.ajax({
        type: 'POST',
        // url: urlForm,
        url: '/teacher_store',
        data: form,
        success: function(data) {
          $('#modal-teacher-add').modal('hide');
          $('#addFormTeacher')[0].reset();
          showTeachers();
        },

        error: function(msg) {
          console.log(msg);
          let errors = msg.responseJSON;
        }
      });
    });
    // Edit Teacher
    $(document).on('click', '.editTeacher', function(event) {
      event.preventDefault();
      let id = $(this).data('id');
      let numero_pregunta = $(this).data('numero_pregunta');
      let pregunta = $(this).data('pregunta');

      $('#modal-teacher-edit').modal('show');
      $('#numero_pregunta_teacher').val(numero_pregunta);
      $('#pregunta_teacher').val(pregunta);
      $('#id_teacher').val(id);
    });
    // Update Teacher
    $('#editFormTeacher').on('submit', function(e) {
      e.preventDefault();
      let form2 = $(this).serialize();
      let urlForm2 = $(this).attr('action');
      $.post(urlForm2, form2, function(data) {
        $('#modal-teacher-edit').modal('hide');
        showTeachers();
      })
    });
    // Delete Teacher
    $(document).on('click', '.deleteTeacher', function(event) {
      event.preventDefault();
      let id = $(this).data('id');
      $('#modal-teacher-delete').modal('show');
      $('#delete-teacher').val(id);
    });
    // Destroy Teacher
    $('#delete-teacher').click(function() {
      var id = $(this).val();
      $.post("{{ URL::to('teacher_delete') }}", {
        id: id
      }, function() {
        $('#modal-teacher-delete').modal('hide');
        showTeachers();
      })
    });


    // Show Tutor
    function showTutors() {
      $.get("{{ URL::to('tutor_show') }}", function(data) {
        $('#tutorBody').empty().html(data);
      })
    }
    // Add Tutor
    $('#addFormTutor').on('submit', function(e) {
      e.preventDefault();
      let form = $(this).serialize();
      // let urlForm = $(this).serialize();
      $.ajax({
        type: 'POST',
        // url: urlForm,
        url: url + '/tutor_store',
        data: form,
        success: function(data) {
          $('#modal-tutor-add').modal('hide');
          $('#addFormTutor')[0].reset();
          showTutors();
        },

        error: function(msg) {
          console.log(msg);
          let errors = msg.responseJSON;
        }
      });
    });
    // Edit Tutor
    $(document).on('click', '.editTutor', function(event) {
      event.preventDefault();
      let id = $(this).data('id');
      let numero_pregunta = $(this).data('numero_pregunta');
      let pregunta = $(this).data('pregunta');

      $('#modal-tutor-edit').modal('show');
      $('#numero_pregunta_tutor').val(numero_pregunta);
      $('#pregunta_tutor').val(pregunta);
      $('#id_tutor').val(id);
    });
    // Update Tutor
    $('#editFormTutor').on('submit', function(e) {
      e.preventDefault();
      let form2 = $(this).serialize();
      let urlForm2 = $(this).attr('action');
      $.post(urlForm2, form2, function(data) {
        $('#modal-tutor-edit').modal('hide');
        showTutors();
      })
    });
    // Delete Tutor
    $(document).on('click', '.deleteTutor', function(event) {
      event.preventDefault();
      let id = $(this).data('id');
      $('#modal-tutor-delete').modal('show');
      $('#delete-tutor').val(id);
    });
    // Destroy Tutor
    $('#delete-tutor').click(function() {
      var id = $(this).val();
      $.post("{{ URL::to('tutor_delete') }}", {
        id: id
      }, function() {
        $('#modal-tutor-delete').modal('hide');
        showTutors();
      })
    });


    // Show Option
    function showOptions() {
      $.get("{{ URL::to('option_show/docente') }}", function(data) {
        $('#optionTeacherBody').empty().html(data);
      })
      $.get("{{ URL::to('option_show/tutor') }}", function(data) {
        $('#optionTutorBody').empty().html(data);
      })
    }
    // Add Option
    $('#addFormOption').on('submit', function(e) {
      e.preventDefault();
      let form = $(this).serialize();
      // let urlForm = $(this).serialize();
      $.ajax({
        type: 'POST',
        // url: url + '/option_store',
        url: '/option_store',
        data: form,
        success: function(data) {
          $('#modal-option-add').modal('hide');
          $('#addFormOption')[0].reset();
          showOptions();
        },

        error: function(msg) {
          console.log(msg);
          let errors = msg.responseJSON;
        }
      });
    });
    // Add Option Type
    $(document).on('click', '.addOption', function(event) {
      let type = $(this).data('type');
      $('#type_option').val(type);
      $('#title-name-add').text(type.toUpperCase());
    });
    // Edit Option
    $(document).on('click', '.editOption', function(event) {
      event.preventDefault();
      let id = $(this).data('id');
      let indice = $(this).data('indice');
      let opcion = $(this).data('opcion');
      let valor = $(this).data('valor');
      let type = $(this).data('type');

      $('#modal-option-edit').modal('show');
      $('#index_option').val(indice);
      $('#name_option').val(opcion);
      $('#value_option').val(valor);
      $('#id_option').val(id);
      $('#title-name-edit').text(type.toUpperCase());
    });
    // Update Option
    $('#editFormOption').on('submit', function(e) {
      e.preventDefault();
      let form = $(this).serialize();
      let urlForm = $(this).attr('action');
      $.post(urlForm, form, function(data) {
        $('#modal-option-edit').modal('hide');
        showOptions();
      })
    });
    // Delete Option
    $(document).on('click', '.deleteOption', function(event) {
      event.preventDefault();
      let id = $(this).data('id');
      let type = $(this).data('type');

      $('#modal-option-delete').modal('show');
      $('#delete-option').val(id);
      $('#title-name-delete').text(type.toUpperCase());
    });
    // Destroy Option
    $('#delete-option').click(function() {
      var id = $(this).val();
      $.post("{{ URL::to('option_delete') }}", {
        id: id
      }, function() {
        $('#modal-option-delete').modal('hide');
        showOptions();
      })
    });
  </script>
@endsection
