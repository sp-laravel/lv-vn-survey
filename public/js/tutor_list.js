    // Div
    let reloadTable = document.querySelector('#reload-table');

    // Change switch
    function activeStatus(element, id) {
      if ($('.horaryActive:checked').length > 1) {
        element.checked = false;

        Swal.fire({
          icon: 'error',
          title: `Solo una encuesta puede estar activa`,
          showConfirmButton: false,
          timer: 3000
        })
      } else {
        let status = 0;
        if (element.classList.contains('theone')) {
          element.classList.remove("theone");
          status = 0;
        } else {
          element.classList.add("theone");
          status = 1;
        }
        updateHoraryStatus(id, status);
        showTutorList(dni,dashboard);
      }
    }

    // Update Swich
    function updateHoraryStatus(idHorary, status) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      });
      $.ajax({
        type: 'POST',
        url: '/horary',
        // url: url + '/horary',
        data: {
          id: idHorary,
          status: status
        },
        success: function(data) {
          // $("#data").html(data.msg);
        },

        error: function(msg) {
          console.log(msg);
          let errors = msg.responseJSON;
        }
      });
    }

    // Update Table
    reloadTable.addEventListener('click', function() {
      showTutorList(dni, dashboard);
    })