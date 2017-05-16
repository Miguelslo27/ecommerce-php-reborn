<?php

ini_set("memory_limit","500M");

$relative = '..';
require '../includes/common.php';

header('Content-type: text/csv');
header('Content-Disposition: attachment;filename="Suscripciones Monique.csv"');
header('Cache-Control: max-age=0');

$output = fopen('php://output', 'w');

$userStats = loadUser();
if ($userStats['user']->administrador == 0 ) {
	echo "Acceso restringido!";
	exit;
}

$todasLasSuscripciones = obtenerSuscripciones();

// output the column headings
fputcsv($output, array('ID', 'E-Mail'));

foreach ($todasLasSuscripciones as $usuario) {
	fputcsv($output, array($usuario->id, $usuario->email));
}

fclose($output);
exit;

?>