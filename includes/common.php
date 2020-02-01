<?php

session_start();
header('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

define('CATEGORIES_PER_PAGE', 6);

if (isset($_GET['debug'])) {
	$_SESSION['debug'] = $_GET['debug'];
}

if (isset($_SESSION['debug'])) {

?>

	<!doctype html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv=”Expires” content=”0″>
		<meta http-equiv=”Last-Modified” content=”0″>
		<meta http-equiv=”Cache-Control” content=”no-cache, mustrevalidate”>
		<meta http-equiv=”Pragma” content=”no-cache”>

		<title>eCommerce - En reparación</title>

		<style>
			body {
				margin: 0;
				padding: 0;
				text-align: center;
			}
		</style>
	</head>

	<body>
		<img src="/statics/images/enconstruccion.png">
	</body>

	</html>

<?php
	exit();
}

require_once('db.class.php');
require_once('class.upload.php');
include('mailer/PHPMailerAutoload.php');

switch ($_SERVER['HTTP_HOST']) {
	default:
		$db_dbase  = 'ecommerce_db';
		$dbaseHost = 'localhost';
		$dbaseUser = 'root';
		$dbasePass = '';
		break;
}

// config
$config = array(
	'templatesPath' => $relative . '/templates/',
	'db_dbase'      => $db_dbase,
	'db_host'       => $dbaseHost,
	'db_user'       => $dbaseUser,
	'db_pass'       => $dbasePass
);

$revision = 1; // 'revision='.rand(1,3000);

$db = new DB($config['db_dbase'], $config['db_host'], $config['db_user'], $config['db_pass']);

/* USUARIO */
function loadUser($login = NULL)
{
	if (isset($_SESSION['temp_userid'])) {
		$tempuserid = $_SESSION['temp_userid'];
		$pedido     = obtenerPedidoAbierto($tempuserid);
	} else {
		$pedido = NULL;
	}

	// si no hay usuario ingresado
	if (!isset($_SESSION['usuario'])) {
		// chequeo si hay usuarios en la base de datos (solo la primera vez)
		if (checkUsers()) {
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			$pass  = isset($_POST['pass']) ? $_POST['pass'] : '';

			if ((!$email || !$pass) && $login == "login") {
				return array('user' => NULL, 'cart' => $pedido,  'status' => 'ERROR_EMAIL_OR_PASS');
			} elseif (!$email && !$pass) {
				return array('user' => NULL, 'cart' => $pedido,  'status' => 'READY_TO_LOGIN');
			}

			return loginUser($email, $pass);
		} else {
			// muestro formulario de registro
			return array('user' => NULL, 'cart' => $pedido,  'status' => 'NO_USERS');
		}
	} else {
		$usuario = JSON_decode($_SESSION['usuario']);

		if (checkCurrentUser($usuario->email)) {
			$pedido = obtenerPedidoAbierto($usuario->id);

			return
				array(
					'user' => $usuario,
					'cart' => $pedido,
					'status' => 'LOGGED'
				);
		} elseif (!checkUsers()) {
			return array('user' => NULL, 'cart' => $pedido,  'status' => 'NO_USERS');
		} else {
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			$pass = isset($_POST['pass']) ? $_POST['pass'] : '';

			if (!$email || !$pass) {
				return array('user' => NULL, 'cart' => $pedido,  'status' => 'ERROR_EMAIL_OR_PASS');
			}

			loginUser($email, $pass);
		}
	}
}

function loginUser($email = NULL, $pass = NULL, $forzarLogin = false)
{
	if (!$email && !$pass) {
		$email = isset($_POST['email']) ? $_POST['email'] : '';
		$pass  = isset($_POST['pass']) ? $_POST['pass'] : '';
	}

	$email = str_replace(" ", "", strtolower($email));

	if ((!$email || !$pass) && !$forzarLogin) {
		exit;
		return array('user' => NULL, 'cart' => NULL,  'status' => 'ERROR_EMAIL_OR_PASS');
	}

	// cargar el usuario por email y pass y retornar los valores
	$db = $GLOBALS['db'];

	if ($forzarLogin) {
		$sql = 'SELECT `id`, `nombre`, `apellido`, `rut`, `email`, `direccion`, `telefono`, `celular`, `departamento`, `ciudad`, `administrador` FROM `usuario` WHERE `email` = "' . $email . '"';
	} else {
		$sql = 'SELECT `id`, `nombre`, `apellido`, `rut`, `email`, `direccion`, `telefono`, `celular`, `departamento`, `ciudad`, `administrador` FROM `usuario` WHERE `email` = "' . $email . '" AND `clave` = "' . md5($pass . $email) . '"';
	}

	$usuario = $db->getObject($sql);

	if ($usuario) {
		// Obtengo el pedido abierto del usuario
		$pedido    = obtenerPedidoAbierto($usuario->id);
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
		if ($pedido && $prepedido) {
			$pedido = combinarPedidos($pedido, $prepedido);
		} else {
			$pedido = $prepedido;
		}

		$_SESSION['usuario'] = JSON_encode($usuario);
		$_SESSION['pedido'] = JSON_encode($pedido);

		// Redireccionar a la última página visitada donde se cargarán los datos del usuario
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	} else {
		return array('user' => NULL, 'cart' => NULL, 'status' => 'ERROR_EMAIL_OR_PASS');
	}
}

function checkEmail($email = NULL)
{

	if (!$email) {
		return false;
	}

	$db = $GLOBALS['db'];
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

	$db = $GLOBALS['db'];
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
			$db  = $GLOBALS['db'];
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

	$db = $GLOBALS['db'];
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

	$db = $GLOBALS['db'];
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
	$user = loadUser();

	if ($user['user'] && !isset($_POST['id'])) {
		$user['status'] = 'LOGGED';
		return $user;
	}

	if (!isset($_POST['email'])) {
		return array('user' => NULL, 'cart' => NULL, 'status' => 'EMAIL_NOT_SETTED');
	}

	if (!isset($_POST['pass'])) {
		return array('user' => NULL, 'cart' => NULL,  'status' => 'PASSWORD_NOT_SETTED');
	}

	$db    = $GLOBALS['db'];
	$email = str_replace(" ", "", strtolower($_POST['email']));

	if (!preg_match('/^[a-z0-9]+[a-z0-cribir9_.-]+@[a-z0-9_.-]{3,}.[a-z0-9_.-]{1,}.$/', $email)) {
		return array('user' => NULL, 'cart' => NULL,  'status' => 'EMAIL_MALFORMED');
	}

	if (!isset($_POST['id']) && isset($_POST['isadmin']) && $_POST['isadmin']) {
		$sql = 'INSERT INTO `usuario` (`nombre`, `apellido`, `email`, `clave`, `codigo`, `administrador`) VALUES ("' . $_POST['nombre'] . '", "' . $_POST['apellido'] . '", "' . $email . '", "' . md5($_POST['pass'] . $email) . '", "' . md5($email) . '", 1)';
	} elseif (!isset($_POST['id'])) {
		$sql = 'INSERT INTO `usuario` (`nombre`, `apellido`, `rut`, `email`, `clave`, `codigo`, `direccion`, `telefono`, `celular`, `departamento`, `ciudad`, `administrador`) VALUES ("' . $_POST['nombre'] . '","' . $_POST['apellido'] . '","' . $_POST['rut'] . '","' . $email . '","' . md5($_POST['pass'] . $email) . '","' . md5($email) . '","' . $_POST['direccion'] . '","' . $_POST['telefono'] . '","' . $_POST['celular'] . '","' . $_POST['departamento'] . '","' . $_POST['ciudad'] . '",0)';
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

		if (isset($_POST['email']) && $_POST['email'] != "") {
			$sql .= '`email` = "' . $email . '",';
		}

		if (isset($_POST['pass']) && $_POST['pass'] != "") {
			$sql .= '`clave` = "' . md5($_POST['pass'] . $email) . '",';
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

	if (!isset($_POST['id']) && checkCurrentUser($_POST['email'])) {
		return array('user' => NULL, 'cart' => NULL,  'status' => 'DUPLICATE_EMAIL');
	}

	$cid = $db->insert($sql);

	if ($cid || isset($_POST['id'])) {
		// cargar el usuario registrado y retornar los valores
		$res = loginUser($email, $_POST['pass'], true);

		// redirecciono a pedidos
		header('Location: ' . $_SERVER['HTTP_REFERER'], true, 302);

		return $res;
	}

	return array('user' => NULL, 'cart' => NULL,  'status' => 'ERROR_SAVING');
}

function loadSection($file, $data)
{
	$config = $GLOBALS['config'];
	include($config['templatesPath'] . $file . '.php');
}

function checkCurrentUser($email)
{

	$db = $GLOBALS['db'];
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

	$db = $GLOBALS['db'];
	// $sql = 'SELECT COUNT(id) AS usuarios FROM `dev_usuario`';
	$sql = 'SELECT COUNT(id) AS usuarios FROM `usuario`';
	$r = $db->getObject($sql);

	if ($r->usuarios == 0) {

		return false;
	}

	return true;
}

function obtenerUsuarios()
{

	$db = $GLOBALS['db'];
	$sql = 'SELECT * FROM (SELECT usuario.id, usuario.nombre, usuario.apellido, usuario.rut, usuario.email, usuario.direccion, usuario.telefono, usuario.celular, usuario.departamento, usuario.ciudad, SUM(pedido.total) AS total_pedidos FROM pedido RIGHT JOIN usuario ON pedido.usuario_id = usuario.id WHERE pedido.estado = 1 OR pedido.usuario_id IS NULL GROUP BY usuario.id UNION SELECT usuario.id, usuario.nombre, usuario.apellido, usuario.rut, usuario.email, usuario.direccion, usuario.telefono, usuario.celular, usuario.departamento, usuario.ciudad, NULL AS total_pedidos FROM pedido RIGHT JOIN usuario ON pedido.usuario_id = usuario.id WHERE pedido.estado != 1 GROUP BY usuario.id) AS usuarios GROUP BY usuarios.id ORDER BY `usuarios`.`total_pedidos` DESC';

	$r = $db->getObjects($sql);

	return $r;
}

function obtenerTotalUsuarios()
{
	$db = $GLOBALS['db'];
	$sql = 'SELECT COUNT(`id`) as `total` FROM `usuario`';

	$r = $db->getObject($sql);

	return $r;
}

function obtenerUsuariosPaginados($cantidadPorPagina = 20, $pagina = 1)
{
	$db = $GLOBALS['db'];
	$sql = 'SELECT * FROM `usuario` LIMIT ' . ($cantidadPorPagina * ($pagina - 1)) . ',' . $cantidadPorPagina;

	$r = $db->getObjects($sql);

	return $r;
}

function obtenerTotalOrdenes($id_usuario = null, $estado = NULL)
{
	$db = $GLOBALS['db'];
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

function obtenerOrdenesPaginadas($id_usuario = null, $estado = NULL, $cantidadPorPagina = 20, $pagina = 1)
{
	$db = $GLOBALS['db'];
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

	$sql .= ' ORDER BY `fecha` DESC LIMIT ' . ($cantidadPorPagina * ($pagina - 1)) . ',' . $cantidadPorPagina;

	$pedidos = $db->getObjects($sql);
	return $pedidos;
}

function obtenerUsuariosExportacion()
{
	$db = $GLOBALS['db'];
	$sql = 'SELECT * FROM (SELECT usuario.id, usuario.nombre, usuario.apellido, usuario.rut, usuario.email, usuario.direccion, usuario.telefono, usuario.celular, usuario.departamento, usuario.ciudad, SUM(pedido.total) AS total_pedidos FROM pedido RIGHT JOIN usuario ON pedido.usuario_id = usuario.id WHERE pedido.estado = 1 OR pedido.usuario_id IS NULL GROUP BY usuario.id UNION SELECT usuario.id, usuario.nombre, usuario.apellido, usuario.rut, usuario.email, usuario.direccion, usuario.telefono, usuario.celular, usuario.departamento, usuario.ciudad, NULL AS total_pedidos FROM pedido RIGHT JOIN usuario ON pedido.usuario_id = usuario.id WHERE pedido.estado != 1 GROUP BY usuario.id) AS usuarios GROUP BY usuarios.id ORDER BY `usuarios`.`total_pedidos` DESC';

	$r = $db->getObjects($sql);

	return $r;
}

function obtenerSuscripciones()
{

	$db = $GLOBALS['db'];
	$sql = 'SELECT * FROM `suscripciones`';

	$r = $db->getObjects($sql);

	return $r;
}

function getCategory()
{
	if (isset($_GET['cid']) && $_GET['cid'] != 'new' && $_GET['cid'] != 'save') {
		$db  = $GLOBALS['db'];
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
	$db                  = $GLOBALS['db'];
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
	$db                  = $GLOBALS['db'];
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

function getArticles($parentId = NULL)
{
	$db = $GLOBALS['db'];
	$sql = 'SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `talle_surtido`, `adaptable`, `colores_url`, `colores_surtidos_url`, `packs`, `imagenes_url`, `categoria_id`, `estado`, `nuevo`, `agotado`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido`, `orden` FROM `articulo`';

	if (!isset($parentId)) {
		$sql .= 'ORDER BY `orden` ASC';
	}
	elseif ($parentId == -1) {
		$sql = "SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `talle_surtido`, `adaptable`, `colores_url`, `colores_surtidos_url`, `packs`, `imagenes_url`, `categoria_id`, `estado`, `nuevo`, `agotado`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido`, `orden` FROM `articulo` WHERE `oferta` = 1 ORDER BY `orden` ASC";
	} elseif ($parentId > 0) {
		$sql = "SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `talle_surtido`, `adaptable`, `colores_url`, `colores_surtidos_url`, `packs`, `imagenes_url`, `categoria_id`, `estado`, `nuevo`, `agotado`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido`, `orden` FROM `articulo` WHERE `categoria_id` = $parentId AND `estado` = 1 ORDER BY `orden` ASC";
	}

	$arts = $db->getObjects($sql);

	return ($arts && count($arts) > 0) ? $arts : array();
}

function buscarArticulos($busqueda = NULL)
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
	$db = $GLOBALS['db'];
	$sql = 'SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `talle_surtido`, `adaptable`, `colores_url`, `colores_surtidos_url`, `packs`, `imagenes_url`, `categoria_id`, `estado`, `nuevo`, `agotado`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido`, `orden` FROM `articulo` WHERE `codigo` LIKE "%' . $busqueda_ . '%" OR `nombre` LIKE "%' . $busqueda_ . '%" ORDER BY `orden` ASC';
	$arts = $db->getObjects($sql);

	return (count($arts) > 0) ? $arts : array();
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
			$db            = $GLOBALS['db'];
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
	$db            = $GLOBALS['db'];
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
	$db       = $GLOBALS['db'];
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
			$db            = $GLOBALS['db'];
			// $sql        = 'INSERT INTO `articulo` (`nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `talle_surtido`, `adaptable`, `colores_url`, `colores_surtidos_url`, `packs`, `categoria_id`, `imagenes_url`, `estado`, `nuevo`, `agotado`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido`, `orden`) VALUES ("' . $_POST['nombre'] . '","' . $_POST['codigo'] . '","' . $_POST['descripcion_breve'] . '","' . $_POST['descripcion'] . '","' . $_POST['talle'] . '","' . $_POST['talle_surtido'] . '","0","' . $colorsLocation . '","' . $colorsSurtLocation . '","' . $_POST['packs'] . '","' . $_POST['categoria_id'] . '","' . $imagesLocation . '", 1, "' . @($_POST['nuevo'] == "on" ? 1 : 0) . '", "' . @($_POST['agotado'] == "on" ? 1 : 0) . '", "' . @($_POST['oferta'] == "on" ? 1 : 0) . '", "' . @($_POST['surtido'] == "on" ? 1 : 0) . '", "' . $_POST['precio'] . '", "' . $_POST['precio_oferta'] . '", "' . $_POST['precio_surtido'] . '", "' . $_POST['precio_oferta_surtido'] . '", ' . $_POST['orden'] . ')';
			$sql           = 'INSERT INTO `articulo` (`nombre`,`codigo`,`descripcion_breve`,`descripcion`,`categoria_id`,`nuevo`,`agotado`,`oferta`,`precio`,`precio_oferta`,`orden`) VALUES ("' . $_POST['nombre'] . '","' . $_POST[' codigo'] . '","' . $_POST[' descripcion_breve'] . '","' . $_POST[' descripcion'] . '","' . $_POST[' categoria_id'] . '","' . ($_POST['nuevo'] == "on" ? 1 : 0) . '","' . ($_POST['agotado'] == "on" ? 1 : 0) . '","' . ($_POST['oferta'] == "on" ? 1 : 0) . '","' . $_POST['precio'] . '","' . $_POST['precio_oferta'] . '","' . $_POST['orden'] . '")';
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

	$db = $GLOBALS['db'];
	$imageLoc     = '/statics/images/articles/{id}/';
	$colorLoc     = '/statics/images/articles/{id}/colors/';
	$colorSurtLoc = '/statics/images/articles/{id}/colors/surtidos/';

	$sql = 'UPDATE `articulo` SET `nombre`="' . $_POST['nombre'] . '", `codigo`="' . $_POST['codigo'] . '", `descripcion_breve`="' . $_POST['descripcion_breve'] . '", `descripcion`="' . $_POST['descripcion'] . '", `talle`="' . $_POST['talle'] . '", `talle_surtido`="' . $_POST['talle_surtido'] . '", `adaptable`="' . @($_POST['adaptable'] == "on" ? 1 : 0) . '", `colores_url` = "' . $colorLoc . '", `colores_surtidos_url` = "' . $colorSurtLoc . '", `packs`="' . $_POST['packs'] . '", `categoria_id`="' . $_POST['categoria_id'] . '", `imagenes_url` = "' . $imageLoc . '", `orden`=' . $_POST['orden'] . ', `nuevo`=' . ($_POST['nuevo'] == "on" ? 1 : 0) . ', `agotado`=' . ($_POST['agotado'] == "on" ? 1 : 0) . ', `oferta`=' . ($_POST['oferta'] == "on" ? 1 : 0) . ', `surtido`=' . ($_POST['surtido'] == "on" ? 1 : 0) . ', `precio`="' . $_POST['precio'] . '", `precio_oferta`=' . (isset($_POST['precio_oferta']) ? $_POST['precio_oferta'] : 0) . ', `precio_surtido`=' . (isset($_POST['precio_surtido']) ? $_POST['precio_surtido'] : 0) . ', `precio_oferta_surtido`=' . (isset($_POST['precio_oferta_surtido']) ? $_POST['precio_oferta_surtido'] : 0) . ' WHERE `id`=' . $id;

	$cid = $db->insert($sql);

	$relative          = $GLOBALS['relative'];
	$imageLocation     = $relative . '/statics/images/articles/' . $id . '/';
	$colorLocation     = $relative . '/statics/images/articles/' . $id . '/colors/';
	$colorSurtLocation = $relative . '/statics/images/articles/' . $id . '/colors/surtidos/';

	// creo la carpeta para las imagenes de este artículo
	@mkdir($imageLocation);

	if ($_FILES['imagen']['error'] == 0) {

		// salvar imagen
		@unlink($imageLocation . '/thumbnail.jpg');
		$img = new \Verot\Upload\Upload($_FILES['imagen']);
		
		if ($img->uploaded) {
			$img->file_new_name_body = 'thumbnail';
			$img->image_resize       = true;
			$img->image_x            = 500;
			$img->image_ratio_y      = true;
			$img->image_convert      = 'webp';
			$img->process($imageLocation);
		}
	}

	if ($_FILES['colores']['error'][0] == 0) {
		// salvar colores
		@unlink($imageLocation . '/colors.jpg');
		$oldColors = glob($colorLocation . '*'); // get all file names

		foreach ($oldColors as $oldColor) {
			unlink($oldColor);
		}

		// salvar colores
		$colorsNum = count($_FILES['colores']['name']);

		for ($i = 0; $i < $colorsNum; $i++) {

			$currentColor			  = array();
			$currentColor['name']	  = $_FILES['colores']['name'][$i];
			$currentColor['type']     = $_FILES['colores']['type'][$i];
			$currentColor['tmp_name'] = $_FILES['colores']['tmp_name'][$i];
			$currentColor['error']    = $_FILES['colores']['error'][$i];
			$currentColor['size']     = $_FILES['colores']['size'][$i];

			$colorName = (string) $i + 1;
			$colorName = (strlen($colorName) < 2 ? '0' . $colorName : $colorName);

			@$color = new \Verot\Upload\Upload($currentColor);
			
			if ($color->uploaded) {
				$color->file_new_name_body = $colorName;
				$color->image_convert = 'jpg';
				@$color->process($colorLocation);
			}
		}
	}

	if ($_FILES['colores_surtidos']['error'][0] == 0) {
		// salvar colores
		$oldSColors = glob($colorSurtLocation . '*'); // get all file names

		foreach ($oldSColors as $oldSColor) {
			unlink($oldSColor);
		}

		// salvar colores
		$colorsSNum = count($_FILES['colores_surtidos']['name']);

		for ($i = 0; $i < $colorsSNum; $i++) {

			$currentSColor			  = array();
			$currentSColor['name']	  = $_FILES['colores_surtidos']['name'][$i];
			$currentSColor['type']     = $_FILES['colores_surtidos']['type'][$i];
			$currentSColor['tmp_name'] = $_FILES['colores_surtidos']['tmp_name'][$i];
			$currentSColor['error']    = $_FILES['colores_surtidos']['error'][$i];
			$currentSColor['size']     = $_FILES['colores_surtidos']['size'][$i];

			$colorSName = (string) $i + 1;
			$colorSName = (strlen($colorSName) < 2 ? '0' . $colorSName : $colorSName);

			@$colorS = new \Verot\Upload\Upload($currentSColor);
			if ($colorS->uploaded) {

				$colorS->file_new_name_body = $colorSName;
				$colorS->image_convert = 'jpg';
				@$colorS->process($colorSurtLocation);
			}
		}
	}
}

function deleteArticle($id)
{
	if (!isAdmin()) return;
	if (!$id) return;

	$db = $GLOBALS['db'];
	$sql = 'DELETE FROM `articulo` WHERE `id`=' . $id;
	$cid = $db->insert($sql);
}

/* PEDIDOS */
function agregarAlPedido($id, $cantidad, $esPack = 'true', $talle = NULL, $color = NULL)
{
	$user = loadUser();

	if ((!$user || $user['user'] == "") && !isset($_SESSION['temp_userid'])) {
		// Algoritmo del temp_userid
		$ipToNumber = (int) implode('', explode('.', getRealIP()));
		$timeLength = time();

		// Guardo un user id temporal igual al timestam actual
		$temp_userid = $ipToNumber + $timeLength;

		// Guardo ese user id temporal en la sesión
		$_SESSION['temp_userid'] = $temp_userid;
	} else {
		if (!$user || $user['user'] == "") {
			// Guardo el user ID para guardar el pedido
			$temp_userid = $_SESSION['temp_userid'];
		} else {
			$temp_userid = $user['user']->id;
		}
	}

	$userid = $temp_userid;

	// checar si hay un pedido abierto (1 : pendiente, 2 : cancelado, 3 : aprobado, 4 : abierto, 5 : cerrado)
	$estafecha = time() - (2 * 24 * 60 * 60);
	$esPack    = $esPack == 'true' ? true : false;
	$db        = $GLOBALS['db'];
	$sql_reuse = 'SELECT `id`, `fecha`, `total`, `cantidad`, `estado` FROM `pedido` WHERE `usuario_id` = "' . $userid . '" AND `estado` = 4 AND `fecha` >= "' . date('Y/m/d', $estafecha) . '"';
	$pedido    = $db->getObject($sql_reuse);
	$pedidoId  = NULL;

	if ($pedido) {
		// si hay pedido
		// guardo el id de este pedido
		$pedidoId = $pedido->id;
	} else {
		// creo el pedido con estado abierto
		$h = "-3";
		$hm = $h * 60;
		$ms = $hm * 60;
		$gmdate = gmdate("Y-m-d H:i:s", time() + ($ms));

		$sql = 'INSERT INTO `pedido` (`usuario_id`, `fecha`, `total`, `cantidad`, `estado`) VALUES ("' . $userid . '", "' . $gmdate . '", 0, 0, 4)';
		$pedidoId = $db->insert($sql);

		// controlar pedido, si no existe retornar error
		if (!$pedidoId) {
			return array('status' => 'error', 'error' => 'INVOICE_DOESNT_EXIST');
		}

		$pedido = $db->getObject($sql_reuse);
	}

	// obtengo el articulo para extraer los datos necesarios para el pedido
	$sql = 'SELECT `packs`, `colores_url`, `colores_surtidos_url`, `talle`, `talle_surtido`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido` FROM `articulo` WHERE `id`=' . $id;
	$articulo = $db->getObject($sql);

	// controlar articulo, si no existe retornar error
	if (!$articulo) {
		return array('status' => 'error', 'error' => 'ITEM_DOESNT_EXIST');
	}

	// Chequeo el precio si es pack o surtido y lo actualizo en el pedido
	if ($esPack) {
		$articulo_precio = (($articulo->oferta == 1 && $articulo->precio_oferta > 0) ? $articulo->precio_oferta : $articulo->precio);
		$surtido = 0;

		// guardar todos los colores en $colors
		$colorsDir  = '../../..' . str_replace("{id}", $id, $articulo->colores_url);

		if (!is_dir($colorsDir)) {
			$colors = '0';
		} else {
			$colorsFiles = opendir($colorsDir);
			$colorsList = array();

			if (!$colorsFiles) {
				$colors = '0';
			} else {
				$auxColors = array();
				while ($col = readdir($colorsFiles)) {
					if (!is_dir($colorsDir . $col)) {
						// $colorsList[] = $col;
						$auxColors[] = basename($col, '.jpg');
					}
				}

				$colors = implode(',', $auxColors);
			}
		}
	} else {
		$articulo_precio = 0;
		if ($articulo->oferta == 1) {
			$articulo_precio = ($articulo->precio_oferta_surtido > 0 ? $articulo->precio_oferta_surtido : ($articulo->precio_surtido > 0 ? $articulo->precio_surtido : ($articulo->precio_oferta > 0 ? $articulo->precio_oferta : $articulo->precio)));
		} else {
			$articulo_precio = ($articulo->precio_surtido > 0 ? $articulo->precio_surtido : $articulo->precio);
		}
		// TODO - Error
		// $colors = str_replace('color-'.$id.'-', '', $color);
		$colors = $color;
		$surtido = 1;
	}

	$pack        = $esPack ? (int) str_replace(array("pack x", "pack x ", "X", "x", "X ", "x ", "packs x", "packs x ", "Packs X", "Packs X ", "PACKS X", "PACKS X ", "Pack x", "Pack x "), "", $articulo->packs) : 1;
	$subtotalArt = $articulo_precio * $pack * $cantidad;
	$totalPedido = $pedido->total + ($articulo_precio * $pack * $cantidad);
	$talle       = $esPack ? $articulo->talle : $talle;

	$sql = 'UPDATE `pedido` SET `total`=' . $totalPedido . ', `cantidad`=' . ($pedido->cantidad + 1) . ' WHERE `id`=' . $pedidoId;
	$sql_update_pedido = $sql;
	$db->insert($sql);

	// TODO WORKING ON
	// return array('userid' => $userid, 'articulo' => $articulo, 'articulo_precio' => $articulo_precio, 'sql_update_pedido' => $sql_update_pedido);

	// Guardo el articulo relacionado al pedido, en la tabla articulo_pedido
	$sql = 'INSERT INTO `articulo_pedido` (`pedido_id`, `articulo_id`, `precio_actual`, `surtido`, `talle`, `color`, `cantidad`, `subtotal`) VALUES (' . $pedidoId . ', ' . $id . ', ' . $articulo_precio . ', ' . $surtido . ', "' . $talle . '", "' . $colors . '", ' . ($pack * $cantidad) . ', ' . $subtotalArt  . ')';
	$rId = $db->insert($sql);


	$pedido = $db->getObject($sql_reuse);

	if ($rId) {
		return array('status' => 'ok', 'pedido' => $pedido);
	} else {
		return array('status' => 'error', 'error' => 'DB_ERROR');
	}
}

function eliminarDelPedido($idpedido, $itemid, $pedidoid, $precioitem, $cantidaditem, $totalpedido, $cantidaditemstotal)
{

	$db = $GLOBALS['db'];
	$sql = 'DELETE FROM `articulo_pedido` WHERE `pedido_id`=' . $pedidoid . ' AND `articulo_id`=' . $itemid . ' AND `id`=' . $idpedido;
	$db->insert($sql);

	$sql = 'SELECT COUNT(*) AS `cantidad_en_pedido`, SUM(`subtotal`) AS `total_en_pedido` FROM `articulo_pedido` WHERE `pedido_id`=' . $pedidoid;
	$articulos = $db->getObject($sql);

	if ($articulos->cantidad_en_pedido > 0) {

		$sql = 'UPDATE `pedido` SET `total`=' . $articulos->total_en_pedido . ', `cantidad`=' . $articulos->cantidad_en_pedido . ' WHERE `id`=' . $pedidoid;
	} else {

		$sql = 'DELETE FROM `pedido` WHERE `id`=' . $pedidoid;
	}

	$db->insert($sql);

	return array('status' => 'DELTE_SUCCESSFUL', 'articulos' => $articulos->cantidad_en_pedido, 'total' => $articulos->total_en_pedido);
}

function obtenerPedido($idPedido)
{
	$pedidoCompleto = array('articulos' => NULL, 'pedido' => NULL);

	$db = $GLOBALS['db'];
	$sql = 'SELECT `pedido`.*, `usuario`.`nombre`, `usuario`.`apellido`, `usuario`.`rut`, `usuario`.`telefono`, `usuario`.`celular`, `usuario`.`email` FROM `pedido` JOIN `usuario` ON `pedido`.`usuario_id` = `usuario`.`id` WHERE `pedido`.`id`=' . $idPedido;
	$pedidoCompleto['pedido'] = $db->getObject($sql);

	if (empty($pedidoCompleto['pedido'])) {
		$sql = 'SELECT `pedido`.* FROM `pedido` WHERE `pedido`.`id`=' . $idPedido;
		$pedidoCompleto['pedido'] = $db->getObject($sql);
	}

	$sql = 'SELECT `articulo_pedido`.`id` AS `id_pedido`, `articulo_pedido`.`cantidad`, `articulo_pedido`.`subtotal`, `articulo`.`id`, `articulo`.`nombre`, `articulo`.`codigo`, `articulo_pedido`.`surtido`, `articulo_pedido`.`talle`, `articulo_pedido`.`color`, `articulo`.`colores_url`, `articulo`.`colores_surtidos_url`, `articulo`.`imagenes_url` FROM `articulo_pedido` JOIN `articulo` ON `articulo_pedido`.`articulo_id`=`articulo`.`id` WHERE `articulo_pedido`.`pedido_id`=' . $idPedido;
	$pedidoCompleto['articulos'] = $db->getObjects($sql);

	return $pedidoCompleto;
}

function obtenerPedidoAbierto($id_usuario = null)
{

	$id_us     = $id_usuario ? $id_usuario : JSON_decode($_SESSION['usuario'])->id;

	$estafecha = time() - (2 * 24 * 60 * 60);
	// obtengo el pedido abierto
	$db        = $GLOBALS['db'];
	$sql       = 'SELECT * FROM `pedido` WHERE `estado` = 4 AND `usuario_id`=' . $id_us . ' AND `fecha` >= "' . date('Y/m/d', $estafecha) . '"';
	$pedido    = $db->getObject($sql);

	return $pedido;
}

function obtenerPedidos($id_usuario = null, $estado = NULL)
{

	$db = $GLOBALS['db'];
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

	$pedidos = $db->getObjects($sql);
	return $pedidos;
}

function obtenerUltimoPedido()
{
	$db = $GLOBALS['db'];
	$sql = 'SELECT `pedido`.*, `usuario`.`nombre`, `usuario`.`apellido`, `usuario`.`rut`, `usuario`.`telefono`, `usuario`.`celular`, `usuario`.`email` FROM `pedido` JOIN `usuario` ON `pedido`.`usuario_id`=`usuario`.`id` WHERE `estado` = 1 AND `notificado` != 1 ORDER BY `fecha` DESC';

	$pedido = $db->getObject($sql);

	return $pedido;
}

function actualizarUltimoPedido()
{
	$db = $GLOBALS['db'];
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

	$db = $GLOBALS['db'];

	$lugar = ($_POST['lugar_compra'] == 'envio_interior' ? 'Interior' : ($_POST['lugar_compra'] == 'envio_montevideo' ? 'Montevideo' : ''));
	$retira = $_POST['retira_agencia'] == 'true' || $_POST['retira_local'] == 'true' ? 1 : 0;

	$sql = 'UPDATE `pedido` SET `estado`=1, `lugar`="' . $lugar . '", `retira`=' . $retira . ', `agencia_de_envio`="' . $_POST['agencia_entrega'] . '", `direccion_de_entrega`="' . $_POST['direccion_entrega'] . '", `forma_de_pago`="' . (isset($_POST['forma_pago']) ? $_POST['forma_pago'] : '') . '" WHERE `id`=' . $idPedido;
	// agregar direccion del usuario, agencia de entrega y forma de pago al pedido
	$db->insert($sql);

	$ordenSQL = 'SELECT * FROM `pedido` WHERE `id`=' . $idPedido;
	$ordenOBJ = $db->getObject($ordenSQL);

	$usuarioSQL = 'SELECT * FROM `usuario` WHERE `id`=' . $ordenOBJ->usuario_id;
	$usuarioOBJ = $db->getObject($usuarioSQL);

	$pedidoSQL = 'SELECT `articulo_pedido`.`id`, `articulo_pedido`.`articulo_id`, `articulo_pedido`.`precio_actual`, `articulo_pedido`.`cantidad`, `articulo_pedido`.`subtotal`, `articulo`.`codigo`, `articulo`.`nombre`,`articulo_pedido`.`talle`, `articulo_pedido`.`surtido`, `articulo_pedido`.`color`, `articulo`.`colores_url`, `articulo`.`colores_surtidos_url`, `articulo`.`imagenes_url` FROM `articulo_pedido` JOIN `articulo` ON `articulo_pedido`.`articulo_id`=`articulo`.`id` WHERE `pedido_id`=' . $idPedido;
	$pedidoOBJ = $db->getObjects($pedidoSQL);

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
	foreach ($pedidoOBJ as $articulo) {

		$mensaje .=
			'<tr>' .
			'<td>' . $articulo->codigo . '</td>' .
			'<td>' . $articulo->nombre . '</td>' .
			'<td>' . ($articulo->surtido == 0 ? 'No' : 'Si') . '</td>' .
			'<td>' . $articulo->talle . '</td>' .
			'<td>';

		$surtido           = $articulo->surtido == 0 ? false : true;
		$relative          = '../../..';
		$colorsAuxDir      = '';
		$colorsDir         = '';
		$colorsDirForEmail = 'http://' . $_SERVER['SERVER_NAME'];
		$colores           = explode(',', $articulo->color);

		if ($articulo->colores_url == $articulo->imagenes_url) {
			$mensaje .= '<img src="http://' . $_SERVER['SERVER_NAME'] . str_replace("{id}", $articulo->articulo_id, $articulo->imagenes_url) . 'colors.jpg" />';
		} else {
			if ($surtido) {
				$colorsDir    = str_replace("{id}", $articulo->articulo_id, $articulo->colores_surtidos_url);
				$colorsAuxDir = $relative . str_replace("{id}", $articulo->articulo_id, $articulo->colores_surtidos_url);
				if (!file_exists($colorsAuxDir)) {
					$colorsDir    = str_replace("{id}", $articulo->articulo_id, $articulo->colores_url);
					$colorsAuxDir = $relative . str_replace("{id}", $articulo->articulo_id, $articulo->colores_url);
				}
			} else {
				$colorsDir    = str_replace("{id}", $articulo->articulo_id, $articulo->colores_url);
				$colorsAuxDir = $relative . str_replace("{id}", $articulo->articulo_id, $articulo->colores_url);
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
							$colorsDir         = str_replace("{id}", $articulo->articulo_id, $articulo->colores_url);
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
				$colorsDir = $relative . str_replace("{id}", $articulo->articulo_id, $articulo->imagenes_url);
				$colors    = $colorsDir . 'colors.jpg';

				if (file_exists($colors)) {
					$mensaje .= '<img src="http://' . $_SERVER['SERVER_NAME'] . str_replace("{id}", $articulo->articulo_id, $articulo->imagenes_url) . 'colors.jpg" />';
				} else {
					$mensaje .= '<span>No hay colores</span>';
				}
			}
		}

		$mensaje .=
			'</td>' .
			'<td>' . $articulo->cantidad . '</td>' .
			'<td>$ ' . $articulo->subtotal . ',00</td>' .
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

	$db = $GLOBALS['db'];

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

	$db = $GLOBALS['db'];

	// agregar direccion del usuario, agencia de entrega y forma de pago al pedido
	// $sql = 'UPDATE `dev_pedido` SET `estado`=3 WHERE `id`=' . $idPedido;
	$sql = 'UPDATE `pedido` SET `estado`=3 WHERE `id`=' . $idPedido;
	$db->insert($sql);

	return array('status' => 'STATUS_UPDATED_SUCCESSFUL');
}

function posponerPedido($idPedido)
{

	$db = $GLOBALS['db'];

	// agregar direccion del usuario, agencia de entrega y forma de pago al pedido
	// $sql = 'UPDATE `dev_pedido` SET `estado`=1 WHERE `id`=' . $idPedido;
	$sql = 'UPDATE `pedido` SET `estado`=1 WHERE `id`=' . $idPedido;
	$db->insert($sql);

	return array('status' => 'STATUS_UPDATED_SUCCESSFUL');
}

function cerrarPedido($idPedido)
{
	$db = $GLOBALS['db'];

	// agregar direccion del usuario, agencia de entrega y forma de pago al pedido
	// $sql = 'UPDATE `dev_pedido` SET `estado`=1 WHERE `id`=' . $idPedido;
	$sql = 'UPDATE `pedido` SET `estado`=5 WHERE `id`=' . $idPedido;
	$db->insert($sql);

	return array('status' => 'STATUS_UPDATED_SUCCESSFUL');
}

function cambiarPertenenciaDelPedido($pedidoid, $idNuevoUsuario, $idViejoUsuario)
{
	$db = $GLOBALS['db'];

	// Cambio el id temporal de usuario del prepedido por el id del usuario logueado
	$sql = 'UPDATE `pedido` SET `usuario_id` = ' . $idNuevoUsuario . ' WHERE `id` = ' . $pedidoid . ' AND `usuario_id`=' . $idViejoUsuario;
	$db->insert($sql);

	// Obtengo el pedido
	$sql_p   = 'SELECT * FROM `pedido` WHERE `id` = ' . $pedidoid;
	$pedido  = $db->getObject($sql_p);

	// Lo retorno
	return $pedido;
}

function combinarPedidos($pedido, $prepedido)
{
	$db = $GLOBALS['db'];

	$pedido_cantidad = $pedido->cantidad;
	$pedido_total    = $pedido->total;

	// Obtengo los artículos del pre pedido
	$sql_prearticulos    = 'SELECT `articulo_pedido`.`id` AS `id_pedido`, `articulo_pedido`.`cantidad`, `articulo_pedido`.`subtotal`, `articulo`.`id`, `articulo`.`nombre`, `articulo`.`codigo`, `articulo_pedido`.`surtido`, `articulo_pedido`.`talle`, `articulo_pedido`.`color`, `articulo`.`colores_url`, `articulo`.`colores_surtidos_url`, `articulo`.`imagenes_url` FROM `articulo_pedido` JOIN `articulo` ON `articulo_pedido`.`articulo_id`=`articulo`.`id` WHERE `articulo_pedido`.`pedido_id`=' . $prepedido->id;
	$prearticulospedidos = $db->getObjects($sql_prearticulos);

	// Recorro los articulos pre pedidos
	foreach ($prearticulospedidos as $art_pedido) {
		// actualizo el total y la cantidad en el pedido
		$pedido_cantidad = $pedido_cantidad + 1;
		$pedido_total    = $pedido_total + $art_pedido->subtotal;
	}

	// Cambio el id de los articulos pre pedidos por los del pedido
	$sql_ap = 'UPDATE `articulo_pedido` SET `pedido_id` = ' . $pedido->id . ' WHERE `pedido_id` = ' . $prepedido->id;
	$db->insert($sql_ap);

	// Actualizo la cantidad y el total al pedido principal
	$sql_p = 'UPDATE `pedido` SET `cantidad` = ' . $pedido_cantidad . ', `total` = ' . $pedido_total . ' WHERE `id` = ' . $pedido->id;
	$db->insert($sql_p);

	// Elimino el prepedido
	$sql_dp = 'DELETE FROM `pedido` WHERE `id` = ' . $prepedido->id;
	$db->insert($sql_dp);

	$pedido_actualizado = obtenerPedidoAbierto($pedido->usuario_id);

	return $pedido_actualizado;
}

/* GENERAL */
function startDocument()
{
	echo "<!doctype html>\n<html lang=\"es\">\n<head>\n";
	$place = 'head';
	include($GLOBALS['config']['templatesPath'] . 'includes.php');
	createAppObjects();
	echo "\n</head>\n<body>\n";
}

function endDocument()
{
	$place = 'body-end';
	include($GLOBALS['config']['templatesPath'] . 'includes.php');
	echo "</body>\n</html>";
}

function createAppObjects()
{
	echo "\t<script>\n";
	echo "\n";
	echo "\tvar userStats = " . JSON_encode($GLOBALS['userStats']) . ";";
	echo "\n\n";
	echo "\t</script>\n";
}

function custom_error_log($msg = null, $line = null, $file = null, $function = null)
{
	// echo date('d/m/Y H:i:s').' :: '.$file.' :: '.$function.' :: '.$line.': '.$msg."\n";

	if (empty($msg)) {
		error_log(date('d/m/Y H:i:s') . ' :: ' . __FILE__ . ' :: ' . __FUNCTION__ . ' :: ' . __LINE__ . ': $msg is null or empty' . "\n", 3, "../../error.txt");
	}
	if (empty($line)) {
		error_log(date('d/m/Y H:i:s') . ' :: ' . __FILE__ . ' :: ' . __FUNCTION__ . ' :: ' . __LINE__ . ': $line is null or empty' . "\n", 3, "../../error.txt");
	}
	if (empty($file)) {
		error_log(date('d/m/Y H:i:s') . ' :: ' . __FILE__ . ' :: ' . __FUNCTION__ . ' :: ' . __LINE__ . ': $line is null or empty' . "\n", 3, "../../error.txt");
	}

	error_log(date('d/m/Y H:i:s') . ' :: ' . $file . ' :: ' . $function . ' :: ' . $line . ': ' . $msg . "\n", 3, "../../error.txt");
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

function consoleLog($line, $var)
{
	echo '<script>console.log("PHP#' . $line . '-->", "' . $var . '");</script>';
}

function debug($variable)
{
	$bt = debug_backtrace();
	$caller = array_shift($bt);
	$file = @array_pop(explode('/', $caller['file']));
	header_log($variable);
?>
	<pre class="floating-debug-section">
<strong><?php echo $file . '#' . $caller['line'] . ':' ?></strong>
<?php var_dump($variable); ?>
</pre>
<?php
}

function header_log($data)
{
	$bt = debug_backtrace();
	$caller = array_shift($bt);
	$file = @array_pop(explode('/', $caller['file']));
	header('log_' . $file . '#' . $caller['line'] . ': ' . json_encode($data));
}

function isAdmin()
{
	return @$GLOBALS['userStats']['user']->administrador;
}

function protectFromNotAdminUsers()
{
	if (!isAdmin()) {
		header('Location: /404');
	}
}

function delTree($dir)
{
	$files = array_diff(scandir($dir), array('.','..'));

	foreach ($files as $file) {
		(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
	}

	return rmdir($dir);
}

?>