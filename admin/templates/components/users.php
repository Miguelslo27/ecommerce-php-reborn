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
        <input type="hidden" name="action" value="<?php bind('ACTION_CREATE_USER') ?>"></input>
        <div class="form-group">
          <label for="user_name">Nombre:</label>
          <input name="user_name" id="user_name" type="text" class="<?php fieldHasError('user_name', 'error') ?>" value="<?php bind(getPreformData('user_name', '')) ?>">
        </div>
        <div class="form-group">
          <label for="user_lastname">Apellido:</label>
          <input name="user_lastname" id="user_lastname" type="text" class="<?php fieldHasError('user_lastname', 'error') ?>" value="<?php bind(getPreformData('user_lastname', '')) ?>"></input>
        </div>
        <div class="form-group">
          <label for="user_document">Documento:</label>
          <input name="user_document" id="user_document" type="text" class="<?php fieldHasError('user_document', 'error') ?>" value="<?php bind(getPreformData('user_document', '')) ?>"></input>
        </div>
        <div class="form-group">
          <label for="user_address">Dirección:</label>
          <input name="user_address" id="user_address" type="text" class="<?php fieldHasError('user_address', 'error') ?>" value="<?php bind(getPreformData('user_address', '')) ?>">
        </div>
        <div class="form-group">
          <label for="user_state">Departamento:</label>
          <input name="user_state" id="user_state" type="text" class="<?php fieldHasError('user_state', 'error') ?>" value="<?php bind(getPreformData('user_state', '')) ?>">
        </div>
        <div class="form-group">
          <label for="user_city">Ciudad:</label>
          <input name="user_city" id="user_city" type="text" class="<?php fieldHasError('user_city', 'error') ?>" value="<?php bind(getPreformData('user_city', '')) ?>">
        </div>
        <div class="form-group">
          <label for="user_phone">Teléfono:</label>
          <input name="user_phone" id="user_phone" type="text" class="<?php fieldHasError('user_phone', 'error') ?>" value="<?php bind(getPreformData('user_phone', '')) ?>">
        </div>
        <div class="form-group">
          <label for="user_cellphone">Celular:</label>
          <input name="user_cellphone" id="user_cellphone" type="text" class="<?php fieldHasError('user_cellphone', 'error') ?>" value="<?php bind(getPreformData('user_cellphone', '')) ?>">
        </div>
        <div class="form-group">
          <label for="user_email">Email:</label>
          <input name="user_email" id="user_email" type="text" class="<?php fieldHasError('user_email', 'error') ?>" value="<?php bind(getPreformData('user_email', '')) ?>">
        </div>
        <div class="form-group">
          <label for="user_password">Contraseña:</label>
          <input name="user_password" id="user_password" type="password" class="<?php fieldHasError('user_password', 'error') ?>" value="<?php bind(getPreformData('user_password', '')) ?>">
        </div>
        <div class="button-container multiple-buttons">
          <button class="button" type="submit">
            <i class="fas fa-check"></i> Guardar
          </button>
          <button class="button save-and-create-new-button" type="submit">
            <i class="fas fa-check"></i> Guardar y crear otra
          </button>
        </div>
      </form>
    <?php endif ?>
  </div>
</div>