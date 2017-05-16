			<!-- <a href="/" class="user-menu user-login"><span class="icon fa fa-2x fa-user"></span><span class="label">Ingresar</span></a> -->
			<div class="user-links">
				<a href="#" class="user-menu user-logged">
					<span class="icon fa fa-2x fa-user"></span>
					<span class="link-label"><?php echo $userName ?></span>
				</a>
				<?php

				if($userStats['user']->administrador == 0) {

				?>

				<a href="/pedido" class="user-menu user-cart"><span class="icon fa fa-2x fa-shopping-cart"></span><span class="link-label">Pedido (<?php echo $userStats['cart'] ? $userStats['cart']->cantidad : 0; ?>)</span></a>

				<?php

				}

				?>
			</div>
			<span class="need-help"><a href="/como-comprar">¿Necesitas ayuda con tu compra?</a></span>
			<span class="phone-numbers"><span class="icon fa fa-2x fa-phone"></span><span class="link-label">22003328 / 22098151</span></span>



			<div class="user-cmd-dropdown user-info">
				<!-- <span class="arrow-out"></span>
				<span class="arrow-in"></span> -->
				<?php
				if($userStats['user']->administrador == 0) {

				?>

				<!-- <div class="user-info-row">
					<span class="user-info-label">Pedidos:</span>
					<span class="user-info-value">0</span>
				</div> -->
				<div class="user-info-row">
					<span class="user-info-label">Pedido actual:</span>
					<span class="user-info-value">$ <?php echo $userStats['cart'] ? $userStats['cart']->total: '0'; ?>,00</span>
					<!-- $userStats['cart']->total -->
				</div>

				<?php

				}

				?>
				<div class="user-info-row user-info-cmds">
					<?php
					if($userStats['user']->administrador == 1) {

					?>
					<a href="/administrar-pedidos" class="btn btn-style btn-small black">Administrar Pedidos</a>
					<a href="/administrar-usuarios" class="btn btn-style btn-small black">Administrar Usuarios</a>
					<br><br>
					<?php

					}

					?>

					<a href="/registro?id=<?php  echo $userStats['user']->id; ?>" class="btn btn-style btn-small grey" id="logout">Mis Datos</a>
					<a href="/logout" class="btn btn-style btn-small grey" id="logout">Salir</a>
				</div>
			</div>

			<div class="user-cmd-dropdown user-cart">
				<!-- <span class="arrow-out"></span>
				<span class="arrow-in"></span> -->
				<div class="user-info-row">
					<div id="se-a-agregado-al-pedido">
						<h3>Se ha agregado el artículo <span class="articulo-agregado-al-pedido">M000</span></h3>
						<a href="/pedido" class="btn btn-style btn-small black">Ir al pedido (<span class="cantidad-articulos-pedido">0</span>)</a>
					</div>
				</div>
			</div>

			<div class="user-cmd-dropdown user-search">
				<div class="user-info-row">
					Buscar...
				</div>
			</div>