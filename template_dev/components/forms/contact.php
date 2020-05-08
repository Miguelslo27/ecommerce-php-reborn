<!-- FORM SECTION -->
<div class="form-div">
  <form action="" method="POST">
    <input type="hidden" name="action" value="<?php bind(ACTION_SEND_EMAIL) ?>">

    <div class="form-placeholder">
      <input type="text" name="sendemail_name" placeholder="Nombre">
    </div>
    <div class="form-placeholder">
      <input type="text" name="sendemail_subject" placeholder="Asunto">
    </div>
    <div class="form-placeholder">
      <input type="text" name="sendemail_phone" placeholder="Telefono">
    </div>
    <div class="form-placeholder">
      <input type="text" name="sendemail_from" placeholder="Email">
    </div>
    <div class="form-placeholder">
      <textarea name="sendemail_message" placeholder="Mensaje"></textarea>
    </div>
    <div class="form-actions">
      <button class="btn-100" type="submit">ENVIAR CONSULTA</button>
    </div>
  </form>
</div>