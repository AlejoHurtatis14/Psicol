let arrayListadoProfesores = [];
let idEdicionActual = -1;

$(function () {

  ejecutarPeticion({}, "Profesores/Listar", "listadoProfesores");

  $("#frmProfesor").on('submit', function (e) {
    e.preventDefault();

    if ($("#documento").val().trim() == '') {
      return ejecutarNotificacion('error', 'No ha diligenciado el documento');
    }

    if ($("#nombre").val().trim() == '') {
      return ejecutarNotificacion('error', 'No ha diligenciado el nombre');
    }
    let form = new FormData(this);

    form.set('estado', ($("#estado").is(':checked') ? '1' : '0'));

    if (idEdicionActual > -1) {
      form.set('idEditar', idEdicionActual);
      ejecutarPeticion(form, "Profesores/Editar", "respuestaProfesor")
    } else {
      ejecutarPeticion(form, "Profesores/Crear", "respuestaProfesor")
    }
  });

  $(".btnCancelarProfesor").on('click', function () {
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

function respuestaProfesor({ valid, message }) {
  if (valid) {
    ejecutarNotificacion('success', message);
    ejecutarPeticion({}, "Profesores/Listar", "listadoProfesores");
    limpiarCampos();
  } else {
    ejecutarNotificacion('error', message);
  }
}

function limpiarCampos() {
  $("#frmProfesor input").val('');
  $("#estado").prop('checked', true);
  $("#modalCrearProfesor").modal('hide');
  $("#modalCrearProfesorLabel").html('Agregar');
  $(".btnCrearProfesor").html('<i class="bi bi-check-lg"></i> Crear');
  idEdicionActual = -1;
}

function listadoProfesores({ profesores }) {
  arrayListadoProfesores = profesores;
  let estructura = '';
  if (profesores.length) {
    profesores.forEach((it, pos) => {

      let buttons = `
        <div class="btn-group" role="group" aria-label="Botones">
          <button type="button" onclick="editarProfesor(${pos})" class="btn btn-secondary" title="Editar">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button type="button" onclick="eliminarProfesor(${pos})" class="btn btn-danger" title="Eliminar">
            <i class="bi bi-trash-fill"></i>
          </button>
        </div>
      `;

      estructura += `<tr>
        <th scope="row">${pos + 1}</th>
        <td>${it.documento}</td>
        <td>${it.nombre}</td>
        <td>${(it.telefono || '')}</td>
        <td>${(it.correo || '')}</td>
        <td>${(it.direccion || '')}</td>
        <td>${(it.ciudad || '')}</td>
        <td>${(it.estado ? '<span class="badge text-bg-success">Activo</span>' : '<span class="badge text-bg-danger">Inactivo</span>')}</td>
        <td>${buttons}</td>
      </tr>`;
    })
  } else {
    estructura = `<tr>
      <td colspan="9" class="text-center">No se encontraron registros</td>
    </tr>`;
  }
  $(".tbodyprofesores").html(estructura);
}

function editarProfesor(posicion) {
  let data = arrayListadoProfesores[posicion];
  Object.keys(data).forEach((key) => {
    $(`#${key}`).val(data[key]);
  });
  $("#estado").prop('checked', data.estado);
  idEdicionActual = data.id;
  $("#modalCrearProfesor").modal('show');
  $("#modalCrearProfesorLabel").html('Modificar');
  $(".btnCrearProfesor").html('<i class="bi bi-pencil"></i> Modificar');
}

function eliminarProfesor(posicion) {
  let data = arrayListadoProfesores[posicion];
  Swal.fire({
    title: `Está seguro de eliminar al profesor ${data.nombre}?`,
    showCancelButton: true,
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      let info = new FormData();
      info.set('idProfesor', data.id);
      ejecutarPeticion(info, "Profesores/Eliminar", "profesorEliminado");
    }
  })
}

function profesorEliminado({ valid, message }) {
  if (valid) {
    ejecutarNotificacion('success', message);
    ejecutarPeticion({}, "Profesores/Listar", "listadoProfesores");
  } else {
    ejecutarNotificacion('error', message);
  }
}