<?php

$relative = '..';
require '../core/common.php';

$userStats = loadUser();
if (!isAdmin() ) {

	echo "Acceso restringido!";
	return;

}
// $cartItems = $userStats['cart'] ? obtenerPedido($userStats['cart']->id) : NULL;
$usuario = getUsers(isset($_GET['id']) ? $_GET['id'] : null);
$page = 'online-history';
$appSubPlace = 'administrar-usuarios';

startDocument();
include($template_path . 'header.php');

?>
