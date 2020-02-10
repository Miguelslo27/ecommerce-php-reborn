<div class="inner form-login">
	<h1>Ingresar</h1>
	<form action="/login/" method="POST">
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
			<span>|</span>
			<a href="/registro/">Soy nuevo, deseo registrarme</a>
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
</div>