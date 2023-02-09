<div class="row my-2">
  <div class="offset-10 col-2 text-end">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearAsignatura">
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
          <th scope="col">Nombres</th>
          <th scope="col">Área de Conocimiento</th>
          <th scope="col">Créditos</th>
          <th scope="col">Tipo</th>
          <th scope="col">Descripción</th>
          <th scope="col">Estado</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody class="table-group-divider tbodyasignaturas"></tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCrearAsignatura" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearAsignaturaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalCrearAsignaturaLabel">Agregar</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      
        <form id="frmAsignatura">
          <div class="row">
            <div class="col-12 col-md-6 mb-3">
              <label for="nombre" class="form-label mb-0">Nombre</label>
              <input type="text" class="form-control" id="nombre" maxlength="100" name="nombre" placeholder="Nombre">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="areaconocimiento" class="form-label mb-0">Area de conocimiento</label>
              <input type="text" class="form-control" id="areaconocimiento" maxlength="50" name="areaconocimiento" placeholder="Area de conocimiento">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="creditos" class="form-label mb-0">Créditos</label>
              <input type="number" class="form-control" id="creditos" name="creditos" placeholder="Creditos">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="tipo" class="form-label mb-0">Tipo</label>
              <select class="form-select" id="tipo" name="tipo">
                <option selected value="O">Obligatoria</option>
                <option value="E">Electiva</option>
              </select>
            </div>
            <div class="col-12 mb-3">
              <label for="descripcion" class="form-label mb-0">Descripción</label>
              <textarea class="form-control" id="descripcion" name="descripcion" maxlength="300" rows="3"></textarea>
            </div>
            <div class="form-check form-switch mx-3">
              <input class="form-check-input" checked type="checkbox" role="switch" id="estado" name="estado">
              <label class="form-check-label" for="estado">Estado</label>
            </div>
          </div>
        </form>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btnCancelarAsignatura" data-bs-dismiss="modal">
          <i class="bi bi-x-lg"></i> Cerrar
        </button>
        <button type="submit" class="btn btn-primary btnCrearAsignatura" form="frmAsignatura">
          <i class="bi bi-check-lg"></i> Crear
        </button>
      </div>
    </div>
  </div>
</div>