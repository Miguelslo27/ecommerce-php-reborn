<?php

function protectFromNotAdminUsers()
{
  if (!isAdmin()) {
    header('Location: /404');
  }
}

// @To-Do
function getCurrentUrl()
{
  throw new Error('Not implemented');
}

// @To-Do
function getCurrentPath()
{
  throw new Error('Not implemented');
}

// @To-Do
function getQueryParams($additions = null)
{
  $params     = $_SERVER['QUERY_STRING'];
  $paramsList = [];
  $paramsObj  = [];
  $returnList = [];

  if (trim($params) != '') {
    $paramsList = explode('&', $params);
  }

  foreach ($paramsList as $value) {
    $paramKeyValue        = explode('=', $value);
    $paramKey             = $paramKeyValue[0];
    $parmaValue           = isset($paramKeyValue[1]) ? $paramKeyValue[1] : 'true';
    $paramsObj[$paramKey] = $parmaValue;
  }

  if ($additions) {
    foreach ($additions as $addition => $value) {
      if ($value) {
        $paramsObj[$addition] = $value;
      } else {
        unset($paramsObj[$addition]);
      }
    }
  }

  foreach ($paramsObj as $param => $value) {
    $returnList[] = "$param=$value";
  }

  return implode('&', $returnList);
}

// @To-Do
function loadSite()
{
  throw new Error('Not implemented');
}

// @To-Do
function newDocument($page_name, $sub_page_name, $includes, $getbefore = null)
{
  // @To-Do
  // setGlobal('site', loadSite());
  // setGlobal('user', getCurrentUser());
  // @To-Do
  // setGlobal('cart', getCurrentCart());
  
  setGlobal('page', $page_name);
  setGlobal('sub_page', $sub_page_name);

  if (isset($getbefore) && gettype($getbefore) === 'object') {
    $getbefore();
  }

  startNewDocument();

  $classes = ['container'];
  if (isset($page_name) && trim($page_name) !== '') {
    $classes[] = '__' . $page_name . '__';
  }

  if (isset($sub_page_name) && trim($sub_page_name) !== '') {
    $classes[] = '__' . $sub_page_name . '__';
  }

  ?>
  <div class="<?php echo implode(' ', $classes) ?>">
  <?php
  
  foreach ($includes as $file) {
    include(getTemplatePath() . $file . '.php');
  }

  ?>
  </div>
  <?php

  endNewDocument();
}

function startNewDocument()
{
  ?>
  <!doctype html>
  <html lang="es">
  <head>
    <title>Demo Site - e-Com.uy</title>
    <?php include(getTemplatePath() . 'include_metatags.php') ?>
    <?php include(getTemplatePath() . 'include_css.php') ?>
  </head>
  <body class="page_<?php echo getGlobal('page') ?>">
    <?php include(getTemplatePath() . 'header.php') ?>
  <?php
}

function endNewDocument()
{
  ?>
    <?php include(getTemplatePath() . 'footer.php') ?>
    <?php include(getTemplatePath() . 'include_js.php') ?>
  </body>
  </html>
  <?php
}

/* USUARIO */
// FORGET THIS METHOD
// IT SHOULDN'T EVEN EXIST
function loadUser($login = NULL)
{
  // if(!getCurrentUser()) {
  //   if (checkUsers()) {
  //     $email = isset($_POST['email']) ? $_POST['email'] : '';
  //     $pass  = isset($_POST['pass']) ? $_POST['pass'] : '';

  //     if ((!$email || !$pass) && $login == "login") {
  //       return array('user' => NULL, 'cart' => $order,  'status' => 'ERROR_EMAIL_OR_PASS');
  //     } elseif (!$email && !$pass) {
  //       return array('user' => NULL, 'cart' => $order,  'status' => 'READY_TO_LOGIN');
  //     }

  //     return loginUser($email, $pass);
  //   } else {
  //     // muestro formulario de registro
  //     return array('user' => NULL, 'cart' => $order,  'status' => 'NO_USERS');
  //   }
  // } else {
  //   $usuario = JSON_decode($_SESSION['usuario']);

  //   if (checkCurrentUser($usuario->email)) {
  //     $order = obtenerPedidoAbierto($usuario->id);

  //     return
  //       array(
  //         'user' => $usuario,
  //         'cart' => $order,
  //         'status' => 'LOGGED'
  //       );
  //   } elseif (!checkUsers()) {
  //     return array('user' => NULL, 'cart' => $order,  'status' => 'NO_USERS');
  //   } else {
  //     $email = isset($_POST['email']) ? $_POST['email'] : '';
  //     $pass = isset($_POST['pass']) ? $_POST['pass'] : '';

  //     if (!$email || !$pass) {
  //       return array('user' => NULL, 'cart' => $order,  'status' => 'ERROR_EMAIL_OR_PASS');
  //     }

  //     loginUser($email, $pass);
  //   }
  // }
}
// -- --

function loginUser($email = null, $pass = null, $forzarLogin = false)
{
  if (!isset($_POST['login'])) return;
  
  if (!$email && !$pass) {
    $email = !empty($_POST['email']) ? $_POST['email'] : '';
    $pass  = !empty($_POST['pass']) ? $_POST['pass'] : '';
  }

  $email = str_replace(" ", "", strtolower($email));

  if (empty($email) || empty($pass)) {
    return 'Email o password incorrecto';
  }

  // if ((!$email || !$pass) && !$forzarLogin) {
  //   // exit;
  //   return array('user' => NULL, 'cart' => NULL,  'status' => 'ERROR_EMAIL_OR_PASS');
  // }

  // cargar el usuario por email y pass y retornar los valores
  $db = getDBConnection();

  if ($forzarLogin) {
    $sql = 'SELECT `id`, `nombre`, `apellido`, `rut`, `email`, `direccion`, `telefono`, `celular`, `departamento`, `ciudad`, `administrador` FROM `usuario` WHERE `email` = "' . $email . '"';
  } else {
    $sql = 'SELECT `id`, `nombre`, `apellido`, `rut`, `email`, `direccion`, `telefono`, `celular`, `departamento`, `ciudad`, `administrador` FROM `usuario` WHERE `email` = "' . $email . '" AND `clave` = "' . md5($pass . $email) . '"';
  }

  $usuario = $db->getObject($sql);

  if ($usuario) {
    // Obtengo el pedido abierto del usuario
    $order     = obtenerPedidoAbierto($usuario->id);
    $prepedido = false;

    // Si hay un id temporal
    if (isset($_SESSION['temp_userid'])) {
      // Obtengo el pre pedido
      $prepedido = obtenerPedidoAbierto($_SESSION['temp_userid']);

      // Si tengo prepedido cambio la pertenencia por la del usuario logueado
      if ($prepedido) {
        $prepedido = cambiarPertenenciaDelPedido($prepedido->id, $usuario->id, $_SESSION['temp_userid']);
      }
    }

    // Si hay pedido y prepedido, los combino en el pedido abierto del usuario
    if ($order && $prepedido) {
      $order = combinarPedidos($order, $prepedido);
    } else {
      $order = $prepedido;
    }

    // $_SESSION['usuario'] = JSON_encode($usuario);
    // $_SESSION['pedido'] = JSON_encode($order);
    $_SESSION['usuario'] = $usuario;
    $_SESSION['pedido'] = $order;

    setGlobal('user', $_SESSION['usuario']);
    setGlobal('cart', $_SESSION['pedido']);
    // Redireccionar a la última página visitada donde se cargarán los datos del usuario
    // header('Location: ' . $_SERVER['HTTP_REFERER']);
    return 'Ingresaste con éxito';
  } else {
    return 'Email o password incorrecto';
  }
}

function checkEmail($email = NULL)
{

  if (!$email) {
    return false;
  }

  $db = getDBConnection();
  // $sql = 'SELECT `email`, `codigo` FROM `dev_usuario` WHERE `email` = "' . $email . '"';
  $sql = 'SELECT `email`, `codigo` FROM `usuario` WHERE `email` = "' . $email . '"';
  $usuario = $db->getObject($sql);

  if (isset($usuario->email) && $usuario->email != '') {
    $_SESSION['codigo-de-recuperacion'] = $usuario->codigo;
    return true;
  } else return false;
}

function checkSuscription($email = NULL)
{
  if (!$email) {
    return false;
  }

  $db = getDBConnection();
  $sql = 'SELECT `email` FROM `suscripciones` WHERE `email` = "' . $email . '"';
  $sus = $db->getObject($sql);

  if (isset($sus->email) && $sus->email != '') {
    return true;
  } else return false;
}

function suscribir($email)
{
  $suscribed = false;
  $email = str_replace(" ", "", strtolower($email));

  // Chequear formato del email
  if (preg_match('/^[a-z0-9]+[a-z0-cribir9_.-]+@[a-z0-9_.-]{3,}.[a-z0-9_.-]{1,}.$/', $email)) {
    // Si el email está bien formado
    // Chequeo si ya existe usuario con ese email
    if (checkEmail($email) || checkSuscription($email)) {
      // Si existe, retorono suscripto = true
      $suscribed = true;
    } else {
      // Si no existe, lo suscribo
      $db  = getDBConnection();
      $sql = 'INSERT INTO `suscripciones` (`email`) VALUES ("' . $email . '")';
      $sus = $db->insert($sql);

      // si se suscribió correctamente retornar suscripto = true
      if ($sus) {
        $suscribed = true;
      }
    }
  }

  return $suscribed;
}

function enviarDatosDeRecuperacion($email)
{

  $asunto = "Solicitud de recuperación de contraseña";
  $mensaje = '' .
    '<p>Has solicitado la recuperación de tu contraseña de eCommerce</p>' .
    '<p>Por favor, sigue el link a continuación y podrás cambiar tu contraseña.</p>' .
    '<p><a href="/recuperar-clave/index.php?c=' . $_SESSION['codigo-de-recuperacion'] . '">Click aquí para cambiar contraseña</a></p>' .
    '<p>Si por cualquier motivo no puedes hacer click en el link anterior, copia la siguente dirección y pégala en la barra de direcciones de tu navegador</p>' .
    '<p>/recuperar-clave/index.php?c=' . $_SESSION['codigo-de-recuperacion'] . '</p>';

  $mail = new PHPMailer();
  // $mail->addAddress('no-responder@eCommerce', 'eCommerce');
  $mail->addAddress($email);

  $mail->setFrom('eCommerce@eCommerce', 'eCommerce - Tienda Online');
  $mail->Subject = utf8_decode($asunto);
  $mail->msgHTML(utf8_decode($mensaje));

  if ($mail->send()) {

    return true;
  } else {

    return false;
  }
}

function checkCodigoDeValidacion($codigo = NULL)
{

  // debo obtener el usuario según el código
  if (!$codigo) {
    return false;
  }

  $db = getDBConnection();
  // $sql = 'SELECT `email`, `codigo` FROM `dev_usuario` WHERE `codigo` = "' . $codigo . '"';
  $sql = 'SELECT `email`, `codigo` FROM `usuario` WHERE `codigo` = "' . $codigo . '"';
  $usuario = $db->getObject($sql);

  if (isset($usuario->email) && $usuario->email != '') {
    $_SESSION['email-de-recuperacion'] = $usuario->email;
    return true;
  } else return false;
}

function checkClaves($clave1 = NULL, $clave2 = NULL)
{

  if (!$clave1 || !$clave2 || $clave1 != $clave2 || $clave1 == '') {

    return false;
  }

  return actualizarClave($clave1);
}

function actualizarClave($clave = NULL)
{

  if (!$clave) return false;
  $email = str_replace(" ", "", strtolower($_SESSION['email-de-recuperacion']));

  $db = getDBConnection();
  // $sql = 'UPDATE `dev_usuario` SET `clave`="' . md5($clave . $email) . '" WHERE `email`="' . $email .'"';
  $sql = 'UPDATE `usuario` SET `clave`="' . md5($clave . $email) . '" WHERE `email`="' . $email . '"';

  $cid = $db->insert($sql);

  return true;
}

function logout()
{
  session_destroy();
  header('Location: /');
  return array('user' => NULL, 'cart' => NULL, 'status' => 'LOGGED_OUT');
}

function saveUser()
{
  if (empty($_POST['save'])) return;
  if (empty($_POST['type'])) return;
  if ($_POST['type'] !== 'user') return;

  $user  = loadUser();
  $db    = getDBConnection();
  $email = str_replace(" ", "", strtolower($_POST['reg_email']));

  if ($user['user'] && empty($_POST['id'])) {
    $user['status'] = 'LOGGED';
    return 'Ya ingresaste';
  }

  if (empty($email)) {
    return 'Error: El email no puede ser vacío';
  }

  if (!preg_match('/^[a-z0-9]+[a-z0-cribir9_.-]+@[a-z0-9_.-]{3,}.[a-z0-9_.-]{1,}.$/', $email)) {
    return 'Error: El email no tiene el formato correcto';
  }

  if (empty($_POST['id']) && empty($_POST['reg_pass'])) {
    return 'Error: La contraseña no puede ser vacía';
  }

  if (empty($_POST['id']) && (empty($_POST['pass2']) || $_POST['reg_pass'] !== $_POST['pass2'])) {
    return 'Error: Las contraseñas deben coincidir';
  }

  if (empty($_POST['id']) && checkCurrentUser($email)) {
    return 'Error: El email ya se encuentra registrado';
  }

  if (
    empty($_POST['id'])
    && !empty($_POST['isadmin'])
    && $_POST['isadmin']
    && isAdmin()
  ) {
    $sql = 'INSERT INTO `usuario` (`nombre`, `apellido`, `email`, `clave`, `codigo`, `administrador`) VALUES ("' . $_POST['nombre'] . '", "' . $_POST['apellido'] . '", "' . $email . '", "' . md5($_POST['reg_pass'] . $email) . '", "' . md5($email) . '", 1)';
  } elseif (empty($_POST['id'])) {
    $sql = 'INSERT INTO `usuario` (`nombre`, `apellido`, `rut`, `email`, `clave`, `codigo`, `direccion`, `telefono`, `celular`, `departamento`, `ciudad`) VALUES ("' . $_POST['nombre'] . '","' . $_POST['apellido'] . '","' . $_POST['rut'] . '","' . $email . '","' . md5($_POST['reg_pass'] . $email) . '","' . md5($email) . '","' . $_POST['direccion'] . '","' . $_POST['telefono'] . '","' . $_POST['celular'] . '","' . $_POST['departamento'] . '","' . $_POST['ciudad'] . '")';
  } else {
    $sql = 'UPDATE `usuario` SET ';

    if (isset($_POST['nombre']) && $_POST['nombre'] != "") {
      $sql .= '`nombre` = "' . $_POST['nombre'] . '",';
    }

    if (isset($_POST['apellido']) && $_POST['apellido'] != "") {
      $sql .= '`apellido` = "' . $_POST['apellido'] . '",';
    }

    if (isset($_POST['rut']) && $_POST['rut'] != "") {
      $sql .= '`rut` = "' . $_POST['rut'] . '",';
    }

    if (isset($email) && $email != "") {
      $sql .= '`email` = "' . $email . '",';
    }

    if (isset($_POST['reg_pass']) && $_POST['reg_pass'] != "") {
      $sql .= '`clave` = "' . md5($_POST['reg_pass'] . $email) . '",';
    }

    if (isset($_POST['direccion']) && $_POST['direccion'] != "") {
      $sql .= '`direccion` = "' . $_POST['direccion'] . '",';
    }

    if (isset($_POST['telefono']) && $_POST['telefono'] != "") {
      $sql .= '`telefono` = "' . $_POST['telefono'] . '",';
    }

    if (isset($_POST['celular']) && $_POST['celular'] != "") {
      $sql .= '`celular` = "' . $_POST['celular'] . '",';
    }

    if (isset($_POST['departamento']) && $_POST['departamento'] != "") {
      $sql .= '`departamento` = "' . $_POST['departamento'] . '",';
    }

    if (isset($_POST['ciudad']) && $_POST['ciudad'] != "") {
      $sql .= '`ciudad` = "' . $_POST['ciudad'] . '",';
    }

    $sql  = substr($sql, 0, -1);
    $sql .= ' WHERE `id` = ' . $_POST['id'];
  }

  $uid = $db->insert($sql);

  if ($uid || isset($_POST['id'])) {
    loginUser($email, $_POST['reg_pass'], true);
    return 'Usuario registrado';
  }

  return 'Hubo un error al registrarte';
}

function checkCurrentUser($email)
{

  $db = getDBConnection();
  // $sql = 'SELECT COUNT(id) AS usuarios FROM `dev_usuario` WHERE `email` = "' . $email . '"';
  $sql = 'SELECT COUNT(id) AS usuarios FROM `usuario` WHERE `email` = "' . $email . '"';
  $r = $db->getObject($sql);

  if ($r->usuarios == 0) {

    return false;
  }

  return true;
}

function checkUsers()
{

  $db = getDBConnection();
  // $sql = 'SELECT COUNT(id) AS usuarios FROM `dev_usuario`';
  $sql = 'SELECT COUNT(id) AS usuarios FROM `usuario`';
  $r = $db->getObject($sql);

  if ($r->usuarios == 0) {

    return false;
  }

  return true;
}

function getUsers()
{
  $db             = getDBConnection();
  $users_per_page = @$_GET['pp'] ? $_GET['pp'] : USERS_PER_PAGE;
  $curret_page    = @$_GET['p'] ? $_GET['p'] : 1;
  $offset         = ($curret_page - 1) * $users_per_page;
  $sql            = 'SELECT * FROM (SELECT usuario.id, usuario.nombre, usuario.apellido, usuario.rut, usuario.email, usuario.direccion, usuario.telefono, usuario.celular, usuario.departamento, usuario.ciudad, usuario.administrador, SUM(pedido.total) AS total_pedidos FROM pedido RIGHT JOIN usuario ON pedido.usuario_id = usuario.id WHERE pedido.estado = 1 OR pedido.usuario_id IS NULL GROUP BY usuario.id UNION SELECT usuario.id, usuario.nombre, usuario.apellido, usuario.rut, usuario.email, usuario.direccion, usuario.telefono, usuario.celular, usuario.departamento, usuario.ciudad, usuario.administrador, NULL AS total_pedidos FROM pedido RIGHT JOIN usuario ON pedido.usuario_id = usuario.id WHERE pedido.estado != 1 GROUP BY usuario.id) AS usuarios GROUP BY usuarios.id ORDER BY `usuarios`.`total_pedidos` DESC';
  $sql           .= " LIMIT $offset, $users_per_page";
  $users          = $db->getObjects($sql);

  if (!$users || count($users) == 0) {
    $curret_page = 1;
    $offset      = ($curret_page - 1) * $users_per_page;
    $sql         = "SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `imagenes_url`, `categoria_id`, `nuevo`, `agotado`, `oferta`, `precio`, `precio_oferta`, `orden` FROM `articulo` ORDER BY `orden` ASC";
    $sql        .= " LIMIT $offset, $users_per_page";
    $users       = $db->getObjects($sql);
  }

  return ($users && count($users) > 0) ? $users : array();
}

function paginateUsers()
{
  $db             = getDBConnection();
  $users_per_page = @$_GET['pp'] ? $_GET['pp'] : USERS_PER_PAGE;
  $curret_page    = @$_GET['p'] ? $_GET['p'] : 1;
  $users_count    = $db->countOfAll('usuario');
  $pages_count    = ceil($users_count / $users_per_page);
  $url            = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '?p={{page}}&pp={{per_page}}';
  $url            = preg_replace('/pp=\d+/i', 'pp={{per_page}}', $url);
  $url            = preg_replace('/p=\d+/i', 'p={{page}}', $url);
  $url            = str_replace('{{per_page}}', $users_per_page, $url);
?>
  <?php if ($pages_count > 1) : ?>
    <div class="pagination">
      <a href="<?php echo str_replace('{{page}}', $curret_page > 1 ? $curret_page - 1 : $pages_count, $url) ?>"><i class="fas fa-arrow-left"></i></a>
      <?php for ($i = 1; $i <= $pages_count; $i++) : ?>
        <a class="<?php echo $i == $curret_page ? 'active' : '' ?>" href="<?php echo str_replace('{{page}}', $i, $url) ?>"><?php echo $i ?></a>
      <?php endfor ?>
      <a href="<?php echo str_replace('{{page}}', $curret_page < $pages_count ? $curret_page + 1 : 1, $url) ?>"><i class="fas fa-arrow-right"></i></a>
    </div>
  <?php endif ?>
  <div class="per-page">
    <span>Mostrar:</span>
    <a class="<?php echo $users_per_page == 10 ? 'active' : '' ?>" href="?p=1&pp=10">10</a>
    <a class="<?php echo $users_per_page == 20 ? 'active' : '' ?>" href="?p=1&pp=20">20</a>
    <a class="<?php echo $users_per_page == 30 ? 'active' : '' ?>" href="?p=1&pp=30">30</a>
  </div>
<?php
}

function obtenerTotalUsuarios()
{
  $db = getDBConnection();
  $sql = 'SELECT COUNT(`id`) as `total` FROM `usuario`';

  $r = $db->getObject($sql);

  return $r;
}

function getUsersPaginados($quantityPorPagina = 20, $pagina = 1)
{
  $db = getDBConnection();
  $sql = 'SELECT * FROM `usuario` LIMIT ' . ($quantityPorPagina * ($pagina - 1)) . ',' . $quantityPorPagina;

  $r = $db->getObjects($sql);

  return $r;
}

function obtenerTotalOrdenes($id_usuario = null, $estado = NULL)
{
  $db = getDBConnection();
  $sql = 'SELECT COUNT(`id`) as `total` FROM `pedido`';

  if ($id_usuario) {
    // le agrego el usuario, si se especifico el id
    $sql .= ' WHERE `usuario_id`=' . $id_usuario;
  }

  if ($estado) {
    if (!$id_usuario) {
      $sql .= ' WHERE';
    } else {
      $sql .= ' AND';
    }

    $sql .= ' `estado`=' . $estado;
  }

  $r = $db->getObject($sql);

  return $r;
}

function obtenerOrdenesPaginadas($id_usuario = null, $estado = NULL, $quantityPorPagina = 20, $pagina = 1)
{
  $db = getDBConnection();
  $sql = 'SELECT `pedido`.*, `usuario`.`nombre`, `usuario`.`apellido`, `usuario`.`rut`, `usuario`.`telefono`, `usuario`.`celular`, `usuario`.`email` FROM `pedido` JOIN `usuario` ON `pedido`.`usuario_id`=`usuario`.`id`';

  if ($id_usuario) {
    // le agrego el usuario, si se especifico el id
    $sql .= ' WHERE `usuario_id`=' . $id_usuario;
  }

  if ($estado) {
    if (!$id_usuario) {
      $sql .= ' WHERE';
    } else {
      $sql .= ' AND';
    }

    $sql .= ' `estado`=' . $estado;
  }

  $sql .= ' ORDER BY `fecha` DESC LIMIT ' . ($quantityPorPagina * ($pagina - 1)) . ',' . $quantityPorPagina;

  $orders = $db->getObjects($sql);
  return $orders;
}

function getUsersExportacion()
{
  $db = getDBConnection();
  $sql = 'SELECT * FROM (SELECT usuario.id, usuario.nombre, usuario.apellido, usuario.rut, usuario.email, usuario.direccion, usuario.telefono, usuario.celular, usuario.departamento, usuario.ciudad, SUM(pedido.total) AS total_pedidos FROM pedido RIGHT JOIN usuario ON pedido.usuario_id = usuario.id WHERE pedido.estado = 1 OR pedido.usuario_id IS NULL GROUP BY usuario.id UNION SELECT usuario.id, usuario.nombre, usuario.apellido, usuario.rut, usuario.email, usuario.direccion, usuario.telefono, usuario.celular, usuario.departamento, usuario.ciudad, NULL AS total_pedidos FROM pedido RIGHT JOIN usuario ON pedido.usuario_id = usuario.id WHERE pedido.estado != 1 GROUP BY usuario.id) AS usuarios GROUP BY usuarios.id ORDER BY `usuarios`.`total_pedidos` DESC';

  $r = $db->getObjects($sql);

  return $r;
}

function obtenerSuscripciones()
{

  $db = getDBConnection();
  $sql = 'SELECT * FROM `suscripciones`';

  $r = $db->getObjects($sql);

  return $r;
}

function getCategory()
{
  if (isset($_GET['cid']) && $_GET['cid'] != 'new' && $_GET['cid'] != 'save') {
    $db  = getDBConnection();
    $sql = 'SELECT `id`, `titulo`, `descripcion_breve`, `descripcion`, `imagen_url`, `categoria_id`, `estado`, `orden` FROM `categoria` WHERE id = ' . $_GET['cid'] . ' AND `estado` = 1';
    $cat = $db->getObject($sql);
  } elseif (isset($_GET['ofertas']) && $_GET['ofertas'] == 1) {
    $cat = new stdClass();
    $cat->id = -1;
    $cat->titulo = 'Ofertas eCommerce';
    $cat->descripcion_breve = 'Encuentra todos los artículos en oferta en eCommerce';
    $cat->descripcion = '';
    $cat->imagen_url = '';
    $cat->categoria_id = NULL;
    $cat->estado = NULL;
  } else {
    $cat = new stdClass();
    $cat->id = 0;
    $cat->titulo = 'Todas las categorías';
    $cat->descripcion_breve = 'Explore las categorias para encontrar el artículo que busca';
    $cat->descripcion = '';
    $cat->imagen_url = '';
    $cat->categoria_id = NULL;
    $cat->estado = NULL;
  }

  $cat->subcategorias = getCategories($cat->id);
  $cat->articulos = getArticles($cat->id);

  return $cat;
}

function getCategories($parentId = NULL, $limit = null)
{
  $db                  = getDBConnection();
  $categories_per_page = @$_GET['pp'] ? $_GET['pp'] : CATEGORIES_PER_PAGE;
  $curret_page         = @$_GET['p'] ? $_GET['p'] : 1;
  $offset              = ($curret_page - 1) * $categories_per_page;
  $sql                 = "SELECT `id`, `titulo`, `descripcion_breve`, `descripcion`, `imagen_url`, `categoria_id`, `estado`, `orden` FROM `categoria` WHERE `categoria_id` = $parentId AND `estado` = 1 ORDER BY `orden` ASC";
  $sql                .= " LIMIT $offset, $categories_per_page";
  $cats                = $db->getObjects($sql);

  if (!$cats || count($cats) == 0) {
    $curret_page = 1;
    $offset      = ($curret_page - 1) * $categories_per_page;
    $sql         = "SELECT `id`, `titulo`, `descripcion_breve`, `descripcion`, `imagen_url`, `categoria_id`, `estado`, `orden` FROM `categoria` WHERE `categoria_id` = $parentId AND `estado` = 1 ORDER BY `orden` ASC";
    $sql        .= " LIMIT $offset, $categories_per_page";
    $cats        = $db->getObjects($sql);
  }

  return ($cats && count($cats) > 0) ? $cats : array();
}

function paginateCategories()
{
  $db                  = getDBConnection();
  $categories_per_page = @$_GET['pp'] ? $_GET['pp'] : CATEGORIES_PER_PAGE;
  $curret_page         = @$_GET['p'] ? $_GET['p'] : 1;
  $categories_count    = $db->countOf('categoria', '`estado` = 1');
  $pages_count         = ceil($categories_count / $categories_per_page);
  $url                 = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '?p={{page}}&pp={{per_page}}';
  $url                 = preg_replace('/pp=\d+/i', 'pp={{per_page}}', $url);
  $url                 = preg_replace('/p=\d+/i', 'p={{page}}', $url);
  $url                 = str_replace('{{per_page}}', $categories_per_page, $url);
?>
  <?php if ($pages_count > 1) : ?>
    <div class="pagination">
      <a href="<?php echo str_replace('{{page}}', $curret_page > 1 ? $curret_page - 1 : $pages_count, $url) ?>"><i class="fas fa-arrow-left"></i></a>
      <?php for ($i = 1; $i <= $pages_count; $i++) : ?>
        <a class="<?php echo $i == $curret_page ? 'active' : '' ?>" href="<?php echo str_replace('{{page}}', $i, $url) ?>"><?php echo $i ?></a>
      <?php endfor ?>
      <a href="<?php echo str_replace('{{page}}', $curret_page < $pages_count ? $curret_page + 1 : 1, $url) ?>"><i class="fas fa-arrow-right"></i></a>
    </div>
  <?php endif ?>
  <div class="per-page">
    <span>Mostrar:</span>
    <a class="<?php echo $categories_per_page == 6 ? 'active' : '' ?>" href="?p=1&pp=6">6</a>
    <a class="<?php echo $categories_per_page == 12 ? 'active' : '' ?>" href="?p=1&pp=12">12</a>
    <a class="<?php echo $categories_per_page == 24 ? 'active' : '' ?>" href="?p=1&pp=24">24</a>
  </div>
<?php
}

function getArticle()
{
  if (!isset($_GET['aid'])) return;
  
  $db  = getDBConnection();
  $aid = $_GET['aid'];
  $sql = "SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `imagenes_url`, `categoria_id`, `nuevo`, `agotado`, `oferta`, `precio`, `precio_oferta`, `orden` FROM `articulo` WHERE id = $aid";
  $art = $db->getObject($sql);
  return $art;
}

function getArticles($parentId = NULL)
{
  $db                = getDBConnection();
  $articles_per_page = @$_GET['pp'] ? $_GET['pp'] : ARTICLES_PER_PAGE;
  $curret_page       = @$_GET['p'] ? $_GET['p'] : 1;
  $offset            = ($curret_page - 1) * $articles_per_page;
  $sql               = "SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `imagenes_url`, `categoria_id`, `nuevo`, `agotado`, `oferta`, `precio`, `precio_oferta`, `orden` FROM `articulo` ORDER BY `orden` ASC";
  $sql              .= " LIMIT $offset, $articles_per_page";
  $arts              = $db->getObjects($sql);

  if (!$arts || count($arts) == 0) {
    $curret_page = 1;
    $offset      = ($curret_page - 1) * $articles_per_page;
    $sql         = "SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `imagenes_url`, `categoria_id`, `nuevo`, `agotado`, `oferta`, `precio`, `precio_oferta`, `orden` FROM `articulo` ORDER BY `orden` ASC";
    $sql        .= " LIMIT $offset, $articles_per_page";
    $arts        = $db->getObjects($sql);
  }

  return ($arts && count($arts) > 0) ? $arts : array();
}

function searchForArticles($busqueda = NULL)
{

  $palabras_buscadas = explode(" ", $busqueda);
  $resultado_ = array();
  foreach ($palabras_buscadas as $palabra) {

    switch ($palabra) {

      default:
        $resultado_[] = $palabra;
        continue 2;
        break;

      case 'camisas':
        $resultado_[] = "camisa";
        continue 2;
        break;

      case 'pantalones':
        $resultado_[] = "pantalón";
        continue 2;
        break;

      case 'pantalon':
        $resultado_[] = "pantalón";
        continue 2;
        break;

      case 'buzos':
        $resultado_[] = "buzo";
        continue 2;
        break;

      case 'poleras':
        $resultado_[] = "polera";
        continue 2;
        break;

      case 'rompevientos':
      case 'rompe vientos':
      case 'rompe viento':
        $resultado_[] = "rompeviento";
        continue 2;
        break;

      case 'sacos':
        $resultado_[] = "saco";
        continue 2;
        break;

      case 'camperas':
        $resultado_[] = "campera";
        continue 2;
        break;

      case 'blusas':
        $resultado_[] = "blusa";
        continue 2;
        break;

      case 'minifaldas':
      case 'mini faldas':
      case 'mini falda':
        $resultado_[] = "minifalda";
        continue 2;
        break;

      case 'shorts':
        $resultado_[] = "short";
        continue 2;
        break;
    }
  }

  $busqueda_ = implode(" ", $resultado_);
  $db = getDBConnection();
  $sql = 'SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `talle_surtido`, `adaptable`, `colores_url`, `colores_surtidos_url`, `packs`, `imagenes_url`, `categoria_id`, `estado`, `nuevo`, `agotado`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido`, `orden` FROM `articulo` WHERE `codigo` LIKE "%' . $busqueda_ . '%" OR `nombre` LIKE "%' . $busqueda_ . '%" ORDER BY `orden` ASC';
  $arts = $db->getObjects($sql);

  return (count($arts) > 0) ? $arts : array();
}

function paginateArticles()
{
  $db                = getDBConnection();
  $articles_per_page = @$_GET['pp'] ? $_GET['pp'] : ARTICLES_PER_PAGE;
  $curret_page       = @$_GET['p'] ? $_GET['p'] : 1;
  $articles_count    = $db->countOf('articulo', '`estado` = 1');
  $pages_count       = ceil($articles_count / $articles_per_page);
  $url               = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '?p={{page}}&pp={{per_page}}';
  $url               = preg_replace('/pp=\d+/i', 'pp={{per_page}}', $url);
  $url               = preg_replace('/p=\d+/i', 'p={{page}}', $url);
  $url               = str_replace('{{per_page}}', $articles_per_page, $url);
?>
  <?php if ($pages_count > 1) : ?>
    <div class="pagination">
      <a href="<?php echo str_replace('{{page}}', $curret_page > 1 ? $curret_page - 1 : $pages_count, $url) ?>"><i class="fas fa-arrow-left"></i></a>
      <?php for ($i = 1; $i <= $pages_count; $i++) : ?>
        <a class="<?php echo $i == $curret_page ? 'active' : '' ?>" href="<?php echo str_replace('{{page}}', $i, $url) ?>"><?php echo $i ?></a>
      <?php endfor ?>
      <a href="<?php echo str_replace('{{page}}', $curret_page < $pages_count ? $curret_page + 1 : 1, $url) ?>"><i class="fas fa-arrow-right"></i></a>
    </div>
  <?php endif ?>
  <div class="per-page">
    <span>Mostrar:</span>
    <a class="<?php echo $articles_per_page == 6 ? 'active' : '' ?>" href="?p=1&pp=6">6</a>
    <a class="<?php echo $articles_per_page == 12 ? 'active' : '' ?>" href="?p=1&pp=12">12</a>
    <a class="<?php echo $articles_per_page == 24 ? 'active' : '' ?>" href="?p=1&pp=24">24</a>
  </div>
<?php
}

/* ADMINISTRACION */
function saveCategory()
{
  if (!isAdmin()) return;

  if (isset($_POST['type']) && $_POST['type'] == 'category') {
    if (isset($_POST['save'])) {
      if (isset($_POST['id']) && $_POST['id'] != "") {
        updateCategory($_POST['id']);
        return;
      }

      $relative      = $GLOBALS['relative'];
      $db            = getDBConnection();
      $sql           = 'INSERT INTO `categoria` (`titulo`, `descripcion_breve`, `descripcion`, `categoria_id`, `estado`, `orden`) VALUES ("' . $_POST['titulo'] . '", "' . $_POST['descripcion_breve'] . '", "' . $_POST['descripcion'] . '", "' . $_POST['categoria_id'] . '", 1, ' . $_POST['orden'] . ')';
      $cid           = $db->insert($sql);
      $imageLocation = ($_FILES['imagen']['error'] == 0) ? '/statics/images/categories/' . $cid . '/' : '';

      // creo la carpeta para las imagenes de esta categoria
      @mkdir($relative . $imageLocation);

      // salvar imagen
      $img = new \Verot\Upload\Upload($_FILES['imagen']);

      if ($img->uploaded) {
        $img->file_new_name_body = 'thumbnail';
        $img->image_resize       = true;
        $img->image_x            = 500;
        $img->image_ratio_y      = true;
        $img->image_convert      = 'webp';
        $img->process($relative . $imageLocation);

        $sql = 'UPDATE `categoria` SET `imagen_url` = "' . $imageLocation . $img->file_dst_name . '" WHERE `id`=' . $cid;
        $db->insert($sql);
      }

      return;
    }

    if (isset($_POST['delete'])) {
      deleteCategory($_POST['id']);
    }
  }
}

function updateCategory($id = NULL)
{
  if (!isAdmin()) return;
  if (!$id) return;

  $relative      = $GLOBALS['relative'];
  $db            = getDBConnection();
  $sql           = 'UPDATE `categoria` SET `titulo`="' . $_POST['titulo'] . '", `descripcion_breve`="' . $_POST['descripcion_breve'] . '", `descripcion`="' . $_POST['descripcion'] . '", `categoria_id`=' . $_POST['categoria_id'] . ', `orden` = ' . $_POST['orden'] . ' WHERE `id`=' . $id;
  $imageLocation = ($_FILES['imagen']['error'] == 0) ? '/statics/images/categories/' . $id . '/' : '';

  $db->insert($sql);

  // creo la carpeta para las imagenes de esta categoria
  @mkdir($imageLocation);

  // Elimino la imagen anterior
  @unlink($relative . $imageLocation . '/thumbnail.jpg');

  // salvar imagen
  $img = new \Verot\Upload\Upload($_FILES['imagen']);

  if ($img->uploaded) {
    $img->file_new_name_body = 'thumbnail';
    $img->image_resize       = true;
    $img->image_x            = 500;
    $img->image_ratio_y      = true;
    $img->image_convert      = 'webp';
    $img->process($relative . $imageLocation);

    $sql = 'UPDATE `categoria` SET `imagen_url` = "' . $imageLocation . $img->file_dst_name . '" WHERE `id`=' . $id;
    $db->insert($sql);
  }
}

function deleteCategory($id = NULL)
{
  if (!isAdmin()) return;
  if (!$id) return;

  $relative = $GLOBALS['relative'];
  $db       = getDBConnection();
  $sql      = 'DELETE FROM `categoria` WHERE `id`=' . $id;

  delTree($relative . '/statics/images/categories/' . $id);
  $db->insert($sql);
}

function saveArticle()
{
  if (!isAdmin()) return;

  if (isset($_POST['type']) && $_POST['type'] == 'article') {
    if (isset($_POST['save'])) {
      if (isset($_POST['id']) && $_POST['id'] != "") {
        updateArticle($_POST['id']);
        return;
      }

      $relative      = $GLOBALS['relative'];
      $db            = getDBConnection();
      $sql           = 'INSERT INTO `articulo` (`nombre`,`codigo`,`descripcion_breve`,`descripcion`,`categoria_id`,`nuevo`,`agotado`,`oferta`,`precio`,`precio_oferta`,`orden`) VALUES ("' . $_POST['nombre'] . '","' . $_POST['codigo'] . '","' . $_POST['descripcion_breve'] . '","' . $_POST['descripcion'] . '","' . $_POST['categoria_id'] . '","' . (@$_POST['nuevo'] == "on" ? 1 : 0) . '","' . (@$_POST['agotado'] == "on" ? 1 : 0) . '","' . (@$_POST['oferta'] == "on" ? 1 : 0) . '","' . $_POST['precio'] . '","' . $_POST['precio_oferta'] . '","' . $_POST['orden'] . '")';
      $cid           = $db->insert($sql);
      $imageLocation = ($_FILES['imagen']['error'] == 0) ? '/statics/images/articles/' . $cid . '/' : '';

      // creo la carpeta para las imagenes de este artículo
      @mkdir($relative . $imageLocation);

      // salvar imagen
      $img = new \Verot\Upload\Upload($_FILES['imagen']);

      if ($img->uploaded) {
        $img->file_new_name_body = 'thumbnail';
        $img->image_resize       = true;
        $img->image_x            = 500;
        $img->image_ratio_y      = true;
        $img->image_convert      = 'webp';
        $img->process($relative . $imageLocation);

        $sql = 'UPDATE `articulo` SET `imagenes_url` = "' . $imageLocation . $img->file_dst_name . '" WHERE `id`=' . $cid;
        $db->insert($sql);
      }
    }

    if (isset($_POST['delete'])) {
      deleteArticle($_POST['id']);
    }
  }
}

function updateArticle($id)
{
  if (!isAdmin()) return;
  if (!$id) return;

  $relative      = $GLOBALS['relative'];
  $db            = getDBConnection();
  $sql           = 'UPDATE `articulo` SET `nombre`="' . $_POST['nombre'] . '", `codigo`="' . $_POST['codigo'] . '", `descripcion_breve`="' . $_POST['descripcion_breve'] . '", `descripcion`="' . $_POST['descripcion'] . '", `categoria_id`="' . $_POST['categoria_id'] . '", `orden`=' . $_POST['orden'] . ', `nuevo`=' . (@$_POST['nuevo'] == "on" ? 1 : 0) . ', `agotado`=' . (@$_POST['agotado'] == "on" ? 1 : 0) . ', `oferta`=' . (@$_POST['oferta'] == "on" ? 1 : 0) . ', `precio`="' . $_POST['precio'] . '", `precio_oferta`=' . (isset($_POST['precio_oferta']) ? $_POST['precio_oferta'] : 0) . ' WHERE `id`=' . $id;
  $imageLocation = ($_FILES['imagen']['error'] == 0) ? '/statics/images/articles/' . $id . '/' : '';

  $db->insert($sql);

  // creo la carpeta para las imagenes de este articulo
  @mkdir($imageLocation);

  // Elimino la imagen anterior
  @unlink($relative . $imageLocation . '/thumbnail.jpg');

  // salvar imagen
  $img = new \Verot\Upload\Upload($_FILES['imagen']);

  if ($img->uploaded) {
    $img->file_new_name_body = 'thumbnail';
    $img->image_resize       = true;
    $img->image_x            = 500;
    $img->image_ratio_y      = true;
    $img->image_convert      = 'webp';
    $img->process($relative . $imageLocation);

    $sql = 'UPDATE `articulo` SET `imagenes_url` = "' . $imageLocation . $img->file_dst_name . '" WHERE `id`=' . $id;
    $db->insert($sql);
  }
}

function deleteArticle($id)
{
  if (!isAdmin()) return;
  if (!$id) return;

  $db = getDBConnection();
  $sql = 'DELETE FROM `articulo` WHERE `id`=' . $id;
  $cid = $db->insert($sql);
}

/* PEDIDOS */
// function addToCart($id, $quantity, $esPack = 'true', $talle = NULL, $color = NULL)
function addToCart($id = null, $quantity = 1)
{
  if (getRequestParam('addtocart')) $id = getRequestParam('addtocart');
  if (getRequestParam('add')) $quantity = getRequestParam('add');
  if (!isset($id)) return null;

  $user = loadUser();

  if ((!$user || $user['user'] == "") && !isset($_SESSION['temp_userid'])) {
    $ipToNumber  = (int) implode('', explode('.', getRealIP()));
    $timeLength  = time();
    $temp_userid = $ipToNumber + $timeLength;

    $_SESSION['temp_userid'] = $temp_userid;
  } else {
    if (!$user || $user['user'] == "") {
      $temp_userid = $_SESSION['temp_userid'];
    } else {
      $temp_userid = $user['user']->id;
    }
  }

  $userid       = $temp_userid;
  $from2daysago = time() - (2 * 24 * 60 * 60);
  $db           = getDBConnection();
  $sql_reuse    = 'SELECT `id`, `fecha`, `total`, `cantidad`, `estado` FROM `pedido` WHERE `usuario_id` = "' . $userid . '" AND `estado` = 4 AND `fecha` >= "' . date('Y/m/d', $from2daysago) . '"';
  $order        = $db->getObject($sql_reuse);
  $orderId      = NULL;

  if ($order) {
    $orderId = $order->id;
  } else {
    $h       = "-3";
    $hm      = $h * 60;
    $ms      = $hm * 60;
    $gmdate  = gmdate("Y-m-d H:i:s", time() + ($ms));
    $sql     = 'INSERT INTO `pedido` (`usuario_id`, `fecha`, `total`, `cantidad`, `estado`) VALUES ("' . $userid . '", "' . $gmdate . '", 0, 0, 4)';
    $orderId = $db->insert($sql);
    $order   = $db->getObject($sql_reuse);
  }

  $sql     = 'SELECT `oferta`, `surtido`, `precio`, `precio_oferta` FROM `articulo` WHERE `id`=' . $id;
  $article = $db->getObject($sql);

  if (!$article) {
    // return array('status' => 'error', 'error' => 'ITEM_DOESNT_EXIST');
    return 'Hubo un error agregando el artículo al carrito';
  }

  $article_price        = $article->oferta ? $article->precio_oferta : $article->precio;
  $subtotal_for_article = $article_price * $quantity;
  $total_for_order      = $order->total + $subtotal_for_article;
  $sql                  = 'UPDATE `pedido` SET `total`=' . $total_for_order . ', `cantidad`=' . ($order->cantidad + 1) . ' WHERE `id`=' . $orderId;
  $db->insert($sql);

  $sql   = 'INSERT INTO `articulo_pedido` (`pedido_id`, `articulo_id`, `precio_actual`, `cantidad`, `subtotal`) VALUES (' . $orderId . ', ' . $id . ', ' . $article_price . ', ' . $quantity . ', ' . $subtotal_for_article  . ')';
  $rId   = $db->insert($sql);
  $order = $db->getObject($sql_reuse);

  if ($rId) {
    // return array('status' => 'ok', 'pedido' => $order);
    return 'El artículo se agregó al cartito';
  } else {
    // return array('status' => 'error', 'error' => 'DB_ERROR');
    return 'Hubo un error agregando el artículo al carrito';
  }
}

function eliminarDelPedido($idpedido, $itemid, $orderid, $precioitem, $quantityitem, $total_for_order, $quantityitemstotal)
{

  $db = getDBConnection();
  $sql = 'DELETE FROM `articulo_pedido` WHERE `pedido_id`=' . $orderid . ' AND `articulo_id`=' . $itemid . ' AND `id`=' . $idpedido;
  $db->insert($sql);

  $sql = 'SELECT COUNT(*) AS `cantidad_en_pedido`, SUM(`subtotal`) AS `total_en_pedido` FROM `articulo_pedido` WHERE `pedido_id`=' . $orderid;
  $articles = $db->getObject($sql);

  if ($articles->cantidad_en_pedido > 0) {

    $sql = 'UPDATE `pedido` SET `total`=' . $articles->total_en_pedido . ', `cantidad`=' . $articles->cantidad_en_pedido . ' WHERE `id`=' . $orderid;
  } else {

    $sql = 'DELETE FROM `pedido` WHERE `id`=' . $orderid;
  }

  $db->insert($sql);

  return array('status' => 'DELTE_SUCCESSFUL', 'articulos' => $articles->cantidad_en_pedido, 'total' => $articles->total_en_pedido);
}

function obtenerPedido($idPedido)
{
  $orderCompleto = array('articulos' => NULL, 'pedido' => NULL);

  $db = getDBConnection();
  $sql = 'SELECT `pedido`.*, `usuario`.`nombre`, `usuario`.`apellido`, `usuario`.`rut`, `usuario`.`telefono`, `usuario`.`celular`, `usuario`.`email` FROM `pedido` JOIN `usuario` ON `pedido`.`usuario_id` = `usuario`.`id` WHERE `pedido`.`id`=' . $idPedido;
  $orderCompleto['pedido'] = $db->getObject($sql);

  if (empty($orderCompleto['pedido'])) {
    $sql = 'SELECT `pedido`.* FROM `pedido` WHERE `pedido`.`id`=' . $idPedido;
    $orderCompleto['pedido'] = $db->getObject($sql);
  }

  $sql = 'SELECT `articulo_pedido`.`id` AS `id_pedido`, `articulo_pedido`.`cantidad`, `articulo_pedido`.`subtotal`, `articulo`.`id`, `articulo`.`nombre`, `articulo`.`codigo`, `articulo_pedido`.`surtido`, `articulo_pedido`.`talle`, `articulo_pedido`.`color`, `articulo`.`colores_url`, `articulo`.`colores_surtidos_url`, `articulo`.`imagenes_url` FROM `articulo_pedido` JOIN `articulo` ON `articulo_pedido`.`articulo_id`=`articulo`.`id` WHERE `articulo_pedido`.`pedido_id`=' . $idPedido;
  $orderCompleto['articulos'] = $db->getObjects($sql);

  return $orderCompleto;
}

// @To-Do
function loadCart() {
  $from2daysago = time() - (2 * 24 * 60 * 60);
  $db           = getDBConnection();
  $sql          = 'SELECT * FROM `pedido` WHERE `estado` = 4 AND `usuario_id`=' . (getUserId() ? getUserId() : $_SESSION['temp_userid']) . ' AND `fecha` >= "' . date('Y/m/d', $from2daysago) . '"';
  $cart         = $db->getObject($sql);
  setGlobal('cart', $cart);
}

function obtenerPedidoAbierto($id_usuario = null)
{

  $id_us     = $id_usuario ? $id_usuario : JSON_decode($_SESSION['usuario'])->id;

  $from2daysago = time() - (2 * 24 * 60 * 60);
  // obtengo el pedido abierto
  $db        = getDBConnection();
  $sql       = 'SELECT * FROM `pedido` WHERE `estado` = 4 AND `usuario_id`=' . $id_us . ' AND `fecha` >= "' . date('Y/m/d', $from2daysago) . '"';
  $order    = $db->getObject($sql);

  return $order;
}

function obtenerPedidos($id_usuario = null, $estado = NULL)
{

  $db = getDBConnection();
  // de momento selecciono todos los pedidos
  $sql = 'SELECT `pedido`.*, `usuario`.`nombre`, `usuario`.`apellido`, `usuario`.`rut`, `usuario`.`telefono`, `usuario`.`celular`, `usuario`.`email` FROM `pedido` JOIN `usuario` ON `pedido`.`usuario_id`=`usuario`.`id`';
  if ($id_usuario) {

    // le agrego el usuario, si se especifico el id
    $sql .= ' WHERE `usuario_id`=' . $id_usuario;
  }

  if ($estado) {

    if (!$id_usuario) {

      $sql .= ' WHERE';
    } else {

      $sql .= ' AND';
    }

    $sql .= ' `estado`=' . $estado;
  }

  $sql .= ' ORDER BY `estado` ASC';

  $orders = $db->getObjects($sql);
  return $orders;
}

function obtenerUltimoPedido()
{
  $db = getDBConnection();
  $sql = 'SELECT `pedido`.*, `usuario`.`nombre`, `usuario`.`apellido`, `usuario`.`rut`, `usuario`.`telefono`, `usuario`.`celular`, `usuario`.`email` FROM `pedido` JOIN `usuario` ON `pedido`.`usuario_id`=`usuario`.`id` WHERE `estado` = 1 AND `notificado` != 1 ORDER BY `fecha` DESC';

  $order = $db->getObject($sql);

  return $order;
}

function actualizarUltimoPedido()
{
  $db = getDBConnection();
  // Update last order with a flag
  $sql = 'UPDATE `pedido` SET `notificado` = 1';
  $db->insert($sql);
}

function completarPedido($idPedido)
{
  if (!empty($_GET['test-mode']) && $_GET['test-mode'] == 't') {
    // $currentUser = loadUser();
    // var_dump($currentUser);
    // var_dump($currentUser['user']->email);
  }

  $db = getDBConnection();

  $lugar = ($_POST['lugar_compra'] == 'envio_interior' ? 'Interior' : ($_POST['lugar_compra'] == 'envio_montevideo' ? 'Montevideo' : ''));
  $retira = $_POST['retira_agencia'] == 'true' || $_POST['retira_local'] == 'true' ? 1 : 0;

  $sql = 'UPDATE `pedido` SET `estado`=1, `lugar`="' . $lugar . '", `retira`=' . $retira . ', `agencia_de_envio`="' . $_POST['agencia_entrega'] . '", `direccion_de_entrega`="' . $_POST['direccion_entrega'] . '", `forma_de_pago`="' . (isset($_POST['forma_pago']) ? $_POST['forma_pago'] : '') . '" WHERE `id`=' . $idPedido;
  // agregar direccion del usuario, agencia de entrega y forma de pago al pedido
  $db->insert($sql);

  $ordenSQL = 'SELECT * FROM `pedido` WHERE `id`=' . $idPedido;
  $ordenOBJ = $db->getObject($ordenSQL);

  $usuarioSQL = 'SELECT * FROM `usuario` WHERE `id`=' . $ordenOBJ->usuario_id;
  $usuarioOBJ = $db->getObject($usuarioSQL);

  $orderSQL = 'SELECT `articulo_pedido`.`id`, `articulo_pedido`.`articulo_id`, `articulo_pedido`.`precio_actual`, `articulo_pedido`.`cantidad`, `articulo_pedido`.`subtotal`, `articulo`.`codigo`, `articulo`.`nombre`,`articulo_pedido`.`talle`, `articulo_pedido`.`surtido`, `articulo_pedido`.`color`, `articulo`.`colores_url`, `articulo`.`colores_surtidos_url`, `articulo`.`imagenes_url` FROM `articulo_pedido` JOIN `articulo` ON `articulo_pedido`.`articulo_id`=`articulo`.`id` WHERE `pedido_id`=' . $idPedido;
  $orderOBJ = $db->getObjects($orderSQL);

  $asunto = '(eCommerce - Pedido) Orden N. ' . $idPedido;
  $mensaje = '' .

    '<h2><a href="/detalle?id=' . $idPedido . '">Orden N. ' . $idPedido . '</a></h2>' .
    '<p><strong>Fecha:</strong> ' . $ordenOBJ->fecha . '</p>' .
    '<p><strong>Nombre:</strong> ' . $usuarioOBJ->nombre . ' ' . $usuarioOBJ->apellido . '</p>' .
    '<p><strong>RUT:</strong> ' . $usuarioOBJ->rut . '</p>' .
    '<p><strong>Teléfono:</strong> ' . $usuarioOBJ->telefono . (($usuarioOBJ->celular != "") ? ' / ' . $usuarioOBJ->celular : '') . '</p>' .
    '<p><strong>Email:</strong> ' . $usuarioOBJ->email . '</p>';

  $mensaje .=
    '<p><strong>Compra en ' . $lugar . '</strong></p>';

  // TODO MIKE - Debug on email for direccion de entrega and forma de pago
  if (!empty($_GET['test-mode']) && $_GET['test-mode'] == 't') {
    $currentUser = loadUser();
    if ($currentUser['user']->email == 'miguelmail2006@gmail.com') {
      var_dump($ordenOBJ);
      exit;
    }
  }

  // Interior
  // Montevideo
  if ($lugar == 'Interior') {
    if ($retira) {

      $mensaje .=
        '<p><strong>Retira en Agencia</strong></p>' .
        '<p><strong>Localidad:</strong> ' . $usuarioOBJ->departamento . ', ' . $usuarioOBJ->ciudad . '</p>';
    } else {

      $mensaje .=

        '<p><strong>Envio al Interior</strong></p>' .
        '<p><strong>Localidad:</strong> ' . $usuarioOBJ->departamento . ', ' . $usuarioOBJ->ciudad . '</p>' .
        '<p><strong>Dirección de entrega:</strong> ' . $ordenOBJ->direccion_de_entrega . '</p>';
    }

    $mensaje .=
      '<p><strong>Agencia de Envío:</strong> ' . $ordenOBJ->agencia_de_envio . '</p>' .
      '<p><strong>Forma de Pago:</strong> ' . $ordenOBJ->forma_de_pago . '</p>';
  } elseif ($lugar == 'Montevideo') {
    if ($retira) {

      $mensaje .=
        '<p><strong>Retira y paga en local eCommerce.</strong></p>';
    } else {

      $mensaje .=
        '<p><strong>Envio en Montevideo</strong></p>' .
        '<p><strong>Dirección de entrega:</strong> ' . $ordenOBJ->direccion_de_entrega . '</p>' .
        '<p><strong>Forma de Pago:</strong> ' . $ordenOBJ->forma_de_pago . '</p>';
    }
  }

  $mensaje .=
    '<table border="1">' .
    '<thead>' .
    '<tr>' .
    '<td>Código</td>' .
    '<td>Artículo</td>' .
    '<td>Surtido</td>' .
    '<td>Talles</td>' .
    '<td>Colores</td>' .
    '<td>Cantidad</td>' .
    '<td>Subtotal</td>' .
    '</tr>' .
    '</thead>' .
    '<tbody>';
  foreach ($orderOBJ as $article) {

    $mensaje .=
      '<tr>' .
      '<td>' . $article->codigo . '</td>' .
      '<td>' . $article->nombre . '</td>' .
      '<td>' . ($article->surtido == 0 ? 'No' : 'Si') . '</td>' .
      '<td>' . $article->talle . '</td>' .
      '<td>';

    $surtido           = $article->surtido == 0 ? false : true;
    $relative          = '../../../';
    $colorsAuxDir      = '';
    $colorsDir         = '';
    $colorsDirForEmail = 'http://' . $_SERVER['SERVER_NAME'];
    $colores           = explode(',', $article->color);

    if ($article->colores_url == $article->imagenes_url) {
      $mensaje .= '<img src="http://' . $_SERVER['SERVER_NAME'] . str_replace("{id}", $article->articulo_id, $article->imagenes_url) . 'colors.jpg" />';
    } else {
      if ($surtido) {
        $colorsDir    = str_replace("{id}", $article->articulo_id, $article->colores_surtidos_url);
        $colorsAuxDir = $relative . str_replace("{id}", $article->articulo_id, $article->colores_surtidos_url);
        if (!file_exists($colorsAuxDir)) {
          $colorsDir    = str_replace("{id}", $article->articulo_id, $article->colores_url);
          $colorsAuxDir = $relative . str_replace("{id}", $article->articulo_id, $article->colores_url);
        }
      } else {
        $colorsDir    = str_replace("{id}", $article->articulo_id, $article->colores_url);
        $colorsAuxDir = $relative . str_replace("{id}", $article->articulo_id, $article->colores_url);
      }

      if (file_exists($colorsAuxDir)) {
        $colorsDirForEmail .= $colorsDir;
        $mensaje .=
          '<ul style="list-style:none;margin:0;padding:0;display:inline-block;">';
        foreach ($colores as $color) {
          if (!is_dir($colorsAuxDir . $color)) {
            if (file_exists($colorsAuxDir . $color . '.jpg')) {
              $mensaje .=
                '<li style="display:inline-block;">
          <span style="border-radius:8px;border-width:2px;border-style:solid;border-color:#ccc;width:14px;font-size:0px;display:inline-block;">
            <img src="' . $colorsDirForEmail . $color . '.jpg" style="border-radius:7px; width: 14px;" />
          </span>
        </li>';
            } else {
              $colorsDir         = str_replace("{id}", $article->articulo_id, $article->colores_url);
              $colorsDirForEmail = 'http://' . $_SERVER['SERVER_NAME'] . $colorsDir;
              $mensaje .=
                '<li style="display:inline-block;">
          <span style="border-radius:8px;border-width:2px;border-style:solid;border-color:#ccc;width:14px;font-size:0px;display:inline-block;">
            <img src="' . $colorsDirForEmail . $color . '.jpg" style="border-radius:7px; width: 14px;" />
          </span>
        </li>';
            }
          }
        }
        $mensaje .=
          '</ul>';
      } else {
        $colorsDir = $relative . str_replace("{id}", $article->articulo_id, $article->imagenes_url);
        $colors    = $colorsDir . 'colors.jpg';

        if (file_exists($colors)) {
          $mensaje .= '<img src="http://' . $_SERVER['SERVER_NAME'] . str_replace("{id}", $article->articulo_id, $article->imagenes_url) . 'colors.jpg" />';
        } else {
          $mensaje .= '<span>No hay colores</span>';
        }
      }
    }

    $mensaje .=
      '</td>' .
      '<td>' . $article->cantidad . '</td>' .
      '<td>$ ' . $article->subtotal . ',00</td>' .
      '</tr>';
  }

  $mensaje .=
    '</tbody>' .
    '</table>' .
    '<p><strong>TOTAL:</strong> $' . $ordenOBJ->total . ',00</p>';

  $mail = new PHPMailer();

  if ($usuarioOBJ->email == 'miguelmail2006@gmail.com') {
    $mail->addAddress('miguelmail2006@gmail.com', 'eCommerce');
    // $mail->addAddress('miguelso18@hotmail.com', 'eCommerce');
    // $mail->addAddress('esteban.leyton@hotmail.com', 'eCommerce');
  } else {
    $mail->addAddress('miguelmail2006@gmail.com', 'eCommerce');
    $mail->addAddress('miguelmail2006@gmail.com', 'eCommerce');
    $mail->addAddress('gahecht@hotmail.com', 'Gabriela Hecht');
  }

  $mail->setFrom('eCommerce@eCommerce', 'eCommerce - Pedidos Online');
  $mail->Subject = utf8_decode($asunto);
  $mail->isHTML(true);
  $mail->Body = utf8_decode($mensaje);

  if ($mail->send()) {

    $mail->clearAddresses();
    $mail->addAddress($usuarioOBJ->email, $usuarioOBJ->nombre . ' ' . $usuarioOBJ->apellido);

    $linkareemplazar = '<a href="/detalle?id=' . $idPedido . '">Orden N. ' . $idPedido . '</a>';
    $valornuevo = 'Orden N. ' . $idPedido;

    $msg = str_replace($linkareemplazar, $valornuevo, $mensaje);

    // $mail->msgHTML(utf8_decode($msg));
    $mail->Body = utf8_decode($mensaje);

    if ($mail->send()) {

      return array('status' => 'EMAIL_SENT', 'message' => $mensaje);
    } else {

      return array('status' => 'EMAIL_ERROR', 'error' => $mail->ErrorInfo);
    }
  } else {

    return array('status' => 'EMAIL_ERROR', 'error' => $mail->ErrorInfo);
  }
}

function aprobarPedido($idPedido)
{

  $db = getDBConnection();

  // agregar direccion del usuario, agencia de entrega y forma de pago al pedido
  // $sql = 'UPDATE `dev_pedido` SET `estado`=2 WHERE `id`=' . $idPedido;
  $sql = 'UPDATE `pedido` SET `estado`=2 WHERE `id`=' . $idPedido;
  $db->insert($sql);

  return array('status' => 'STATUS_UPDATED_SUCCESSFUL');
}

function cancelarPedido($idPedido)
{
  if (!isAdmin()) return;
  if (!$idPedido) return;

  $db = getDBConnection();

  // agregar direccion del usuario, agencia de entrega y forma de pago al pedido
  // $sql = 'UPDATE `dev_pedido` SET `estado`=3 WHERE `id`=' . $idPedido;
  $sql = 'UPDATE `pedido` SET `estado`=3 WHERE `id`=' . $idPedido;
  $db->insert($sql);

  return array('status' => 'STATUS_UPDATED_SUCCESSFUL');
}

function posponerPedido($idPedido)
{

  $db = getDBConnection();

  // agregar direccion del usuario, agencia de entrega y forma de pago al pedido
  // $sql = 'UPDATE `dev_pedido` SET `estado`=1 WHERE `id`=' . $idPedido;
  $sql = 'UPDATE `pedido` SET `estado`=1 WHERE `id`=' . $idPedido;
  $db->insert($sql);

  return array('status' => 'STATUS_UPDATED_SUCCESSFUL');
}

function cerrarPedido($idPedido)
{
  $db = getDBConnection();

  // agregar direccion del usuario, agencia de entrega y forma de pago al pedido
  // $sql = 'UPDATE `dev_pedido` SET `estado`=1 WHERE `id`=' . $idPedido;
  $sql = 'UPDATE `pedido` SET `estado`=5 WHERE `id`=' . $idPedido;
  $db->insert($sql);

  return array('status' => 'STATUS_UPDATED_SUCCESSFUL');
}

function cambiarPertenenciaDelPedido($orderid, $idNuevoUsuario, $idViejoUsuario)
{
  $db = getDBConnection();

  // Cambio el id temporal de usuario del prepedido por el id del usuario logueado
  $sql = 'UPDATE `pedido` SET `usuario_id` = ' . $idNuevoUsuario . ' WHERE `id` = ' . $orderid . ' AND `usuario_id`=' . $idViejoUsuario;
  $db->insert($sql);

  // Obtengo el pedido
  $sql_p   = 'SELECT * FROM `pedido` WHERE `id` = ' . $orderid;
  $order  = $db->getObject($sql_p);

  // Lo retorno
  return $order;
}

function combinarPedidos($order, $prepedido)
{
  $db = getDBConnection();

  $order_cantidad = $order->cantidad;
  $order_total    = $order->total;

  // Obtengo los artículos del pre pedido
  $sql_prearticulos    = 'SELECT `articulo_pedido`.`id` AS `id_pedido`, `articulo_pedido`.`cantidad`, `articulo_pedido`.`subtotal`, `articulo`.`id`, `articulo`.`nombre`, `articulo`.`codigo`, `articulo_pedido`.`surtido`, `articulo_pedido`.`talle`, `articulo_pedido`.`color`, `articulo`.`colores_url`, `articulo`.`colores_surtidos_url`, `articulo`.`imagenes_url` FROM `articulo_pedido` JOIN `articulo` ON `articulo_pedido`.`articulo_id`=`articulo`.`id` WHERE `articulo_pedido`.`pedido_id`=' . $prepedido->id;
  $prearticulospedidos = $db->getObjects($sql_prearticulos);

  // Recorro los articulos pre pedidos
  foreach ($prearticulospedidos as $art_pedido) {
    // actualizo el total y la cantidad en el pedido
    $order_cantidad = $order_cantidad + 1;
    $order_total    = $order_total + $art_pedido->subtotal;
  }

  // Cambio el id de los articulos pre pedidos por los del pedido
  $sql_ap = 'UPDATE `articulo_pedido` SET `pedido_id` = ' . $order->id . ' WHERE `pedido_id` = ' . $prepedido->id;
  $db->insert($sql_ap);

  // Actualizo la cantidad y el total al pedido principal
  $sql_p = 'UPDATE `pedido` SET `cantidad` = ' . $order_cantidad . ', `total` = ' . $order_total . ' WHERE `id` = ' . $order->id;
  $db->insert($sql_p);

  // Elimino el prepedido
  $sql_dp = 'DELETE FROM `pedido` WHERE `id` = ' . $prepedido->id;
  $db->insert($sql_dp);

  $order_actualizado = obtenerPedidoAbierto($order->usuario_id);

  return $order_actualizado;
}

/* GENERAL */
function startDocument()
{
  echo "<!doctype html>\n<html lang=\"es\">\n<head>\n";
  echo "<title>Demo Site - e-Com.uy</title>";
  include(getTemplatePath() . 'include_metatags.php');
  include(getTemplatePath() . 'include_css.php');
  createAppObjects();
  echo "\n</head>\n<body>\n";
}

function endDocument()
{
  include(getTemplatePath() . 'include_js.php');
  echo "</body>\n</html>";
}

function createAppObjects()
{
  echo "\t<script>\n";
  echo "\n";
  echo "\tvar userStats = " . JSON_encode(getGlobal('user')) . ";";
  echo "\n\n";
  echo "\t</script>\n";
}

function getRealIP()
{
  if (isset($_SERVER["HTTP_CLIENT_IP"])) {
    return $_SERVER["HTTP_CLIENT_IP"];
  } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
    return $_SERVER["HTTP_X_FORWARDED_FOR"];
  } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
    return $_SERVER["HTTP_X_FORWARDED"];
  } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
    return $_SERVER["HTTP_FORWARDED_FOR"];
  } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
    return $_SERVER["HTTP_FORWARDED"];
  } else {
    return $_SERVER["REMOTE_ADDR"];
  }
}

function delTree($dir)
{
  $files = array_diff(scandir($dir), array('.', '..'));

  foreach ($files as $file) {
    (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
  }

  return rmdir($dir);
}

function getRequestParam($param) {
  if (!isset($_REQUEST[$param])) {
    return null;
  }

  return $_REQUEST[$param];
}

function processRequests()
{
  // User
  if ($message = saveUser()) {
  ?>
  <div class='floating-notification'>
    <?php echo $message ?>
  </div>
  <?php
  }

  if ($message = loginUser()) {
  ?>
  <div class='floating-notification'>
    <?php echo $message ?>
  </div>
  <?php  
  }

  // @To-Do
  // logoutUser();

  if (getUserId() || $_SESSION['temp_userid']) {
    loadCart();
  }
  
  if ($message = addToCart()) {
  ?>
  <div class='floating-notification'>
    <?php echo $message ?>
  </div>
  <?php
  }

  // Admin
  // saveArticle();
  // saveCategory();
}