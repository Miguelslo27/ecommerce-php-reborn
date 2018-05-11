<?php

$relative = '../../..';
require '../../../includes/common.php';
header('Content-type: application/json');

echo $_GET['id'].'<br>';
echo $_GET['c'].'<br>';
echo $_GET['p'].'<br>';
echo @$_GET['t'].'<br>';
echo @$_GET['color'].'<br>';

// echo JSON_encode(agregarAlPedido($_GET['id'], $_GET['c'], $_GET['p'], @$_GET['t'], @$_GET['color']));

?>