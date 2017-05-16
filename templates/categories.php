			<style>

			a.categoria-ofertas {
				border-radius: 15px;
			    display: block;
			    height: 28px;
			    margin: 5px auto;
			    outline: 0 none;
			    overflow: hidden;
			    text-align: center;
			    width: 170px;
			}
			a.categoria-ofertas img {
				width: 100%;
			}

			/*.categoria-ofertas a {
				background: #1c1c1c;
				color: #fff;
			    font-size: 16px !important;
			    font-weight: bold;
			    padding: 0 !important;*/
			    /*padding-top: 3px;*/
			    /*padding-left: 37px !important;*/
			    /*text-align: center;
			}
			.categoria-ofertas a span.fa {
				font-size: 14px;
			}
			.categoria-ofertas a:hover,
			.categoria-ofertas a:focus,
			.categoria-ofertas a:active {
				background: #3d3d3d !important;
			}*/

			</style>
			<div class="body-content">
				<div class="lista-categorias">

					<h1 class="titulo-pedidos" style="text-align: center">
						<!-- <span class="fa icon-snowflake"></span>
						<span class="fa fa-circle"></span> 
						Colección <strong>Otoño/Invierno</strong> 2014
						<span class="fa fa-circle"></span> 
						<span class="fa icon-snowflake"></span> -->
						<img src="/statics/images/titulo-oi.jpg" width="960px">
					</h1>

					<div class="lista-categorias-columna-izquierda">
						<ul>
							<li><a class="<?php echo ($category->id == 0) ? 'category-selected' : ''; ?>" href="/categorias">Ver todo</a></li>
						<?php
						foreach($categories as $cat) {

							?>
							<li><a href="/categorias?c=<?php echo $cat->id; ?>" class="<?php echo ($cat->titulo == $category->titulo) ? 'category-selected' : '' ?>"><?php echo $cat->titulo; ?></a></li>
							<?php

						}
						?>
							<!-- <li class="categoria-ofertas"><a href="/categorias?ofertas=1">Ofertas Monique</a></li> -->
							<!-- <li class="categoria-ofertas"><a href="/categorias?ofertas=1"><span class="fa fa-star"></span>&nbsp;&nbsp;&nbsp;Ofertas Monique&nbsp;&nbsp;&nbsp;<span class="fa fa-star"></span></a></li> -->
						</ul>
						<a class="categoria-ofertas" href="/categorias?ofertas=1"><img src="/statics/images/ofertas.jpg" alt="Ofertas Monique"></a>
					</div>

					<div class="lista-subcategorias">
						<!-- <h1><?php echo ($category->id == 0) ? $category->titulo : $category->titulo; ?></h1> -->
						<!-- <h1 style="display: none;"><img width="35px" src="/statics/images/hoja.gif" style="position: relative; bottom: -6px; margin-right: 10px;">Colección Otoño / Invierno 2014</h1> -->

						<!-- <h1 class="titulo-pedidos" style="text-align: center">
							<span class="fa icon-snowflake"></span>
							<span class="fa fa-circle"></span> 
							Colección <strong>Otoño/Invierno</strong> 2014
							<span class="fa fa-circle"></span> 
							<span class="fa icon-snowflake"></span>
							<img src="/statics/images/titulo.jpg">
						</h1> -->

						<!-- <span class="line-h">&nbsp;</span> -->
						<?php
						if ($category->descripcion_breve != '') {
						?>
						<!-- <h2><?php echo ($category->id == 0) ? $category->descripcion_breve : $category->descripcion_breve; ?></h2> -->
						<!-- <h3 style="font-size: 18px;"><a href="/" style="font-size: 18px;">Inicio</a> / <a href="/categorias/" style="font-size: 18px;">Realizar Pedido</a> / <?php echo ($category->id == 0) ? $category->titulo : $category->titulo; ?><span style="float: right"><span>Envios a todo el interior</span> <span class="fa fa-truck" style="font-size: 22px"></span></h3> -->

						<h3 class="ubicacion-de-usuario">
							<a href="/" class="ubicacion-de-usuario-boton ubicacion-de-usuario-link primero">Inicio</a>
							<a href="/categorias/" class="ubicacion-de-usuario-boton ubicacion-de-usuario-link">Precios | Pedidos</a>
							<span class="ubicacion-de-usuario-boton ultimo">
								<?php echo ($category->id == 0) ? $category->titulo : $category->titulo; ?>
							</span>
							<span class="mensaje-envios">
								<span>Envios a todo el interior</span> <span class="fa fa-truck"></span>
							</span>
						</h3>
						<!-- <span class="line-h margin-bottom"></span> -->
						<?php
						}
						if ($userStats['user'] && $userStats['user']->administrador == 1) {

							include($templatesPath . '/user/admin-cmds.php');

						}
						?>
						<?php

						foreach($category->subcategorias as $cat) {
							?>
							<!-- CATEGORIA
							<?php var_dump($cat); ?>
							-->
						<div class="item-categoria">
							<div class="item-categoria-inner">
								<div class="item-categoria-imagen">
									<?php
									$current_image_url = ($cat->imagen_url != '') ? str_replace("{id}", $cat->id, $cat->imagen_url) . "/thumbnail.jpg"  : '/statics/images/noimage.jpg';
									
									if(trim($cat->imagen_url) == '' || !file_exists($_SERVER["DOCUMENT_ROOT"].$current_image_url)) {
										$current_image_url = '/statics/images/noimage.jpg';
									}
									?>
									<a href="/categorias?c=<?php echo $cat->id; ?>"><img src="<?php echo $current_image_url.'?'.$revision; ?>"></a>
								</div>
								<?php
								if ($userStats['user'] && $userStats['user']->administrador == 1) {

									?>

									<div class="admin-category-cmds">
										<span class="admin-category-cmd cmd-edit" data-id="<?php echo $cat->id; ?>" data-titulo="<?php echo $cat->titulo; ?>" data-descripcion_breve="<?php echo $cat->descripcion_breve; ?>" data-descripcion="<?php echo $cat->descripcion; ?>" data-categoria_id="<?php echo $cat->categoria_id; ?>" data-estado="<?php echo $cat->estado; ?>" data-orden="<?php echo $cat->orden; ?>">Editar</span>
										<span class="admin-category-cmd cmd-delete" data-id="<?php echo $cat->id; ?>" data-titulo="<?php echo $cat->titulo; ?>">Eliminar</span>
									</div>

									<?php

								}
								?>
								<div class="item-categoria-titulo" style="display: none;">
									<a href="/categorias?c=<?php echo $cat->id; ?>"><?php echo $cat->titulo; ?></a>
								</div>
								<div class="item-categoria-titulo-new">
									<a href="/categorias?c=<?php echo $cat->id; ?>"><span class="fa fa-circle"></span> <?php echo $cat->titulo; ?> <span class="fa fa-circle"></span></a>
								</div>
							</div>
						</div>
							<?php

						}

						?>
						
					</div>
					<div style="clear: both;"></div>
				</div>
			</div>
