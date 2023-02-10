<div class="row my-2">
  <form id="frmBuscar">
    <div class="row">
      <div class="col-12 col-md-4">
        <label for="estudiante" class="form-label mb-0">Estudiante</label>
        <select class="form-select" id="estudiante" name="estudiante">
          <option value="">Seleccione...</option>
          @foreach ($estudiantes as $estudiante)
            <option value="{{ $estudiante->id }}">{{ $estudiante->documento }} | {{ $estudiante->nombre }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary" form="frmBuscar">
          <i class="bi bi-search"></i> Buscar
        </button>
      </div>
    </div>
  </form>
</div>

<div class="card">
  <div class="card-body">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Documento</th>
          <th scope="col">Estudiante</th>
          <th scope="col">Asignatura</th>
          <th scope="col">Área de Conocimiento</th>
          <th scope="col">Créditos</th>
          <th scope="col">Tipo</th>
          <th scope="col">Semestre</th>
          <th scope="col">Documento Profesor</th>
          <th scope="col">Profesor</th>
        </tr>
      </thead>
      <tbody class="table-group-divider tbodyasignaturas"></tbody>
    </table>
  </div>
</div>