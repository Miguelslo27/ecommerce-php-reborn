<div class="form-container form-xl">
  <div class="form-container">
    <?php if (getParam('uid') === 'todos') : ?>
    <!-- LIST USERS -->
      <div class="form big-form" data-success="" id="list-users">
        <?php $users = getUsers('`status` = 1'); ?>
        <h2>Lista de Usuarios</h2>
        <?php if ($users !== null) : ?>
          <div class="table-row text-center">
            <div class="cell user-name"><b>Nombre</b></div>
            <div class="cell user-id"><b>Documento</b></div>
            <div class="cell user-email"><b>Email</b></div>
            <div class="cell user-location"><b>Ubicación</b></div>
            <div class="cell user-phone"><b>Telefónos</b></div>
          </div>
          <?php for ($i = 0; $i < @count($users); $i++) : ?>
            <div class="table-row <?php bind(($i % 2 === 0) ? 'background' : '') ?>">
              <div class="cell user-name">
                <p><?php bind($users[$i]->name . ' ' . $users[$i]->lastname) ?></p>
              </div>
              <div class="cell user-id">
                <p><?php bind($users[$i]->document) ?></p>
              </div>
              <div class="cell user-email">
                <p><?php bind($users[$i]->email) ?></p>
              </div>
              <div class="cell user-location">
                <p>
                  <?php bind($users[$i]->state)?>
                  <?php if($users[$i]->state && ($users[$i]->city || $users[$i]->address)) : ?>,<?php endif ?>
                  <?php bind($users[$i]->city)?>
                  <?php if($users[$i]->address && $users[$i]->city) : ?>,  <?php endif ?>
                  <?php bind($users[$i]->address)?>
                </p>
              </div>
              <div class="cell user-phone">
                <p>
                  <?php bind($users[$i]->cellphone) ?> 
                  <?php if($users[$i]->cellphone && $users[$i]->phone) : ?> - <?php endif ?>
                  <?php bind($users[$i]->phone) ?>
                </p>
              </div>
              <div class="actions list-admin-buttons">
                <a 
                  class="suspend-button" 
                  data-action="<?php bind(ACTION_HANDLE_SUSPEND_USER) ?>" 
                  data-type="suspend-user"  
                  data-id="<?php bind($users[$i]->id)?>">
                  <i class="fas fa-times-circle"></i> Suspender
                </a>
              </div>
            </div>
          <?php endfor ?>
          </div>
        <?php else : ?>
          <h5 class="text-not-elements">De momento no hay usuarios.</h5>
        <?php endif ?>
      </div>
    <?php endif ?>
    <?php if (getParam('uid') === 'suspendidos') : ?>
    <!-- LIST SUSPENDED USERS -->
      <div class="form big-form" id="list-suspended-users">
        <?php $users = getUsers('`status` = 0'); ?>
        <h2>Lista de Usuarios Suspendidos</h2>
        <?php if ($users !== null) : ?>
          <div class="table-row text-center">
            <div class="cell user-name"><b>Nombre</b></div>
            <div class="cell user-id"><b>Documento</b></div>
            <div class="cell user-email"><b>Email</b></div>
            <div class="cell user-location"><b>Ubicación</b></div>
            <div class="cell user-phone"><b>Telefónos</b></div>
          </div>
          <?php for ($i = 0; $i < @count($users); $i++) : ?>
            <div class="table-row <?php bind(($i % 2 === 0) ? 'background' : '') ?>">
              <div class="cell user-name">
                <p><?php bind($users[$i]->name . ' ' . $users[$i]->lastname) ?></p>
              </div>
              <div class="cell user-id">
                <p><?php bind($users[$i]->document) ?></p>
              </div>
              <div class="cell user-email">
                <p><?php bind($users[$i]->email) ?></p>
              </div>
              <div class="cell user-location">
                <p>
                  <?php bind($users[$i]->state)?>
                  <?php if($users[$i]->state && ($users[$i]->city || $users[$i]->address)) : ?>,<?php endif ?>
                  <?php bind($users[$i]->city)?>
                  <?php if($users[$i]->address && $users[$i]->city) : ?>,  <?php endif ?>
                  <?php bind($users[$i]->address)?>
                </p>
              </div>
              <div class="cell user-phone">
                <p>
                  <?php bind($users[$i]->cellphone) ?> 
                  <?php if($users[$i]->cellphone && $users[$i]->phone) : ?> - <?php endif ?>
                  <?php bind($users[$i]->phone) ?>
                </p>
              </div>
              <div class="actions list-admin-buttons">
                <a 
                  class="restore-button unsuspend-button" 
                  data-action="<?php bind(ACTION_HANDLE_SUSPEND_USER) ?>"
                  data-type="unsuspend-user" 
                  data-id="<?php bind($users[$i]->id)?>">
                  <i class="fas fa-check"></i>  Restablecer
                </a>
              </div>
            </div>
          <?php endfor ?>
          </div>
        <?php else : ?>
          <h5 class="text-not-elements">De momento no hay usuarios suspendidos.</h5>
        <?php endif ?>
      </div>
    <?php endif ?>
    <?php if (getParam('uid') === 'nuevo') : ?>
      <form class="form" action="" method="POST" id="user-form">
        <h2>Crear Usuario</h2>
        <input type="hidden" name="action" value="<?php bind(ACTION_CREATE_USER) ?>">
        <input type="hidden" name="button-action-user" id="button-action-user" value="">
        <div class="form-group">
          <label for="name">Nombre:</label>
          <input name="name" id="name" type="text" class="<?php fieldHasError('name', 'error') ?>" value="<?php bind(getGlobal('user_success') ? '' : getPreformData('name', '')) ?>">
        </div>
        <div class="form-group">
          <label for="lastname">Apellido:</label>
          <input name="lastname" id="lastname" type="text" class="<?php fieldHasError('lastname', 'error') ?>" value="<?php bind(getGlobal('user_success') ? '' : getPreformData('lastname', '')) ?>"></input>
        </div>
        <div class="form-group">
          <label for="reg_email">Email:</label>
          <input name="reg_email" id="reg_email" type="text" class="<?php fieldHasError('reg_email', 'error') ?>" value="<?php bind(getGlobal('user_success') ? '' : getPreformData('reg_email', '')) ?>">
        </div>
        <div class="form-group">
          <label for="reg_pass">Contraseña:</label>
          <input name="reg_pass" id="reg_pass" type="password" class="<?php fieldHasError('reg_pass', 'error') ?>" value="<?php bind(getGlobal('user_success') ? '' : getPreformData('reg_pass', '')) ?>">
        </div>
        <div class="form-group">
          <label for="pass2">Repetir Contraseña:</label>
          <input name="pass2" id="pass2" type="password" class="<?php fieldHasError('pass2', 'error') ?>" value="<?php bind(getGlobal('user_success') ? '' : getPreformData('pass2', '')) ?>">
        </div>
        <div class="form-group">
          <label for="document">Documento:</label>
          <input name="document" id="document" type="text" class="<?php fieldHasError('document', 'error') ?>" value="<?php bind(getGlobal('user_success') ? '' : getPreformData('document', '')) ?>"></input>
        </div>
        <div class="form-group">
          <label for="address">Dirección:</label>
          <input name="address" id="address" type="text" class="<?php fieldHasError('address', 'error') ?>" value="<?php bind(getGlobal('user_success') ? '' : getPreformData('address', '')) ?>">
        </div>
        <div class="form-group">
          <label for="state">Departamento:</label>
          <input name="state" id="state" type="text" class="<?php fieldHasError('state', 'error') ?>" value="<?php bind(getGlobal('user_success') ? '' : getPreformData('state', '')) ?>">
        </div>
        <div class="form-group">
          <label for="city">Ciudad:</label>
          <input name="city" id="city" type="text" class="<?php fieldHasError('city', 'error') ?>" value="<?php bind(getGlobal('user_success') ? '' : getPreformData('city', '')) ?>">
        </div>
        <div class="form-group">
          <label for="phone">Teléfono:</label>
          <input name="phone" id="phone" type="text" class="<?php fieldHasError('phone', 'error') ?>" value="<?php bind(getGlobal('user_success') ? '' : getPreformData('phone', '')) ?>">
        </div>
        <div class="form-group">
          <label for="cellphone">Celular:</label>
          <input name="cellphone" id="cellphone" type="text" class="<?php fieldHasError('cellphone', 'error') ?>" value="<?php bind(getGlobal('user_success') ? '' : getPreformData('cellphone', '')) ?>">
        </div>
        <div class="button-container multiple-buttons">
          <button class="button" type="submit">
            <i class="fas fa-check"></i> Guardar
          </button>
          <button class="button save-and-create-new-button" data-success="<?php bind(getGlobal('user_success'))?>" id="save-and-create-new-user" type="submit">
            <i class="fas fa-check"></i> Guardar y crear otra
          </button>
        </div>
      </form>
    <?php endif ?>
  </div>
</div>