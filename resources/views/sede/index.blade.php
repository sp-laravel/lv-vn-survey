@foreach ($sedes as $sede)
  <tr>
    <td>
      <span class="text-secondary">{{ $sede->sede }}</span>
    </td>
    <td>
      <span class="text-secondary">{{ $sede->email_director }}</span>
    </td>
    <td>
      <div class="d-flex justify-content-end w-100 gap-1">
        <button type="button" class="btn btn-info btn-sm editSede" data-bs-toggle="modal" data-bs-target="#modal-sede-edit"
          data-id="{{ $sede->id }}" data-sede="{{ $sede->sede }}" data-email_director="{{ $sede->email_director }}">
          <i class="fa-solid fa-pen-to-square text-white"></i>
        </button>

        {{-- <button type="button" class="btn btn-danger btn-sm deleteSede" data-bs-toggle="modal"
        data-bs-target="#modal-sede-delete" data-id="{{ $sede->id }}">
        <i class="fa-regular fa-trash-can text-white"></i>
      </button> --}}
      </div>
    </td>
  </tr>
@endforeach
