<div class="inner form-login">
	<h1>Ingresar</h1>
	<form action="/" method="POST">
		<div class="form-line">
			<label for="email">E-Mail</label>
			<input type="text" class="input" id="email" name="email">
		</div>
		<div class="form-line">
			<label for="pass">Contraseña</label>
			<input type="password" class="input" id="pass" name="pass">
		</div>
		<div class="help-line align-right">
			<a href="/recuperar-clave/">He olvidado mi contraseña</a>
		</div>
		<div class="form-line">
			<label for="rememberme">
				<input type="checkbox" id="rememberme" name="rememberme" checked="true">
				Recúerdame en este equipo
			</label>
		</div>
		<div class="form-actions">
			<button type="submit">Ingresar</button>
			<button type="reset">Regresar</button>
		</div>
	</form>
	<!-- <h3>Nuevo usuario</h3>
	<form action="/registro" method="POST">
		<div class="form-line">
			<p>Registrarse en Monique.com.uy tiene muchas ventajas:</p>
			<ul>
				<li>Acceso a nuestros precios mayoristas</li>
				<li>Poder realizar pedidos desde la web</li>
				<li>Recibir ofertas y promociones exclusivas en tu email</li>
			</ul>
		</div>
		<div class="form-line form-actions">
			<a href="/registro" class="btn btn-style btn-register black">Registrarme</a>
			<a href="/" class="btn bnt-login btn-style grey action-close">Ahora no, gracias</a>
		</div>
	</form> -->
</div>