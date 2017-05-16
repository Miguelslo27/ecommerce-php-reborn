<?php

ini_set("memory_limit","500M");

$relative = '..';
require '../includes/common.php';

header('Content-type: text/csv');
header('Content-Disposition: attachment;filename="Usuarios monique.csv"');
header('Cache-Control: max-age=0');

$output = fopen('php://output', 'w');

$userStats = loadUser();
if ($userStats['user']->administrador == 0 ) {

	echo "Acceso restringido!";
	exit;

}

$todosLosUsuarios = obtenerUsuariosExportacion();

// output the column headings
fputcsv($output, array('ID', 'Nombre', 'RUT', 'E-Mail', 'Dirección', 'Teléfono', 'Localidad', 'Total Compras'));

foreach ($todosLosUsuarios as $usuario) {
	fputcsv($output, array($usuario->id, $usuario->nombre .' '. $usuario->apellido, $usuario->rut, $usuario->email, $usuario->direccion, ($usuario->telefono .'/'. $usuario->celular), ($usuario->ciudad .', '. $usuario->departamento), ($usuario->total_pedidos != "NULL" ? $usuario->total_pedidos : 0)));
}

exit;

?>