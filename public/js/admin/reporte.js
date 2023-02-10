$(function () {

  $("#frmBuscar").on('submit', function (e) {
    e.preventDefault();

    if ($("#estudiante").val().trim() == '') {
      return ejecutarNotificacion('error', 'No ha seleccionado el estudiante');
    }

    $.ajax({
      url: urlBase() + 'Reporte/Listar',
      type: 'POST',
      dataType: 'json',
      data: new FormData(this),
      processData: false,
      contentType: false,
      cache: false,
      success: ({ asignaturas }) => {
        let estructura = '';
        if (asignaturas.length) {
          asignaturas.forEach((it, pos) => {

            estructura += `<tr>
              <th scope="row">${pos + 1}</th>
              <td>${it.nombre}</td>
              <td>${it.areaconocimiento}</td>
              <td>${(it.creditos || '')}</td>
              <td>${(it.tipo == 'O' ? 'Obligatoria' : 'Electiva')}</td>
              <td>${(it.semestre || '')}</td>
              <td>${it.docProfesor}</td>
              <td>${it.nomProfesor}</td>
            </tr>`;
          });
        } else {
          estructura = `<tr>
            <td colspan="8" class="text-center">No se encontraron registros</td>
          </tr>`;
        }
        $(".tbodyasignaturas").html(estructura);
      }
    });
  });
});