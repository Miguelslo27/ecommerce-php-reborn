					<style>
					#body .body-content {
						padding: 20px 0!important;
					}
					.lista-articulos {
						width: 100%;
						float: none;
					}
					</style>
					<div class="lista-articulos">
						<span class="line-h margin-bottom"></span>
						<?php

						foreach($resultado as $art) {

						?>

						<div class="item-articulo">
							<div class="item-articulo-inner">
								<div class="item-articulo-imagen">
									<?php
									$current_image_url = ($art->imagenes_url != '') ? str_replace("{id}", $art->id, $art->imagenes_url) . "thumbnail.jpg"  : '/statics/images/noimage.jpg';
									if(trim($art->imagenes_url) == '' || !file_exists($_SERVER["DOCUMENT_ROOT"].$current_image_url)) {
										$current_image_url = '/statics/images/noimage.jpg';
									}
									?>
									<img src="<?php echo $current_image_url.'?'.$revision; ?>">
									<?php
									if ($art->oferta == 1 && $art->agotado != 1) {

									?>
									<span><img src="/statics/images/oferta.png?<?php echo $revision ?>"></span>
									<?php

									} elseif ($art->nuevo == 1 && $art->agotado != 1) {

									?>
									<span><img src="/statics/images/nuevo.png?<?php echo $revision ?>"></span>
									<?php

									} elseif ($art->agotado == 1) {
										
									?>
									<span><img src="/statics/images/agotado.png?<?php echo $revision ?>"></span>
									<?php

									}
									?>
									<?php
									if ($userStats['user'] && $userStats['user']->administrador == 1) {
	
										?>
	
										<div class="admin-article-cmds">
											<pre style="display: none;">
												<?php print_r($art); ?>
											</pre>
											<span class="admin-article-cmd cmd-edit" data-id="<?php echo $art->id; ?>" data-nombre="<?php echo $art->nombre; ?>" data-codigo="<?php echo $art->codigo; ?>" data-descripcion_breve="<?php echo $art->descripcion_breve; ?>" data-descripcion="<?php echo $art->descripcion; ?>" data-precio="<?php echo $art->precio; ?>" data-talle="<?php echo $art->talle; ?>" data-adaptable="<?php echo $art->adaptable; ?>" data-packs="<?php echo $art->packs; ?>" data-categoria_id="<?php echo $art->categoria_id; ?>" data-orden="<?php echo $art->orden; ?>" data-nuevo="<?php echo $art->nuevo; ?>" data-agotado="<?php echo $art->agotado; ?>" data-oferta="<?php echo $art->oferta; ?>" data-surtido="<?php echo $art->surtido; ?>" data-precio_oferta="<?php echo $art->precio_oferta; ?>" data-precio_surtido="<?php echo $art->precio_surtido; ?>" data-precio_oferta_surtido="<?php echo $art->precio_oferta_surtido; ?>">Editar</span>
											<span class="admin-article-cmd cmd-delete" data-id="<?php echo $art->id; ?>"  data-nombre="<?php echo $art->nombre; ?>">Eliminar</span>
										</div>
	
										<?php
	
									}
									?>
								</div>

								<div class="item-articulo-info">
									<div class="item-articulo-description-line item-articulo-nombre">
										<span class="info-value"><?php echo $art->nombre; ?></span>
									</div>
									
									<!-- Switch para Pack / Surtido -->
									<div class="item-switch-pack-surtido">
										<a class="item-switch-tab tab-pack selected" data-tab="item-articulo-info-pack">Comprar pack</a>
										<?php
										if($art->surtido == 1) {
										?>
										<a class="item-switch-tab tab-surtido" data-tab="item-articulo-info-surtido">Comprar surtido</a>
										<?php } ?>
									</div>
									
									<!-- Pack -->
									<div class="item-articulo-subinfo item-articulo-info-pack visible">
										<div class="item-articulo-description-line item-articulo-codigo">
											<span class="info-label">Artículo</span>
											<span class="info-value"><?php echo $art->codigo; ?></span>
										</div>
										<div class="item-articulo-description-line item-articulo-precio">
											<span class="info-label">Precio</span>
											<?php
											if($art->oferta == 1) {
												?>
												<span class="info-value"><span style="text-decoration: line-through; font-size: 11px; line-height: 22px;">$ <?php echo $art->precio; ?></span> <strong style="color: #7b057e;">$ <?php echo $art->precio_oferta; ?> </strong><span style="font-size: 11px; line-height: 22px;">c/u</span></span>
												<?php
											} else {
												?>
												<span class="info-value">$ <?php echo $art->precio; ?> <span style="font-size: 11px; line-height: 22px;">c/u</span></span>
												<?php
											}
											?>
										</div>
										<div class="item-articulo-description-line item-articulo-packs">
											<span class="info-label">Packs</span>
											<span class="info-value"><?php echo $art->packs; ?></span>
										</div>
										<div class="item-articulo-description-line item-articulo-talles">
											<span class="info-label">Talles</span>
											<?php
											// $talles = trim($art->talle) != '' ? str_replace(array(',', ' '), array('-', ''), $art->talle) : 'No hay talles';
											$talles = trim($art->talle) != '' ? $art->talle : 'No hay talles';
											$talles = explode(',', $talles);
											$talles = implode('-', $talles);
											?>
											<span class="info-value"><?php echo $talles ?></span>
										</div>
										<div class="item-articulo-description-line item-articulo-colores">
											<span class="info-label">Colores</span>
											<span class="info-value">
												<?php
												$colorsDir  = '..'.str_replace("{id}", $art->id, $art->colores_url);
												if($art->colores_url == $art->imagenes_url) {
													?>
													<img style="margin: -2px 0 0 -5px" src="<?php echo str_replace("{id}", $art->id, $art->imagenes_url); ?>colors.jpg">
													<?php
												} else {
													if(!is_dir($colorsDir)) {
														?>
														<img src="<?php echo str_replace("{id}", $art->id, $art->imagenes_url); ?>colors.jpg">
														<?php
													} else {
														$colorsFiles = opendir($colorsDir);
														$colorsList = array();

														if(!$colorsFiles) {
															?>
															No hay colores
															<?php
														} else {
															?>
															<ul class="lista-colores">
																<?php

																while($color = readdir($colorsFiles)) {
																	if (!is_dir($colorsDir.$color)) {
																		$colorsList[] = $color;
																	}
																}
																
																sort($colorsList);
																foreach($colorsList AS $color) {
																	$colorId = basename($colorsDir.$color, '.jpg');
																	?>
																	<li class="color"><span id="color-<?php echo $art->id; ?>-<?php echo $colorId; ?>"><img src="<?php echo $colorsDir.$color.'?r='.(rand(1,3000)); ?>"></span></li>
																	<?php
																}
																
																?>
																
															</ul>
													<?php
														}
													} // END IF readdir $colorsDir
												}
												?>
											</span>
											<div style="clear: both;"></div>
										</div>
									</div>
									
									<!-- Surtido -->
									<div class="item-articulo-subinfo item-articulo-info-surtido">
										<div class="item-articulo-description-line item-articulo-codigo">
											<span class="info-label">Artículo</span>
											<span class="info-value"><?php echo $art->codigo; ?></span>
										</div>
										<div class="item-articulo-description-line item-articulo-precio">
											<span class="info-label">Precio</span>
											<?php
											if($art->precio_surtido != "0") {
												if($art->oferta == 1 && $art->precio_oferta_surtido != "0") {
													?>
													<span class="info-value"><span style="text-decoration: line-through; font-size: 11px; line-height: 22px;">$ <?php echo $art->precio_surtido; ?></span> <strong style="color: #7b057e;">$ <?php echo $art->precio_oferta_surtido; ?> </strong></strong><span style="font-size: 11px; line-height: 22px;">c/u</span></span>
													<?php
												} else {
													?>
													<span class="info-value">$ <?php echo $art->precio_surtido; ?> <span style="font-size: 11px; line-height: 22px;">c/u</span></span>
													<?php
												}
											} else {
												if($art->oferta == 1 && $art->precio_oferta != "0") {
													?>
													<span class="info-value"><span style="text-decoration: line-through; font-size: 11px; line-height: 22px;">$ <?php echo $art->precio; ?></span> <strong style="color: #7b057e;">$ <?php echo $art->precio_oferta; ?> </strong><span style="font-size: 11px; line-height: 22px;">c/u</span></span>
													<?php
												} else {
													?>
													<span class="info-value">$ <?php echo $art->precio; ?> <span style="font-size: 11px; line-height: 22px;">c/u</span></span>
													<?php
												}
											}
											?>
										</div>
										<div class="item-articulo-description-line item-articulo-talles">
											<span class="info-label">Talle</span>
											<span class="info-value">
												<?php
												
												$talles = explode(',', $art->talle_surtido != '' ? $art->talle_surtido : $art->talle);
												
												if(trim($art->talle_surtido != '' ? $art->talle_surtido : $art->talle) != "" && count($talles)) {
													?>
													<select class="talle-select" id="talle-<?php echo $art->id ?>">
														<option value="0">Seleccionar</option>
													<?php
														foreach($talles as $talle) {
															?>
															<option value="<?php echo strtoupper(trim($talle)); ?>"><?php echo trim($talle); ?></option>
															<?php
														}
													?>
													</select>
													<?php
												} else {
													?>No hay talles<?php
												}
												
												?>
											</span>
										</div>
										<div class="item-articulo-description-line item-articulo-colores">
											<span class="info-label">Color</span>
											<span class="info-value">
												<?php
												$colorsDirAux = $art->colores_surtidos_url != '' ? (is_dir('..'.str_replace("{id}", $art->id, $art->colores_surtidos_url)) ? $art->colores_surtidos_url : $art->colores_url) : $art->colores_url;
												$colorsDir  = '..'.str_replace("{id}", $art->id, $colorsDirAux);
												?> <!-- <?php var_dump($colorsDir) ?> --> <?php
												if($colorsDirAux == $art->imagenes_url) {
													?>
													<img style="margin: -2px 0 0 -5px" src="<?php echo str_replace("{id}", $art->id, $art->imagenes_url); ?>colors.jpg?r=<?php echo (rand(1,3000)); ?>">
													<?php
												} else {
													if(!is_dir($colorsDir)) {
														?>
														<!-- Estoy acá -->
														No hay colores
														<?php
													} else {
														$colorsFiles = opendir($colorsDir);
														$colorsList = array();
														if(!$colorsFiles) {
															?>
															<!-- O acá -->
															No hay colores
															<?php
														} else {
															?>
															<ul class="lista-colores seleccionable">
																
																<?php
																
																while($color = readdir($colorsFiles)) {
																	if (!is_dir($colorsDir.$color)) {
																		$colorsList[] = $color;
																	}
																}
																
																sort($colorsList);
																foreach($colorsList AS $color) {
																	$colorId = basename($colorsDir.$color, '.jpg');
																	?>
																	<li class="color"><span id="color-<?php echo $art->id; ?>-<?php echo $colorId; ?>"><img src="<?php echo $colorsDir.$color.'?r='.(rand(1,3000)); ?>"></span></li>
																	<?php
																}
																
																?>
																
															</ul>
													<?php
														}
													} // END IF readdir $colorsDir
												}
												?>
											</span>
											<div style="clear: both;"></div>
										</div>
									</div>
										
									<div class="item-articulo-description-line item-articulo-acciones">
										<div class="accion-comprar">
											<?php

											if ($art->agotado != 1) {
										
											?>

											<label>
												Ingrese cantidad <input type="text" value="1" class="input vsmall-input packs-cantidad">
											</label>
											<a href="#" class="btn btn-style black add-to-cart" data-id="<?php echo $art->id; ?>">Agregar al pedido<span class="fa fa-shopping-cart"></span></a>

											<?php

											} else {

											?>

											<label>
												Ingrese cantidad <input type="text" value="1" disabled="true" class="input vsmall-input packs-cantidad">
											</label>
											<a href="#" class="btn btn-style grey" data-id="<?php echo $art->id; ?>">Artículo agotado<span class="fa fa-shopping-cart"></span></a>

											<?php

											}

											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php

						}

						?>
						
						<div style="clear: both"></div>
					</div>