<?php if(getServer('QUERY_STRING') == '') : ?>
  <section class="inner form-forgot">
    <h1 class="shadowed-title">
      <span class="title-shadow">Recuperar Contraseña</span>
      <span class="title">Recuperar Contraseña</span>
    </h1>
    <form action="" method="POST">
      <input type="hidden" name="action" value="<?php bind(ACTION_OBTAIN_PASSWORD) ?>">
      <div class="form-line <?php getGlobal('classesHandler')('email', 'error') ?>">
        <label for="email" class="icon-label"><i class="fas fa-at"></i></label>
        <input type="text" class="input" id="email" name="email" placeholder="Correo electrónico">
      </div>
      <div class="form-line">
        <button class="btn-100" type="submit">Obtener Contraseña</button>
      </div>
    </form>
  </section>
<?php else : ?>
  <section class="inner form-forgot">
    <h1 class="shadowed-title">
      <span class="title-shadow">Cambiar contraseña</span>
      <span class="title">Cambiar contraseña</span>
    </h1>
    <form action="" method="POST">
      <input type="hidden" name="action" value="<?php bind(ACTION_CHANGE_PASSWORD) ?>">
      <div class="form-line <?php getGlobal('classesHandler')('pswrd', 'error') ?>">
        <label for="pswrd" class="icon-label"><i class="fas fa-at"></i></label>
        <input type="text" class="input" id="pswrd" name="pswrd" placeholder="Nueva contraseña">
      </div>
      <div class="form-line <?php getGlobal('classesHandler')('pswrd_confirm', 'error') ?>">
        <label for="pswrd_confirm" class="icon-label"><i class="fas fa-at"></i></label>
        <input type="text" class="input" id="pswrd_confirm" name="pswrd_confirm" placeholder="Repetir contraseña">
      </div>
      <div class="form-line">
        <button class="btn-100" type="submit">Enviar</button>
      </div>
    </form>
  </section>
<?php endif ?>