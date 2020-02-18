<div class="inner form-register">
  <h1>Registro de Usuario</h1>
  <form action="" method="POST">
    <input type="hidden" name="id" value="<?php getGlobal('getPreFormData')('id') ?>">
    <input type="hidden" name="action" value="<?php bind(getCurrentUser() ? ACTION_USER_EDITION : ACTION_USER_REGISTRATION) ?>">
    
    <div class="form-group">
      <label for="nombre">Nombre</label>
      <input type="text" name="nombre" id="nombre" value="<?php getGlobal('getPreFormData')('nombre') ?>">
      <label for="apellido" class="align-center">Apellido</label>
      <input type="text" name="apellido" id="apellido" value="<?php getGlobal('getPreFormData')('apellido') ?>">
    </div>

    <div class="form-line <?php getGlobal('classesHandler')('reg_email', 'error') ?>">
      <label for="reg_email">E-Mail *</label>
      <input type="text" name="reg_email" id="reg_email" value="<?php getGlobal('getPreFormData')('reg_email') ?>">
    </div>

    <div class="form-group">
      <label for="reg_pass" class="<?php getGlobal('classesHandler')('reg_pass', 'error') ?>">Contraseña *</label>
      <input type="password" class="<?php getGlobal('classesHandler')('reg_pass', 'error') ?>" name="reg_pass" id="reg_pass" value="<?php getGlobal('getPreFormData')('reg_pass') ?>">
      <label for="pass2" class="align-center <?php getGlobal('classesHandler')('pass2', 'error') ?>">Repetir contraseña *</label>
      <input type="password" class="<?php getGlobal('classesHandler')('pass2', 'error') ?>" name="pass2" id="pass2" value="<?php getGlobal('getPreFormData')('pass2') ?>">
    </div>

    <div class="form-line">
      <label for="rut">Documento (RUT o CI)</label>
      <input type="text" name="rut" id="rut" value="<?php getGlobal('getPreFormData')('rut') ?>">
    </div>

    <div class="form-line">
      <label for="direccion">Dirección completa</label>
      <input type="text" name="direccion" id="direccion" value="<?php getGlobal('getPreFormData')('direccion') ?>">
    </div>
    
    <div class="form-group">
      <label for="departamento">Departamento</label>
      <input type="text" name="departamento" id="departamento" value="<?php getGlobal('getPreFormData')('departamento') ?>">
      <label for="ciudad" class="align-center">Localidad</label>
      <input type="text" name="ciudad" id="ciudad" value="<?php getGlobal('getPreFormData')('ciudad') ?>">
    </div>

    <div class="form-group">
      <label for="telefono" class="<?php getGlobal('classesHandler')('telefono', 'error') ?>">Teléfono *</label>
      <input type="text" class="<?php getGlobal('classesHandler')('telefono', 'error') ?>" name="telefono" id="telefono" value="<?php getGlobal('getPreFormData')('telefono') ?>">
      <label for="celular" class="align-center <?php getGlobal('classesHandler')('celular', 'error') ?>">Celular *</label>
      <input type="text" class="<?php getGlobal('classesHandler')('celular', 'error') ?>" name="celular" id="celular" value="<?php getGlobal('getPreFormData')('celular') ?>">
    </div>

    <div class="<?php echo getCurrentUser() ? 'form-actions' : 'form-line' ?>">
      <button type="submit"><?php echo getCurrentUser() ? 'Guardar' : 'Registrarme' ?></button>
      <?php echo getCurrentUser() ? '<button type="reset">Cancelar</button>' : '' ?>
    </div>
  </form>
</div>
