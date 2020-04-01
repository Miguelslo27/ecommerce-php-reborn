<section class="inner form-register">
  <h1 class="shadowed-title">
    <span class="title-shadow">Registro de Usuario</span>
    <span class="title">Registro de Usuario</span>
  </h1>

  <form action="" method="POST">
    <input type="hidden" name="action" value="<?php bind(getCurrentUser() ? ACTION_USER_EDITION : ACTION_USER_REGISTRATION) ?>">

    <div class="form-group">
      <label for="name" class="<?php getGlobal('classesHandler')('name', 'error') ?>">Nombre *</label>
      <input type="text" class="<?php getGlobal('classesHandler')('name', 'error') ?>" name="name" id="name" value="<?php getGlobal('getPreFormData')('name') ?>">
      <label for="lastname" class="second-label <?php getGlobal('classesHandler')('lastname', 'error') ?>">Apellido * </label>
      <input type="text" class="<?php getGlobal('classesHandler')('lastname', 'error') ?>" name="lastname" id="lastname" value="<?php getGlobal('getPreFormData')('lastname') ?>">
    </div>

    <div class="form-line <?php getGlobal('classesHandler')('reg_email', 'error') ?>">
      <label for="reg_email">E-Mail *</label>
      <input type="text" name="reg_email" id="reg_email" value="<?php oneOf(@getGlobal('getPreFormData')('reg_email'), getGlobal('getPreFormData')('email')) ?>">
    </div>

    <div class="form-group">
      <label for="reg_pass" class="<?php getGlobal('classesHandler')('reg_pass', 'error') ?>">Contraseña *</label>
      <input type="password" class="<?php getGlobal('classesHandler')('reg_pass', 'error') ?>" name="reg_pass" id="reg_pass">
      <label for="pass2" class="second-label <?php getGlobal('classesHandler')('pass2', 'error') ?>">Repetir contraseña *</label>
      <input type="password" class="<?php getGlobal('classesHandler')('pass2', 'error') ?>" name="pass2" id="pass2">
    </div>

    <div class="form-line <?php getGlobal('classesHandler')('document', 'error') ?>">
      <label for="document">RUT o Cédula * </label>
      <input type="text" name="document" id="document" value="<?php getGlobal('getPreFormData')('document') ?>">
    </div>

    <div class="form-line <?php getGlobal('classesHandler')('address', 'error') ?>">
      <label for="address">Dirección completa</label>
      <input type="text" name="address" id="address" value="<?php getGlobal('getPreFormData')('address') ?>">
    </div>
    
    <div class="form-group">
      <label for="state" class="<?php getGlobal('classesHandler')('state', 'error') ?>">Departamento</label>
      <input type="text" class="<?php getGlobal('classesHandler')('state', 'error') ?>" name="state" id="state" value="<?php getGlobal('getPreFormData')('state') ?>">
      <label for="city" class="second-label <?php getGlobal('classesHandler')('city', 'error') ?>">Localidad</label>
      <input type="text" class="<?php getGlobal('classesHandler')('city', 'error') ?>" name="city" id="city" value="<?php getGlobal('getPreFormData')('city') ?>">
    </div>

    <div class="form-group">
      <label for="phone" class="<?php getGlobal('classesHandler')('phone', 'error') ?>">Teléfono *</label>
      <input type="text" class="<?php getGlobal('classesHandler')('phone', 'error') ?>" name="phone" id="phone" value="<?php getGlobal('getPreFormData')('phone') ?>">
      <label for="cellphone" class="second-label <?php getGlobal('classesHandler')('cellphone', 'error') ?>">Celular *</label>
      <input type="text" class="<?php getGlobal('classesHandler')('cellphone', 'error') ?>" name="cellphone" id="cellphone" value="<?php getGlobal('getPreFormData')('cellphone') ?>">
    </div>

    <div class="form-actions">
      <?php if (getCurrentUser()) : ?>
      <button type="submit">Guardar</button>
      <button type="reset">Revertir cambios</button>
      <?php else : ?>
      <button type="submit">Registrarme</button>
      <a href="/login" class="button secondary">Ya estoy registrado, ingresar</a>
      <?php endif ?>
    </div>
  </form>
</section>
