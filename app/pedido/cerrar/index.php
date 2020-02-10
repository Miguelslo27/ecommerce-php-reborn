<?php

$relative = '../../../';
require '../../../core/common.php';
header('Content-type: application/json');

echo JSON_encode(cerrarPedido($_GET['id']));

?>