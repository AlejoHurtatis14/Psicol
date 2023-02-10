<nav class="navbar navbar-expand-lg bg-dark">
  <div class="container">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link text-white <?= Route::currentRouteName() == 'Asignaturas' ? 'active' : '' ?>" href="<?= url('') ?>/Asignaturas">
              Asignaturas
            </a>
          </li>
          <li class="nav-item>">
            <a class="nav-link text-white <?= Route::currentRouteName() == 'Estudiantes' ? 'active' : '' ?>" href="<?= url('') ?>/Estudiantes">
              Estudiantes
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?= Route::currentRouteName() == 'Profesores' ? 'active' : '' ?>" aria-current="page" href="<?= url('') ?>/Profesores">
              Profesores
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?= Route::currentRouteName() == 'Reporte' ? 'active' : '' ?>" href="<?= url('') ?>/Reporte">
              Reporte
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>