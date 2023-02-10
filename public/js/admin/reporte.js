$(function () {

  $("#frmBuscar").on('submit', function (e) {
    e.preventDefault();
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
              <td>${it.documento}</td>
              <td>${it.nombreEstudiante}</td>
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
            <td colspan="10" class="text-center">No se encontraron registros</td>
          </tr>`;
        }
        $(".tbodyasignaturas").html(estructura);
      }
    });
  });

  $("#frmBuscar").submit();
});