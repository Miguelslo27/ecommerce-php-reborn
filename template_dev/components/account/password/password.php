<section class="inner">
  <h1 class="shadowed-title">
    <span class="title-shadow"> Mi cuenta</span>
    <span class="title"> Mi cuenta</span>
  </h1>

  <div class="div-account">
    <?php getTemplate('../template_dev/components/sidebar-account/sidebar'); ?>

    <section class="form-pass">
      <form action="" method="post" class="form-margin">
        <h2 class="title-account">
          Cambiar Contraseña
        </h2>
        <div class="form-line">
          <label class="label-center" for="">Contraseña vieja</label>
          <input type="password">
        </div>
        <div class="form-line">
          <label class="label-center" for="">Nueva contraseña</label>
          <input type="password">
        </div>
        <div class="form-line">
          <label class="label-center" for="">Repetir la nueva contraseña </label>
          <input type="password">
        </div>
        <button class="button primary" id="button-center">Guardar</button>
        <button class="button secondary" id="button-center">Reset</button>
      </form>
    </section>
  </div>
</section>