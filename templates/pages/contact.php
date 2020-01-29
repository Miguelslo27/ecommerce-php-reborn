<div class="inner page-contact">
  <h1>Contactanos</h1>
  <!-- <span class="line-h"></span> -->
  <!-- <div class="body-content">
    <p><strong>Dirección:</strong> Arenal Grande 2380</p>
    <p><strong>Comunicate al:</strong> 2200 33 28 / 2209 81 51</p>
    <p><strong>Email:</strong> miguelmail2006@gmail.com</p>
    <p><strong>Seguinos en <a class="fa fa-2x fa-facebook-square" target="_blank" href="https://www.facebook.com/eCommerce.ventasxmayor"></a></strong></p>
  </div> -->
  <!-- <h1>Envianos tu consulta</h1> -->
  <div class="body-content">
    <?php
    $enviar = true;
    $errores = array();
    if (isset($_POST['submit'])) {
      if ($_POST['email'] == "") {
        $enviar = false;
        $errores[] = "Tu email es obligatorio";
      }
      if ($_POST['nombre'] == "") {
        $enviar = false;
        $errores[] = "Tu nombre es obligatorio";
      }
      if ($_POST['asunto'] == "") {
        $enviar = false;
        $errores[] = "El asunto es obligatorio";
      }
      if ($_POST['mensaje'] == "") {
        $enviar = false;
        $errores[] = "El mensaje es obligatorio";
      }
      if ($enviar) {
        $mail = new PHPMailer();
        $mail->addAddress('miguelmail2006@gmail.com', 'eCommerce');
        $mail->addAddress('gahecht@hotmail.com', 'Gabriela Hecht');
        // $mail->addAddress('miguelmail2006@gmail.com', 'eCommerce');
        $mail->setFrom('eCommerce@eCommerce', $_POST['nombre'] . ' ' . $_POST['apellido']);
        $mail->addReplyTo($_POST['email'], $_POST['nombre'] . ' ' . $_POST['apellido']);
        $mail->Subject = '(eCommerce) ' . utf8_decode($_POST['asunto']);
        $mail->msgHTML(utf8_decode($_POST['mensaje']));
        if ($mail->send()) {
    ?>
          <div class="mensaje-enviado">
            <p>Tu mensaje se ha enviado correctamente.</p>
            <p>Nos pondremos en contacto a la brevedad.</p>
          </div>
        <?php
        } else {
        ?>
          <div class="mensaje-no-enviado">
            <p>Tu mensaje no se ha enviado!</p>
            <p>Intenta nuevamente en un momento.</p>
          </div>
        <?php
        }
      } else {
        ?>
        <div class="mensaje-no-enviado">
          <p>Tu mensaje no se ha enviado!</p>
          <p>Recuerda que tu nombre, tu email, el asunto y el mensaje, son campos obligatorios.</p>
          <!-- <p>Intenta nuevamente en un momento.</p> -->
          <!-- print_r($errores); -->
        </div>
      <?php
      }
      ?>
      <script>
        setTimeout(function() {
          document.location.href = "/contacto/";
        }, 5000);
      </script>
    <?php
    }
    ?>
    <form action="/contacto/index.php" method="POST" id="contact-form">
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" class="input" id="nombre" name="nombre">
        <label for="apellido" class="align-center">Apellido</label>
        <input type="text" class="input" id="apellido" name="apellido">
      </div>
      <div class="form-line">
        <label for="email">E-Mail</label>
        <input type="text" class="input" id="email" name="email">
      </div>
      <div class="form-line">
        <label for="asunto">Asunto</label>
        <input type="text" class="input" id="asunto" name="asunto">
      </div>
      <div class="form-line">
        <label for="mensaje">Mensaje</label>
        <textarea class="input" id="mensaje" name="mensaje"></textarea>
      </div>
      <div class="form-actions">
        <button type="submit" name="submit">Enviar</button>
        <button type="reset" name="submit">Regresar</button>
      </div>
    </form>
  </div>
</div>