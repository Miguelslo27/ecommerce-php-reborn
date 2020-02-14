<?php

$relative = '../';
require '../core/common.php';

$userStats     = loadUser();
$page          = 'online-history';
$sub_page      = 'pedido-actual';
$template_path = getTemplatePath();
$cartItems     = $userStats['cart'] ? obtenerPedido($userStats['cart']->id) : NULL;

startDocument();
include($template_path . 'header.php');
?>

	<section id="body">
		<div class="body-inner">
				<h1><span class="title-icon"></span><span class="title">Pedido actual</span></h1>
				<div style="clear: both;"></div>
				<div class="body-content">
					<?php
					if ($cartItems) {
						?>
					<h2>Hay <?php echo $cartItems['pedido']->cantidad; ?> artículos en tu pedido, por un total de $ <?php echo $cartItems['pedido']->total; ?>,00</h2>
						<?php
						} else {
						?>
					<h2>No hay artículos en su pedido por el momento</h2>
						<?php
						}
						?>
						<span class="line-h">&nbsp;</span>
					
					<pre style="display: none;">
					<?php
					print_r($cartItems);
					?>
					</pre>

					<table id="pedido-actual" class="carrito" align="center" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<td class="imagen">&nbsp;</td>
								<td class="codigo">Código</td>
								<td class="articulo">Artículo</td>
								<td class="cantidad">Unidades</td>
								<td class="subtotal">Subtotal</td>
								<td class="acciones">Eliminar</td>
							</tr>
						</thead>
						<tbody>
							<?php
							if ($cartItems) {
								foreach ($cartItems['articulos'] as $article) {
								?>
								<tr>
									<td class="imagen">
										<img src="<?php echo ($article->imagenes_url != '' ? str_replace('{id}', $article->id, $article->imagenes_url) . 'thumbnail.jpg' : '/statics/images/noimage.jpg') ?>">
									</td>
									<td class="codigo"><?php echo $article->codigo; ?></td>
									<td class="articulo">
										<?php echo $article->nombre; ?><br /><br />
										<span style="font-size: 13px;">
											<strong>Surtido: </strong><span class="valor-surtido"><?php echo $article->surtido == 0 ? 'No' : 'Si'; ?></span> -
											<strong>Talles: </strong><?php echo $article->talle; ?>
											<br />
											<strong>Colores: </strong>
											<?php
											$surtido    = $article->surtido == 0 ? false : true;
											$colorsDir  = '';
											$colores    = explode(',', $article->color);

											if($article->colores_url == $article->imagenes_url) {
												?>
												<img style="margin: 0 0 -5px;" src="..<?php echo str_replace("{id}", $article->id, $article->imagenes_url); ?>colors.jpg">
												<?php
											} else {
												if($surtido) {
													$colorsDir = $relative.str_replace("{id}", $article->id, $article->colores_surtidos_url);
													if(!file_exists($colorsDir)) {
														$colorsDir = $relative.str_replace("{id}", $article->id, $article->colores_url);
													}
												} else {
													$colorsDir = $relative.str_replace("{id}", $article->id, $article->colores_url);
												}
												
												if(file_exists($colorsDir)) {
													?>
													<ul style="list-style: none; margin: 0; padding: 0; display: inline-block;">
													<?php
														foreach($colores AS $color) {
															if (!is_dir($colorsDir.$color)) {
																if(file_exists($colorsDir.$color.'.jpg')) {
																	?>
																	<li style="display: inline-block;"><span style="border-radius: 8px; border: 2px solid #ccc; height: 14px; width: 14px; display: inline-block; position: relative; bottom: -3px;"><img src="<?php echo $colorsDir.$color.'.jpg?'; ?>" style="border-radius: 7px; width: 14px;"	></span></li>
																	<?php
																} else {
																	$colorsDir = $relative.str_replace("{id}", $article->id, $article->colores_url);
																	?>
																	<li style="display: inline-block;"><span style="border-radius: 8px; border: 2px solid #ccc; height: 14px; width: 14px; display: inline-block; position: relative; bottom: -3px;"><img src="<?php echo $colorsDir.$color.'.jpg?'; ?>" style="border-radius: 7px; width: 14px;"	></span></li>
																	<?php
																}
															}
														}
													?>
													</ul>
													<?php
												} else {
													$colorsDir = $relative.str_replace("{id}", $article->id, $article->imagenes_url);
													$colors    = $colorsDir.'colors.jpg';
													
													if(file_exists($colors)) {
													?>
													<img style="margin: 0 0 -5px;" src="<?php echo $relative.str_replace("{id}", $article->id, $article->imagenes_url); ?>colors.jpg">
													<?php
													} else {
													?>
													<span>No hay colores</span>
													<?php
													}
												}
											}
											?>
										</span>
									</td>
									<td class="cantidad"><?php echo $article->cantidad; ?></td>
									<td class="subtotal">
										<div class="subtotal-wrapper">
										$ <?php echo $article->subtotal; ?>,00
										</div>
									</td>
									<td class="acciones">
										<a alt="Eliminar del pedido" title="Eliminar del pedido" class="acciones-carrito accion-eliminar" data-idpedido="<?php echo $article->id_pedido; ?>" data-itemid="<?php echo $article->id; ?>" data-pedidoid="<?php echo $cartItems['pedido']->id; ?>" data-precioitem="<?php echo $article->subtotal; ?>" data-cantidaditem="1" data-totalpedido="<?php echo $cartItems['pedido']->total; ?>" data-totalitems="<?php echo $cartItems['pedido']->cantidad; ?>">+</a>
									</td>
								</tr>
								<?php
								}
							} else {
							?>
							<tr>
								<td colspan="6" class="no-items">No hay artículos para mostrar. Comience a comprar yendo a <a href="/categorias">Precios | Pedidos</a>.</td>
							</tr>
							<?php
							}
							?>
						</tbody>
						<?php
						if ($cartItems) {
						?>
						<tfoot>
							<tr>
								<td class="total-label" colspan="4">Total</td>
								<td class="total-value" colspan="2">$ <?php echo $cartItems['pedido']->total; ?>,00</td>
							</tr>
						</tfoot>
						<?php
						}
						?>
					</table>
					<div class="cart-cmds">
						<a href="/categorias" class="cart-cmd black btn-style">Seguir Comprando</a>
						<?php
						if ($cartItems) {
							if (getCurrentUser()) {
							?>
							<a class="cart-cmd black btn-style completar-pedido" data-id="<?php echo $cartItems['pedido']->id; ?>">Finalizar Pedido</a>
							<?php
							} else {
							?>
							<a class="cart-cmd black btn-style usuario-para-completar-pedido" data-id="<?php echo $cartItems['pedido']->id; ?>">Finalizar Pedido</a>
							<?php
							}
						}
						?>
					</div>
				
<?php

include($template_path . 'footer.php');
endDocument();

?>