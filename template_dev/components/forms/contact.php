<!-- FORM SECTION -->
<div class="form-div">
  <form action="" method="POST">
    <input type="hidden" name="action" value="<?php bind(ACTION_SEND_EMAIL) ?>">
    <div class="form-placeholder">
      <input type="text" name="sendemail_name" id="sendemail_name" class="<?php getGlobal('classesHandler')('sendemail_name', 'error') ?>" placeholder="Nombre">
    </div>
    <div class="form-placeholder">
      <input type="text" name="sendemail_subject" id="sendemail_subject" class="<?php getGlobal('classesHandler')('sendemail_subject', 'error') ?>" placeholder="Asunto">
    </div>
    <div class="form-placeholder">
      <input type="text" name="sendemail_phone" id="sendemail_phone" class="<?php getGlobal('classesHandler')('sendemail_phone', 'error') ?>" placeholder="Telefono">
    </div>
    <div class="form-placeholder">
      <input type="text" name="sendemail_from" id="sendemail_from" class="<?php getGlobal('classesHandler')('sendemail_from', 'error') ?>" placeholder="Email">
    </div>
    <div class="form-placeholder">
      <textarea name="sendemail_message" id="sendemail_message" class="<?php getGlobal('classesHandler')('sendemail_message', 'error') ?>" placeholder="Mensaje"></textarea>
    </div>
    <div class="form-actions">
      <button class="btn-100" type="submit">ENVIAR CONSULTA</button>
    </div>
  </form>
</div> 