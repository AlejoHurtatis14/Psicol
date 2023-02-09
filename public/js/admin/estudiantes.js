let arrayListadoEstudiantes = [];
let idEdicionActual = -1;
let arrayListadoAsignaturasEstudiante = [];

$(function () {

  ejecutarPeticion({}, "Estudiantes/Listar", "listadoEstudiantes");

  $("#frmEstudiante").on('submit', function (e) {
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
      ejecutarPeticion(form, "Estudiantes/Editar", "respuestaEstudiante")
    } else {
      ejecutarPeticion(form, "Estudiantes/Crear", "respuestaEstudiante")
    }
  });

  $(".btnCancelarEstudiante, .btnCancelarAsignaturas").on('click', function () {
    if (idEdicionActual > -1) {
      limpiarCampos();
    }
  });

  $("#frmAsignaturaEstudiante").on('submit', function (e) {
    e.preventDefault();

    if ($("#asignatura").val().trim() == '') {
      return ejecutarNotificacion('error', 'No ha diligenciado el campo asignatura');
    }

    if ($("#profesor").val().trim() == '') {
      return ejecutarNotificacion('error', 'No ha diligenciado el campo profesor');
    }

    let asignatura = $("#asignatura").val();

    let index = arrayListadoAsignaturasEstudiante.findIndex(op => op.fk_asignatura == asignatura);

    if (index == -1) {
      let data = {
        id: arrayListadoAsignaturasEstudiante.length + 1,
        nombre: $("#asignatura option:selected").html(),
        fk_asignatura: asignatura,
        fk_profesor: $("#profesor").val(),
        nombreProf: $("#profesor option:selected").html(),
        creditos: $("#asignatura option:selected").data('creditos'),
      }
      arrayListadoAsignaturasEstudiante.push(data);
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

function respuestaEstudiante({ valid, message }) {
  if (valid) {
    ejecutarNotificacion('success', message);
    ejecutarPeticion({}, "Estudiantes/Listar", "listadoEstudiantes");
    limpiarCampos();
  } else {
    ejecutarNotificacion('error', message);
  }
}

function limpiarCampos() {
  $("#frmEstudiante input").val('');
  $("#estado").prop('checked', true);
  $("#modalCrearEstudiante").modal('hide');
  $("#modalCrearEstudianteLabel").html('Agregar');
  $(".btnCrearEstudiante").html('<i class="bi bi-check-lg"></i> Crear');
  idEdicionActual = -1;
}

function listadoEstudiantes({ estudiantes }) {
  arrayListadoEstudiantes = estudiantes;
  let estructura = '';
  if (estudiantes.length) {
    estudiantes.forEach((it, pos) => {

      let buttons = `
        <div class="btn-group" role="group" aria-label="Botones">
          <button type="button" onclick="editarEstudiante(${pos})" class="btn btn-secondary" title="Editar">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button type="button" onclick="estadoEstudiante(${pos})" class="btn btn-${it.estado ? 'danger' : 'success'}" title="${it.estado ? 'Inactivar' : 'Activar'}">
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
        <td>${(it.semestre || '')}</td>
        <td>${(it.estado ? '<span class="badge text-bg-success">Activo</span>' : '<span class="badge text-bg-danger">Inactivo</span>')}</td>
        <td class="text-center">${buttons}</td>
      </tr>`;
    })
  } else {
    estructura = `<tr>
      <td colspan="10" class="text-center">No se encontraron registros</td>
    </tr>`;
  }
  $(".tbodyestudiantes").html(estructura);
}

function editarEstudiante(posicion) {
  let data = arrayListadoEstudiantes[posicion];
  Object.keys(data).forEach((key) => {
    $(`#${key}`).val(data[key]);
  });
  $("#estado").prop('checked', data.estado);
  idEdicionActual = data.id;
  $("#modalCrearEstudiante").modal('show');
  $("#modalCrearEstudianteLabel").html('Modificar');
  $(".btnCrearEstudiante").html('<i class="bi bi-pencil"></i> Modificar');
}

function estadoEstudiante(posicion) {
  let data = arrayListadoEstudiantes[posicion];
  Swal.fire({
    title: `Está seguro de ${data.estado ? 'inactivar' : 'activar'} al estudiante ${data.nombre}?`,
    showCancelButton: true,
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      let info = new FormData();
      info.set('idEstudiante', data.id);
      info.set('estado', (data.estado ? 0 : 1));
      ejecutarPeticion(info, "Estudiantes/Eliminar", "estudianteEliminado");
    }
  })
}

function estudianteEliminado({ valid, message }) {
  if (valid) {
    ejecutarNotificacion('success', message);
    ejecutarPeticion({}, "Estudiantes/Listar", "listadoEstudiantes");
  } else {
    ejecutarNotificacion('error', message);
  }
}

function asignarAsignaturas(index) {
  let data = arrayListadoEstudiantes[index];
  idEdicionActual = data.id;
  let info = new FormData();
  info.set('idEstudiante', data.id);
  ejecutarPeticion(info, "AsignaturasEstudiante/Listar", "listadoAsignaturasEstudiante");

  $(".btnConfirmarAsignaturas").off('click').on('click', function () {
    let totalCreditos = 0;
    arrayListadoAsignaturasEstudiante.forEach(it => totalCreditos += +it.creditos);

    if (totalCreditos < 7) {
      ejecutarNotificacion('warning', 'El minimo de créditos debe ser 7');
      return
    }

    Swal.fire({
      title: `Está seguro de guardar los cambios?`,
      showCancelButton: true,
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        let info = new FormData();
        info.set('idEstudiante', idEdicionActual);
        info.set('asignaturas', JSON.stringify(arrayListadoAsignaturasEstudiante));
        ejecutarPeticion(info, "AsignaturasEstudiante/Guardar", "asignaturasAgregadasEstudiante");
      }
    })
  });
}

function listadoAsignaturasEstudiante({ asignaturas, asignaturasEstudiante }) {
  arrayListadoAsignaturasEstudiante = asignaturasEstudiante;
  let estructura = '';
  if (asignaturas.length) {
    asignaturas.forEach((it, pos) => {
      estructura += `<option value="${it.id}" data-creditos="${it.creditos}">${it.nombre}</option>`;
    })
  } else {
    estructura = `<option value="" selected>No se encontraron asignaturas</option>`;
  }
  $("#asignatura").html(estructura);
  organizarListadoAsignaturas();
  $("#modalAsignarAsignaturas").modal('show');

  $("#asignatura").off('change').on('change', function () {
    let info = new FormData();
    info.set('idAsignatura', $(this).val());
    ejecutarPeticion(info, "AsignaturasProfesor/Profesores", "profesoresAsigntura");
  });
  $("#asignatura").change();
}

function profesoresAsigntura({ profesores }) {
  let estructura = '';
  if (profesores.length) {
    profesores.forEach((it, pos) => {
      estructura += `<option value="${it.id}">${it.nombre}</option>`;
    })
  } else {
    estructura = `<option value="" selected>No se encontraron profesores</option>`;
  }
  $("#profesor").html(estructura);
}

function organizarListadoAsignaturas() {
  let estructura = '';
  if (arrayListadoAsignaturasEstudiante.length) {
    arrayListadoAsignaturasEstudiante.forEach((it, pos) => {

      let buttons = `
        <button type="button" onclick="quitarAsignaturaProfesor(${pos})" class="btn btn-danger" title="Quitar">
          <i class="bi bi-x-lg"></i>
        </button>
      `;

      estructura += `<tr>
        <th scope="row">${pos + 1}</th>
        <td>${it.nombre}</td>
        <td>${it.creditos}</td>
        <td>${it.nombreProf}</td>
        <td class="text-center">${buttons}</td>
      </tr>`;
    })
  } else {
    estructura = `<tr>
      <td colspan="4" class="text-center">No se encontraron asignaturas</td>
    </tr>`;
  }
  $(".tbodyasignaturasestudiantes").html(estructura);
}

function quitarAsignaturaProfesor(posicion) {
  arrayListadoAsignaturasEstudiante.splice(posicion, 1);
  organizarListadoAsignaturas();
}

function asignaturasAgregadasEstudiante({ valid, message }) {
  if (valid) {
    ejecutarNotificacion('success', message);
    ejecutarPeticion({}, "Estudiantes/Listar", "listadoEstudiantes");
    $("#modalAsignarAsignaturas").modal('hide');
    limpiarCampos();
  } else {
    ejecutarNotificacion('error', message);
  }
}