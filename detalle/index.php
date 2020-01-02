<?php

$relative = '..';
require '../includes/common.php';

$userStats = loadUser();
if ($userStats['user']->administrador == 0 ) {

	echo "Acceso restringido!";
	return;

}
// $cartItems = $userStats['cart'] ? obtenerPedido($userStats['cart']->id) : NULL;
$orden = obtenerPedido($_GET['id']);
$appPlace = 'online-history';
$appSubPlace = 'administrar-pedidos';

startDocument();
loadSection("header", $userStats);

?>

	<section id="body">
		<div class="body-inner">
			<div class="body-content">
				<h1>Administración de Pedidos - Orden #<?php echo $_GET['id']; ?></h1>
				<div class="admin-cmds">
					<span class="admin-cmd <?php echo !isset($_GET['estado']) || $_GET['estado'] == 1 ? 'filtro-pendiente-activo' : ''; ?>"><a href="/administrar-pedidos?estado=1">Ver Pendientes</a></span>
					<span class="admin-cmd <?php echo isset($_GET['estado']) && $_GET['estado'] == 2 ? 'filtro-aprobado-activo' : ''; ?>"><a href="/administrar-pedidos?estado=2">Ver Aprobadas</a></span>
					<span class="admin-cmd <?php echo isset($_GET['estado']) && $_GET['estado'] == 4 ? 'filtro-abierto-activo' : ''; ?>"><a href="/administrar-pedidos?estado=4">Ver Abiertas</a></span>
					<span class="admin-cmd <?php echo isset($_GET['estado']) && $_GET['estado'] == 5 ? 'filtro-cerrado-activo' : ''; ?>"><a href="/administrar-pedidos?estado=5">Ver Cerradas</a></span>
					<span class="admin-cmd <?php echo isset($_GET['estado']) && $_GET['estado'] == 3 ? 'filtro-cancelado-activo' : ''; ?>"><a href="/administrar-pedidos?estado=3">Ver Canceladas</a></span>
				</div>
				<span class="line-h">&nbsp;</span>
				<div class="administracion-ordenes">

					<div class="orden-info<?php
						switch($orden['pedido']->estado) {
						
							case 1: // Pendiente
						
							echo ' orden-pendiente';
						
							break;
							case 2: // Aprobado
						
							echo ' orden-aprobada';
						
							break;
							case 3: // Cancelado
						
							echo ' orden-cancelada';
						
							break;
							case 4: // Abierta
						
							echo ' orden-abierta';
						
							break;
						
						}
						?>">
						<div class="usuario-info">
							<div class="usuario-data usuario-nombre">
								<span class="label">Orden a nombre de:</span>
								<span class="value"><?php echo $orden['pedido']->nombre . ' ' . $orden['pedido']->apellido; ?></span>
							</div>
							<div class="usuario-data usuario-telefono">
								<span class="label">Telefono de contacto:</span>
								<span class="value"><?php echo $orden['pedido']->telefono; ?></span>
							</div>
							<div class="usuario-data usuario-email">
								<span class="label">Email de contacto:</span>
								<span class="value"><?php echo $orden['pedido']->email; ?></span>
							</div>
						</div>
						<div class="order-id">Orden <?php echo $orden['pedido']->id; ?> (<?php
						switch($orden['pedido']->estado) {
						
							case 1: // Pendiente
						
							echo 'pendiente de aprobación';
						
							break;
							case 2: // Aprobado
						
							echo 'aprobada por el administrador';
						
							break;
							case 3: // Cancelado
						
							echo 'cancelada por el administrador';
						
							break;
							case 4: // Abierta
						
							echo 'aún se encuentra abierta';
						
							break;
						
						}
						?>)</a></div>
						<div class="order-inner">
							<div class="orden-data orden-id"><span class="label">Número de orden: </span><span class="value"><?php echo $orden['pedido']->id; ?></span></div>
							<div class="orden-data orden-fecha"><span class="label">Fecha de creación: </span><span class="value"><?php echo $orden['pedido']->fecha; ?></span></div>
							<div class="orden-data orden-cantidad"><span class="label">Cantidad de artículos: </span><span class="value"><?php echo $orden['pedido']->cantidad; ?></span></div>
							<div class="orden-data orden-total"><span class="label">Total de la orden: </span><span class="value">$ <?php echo $orden['pedido']->total; ?>,00</span></div>
							<div class="orden-data orden-acciones">
								<?php
								switch ($orden['pedido']->estado) {

									case 1: // Pendiente
						
									?>
								<a class="btn btn-small purple btn-style aprobar" data-id="<?php echo $orden->id; ?>">Aprobar</a>
								<a class="btn btn-small grey btn-style cancelar" data-id="<?php echo $orden->id; ?>">Cancelar</a>
									<?php
								
									break;
									case 2: // Aprobado
								
									?>
								<a class="btn btn-small black btn-style cerrar" data-id="<?php echo $orden->id; ?>">Cerrar</a>
								<a class="btn btn-small grey btn-style cancelar" data-id="<?php echo $orden->id; ?>">Cancelar</a>
									<?php
								
									break;
									case 3: // Cancelado
								
									?>
								<a class="btn btn-small purple btn-style pendiente" data-id="<?php echo $orden->id; ?>">Posponer</a>
									<?php
								
									break;
									case 4: // Abierta
								
									?>
								<span class="label">Aun sin finalizado</span>
									<?php
								
									break;

								}
								?>
							</div>
						</div>

						<pre style="display: none;">
						<?php

						print_r($orden);

						?>
						</pre>

						<table>
							<thead>
								<tr>
									<td>Código</td>
									<td>Artículo</td>
									<td>Cantidad</td>
									<td>Subtotal</td>
								</tr>
							</thead>
							<tbody>
<?php
							foreach($orden['articulos'] as $articulo) {

?>
								<tr>
									<td width="20%"><?php echo $articulo->codigo; ?></td>
									<td width="40%">
										<?php echo $articulo->nombre; ?>
										<div>
											<strong>Talles: </strong><?php echo $articulo->talle; ?>
											<strong>Colores:</strong>
											<?php
											$surtido    = $articulo->surtido == 0 ? false : true;
											$colorsDir  = '';
											$colores    = explode(',', $articulo->color);

											if($articulo->colores_url == $articulo->imagenes_url) {
												?>
												<img style="margin: 0 0 -5px;" src="<?php echo $relative.str_replace("{id}", $articulo->id, $articulo->imagenes_url); ?>colors.jpg">
												<?php
											} else {
												if($surtido) {
													$colorsDir = $relative.str_replace("{id}", $articulo->id, $articulo->colores_surtidos_url);
													if(!file_exists($colorsDir)) {
														$colorsDir = $relative.str_replace("{id}", $articulo->id, $articulo->colores_url);
													}
												} else {
													$colorsDir = $relative.str_replace("{id}", $articulo->id, $articulo->colores_url);
												}
												
												if(file_exists($colorsDir)) {
													?>
													<ul style="list-style: none; margin: 0; padding: 0; display: inline-block;">
													<?php
														foreach($colores AS $color) {
															if (!is_dir($colorsDir.$color)) {
																if(file_exists($colorsDir.$color.'.jpg')) {
																	?>
																	<li style="display: inline-block;"><span style="border-radius: 8px; border: 2px solid #ccc; height: 14px; width: 14px; display: inline-block; position: relative; bottom: -3px;"><img src="<?php echo $colorsDir.$color.'.jpg?'.$revision; ?>" style="border-radius: 7px; width: 14px;"	></span></li>
																	<?php
																} else {
																	$colorsDir = $relative.str_replace("{id}", $articulo->id, $articulo->colores_url);
																	?>
																	<li style="display: inline-block;"><span style="border-radius: 8px; border: 2px solid #ccc; height: 14px; width: 14px; display: inline-block; position: relative; bottom: -3px;"><img src="<?php echo $colorsDir.$color.'.jpg?'.$revision; ?>" style="border-radius: 7px; width: 14px;"	></span></li>
																	<?php
																}
															}
														}
													?>
													</ul>
													<?php
												} else {
													$colorsDir = $relative.str_replace("{id}", $articulo->id, $articulo->imagenes_url);
													$colors    = $colorsDir.'colors.jpg';

													if(file_exists($colors)) {
													?>
													<img style="margin: 0 0 -5px;" src="<?php echo $relative.str_replace("{id}", $articulo->id, $articulo->imagenes_url); ?>colors.jpg">
													<?php
													} else {
													?>
													<span>No hay colores</span>
													<?php
													}
												}
											}
											?>
										</div>
									</td>
									<td width="20%"><?php echo $articulo->cantidad; ?></td>
									<td width="20%">$ <?php echo $articulo->subtotal; ?>,00</td>
								</tr>
<?php

							}
?>
							</tbody>
						</table>
					</div>

				</div>

<?php

// echo '<pre>';
// print_r($orden);
// echo '</pre>';

loadSection("footer", $userStats);
endDocument();

?>