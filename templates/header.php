<header>
	<div class="header-inner">
		<div class="site-nav">
			<div class="logo">
				ECOMMERCE
			</div>
		</div>

		<div class="store-nav">
			<nav class="navigation">
				<a href="/" class="access-menu normal-tab <?php if ($GLOBALS['appPlace'] == "home") echo 'is-active'; ?>">Home</a>
				<div class="dropdown-nav">
					<a href="/categorias" class="access-menu dropdown-tab <?php if ($GLOBALS['appPlace'] == "categories") echo 'is-active'; ?>">
						<i class="fas fa-bars"></i>
						<span>Categorías</span>
					</a>
					<div class="dropdown">
						<a class="access-menu dropdown-item" href="/categorias">Test 1</a>
						<a class="access-menu dropdown-item" href="/categorias">Test 2</a>
					</div>
				</div>
				<a href="/productos" class="access-menu normal-tab <?php if ($GLOBALS['appPlace'] == "categories") echo 'is-active'; ?>">Productos</a>
				<a href="/contacto" class="access-menu normal-tab <?php if ($GLOBALS['appPlace'] == "contact") echo 'is-active'; ?>">Contacto</a>
			</nav>

			<div class="search-box">
				<form action="/busqueda/" method="GET">
					<input type="text" name="clave" class="search-input" placeholder="Qué deseas encontrar?">
					<button type="submit" class="search-button">
						<i class="fas fa-search"></i>
					</button>
				</form>
			</div>

			<div class="user-actions">
				<?php
				$userStats     = $GLOBALS['userStats'];
				$templatesPath = $GLOBALS['config']['templatesPath'];
				$revision      = 'revision=' . rand(1, 3000);

				if ($userStats['status'] == 'LOGGED') {
					$userName = $userStats['user']->nombre;
					include($templatesPath . 'user/logged-cmds.php');
				} else {
					include($templatesPath . 'user/not-logged-cmds.php');
				}
				?>
			</div>
		</div>
	</div>
</header>