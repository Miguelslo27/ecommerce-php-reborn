<?php

$relative = '..';
require '../core/common.php';

$userStats = loadUser();
if (!isAdmin() ) {

	echo "Acceso restringido!";
	return;

}
// $cartItems = $userStats['cart'] ? obtenerPedido($userStats['cart']->id) : NULL;
$usuario = obtenerUsuarios(isset($_GET['id']) ? $_GET['id'] : null);
$appPlace = 'online-history';
$appSubPlace = 'administrar-usuarios';

startDocument();
include($templatesPath . 'header.php');

?>
