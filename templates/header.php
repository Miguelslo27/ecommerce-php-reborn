
	<header>
		<div class="header-inner">
			<div id="logo">
				<h2>
					ECOMMERCE
				</h2>
			</div>

			<nav>
				<a href="/" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="home") echo 'is-active'; ?>">Home</a>
				<span class="dropdown-menu">
					<a href="/categorias" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="categories") echo 'is-active'; ?>">Categorías</a>
					<div class="dropdown">
					    <a class="access-menu normal-tab" href="/categorias">Test 1</a>
					    <a class="access-menu normal-tab" href="/catalogos">Test 2</a>
					</div>
				</span>
				<a href="/categorias" class="access-menu large-tab <?php if($GLOBALS['appPlace']=="categories") echo 'is-active'; ?>">Productos</a>
				<a href="/contacto" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="contact") echo 'is-active'; ?>">Contacto</a>
				
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
							<a href="#" class="modal-close action-close">
								<span class="modal-close-left"></span><span class="modal-close-right"></span>
							</a>
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
	