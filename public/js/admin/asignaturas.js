let arrayListadoAsignaturas = [];
let idEdicionActual = -1;

$(function () {

  ejecutarPeticion({}, "Asignaturas/Listar", "listadoAsignaturas");

  $("#frmAsignatura").on('submit', function (e) {
    e.preventDefault();

    if ($("#areaconocimiento").val().trim() == '') {
      return ejecutarNotificacion('error', 'No ha diligenciado el área de conocimiento');
    }

    if ($("#nombre").val().trim() == '') {
      return ejecutarNotificacion('error', 'No ha diligenciado el nombre');
    }

    if ($("#creditos").val().trim() == '') {
      return ejecutarNotificacion('error', 'No ha diligenciado los créditos');
    }
    let form = new FormData(this);

    form.set('estado', ($("#estado").is(':checked') ? '1' : '0'));

    if (idEdicionActual > -1) {
      form.set('idEditar', idEdicionActual);
      ejecutarPeticion(form, "Asignaturas/Editar", "respuestaAsignatura")
    } else {
      ejecutarPeticion(form, "Asignaturas/Crear", "respuestaAsignatura")
    }
  });

  $(".btnCancelarAsignatura").on('click', function () {
    if (idEdicionActual > -1) {
      limpiarCampos();
    }
  });
});

function ejecutarPeticion(form, metodoBack, funcionRetorno) {
  $.ajax({
    url: urlBase() + metodoBack,
    type: 'POST',
    dataType: 'json',
    data: form,
    processData: false,
    contentType: false,
    cache: false,
    success: (resp) => {
      if (funcionRetorno) {
        this[funcionRetorno](resp)
      }
    }
  });
}

function respuestaAsignatura({ valid, message }) {
  if (valid) {
    ejecutarNotificacion('success', message);
    ejecutarPeticion({}, "Asignaturas/Listar", "listadoAsignaturas");
    limpiarCampos();
  } else {
    ejecutarNotificacion('error', message);
  }
}

function limpiarCampos() {
  $("#frmAsignatura input, #frmAsignatura textarea").val('');
  $("#estado").prop('checked', true);
  $("#tipo").val('O');
  $("#modalCrearAsignatura").modal('hide');
  $("#modalCrearAsignaturaLabel").html('Agregar');
  $(".btnCrearAsignatura").html('<i class="bi bi-check-lg"></i> Crear');
  idEdicionActual = -1;
}

function listadoAsignaturas({ asignaturas }) {
  arrayListadoAsignaturas = asignaturas;
  let estructura = '';
  if (asignaturas.length) {
    asignaturas.forEach((it, pos) => {

      let buttons = `
        <div class="btn-group" role="group" aria-label="Botones">
          <button type="button" onclick="editarAsignatura(${pos})" class="btn btn-secondary" title="Editar">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button type="button" onclick="eliminarAsignatura(${pos})" class="btn btn-${it.estado ? 'danger' : 'success'}" title="${it.estado ? 'Inactivar' : 'Activar'}">
            ${it.estado ? '<i class="bi bi-x-lg"></i>' : '<i class="bi bi-check-lg"></i>'}
          </button>
        </div>
      `;

      estructura += `<tr>
        <th scope="row">${pos + 1}</th>
        <td>${it.nombre}</td>
        <td>${it.areaconocimiento}</td>
        <td>${(it.creditos || '')}</td>
        <td>${(it.tipo == 'O' ? 'Obligatoria' : 'Electiva')}</td>
        <td>${(it.descripcion || '')}</td>
        <td>${(it.estado ? '<span class="badge text-bg-success">Activo</span>' : '<span class="badge text-bg-danger">Inactivo</span>')}</td>
        <td class="text-center">${buttons}</td>
      </tr>`;
    })
  } else {
    estructura = `<tr>
      <td colspan="8" class="text-center">No se encontraron registros</td>
    </tr>`;
  }
  $(".tbodyasignaturas").html(estructura);
}

function editarAsignatura(posicion) {
  let data = arrayListadoAsignaturas[posicion];
  Object.keys(data).forEach((key) => {
    $(`#${key}`).val(data[key]);
  });
  $("#estado").prop('checked', data.estado);
  idEdicionActual = data.id;
  $("#modalCrearAsignatura").modal('show');
  $("#modalCrearAsignaturaLabel").html('Modificar');
  $(".btnCrearAsignatura").html('<i class="bi bi-pencil"></i> Modificar');
}

function eliminarAsignatura(posicion) {
  let data = arrayListadoAsignaturas[posicion];
  Swal.fire({
    title: `Está seguro de ${data.estado ? 'inactivar' : 'activar'} la asignatura ${data.nombre}?`,
    showCancelButton: true,
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      let info = new FormData();
      info.set('idAsignatura', data.id);
      info.set('estado', (data.estado ? 0 : 1));
      ejecutarPeticion(info, "Asignaturas/Eliminar", "asignaturaEliminada");
    }
  })
}

function asignaturaEliminada({ valid, message }) {
  if (valid) {
    ejecutarNotificacion('success', message);
    ejecutarPeticion({}, "Asignaturas/Listar", "listadoAsignaturas");
  } else {
    ejecutarNotificacion('error', message);
  }
}