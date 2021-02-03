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
  </div>
</div>