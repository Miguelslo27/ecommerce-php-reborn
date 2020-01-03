
	<header>
		<div class="header-inner">
			<div class="site-nav">
				<div class="logo">
					ECOMMERCE
				</div>
			</div>

			<div class="store-nav">
				<nav class="navigation">
					<a href="/" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="home") echo 'is-active'; ?>">Home</a>
					<a href="/categorias" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="categories") echo 'is-active'; ?>">
						<span>Categorías</span>
						<div class="dropdown">
							<a class="access-menu normal-tab" href="/categorias">Test 1</a>
							<a class="access-menu normal-tab" href="/categorias">Test 2</a>
						</div>
					</a>
					<a href="/categorias" class="access-menu large-tab <?php if($GLOBALS['appPlace']=="categories") echo 'is-active'; ?>">Productos</a>
					<a href="/contacto" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="contact") echo 'is-active'; ?>">Contacto</a>
				</nav>
					
				<div class="search-box">
					<span class="fa fa-search"></span>
					<form action="/busqueda/" method="GET" style="margin: 0; padding: 0;">
						<input type="text" name="clave" class="search-input" placeholder="Qué deseas encontrar?">
					</form>
				</div>
					
				<div class="user-actions">
					<p>User access</p>
					<?php
					// $userStats = $GLOBALS['userStats'];
					// $templatesPath = $GLOBALS['config']['templatesPath'];
				
					// echo "\n<!--\n";
					// print_r($userStats);
					// echo "\n-->\n";
					
					// $revision = 'revision='.rand(1,3000);
	
					// if ($userStats['status'] == 'LOGGED') {
					// 	$userName = $userStats['user']->nombre;
					// 	include($templatesPath . 'user/logged-cmds.php');
					// } else {
					// 	include($templatesPath . 'user/not-logged-cmds.php');
					// }
					?>
				</div>
			</div>
		</div>
	</header>
	