<?php

$relative = '..';
require '../includes/common.php';

// $userStats = loginUser();
$userStats = loadUser();
$appPlace = 'home';
$appSubPlace = 'login';

startDocument();
loadSection("header", $userStats);
// loadSection("content", $userStats);
?>
<form action="/index.php?a=login" method="POST" id="login-form">
  <div class="form-line form-error">
    <span>Alguno de los datos ingresados es incorrecto</span>
  </div>
  <div class="form-line">
    <label for="email">E-Mail</label>
    <input type="text" class="input" id="email" name="email">
  </div>
  <div class="form-line">
    <label for="pass">Contraseña</label>
    <input type="password" class="input" id="pass" name="pass">
  </div>
  <div class="form-line">
    <label class="allsize" for="rememberme">
      <input type="checkbox" id="rememberme" name="rememberme" checked="true">
      Recúerdame en este equipo
    </label>
  </div>
  <div class="form-line form-commands">
    <button type="submit" class="btn bnt-login btn-style black">Ingresar</button>
    <a href="/recuperar-clave/">¿Has olvidado tu contraseña?</a>
  </div>
</form>
<?php
loadSection("footer", $userStats);
endDocument();

?>