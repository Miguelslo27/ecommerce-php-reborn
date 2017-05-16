<?php

$relative = '..';
require '../includes/common.php';

$userStats = loadUser();
if ($userStats['user']->administrador == 0 ) {

	echo "Acceso restringido!";
	return;

}

$appPlace          = 'online-history';
$appSubPlace       = 'administrar-usuarios';

// Paginador
$totalUsuarios     = obtenerTotalUsuarios();
$cantidadPorPagina = isset($_GET['cpp']) ? (int) $_GET['cpp'] : 50;
$totalPaginas      = ceil($totalUsuarios->total / $cantidadPorPagina);
$pagina            = isset($_GET['p']) ? (int) $_GET['p'] : 1;
$usuarios          = obtenerUsuariosPaginados($cantidadPorPagina, $pagina);

startDocument();
loadSection("header", $userStats);

?>

	<style>
		.paginador-pagina {
			display: inline-block;
			height: 15px;
			line-height: 15px;
			text-align: center;
			width: 35px;
		}
		.paginador-pagina.activa {
			font-weight: bold;
		}
	</style>
	<section id="body">
		<div class="body-inner">
			<div class="body-content">
				<h1>Administración de Usuarios</h1>
				<span class="line-h"></span>
				<br>
				<a href="descargar-csv.php" class="btn btn-small black"><span class="fa fa-table" style="position: relative; margin-right: 10px; top: 0.5px;"></span>Descargar lista completa en CSV</a>
				<a href="suscripciones-csv.php" class="btn btn-small black"><span class="fa fa-table" style="position: relative; margin-right: 10px; top: 0.5px;"></span>Descargar suscripciones en CSV</a>
				<br>
				<br>
				<div>
					<strong>Total de usuarios:</strong> <span><?php echo $totalUsuarios->total; ?></span>
					-
					<strong>Página <?php echo $pagina; ?> de <?php echo $totalPaginas; ?></strong>
					-
					<strong>Registros por página:</strong> <a class="paginador-pagina <?php echo ($cantidadPorPagina == 50 ? 'activa' : ''); ?>" href="?p=1&cpp=50">50</a> | <a class="paginador-pagina <?php echo ($cantidadPorPagina == 100 ? 'activa' : ''); ?>" href="?p=1&cpp=100">100</a> | <a class="paginador-pagina <?php echo ($cantidadPorPagina == 500 ? 'activa' : ''); ?>" href="?p=1&cpp=500">500</a>
				</div>
				<div>
					<?php

					for($p = 1; $p < $totalPaginas; $p++) {

					?>

					<a class="paginador-pagina <?php echo ($pagina == $p ? 'activa' : ''); ?>" href="?p=<?php echo $p; ?><?php echo (isset($_GET['cpp']) ? '&cpp='.$_GET['cpp'] : ''); ?>"><?php echo $p; ?></a>

					<?php

					}

					?>
				</div>
				<table class="users-table" cellspacing="0" cellpadding="0">
					<thead>
						<tr>
							<td style="border-top: 1px solid; border-left: 1px solid; border-bottom: 1px solid;">Usuario <!-- Nombre, email, teléfono --> </td>
							<td style="border-top: 1px solid; border-bottom: 1px solid;">Dirección <!-- Dirección, Ubicación --> </td>
							<td style="border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid;">Otros <!-- RUT -->
						</tr>
					</thead>
					<tbody>
						<?php

						foreach($usuarios as $usuario) {

						?>

						<tr>
							<td style="border-top: 1px solid; border-left: 1px solid;">
								<div>
									<strong><?php echo $usuario->nombre.' '.$usuario->apellido; ?></strong>
								</div>
								<div>
									<strong>Email:</strong> <span><?php echo $usuario->email; ?></span>
								</div>
								<div>
									<strong>Teléfono/s:</strong> <span><?php echo $usuario->telefono.' - '.$usuario->celular; ?></span>
								</div>
							</td>
							<td style="border-top: 1px solid;">
								<div>
									<strong>Dirección:</strong> <span><?php echo $usuario->direccion; ?></span>
								</div>
								<div>
									<strong>Ubicación:</strong> <span><?php echo $usuario->ciudad.', '.$usuario->departamento; ?></span>
								</div>
							</td>
							<td style="border-top: 1px solid; border-right: 1px solid;">
								<div>
									<strong>RUT:</strong> <span><?php echo $usuario->rut; ?></span>
								</div>
							</td>
						</tr>

						<?php

						}

						?>
					</tbody>
				</table>

			</div>
		</div>

<?php

loadSection("footer", $userStats);
endDocument();

?>