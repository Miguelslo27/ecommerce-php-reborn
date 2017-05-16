
	<header>
		<div class="header-inner">
			<div id="logo">
				<!-- <a href="/"><img src="/statics/images/categories/41/thumbnail.jpg" alt="Monique.com.uy"></a> -->
				<a href="/"><img src="/statics/images/logo.png" alt="Monique.com.uy"></a>
			</div>

			<!-- Begin MailChimp Signup Form -->
			<!-- <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css"> -->
			<style type="text/css">
				/*#mc_embed_signup {
					background: #fff;
					clear: left;
					width: 305px;
					margin: auto;
					transform: translate(0px, 100%);
				}
				#mc_embed_signup form {
					padding: 0;
				}
				#mc_embed_signup .mc-field-group {
					min-height: auto;
					overflow: hidden;
					width: 100%;
					padding: 0;
				}
				#mc_embed_signup .mc-field-group input {
					padding: 1px 5px;
					width: 200px;
					float: left;
					height: 32px;
					line-height: 32px;
					box-sizing: border-box;
				}
				#mc_embed_signup .mc-field-group input[type=submit] {
					clear: none;
					float: right;
					width: 100px;
					line-height: 28px;
					margin: 0;
				}*/
				/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
				   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
			</style>
			<!-- <div id="mc_embed_signup"> -->
				<!-- <form action="//appsxxi.us13.list-manage.com/subscribe/post?u=0f9e00efc0df9b9a64accf062&amp;id=95cbd68b7d" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate> -->
				    <!-- <div id="mc_embed_signup_scroll"> -->
						<!-- <h2>Subscribe to our mailing list</h2> -->
						<!-- <div class="indicates-required"><span class="asterisk">*</span> indicates required</div> -->
						<!-- <div class="mc-field-group"> -->
							<!-- <label for="mce-EMAIL">
								Email Address 
								<span class="asterisk">*</span>
							</label> -->
							<!-- <input type="email" value="" name="EMAIL" placeholder="Suscripción a Newsletter" class="required email" id="mce-EMAIL"> -->
					    	<!-- <input type="submit" value="Suscribir" name="subscribe" id="mc-embedded-subscribe" class="button"> -->
						<!-- </div> -->
						<!-- <div id="mce-responses" class="clear"> -->
							<!-- <div class="response" id="mce-error-response" style="display:none"></div> -->
							<!-- <div class="response" id="mce-success-response" style="display:none"></div> -->
						<!-- </div> -->    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
					    <!-- <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_0f9e00efc0df9b9a64accf062_95cbd68b7d" tabindex="-1" value=""></div> -->
					    <!-- <div class="clear"> -->
					    <!-- </div> -->
				    <!-- </div> -->
				<!-- </form> -->
			<!-- </div> -->
			<!-- <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='MMERGE3';ftypes[3]='text';fnames[4]='MMERGE4';ftypes[4]='text';fnames[5]='MMERGE5';ftypes[5]='text';fnames[6]='MMERGE6';ftypes[6]='text';fnames[7]='MMERGE7';ftypes[7]='text';fnames[8]='MMERGE8';ftypes[8]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script> -->
			<!--End mc_embed_signup-->

			<nav>
				<!-- <a href="/" class="access-menu is-active">Portada</a> -->
				<a href="/" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="home") echo 'is-active'; ?>">Inicio</a>
				<!-- <a href="/catalogos" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="catalogs") echo 'is-active'; ?>">Catálogos</a> -->

				<span class="dropdown-menu"><a class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="catalogs") echo 'is-active'; ?>" href="#">Catálogos</a>
					<div class="dropdown">
					    <a class="access-menu normal-tab" href="/catalogo?c=actual">Actual</a>
					    <a class="access-menu normal-tab" href="/catalogos?c=anteriores">Anteriores</a>
					</div>
				</span>

				<a href="/como-comprar" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="hoy-to-buy") echo 'is-active'; ?>">¿Cómo Comprar?</a>
				<a href="/categorias" class="access-menu large-tab <?php if($GLOBALS['appPlace']=="categories") echo 'is-active'; ?>">Precios | Pedidos</a>
				<!-- <a href="/mis-pedidos" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="online-history") echo 'is-active'; ?>">Mis Pedidos</a> -->
				<a href="/contacto" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="contact") echo 'is-active'; ?>">Contacto</a>
				<a href="https://www.facebook.com/monique.ventasxmayor" target="_blank" class="access-menu normal-tab">Seguinos <span class="fa fa-2x fa-facebook-square"></span></a>
				<div id="search-box">
					<span class="fa fa-search"></span>
					<form action="/busqueda/" method="GET" style="margin: 0; padding: 0;">
						<input type="text" name="clave" class="search-input" placeholder="Qué deseas encontrar?">
					</form>
				</div>
			</nav>
			<div id="user-cmd">
				
				<?php
			
				$userStats = $GLOBALS['userStats'];
				$templatesPath = $GLOBALS['config']['templatesPath'];
			
				echo "\n<!--\n";
				print_r($userStats);
				echo "\n-->\n";
				
				$revision = 'revision='.rand(1,3000);

				if ($userStats['status'] == 'LOGGED') {
			
					$userName = $userStats['user']->nombre;
					include($templatesPath . 'user/logged-cmds.php');
			
				} else {
			
					?>
					<div class="user-cmd-dropdown bloqueo-de-catalogo" style="text-align: center;">
				    	<div class="user-info-row">
							<!-- <h3>Acceso restringido!</h3> -->
							<a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>
							<!-- <p>Para Precios | Pedido y acceder a la lista de precios por mayor debes estar registrado</p> -->
							<br>
							<p>Para ver la lista de precios por mayor, puedes ir a <a href="/categorias">Precios | Pedidos</a>, para ello debes estar registrado.</p>
							<a href="/registro" class="btn btn-style black">Registrate</a>
						</div>
					</div>
					<?php
					
					include($templatesPath . 'user/not-logged-cmds.php');
			
				}
			
				?>
			
			</div>
		</div>
	</header>
	