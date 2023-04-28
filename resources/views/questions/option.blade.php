@foreach ($options as $option)
  <tr>
    <td>
      <span class="text-secondary">{{ $option->indice }}</span>
    </td>
    <td>
      <span class="text-secondary">{{ $option->opcion }}</span>
    </td>
    <td>
      <span class="text-secondary">{{ $option->valor }}</span>
    </td>
    <td>
      <div class="d-flex justify-content-end w-100 gap-1">
        <button type="button" class="btn btn-info btn-sm editOption" data-bs-toggle="modal"
          data-bs-target="#modal-option-edit" data-id="{{ $option->id }}" data-indice="{{ $option->indice }}"
          data-opcion="{{ $option->opcion }}" data-valor="{{ $option->valor }}" data-type="{{ $option->tipo }}">
          <i class="fa-solid fa-pen-to-square text-white"></i>
        </button>

        <button type="button" class="btn btn-danger btn-sm deleteOption" data-bs-toggle="modal"
          data-bs-target="#modal-option-delete" data-id="{{ $option->id }}" data-type="{{ $option->tipo }}">
          <i class="fa-regular fa-trash-can text-white"></i>
        </button>
      </div>
    </td>
  </tr>
@endforeach
