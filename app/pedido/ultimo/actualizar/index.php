<?php
$relative = '../../../../';
require_once '../../../../core/common.php';
header('Content-type: application/json');

echo JSON_encode(actualizarUltimoPedido());
?>