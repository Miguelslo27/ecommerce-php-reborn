<section class="inner form-login">
  <h1 class="shadowed-title">
    <span class="title-shadow">Ingresar</span>
    <span class="title">Ingresar</span>
  </h1>

  <form action="" method="POST">
    <input type="hidden" name="action" value="<?php bind(ACTION_LOGIN) ?>">

    <div class="form-line <?php getGlobal('classesHandler')('email', 'error') ?>">
      <label for="email" class="icon-label"><i class="fas fa-at"></i></label>
      <input type="text" class="input" id="email" name="email" placeholder="Correo electrónico" value="<?php getGlobal('getPreFormData')('email') ?>">
    </div>
    <div class="form-line <?php getGlobal('classesHandler')('pass', 'error') ?>">
      <label for="pass" class="icon-label"><i class="fas fa-key"></i></label>
      <input type="password" class="input" id="pass" name="pass" placeholder="Contraseña">
    </div>
    <div class="form-line align-center remember">
      <label for="rememberme">
        <input type="checkbox" id="rememberme" name="rememberme" checked="true">
        Recúerdame en este equipo
      </label>
    </div>
    <div class="help-line align-center">
      <a href="/recuperar-clave/">He olvidado mi contraseña</a>
      <span>|</span>
      <a href="/registro/">Soy nuevo, deseo registrarme</a>
    </div>
    <div class="form-line">
      <button type="submit">Ingresar</button>
    </div>
  </form>
</section>