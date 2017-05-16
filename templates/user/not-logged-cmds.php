			<!-- <a href="/" class="user-menu user-login"><span class="icon fa fa-2x fa-user"></span><span class="label">Ingresar</span></a> -->
			<div class="user-links">
				<a href="#" class="user-menu user-login">
					<span class="icon fa fa-2x fa-user"></span>
					<span class="link-label">INGRESAR</span>
				</a>
				<span class="link-label">/</span>
				<a href="/registro"><span class="link-label">REGISTRATE</span></a>
				<a href="/pedido" class="user-menu user-cart"><span class="icon fa fa-2x fa-shopping-cart"></span><span class="link-label">Pedido (<?php echo $userStats['cart'] ? $userStats['cart']->cantidad : 0; ?>)</span></a>
			</div>
		    <span class="need-help"><a href="/como-comprar">¿Necesitas ayuda con tu compra?</a></span>
		    <span class="phone-numbers"><span class="icon fa fa-2x fa-phone"></span><span class="link-label">22003328 / 22098151</span></span>

		    <div class="user-cmd-dropdown user-not-logged-message">
		    	<div class="user-info-row">
					<h3>Acceso restringido!</h3>
					<a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>
					<p>Para realizar pedidos y acceder a la lista de precios por mayor debes estar registrado</p>
					<a href="/registro" class="btn btn-style black">Registrate</a>
				</div>
			</div>