<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= Route::currentRouteName() == 'Asignaturas' ? 'active text-primary' : '' ?>" href="<?= url('') ?>/Asignaturas">
            Asignaturas
          </a>
        </li>
        <li class="nav-item>">
          <a class="nav-link <?= Route::currentRouteName() == 'Estudiantes' ? 'active text-primary' : '' ?>" href="<?= url('') ?>/Estudiantes">
            Estudiantes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= Route::currentRouteName() == 'Informe' ? 'active text-primary' : '' ?>" href="<?= url('') ?>/Informe">
            Informe
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= Route::currentRouteName() == 'Profesores' ? 'active text-primary' : '' ?>" aria-current="page" href="<?= url('') ?>/Profesores">
            Profesores
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>