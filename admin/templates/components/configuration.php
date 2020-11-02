<div class="form-container">

  <!-- DATA FORM -->
  <?php if (getGlobal('section') === 'datos') : ?>
    <form class="form" action="" method="POST">
      <h2>Datos de la Tienda</h2>
      <input type="hidden" name="action" value="<?php bind(ACTION_EDIT_SITE) ?>">
      <div class="form-group">
        <label for="site_name">Nombre:</label>
        <input name="site_name" id="site_name" type="text" class="<?php fieldHasError('site_name', 'error') ?>" value="<?php bind(oneOf(getPreformData('site_name', ''), @getGlobal('site')->name)) ?>">
      </div>
      <div class="form-group">
        <label for="site_dscp">Descripción:</label>
        <textarea name="site_dscp" id="site_dscp" type="text" class="<?php fieldHasError('site_dscp', 'error') ?>"><?php bind(oneOf(getPreformData('site_dscp', ''), @getGlobal('site')->description)) ?></textarea>
      </div>
      <div class="button-container">
        <button class="button" type="submit">
          <i class="fas fa-check"></i> Guardar
        </button>
      </div>   
    </form>  
  <?php endif ?>

  <!-- CONTACT FORM -->
  <?php if (getGlobal('section') === 'contacto') : ?>
    <form class="form" action="" method="POST">
      <h2>Información de Contacto</h2>
      <input type="hidden" name="action" value="<?php bind(ACTION_EDIT_SITE) ?>">
      <div class="form-group">
        <label for="site_address">Direccion:</label>
        <input name="site_address" id="site_address" type="text" class="<?php fieldHasError('site_address', 'error') ?>" value="<?php bind(oneOf(getPreformData('site_address', ''), @getGlobal('site')->address)) ?>">
      </div>
      <div class="form-group">
        <label for="site_phone">Telefono:</label>
        <input name="site_phone" id="site_phone" type="text" class="<?php fieldHasError('site_phone', 'error') ?>" value="<?php bind(oneOf(getPreformData('site_phone', ''), @getGlobal('site')->phone)) ?>">
      </div>
      <div class="form-group">
        <label for="site_email">Email:</label>
        <input name="site_c_email" id="site_c_email" type="text" class="<?php fieldHasError('site_c_email', 'error') ?>" value="<?php bind(oneOf(getPreformData('site_c_email', ''), @getGlobal('site')->contact_email)) ?>">
      </div>
      <div class="form-group">
        <label for="site_phone2">Telefono de Contacto:</label> <!-- PREGUNTAR POR QUE DOS TELEFONOS -->
        <input name="site_c_phone" id="site_c_phone" type="text" class="<?php fieldHasError('site_c_phone', 'error') ?>" value="<?php bind(oneOf(getPreformData('site_c_phone', ''), @getGlobal('site')->contact_phone)) ?>">
      </div>
      <div class="button-container">
        <button class="button" type="submit">
          <i class="fas fa-check"></i> Guardar
        </button>
      </div>
    </form>  
  <?php endif ?>

  <!-- EDIT NETWORK -->
  <?php if (getGlobal('section') === 'redes' && getGlobal('query_param') !== null) : ?>
    <div class="form">
      <div class="arrow-container"><a href="/admin/config/?sid=redes"><i class="fas fa-arrow-left"></i></a></div>
      <h2>Redes Sociales</h2>
      <?php for($i = 0; $i < count(getGlobal('networks_object')); $i++) : ?>
        <?php if (getGlobal('networks_object')[$i]->name === getGlobal('query_param')) : ?>
          <div class="form-group">
            <label for="network_<?php bind(getGlobal('networks_object')[$i]->name)?>"><i class="fab <?php bind(getGlobal('networks_object')[$i]->icon)?>"></i><?php bind(getGlobal('networks_object')[$i]->title)?>:</label>
            <div class="div-input-button">
              <input name="network_<?php bind(getGlobal('networks_object')[$i]->name)?>" id="network_<?php bind(getGlobal('networks_object')[$i]->name)?>" type="text" value="<?php bind(oneOf(getPreformData('network_facebook', ''), @getGlobal('networks_object')[$i]->uri)) ?>">
              <div class="button-container"><a class="edit-network-button button-input" data-action="<?php bind(ACTION_EDIT_SITE_NETWORKS)?>" data-type="edit-network" data-input="network_<?php bind(getGlobal('networks_object')[$i]->name)?>" data-network="<?php bind(getGlobal('networks_object')[$i]->name)?>">Confirmar</a></div>
            </div>
          </div>
        <?php endif?>
      <?php endfor ?>
    <div>  
  <?php endif ?>

  <!-- LIST NETWORKS  -->
  <?php if (getGlobal('section') === 'redes' && getGlobal('query_param') === null) : ?>
    <div class="form">
      <h2>Redes Sociales</h2>
      <?php if (@count(getSiteNetworks()) < 4) : ?>
        <div action="" method="POST" class="div-input-button">
          <select id="add_network_select" name="add_network_select" class="add-network-select" required>
            <option value="" disabled>--Eliga otra red para agregar--</option>
            <?php if (@getGlobal('uri_networks')->instagram === null) : ?>
              <option value="instagram">Instagram</option>
            <?php endif ?>
            <?php if (@getGlobal('uri_networks')->facebook === null) : ?>
              <option value="facebook">Facebook</option>
            <?php endif ?>
            <?php if (@getGlobal('uri_networks')->twitter === null) : ?>
              <option value="twitter">Twitter</option>
            <?php endif ?>
            <?php if (@getGlobal('uri_networks')->youtube === null) : ?>
              <option value="youtube">Youtube</option>
            <?php endif ?>
          </select>
          <div class="add-network-container button-container"><a class="add-network-button button-input" data-action="<?php bind(ACTION_EDIT_SITE_NETWORKS)?>" data-type="add-network">Agregar</a></div>
        </div>
      <?php endif ?>
      <?php for ($i = 0; $i < @count(getSiteNetworks()); $i++) : ?>
        <?php for ($iter = 0; $iter < 4; $iter++) : ?>
          <?php if (getGlobal('networks_object')[$iter]->name === getSiteNetworks()[$i]->tag) : ?>
            <div class="form-group">
              <label for="network_<?php bind(getGlobal('networks_object')[$iter]->name)?>"><i class="fab <?php bind(getGlobal('networks_object')[$iter]->icon)?>"></i><?php bind(getGlobal('networks_object')[$iter]->title)?>:</label>
              <div class="input-group">
                <input name="network_<?php bind(getGlobal('networks_object')[$iter]->name)?>" id="network_<?php bind(getGlobal('networks_object')[$iter]->name)?>" type="text" value="<?php bind(getGlobal('networks_object')[$iter]->uri) ?>" disabled>
                <div class="actions">
                  <a href="/admin/config/?sid=redes&nid=<?php bind(getGlobal('networks_object')[$iter]->name)?>"><i class="fas fa-edit"></i></a>
                  <a class="remove-button remove-network-button" data-action="<?php bind(ACTION_EDIT_SITE_NETWORKS)?>" data-type="remove-network" data-network="<?php bind(getGlobal('networks_object')[$iter]->name)?>"><i class="fas fa-trash-alt"></i></a>
                </div>
              </div>
              <div class="example-text-container">
                <span>Ejemplo: https://www.<?php bind(getGlobal('networks_object')[$iter]->name)?>.com/nombre-de-ejemplo</span>
              </div>
            </div>
          <?php endif ?>
        <?php endfor ?>  
      <?php endfor ?>
    </div>  
  <?php endif ?>

  <!-- ADD/EDIT ADMIN -->
  <?php if (getGlobal('section') === 'admins' && getGlobal('query_param') !== null) : ?>
    <div class="form">
      <div class="arrow-container"><a href="/admin/config/?sid=admins"><i class="fas fa-arrow-left"></i></a></div>
      <?php if (getGlobal('second_query_param') !== null) : ?>
        <h2>Editar Administrador</h2>
      <?php else : ?>
        <h2>Añadir Administrador</h2>
      <?php endif ?>
      <div class="form-group">
        <label for="admin-id">ID:</label>
        <?php if (getGlobal('second_query_param') !== null) : ?>
          <input name="admin-id" id="admin-id" type="number" value="<?php bind(getGlobal('second_query_param'))?>" disabled>
        <?php else : ?>
          <input name="admin-id" id="admin-id" type="number">
        <?php endif ?>
      </div>
      <div class="form-group">
        <label for="admin-role">Role:</label>
        <select id="admin-role" name="admin-role" class="admin-role" value="superadmin" required>
          <?php if (getGlobal('second_query_param') !== null) : ?>
            <option value="admin" <?php bind((getAdmin(getGlobal('second_query_param'))->role === "admin") ? 'selected' : '')?>>Admin</option>
            <option value="seller" <?php bind((getAdmin(getGlobal('second_query_param'))->role === "seller") ? 'selected' : '')?>>Vendedor</option>
            <option value="marketer" <?php bind((getAdmin(getGlobal('second_query_param'))->role === "marketer") ? 'selected' : '')?>>Marketer</option>
          <?php else : ?>
            <option value="admin">Admin</option>
            <option value="seller">Vendedor</option>
            <option value="marketer">Marketer</option>
          <?php endif ?>
        </select>
      </div>
      <div class="button-container"><a class="add-admin-button button" data-action="<?php bind(ACTION_EDIT_SITE)?>" data-type="<?php bind((getGlobal('second_query_param') !== null) ? 'edit-admin' : 'add-admin')?>" data-input="admin-id" data-role="admin-role">Confirmar</a></div>
    </div>
  <?php endif ?>

  <!-- LIST ADMIN -->
  <?php if (getGlobal('section') === 'admins' && getGlobal('query_param') === null) : ?>
    <div class="form big-form" data-success="" id="list-admin">
      <h2>Administradores</h2>
      <?php if (@count(getAdmins()) > 0) : ?>
        <div class="admin-row">
          <div class="admin-id"><b>ID</b></div>
          <div class="admin-name"><b>Nombre</b></div>
          <div class="admin-email"><b>Email</b></div>
          <div class="admin-role"><b>Rol</b></div>
        </div>
        <?php for($i = 0; $i < @count(getAdmins()); $i++) : ?>
          <div class="admin-row <?php bind(($i % 2 === 0) ? 'background' : '')?>">
            <div class="admin-id"><?php bind(getAdmins()[$i]->user_id)?></div>
            <div class="admin-name"><?php bind(getAdmins()[$i]->name . ' ' . getAdmins()[$i]->lastname)?></div>
            <div class="admin-email"><?php bind(getAdmins()[$i]->email)?></div>
            <?php if (getAdmins()[$i]->role === "seller") : ?>
              <div class="admin-role">Vendedor</div>
            <?php else : ?>
              <div class="admin-role"><?php bind(ucfirst(getAdmins()[$i]->role))?></div>
            <?php endif ?>
            <div class="actions list-admin-buttons">
              <a href="/admin/config/?sid=admins&action=edit&id=<?php bind(getAdmins()[$i]->user_id)?>"><i class="fas fa-edit"></i> Editar</a>
              <a class="remove-button remove-admin-button" data-action="<?php bind(ACTION_EDIT_SITE)?>" data-type="remove-admin" data-input="<?php bind(getAdmins()[$i]->user_id)?>"><i class="fas fa-trash-alt"></i> Eliminar</a>
            </div>
          </div>
        <?php endfor ?>
      <?php else : ?>
        <h5 class="text-not-elements">De momento no hay administradores.</h5>
      <?php endif ?>
      <div class="add-container">
        <a href="/admin/config/?sid=admins&action=add"><div class="add-admin"><i class="fas fa-plus"></i>Añadir Administrador</div></a>
      </div>
    </div>  
  <?php endif ?>
</div>