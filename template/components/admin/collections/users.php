<?php protectFromNotAdminUsers() ?>
<section class="inner users-collection">
  <h1>Gestión de usuarios</h1>

  <div class="list-actions">
    <div class="admin-actions">
      <a href="/usuario/nuevo">Nuevo Usuario +</a>
    </div>
  </div>

  <?php if (count(getGlobal('users')) > 0) : ?>
    <div class="list-actions">
      <?php paginateUsers() ?>
    </div>
    <section class="table users">
      <article class="row headline">
        <span class="cell name">Usuario</span>
        <span class="cell email span-3">Email</span>
        <span class="cell role">Rol</span>
        <span class="cell actions">Acciones</span>
      </article>
      <?php foreach (getGlobal('users') as $user) : ?>
        <article class="row">
          <span class="cell name"><?php echo $user->nombre . ' ' . $user->apellido ?></span>
          <span class="cell email span-3"><?php echo $user->email ?></span>
          <span class="cell role"><?php echo $user->administrador ? 'Administrador' : 'Cliente' ?></span>
          <span class="cell actions">
            <a href="/admin/usuario/editar?uid=<?php echo $user->id ?>"><i class="fas fa-user-edit"></i></a>
            |
            <a href="/admin/correo/nuevo?uid=<?php echo $user->id ?>"><i class="fas fa-envelope-open-text"></i></a>
            |
            <a href="/admin/usuario/recrear-clave?uid=<?php echo $user->id ?>"><i class="fas fa-key"></i></a>
            |
            <a href="/admin/usuario/eliminar?uid=<?php echo $user->id ?>"><i class="far fa-trash-alt"></i></a>
          </span>
        </article>
      <?php endforeach ?>
    </section>
  <?php else : ?>
    <div class="empty-list">
      <h2 class>No hay usuarios registrados aún</h2>
    </div>
  <?php endif ?>
</section>