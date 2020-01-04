			<div class="user-links navigation">
				<a href="/login" class="access-menu normal-tab">
					<i class="fa fa-user"></i>
					<span>Ingresar</span>
				</a>
				<a href="/registro" class="access-menu normal-tab">
					<i class="fa fa-user"></i>
					<span>Registrarme</span>
				</a>
				<a href="/pedido" class="access-menu normal-tab">
					<i class="fa fa-shopping-cart"></i>
					<span class="access-menu normal-tab">Mi pedido: $<?php echo $userStats['cart'] ? $userStats['cart']->cantidad : 0; ?></span>
				</a>
			</div>