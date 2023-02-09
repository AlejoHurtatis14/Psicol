<div class="row my-2">
  <div class="offset-10 col-2 text-end">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearEstudiante">
      <i class="bi bi-plus-lg"></i> Crear
    </button>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Documento</th>
          <th scope="col">Nombres</th>
          <th scope="col">Teléfono</th>
          <th scope="col">Correo</th>
          <th scope="col">Dirección</th>
          <th scope="col">Ciudad</th>
          <th scope="col">Semestre</th>
          <th scope="col">Estado</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody class="table-group-divider tbodyestudiantes"></tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCrearEstudiante" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearPEstudianteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalCrearEstudianteLabel">Agregar</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      
        <form id="frmEstudiante">
          <div class="row">
            <div class="col-12 col-md-4 mb-3">
              <label for="documento" class="form-label mb-0">Documento</label>
              <input type="text" class="form-control" maxlength="20" id="documento" name="documento" placeholder="Identificación">
            </div>
            <div class="col-12 col-md-8 mb-3">
              <label for="nombre" class="form-label mb-0">Nombre</label>
              <input type="text" class="form-control" id="nombre" maxlength="100" name="nombre" placeholder="Nombre completo">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="telefono" class="form-label mb-0">Teléfono</label>
              <input type="tel" class="form-control" id="telefono" maxlength="15" name="telefono" placeholder="Teléfono">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="correo" class="form-label mb-0">Correo electrónico</label>
              <input type="text" class="form-control" id="correo" maxlength="50" name="correo" placeholder="Correo electrónico">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="direccion" class="form-label mb-0">Dirección</label>
              <input type="text" class="form-control" id="direccion" maxlength="100" name="direccion" placeholder="Dirección">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="ciudad" class="form-label mb-0">Ciudad</label>
              <input type="text" class="form-control" id="ciudad" maxlength="50" name="ciudad" placeholder="Ciudad">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="semestre" class="form-label mb-0">Semestre</label>
              <input type="number" class="form-control" id="semestre" name="semestre" placeholder="Semestre">
            </div>
            <div class="col-12 col-md-6 mb-3 align-items-center d-flex">
              <div class="form-check form-switch">
                <input class="form-check-input" checked type="checkbox" role="switch" id="estado" name="estado">
                <label class="form-check-label" for="estado">Estado</label>
              </div>
            </div>
          </div>
        </form>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btnCancelarEstudiante" data-bs-dismiss="modal">
          <i class="bi bi-x-lg"></i> Cerrar
        </button>
        <button type="submit" class="btn btn-primary btnCrearEstudiante" form="frmEstudiante">
          <i class="bi bi-check-lg"></i> Crear
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalAsignarAsignaturas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAsignarAsignaturasLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalAsignarAsignaturasLabel">Asignaturas</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      
        <form id="frmAsignaturaEstudiante">
          <div class="row">
            <div class="col-12 col-md-4">
              <label for="asignatura" class="form-label mb-0">Asignaturas</label>
              <select class="form-select" id="asignatura" name="asignatura">
                <option value=""></option>
              </select>
            </div>
            <div class="col-12 col-md-4">
              <label for="profesor" class="form-label mb-0">Profesores</label>
              <select class="form-select" id="profesor" name="profesor">
                <option value=""></option>
              </select>
            </div>
            <div class="col-12 col-md-4 d-flex align-items-end">
              <button type="submit" class="btn btn-primary btnAgregarAsignatura w-100" form="frmAsignaturaEstudiante">
                <i class="bi bi-check-lg"></i> Agregar
              </button>
            </div>    
          </div>
        </form>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Asignatura</th>
              <th scope="col">Créditos</th>
              <th scope="col">Profesor</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody class="table-group-divider tbodyasignaturasestudiantes"></tbody>
        </table>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btnCancelarAsignaturas" data-bs-dismiss="modal">
          <i class="bi bi-x-lg"></i> Cerrar
        </button>
        <button type="submit" class="btn btn-primary btnConfirmarAsignaturas">
          <i class="bi bi-check-lg"></i> Aceptar
        </button>
      </div>
    </div>
  </div>
</div>