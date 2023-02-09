let arrayListadoEstudiantes = [];
let idEdicionActual = -1;

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

  $(".btnCancelarEstudiante").on('click', function () {
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