@foreach ($admins as $admin)
  <tr>
    <td>
      <span class="text-secondary">{{ $admin->email }}</span>
    </td>
    <td>
      <div class="d-flex justify-content-end w-100 gap-1">
        <button type="button" class="btn btn-info btn-sm editAdmin" data-bs-toggle="modal"
          data-bs-target="#modal-admin-edit" data-id="{{ $admin->id }}" data-email="{{ $admin->email }}">
          <i class="fa-solid fa-pen-to-square text-white"></i>
        </button>

        <button type="button" class="btn btn-danger btn-sm deleteAdmin" data-bs-toggle="modal"
          data-bs-target="#modal-admin-delete" data-id="{{ $admin->id }}">
          <i class="fa-regular fa-trash-can text-white"></i>
        </button>
      </div>
    </td>
  </tr>
@endforeach
