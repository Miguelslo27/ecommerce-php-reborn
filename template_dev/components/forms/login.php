<section class="inner form-login">
  <h1 class="shadowed-title">
    <span class="title-shadow">Ingresar</span>
    <span class="title">Ingresar</span>
  </h1>

  <form action="" method="POST">
    <input type="hidden" name="action" value="<?php bind(ACTION_LOGIN) ?>">

    <div class="form-line">
      <label for="email">E-Mail</label>
      <input type="text" class="input" id="email" name="email">
    </div>
    <div class="form-line">
      <label for="pass">Contraseña</label>
      <input type="password" class="input" id="pass" name="pass">
    </div>
    <div class="help-line align-right">
      <a href="/recuperar-clave/">He olvidado mi contraseña</a>
      <span>|</span>
      <a href="/registro/">Soy nuevo, deseo registrarme</a>
    </div>
    <div class="form-line">
      <label for="rememberme">
        <input type="checkbox" id="rememberme" name="rememberme" checked="true">
        Recúerdame en este equipo
      </label>
    </div>
    <div class="form-line">
      <button type="submit">Ingresar</button>
    </div>
  </form>
</section>