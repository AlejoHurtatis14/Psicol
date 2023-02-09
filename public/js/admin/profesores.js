let arrayListadoProfesores = [];
let idEdicionActual = -1;
let arrayListadoAsignaturasProfesores = [];

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

  $(".btnCancelarProfesor, .btnCancelarAsignaturas").on('click', function () {
    if (idEdicionActual > -1) {
      limpiarCampos();
    }
  });

  $("#frmAsignaturaProfesor").on('submit', function (e) {
    e.preventDefault();

    if ($("#asignatura").val().trim() == '') {
      return ejecutarNotificacion('error', 'No ha diligenciado el campo asignatura');
    }

    let asignatura = $("#asignatura").val();

    let index = arrayListadoAsignaturasProfesores.findIndex(op => op.fk_asignatura == asignatura);

    if (index == -1) {
      let data = {
        id: arrayListadoAsignaturasProfesores.length + 1,
        nombre: $("#asignatura option:selected").html(),
        fk_asignatura: asignatura
      }
      arrayListadoAsignaturasProfesores.push(data);
      organizarListadoAsignaturas();
    } else {
      ejecutarNotificacion('warning', 'La asignatura ya esta asignada');
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
          <button type="button" onclick="estadoProfesor(${pos})" class="btn btn-${it.estado ? 'danger' : 'success'}" title="${it.estado ? 'Inactivar' : 'Activar'}">
            ${it.estado ? '<i class="bi bi-x-lg"></i>' : '<i class="bi bi-check-lg"></i>'}
          </button>
          ${it.estado ? `<button type="button" onclick="asignarAsignaturas(${pos})" class="btn btn-info" title="Asignaturas">
            <i class="bi bi-bookmark-plus"></i>
          </button>` : ''}
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
        <td class="text-center">${(it.estado ? '<span class="badge text-bg-success">Activo</span>' : '<span class="badge text-bg-danger">Inactivo</span>')}</td>
        <td class="text-center">${buttons}</td>
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

function estadoProfesor(posicion) {
  let data = arrayListadoProfesores[posicion];
  Swal.fire({
    title: `Está seguro de ${data.estado ? 'inactivar' : 'activar'} al profesor ${data.nombre}?`,
    showCancelButton: true,
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      let info = new FormData();
      info.set('idProfesor', data.id);
      info.set('estado', (data.estado ? 0 : 1));
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

function asignarAsignaturas(index) {
  let data = arrayListadoProfesores[index];
  idEdicionActual = data.id;
  let info = new FormData();
  info.set('idProfesor', data.id);
  ejecutarPeticion(info, "AsignaturasProfesor/Listar", "listadoAsignaturasProfesor");

  $(".btnConfirmarAsignaturas").off('click').on('click', function () {
    Swal.fire({
      title: `Está seguro de guardar los cambios?`,
      showCancelButton: true,
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        let info = new FormData();
        info.set('idProfesor', idEdicionActual);
        info.set('asignaturas', JSON.stringify(arrayListadoAsignaturasProfesores));
        ejecutarPeticion(info, "AsignaturasProfesor/Guardar", "asignaturasAgregadasProfesor");
      }
    })
  });
}

function listadoAsignaturasProfesor({ asignaturas, asignaturasProfesor }) {
  arrayListadoAsignaturasProfesores = asignaturasProfesor;
  let estructura = '';
  if (asignaturas.length) {
    asignaturas.forEach((it, pos) => {
      estructura += `<option value="${it.id}">${it.nombre}</option>`;
    })
  } else {
    estructura = `<option value="" selected>No se encontraron asignaturas</option>`;
  }
  $("#asignatura").html(estructura);
  organizarListadoAsignaturas();
  $("#modalAsignarAsignaturas").modal('show');
}

function organizarListadoAsignaturas() {
  let estructura = '';
  if (arrayListadoAsignaturasProfesores.length) {
    arrayListadoAsignaturasProfesores.forEach((it, pos) => {

      let buttons = `
        <button type="button" onclick="quitarAsignaturaProfesor(${pos})" class="btn btn-danger" title="Quitar">
          <i class="bi bi-x-lg"></i>
        </button>
      `;

      estructura += `<tr>
        <th scope="row">${pos + 1}</th>
        <td>${it.nombre}</td>
        <td class="text-center">${buttons}</td>
      </tr>`;
    })
  } else {
    estructura = `<tr>
      <td colspan="3" class="text-center">No se encontraron asignaturas</td>
    </tr>`;
  }
  $(".tbodyasignaturasprofesores").html(estructura);
}

function quitarAsignaturaProfesor(posicion) {
  arrayListadoAsignaturasProfesores.splice(posicion, 1);
  organizarListadoAsignaturas();
}

function asignaturasAgregadasProfesor({ valid, message }) {
  if (valid) {
    ejecutarNotificacion('success', message);
    ejecutarPeticion({}, "Profesores/Listar", "listadoProfesores");
    $("#modalAsignarAsignaturas").modal('hide');
    limpiarCampos();
  } else {
    ejecutarNotificacion('error', message);
  }
}