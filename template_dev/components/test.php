<section class="full-inner">
  <h1 class="shadowed-title">
    <span class="title-shadow">Contacto</span>
    <span class="title">Contacto</span>
  </h1>

  <form action="" method="POST">
    <input type="hidden" name="action" value="<?php bind(ACTION_SEND_EMAIL) ?>">
    
    <div class="form-line">
      <label for="input">Mi input</label>
      <input type="text" name="input" id="input">
    </div>

    <div class="form-placeholder">
      <input type="text" placeholder="Nombre">
    </div>

    <div class="form-group">
      <label for="input">Mi input</label>
      <input type="text" name="input" id="input">

      <label for="input" class="align-center">Mi input</label>
      <input type="text" name="input" id="input">
    </div>
    
    <div class="form-actions">
      <button type="submit">Boton</button>
      <button type="reset" disabled>Boton</button>
    </div>

    <a href="" class="button secondary disabled">Mi link</a>
  </form>
</section>