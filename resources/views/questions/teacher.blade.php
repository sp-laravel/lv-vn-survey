@foreach ($teachers as $teacher)
  <tr>
    <td class="text-center">
      <span class="text-secondary">{{ $teacher->numero_pregunta }}</span>
    </td>
    <td>
      <span class="text-secondary">{{ $teacher->pregunta }}</span>
    </td>
    <td>
      <div class="d-flex justify-content-end w-100 gap-1">
        <button type="button" class="btn btn-success btn-sm editTeacher" data-bs-toggle="modal"
          data-bs-target="#modal-teacher-edit" data-id="{{ $teacher->id }}"
          data-numero_pregunta="{{ $teacher->numero_pregunta }}" data-pregunta="{{ $teacher->pregunta }}">
          <i class="fa-solid fa-pen-to-square text-white"></i>
        </button>

        {{-- <button type="button" class="btn btn-danger btn-sm deleteTeacher" data-bs-toggle="modal"
          data-bs-target="#modal-teacher-delete" data-id="{{ $teacher->id }}">
          <i class="fa-regular fa-trash-can text-white"></i>
        </button> --}}
      </div>
    </td>
  </tr>
@endforeach
