@foreach ($tutors as $tutor)
  <tr>
    <td class="text-center">
      <span class="text-secondary">{{ $tutor->numero_pregunta }}</span>
    </td>
    <td>
      <span class="text-secondary">{{ $tutor->pregunta }}</span>
    </td>
    <td>
      <div class="d-flex justify-content-end w-100 gap-1">
        <button type="button" class="btn btn-success btn-sm editTutor" data-bs-toggle="modal"
          data-bs-target="#modal-tutor-edit" data-id="{{ $tutor->id }}"
          data-numero_pregunta="{{ $tutor->numero_pregunta }}" data-pregunta="{{ $tutor->pregunta }}">
          <i class="fa-solid fa-pen-to-square text-white"></i>
        </button>

        {{-- <button type="button" class="btn btn-danger btn-sm deleteTutor" data-bs-toggle="modal"
          data-bs-target="#modal-tutor-delete" data-id="{{ $tutor->id }}">
          <i class="fa-regular fa-trash-can text-white"></i>
        </button> --}}
      </div>
    </td>
  </tr>
@endforeach
