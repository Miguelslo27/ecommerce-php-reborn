<div class="inner form-register">
	<h1>Registro de Usuario</h1>
	<form action="" method="POST">
		<div class="form-group">
			<label for="nombre">Nombre</label>
			<input type="text" id="nombre" name="nombre">
			<label for="apellido" class="align-center">Apellido</label>
			<input type="text" id="apellido" name="apellido">
		</div>
		<div class="form-line">
			<label for="email">E-Mail</label>
			<input type="text" id="email" name="email">
		</div>
		<div class="form-group">
			<label for="pass">Contraseña</label>
			<input type="password" id="pass" name="pass">
			<label for="pass2" class="align-center">Repetir contraseña</label>
			<input type="password" id="pass2" name="pass2">
		</div>

		<div class="form-line">
			<label for="rut">RUT (opcional)</label>
			<input type="text" id="rut" name="rut" value="<?php echo (getCurrentUser() ? getCurrentUser()->rut : ''); ?>">
		</div>

		<div class="form-line">
			<label for="direccion">Dirección completa</label>
			<input type="text" id="direccion" name="direccion">
		</div>
		<div class="form-group">
			<label for="telefono">Teléfono</label>
			<input type="text" id="telefono" name="telefono">
			<label for="celular" class="align-center">Celular</label>
			<input type="text" data-label="Celular" id="celular" name="celular" value="<?php echo (getCurrentUser() ? getCurrentUser()->celular : ''); ?>">
		</div>
		<div class="form-group">
			<label for="departamento">Departamento</label>
			<input type="text" id="departamento" name="departamento">
			<label for="ciudad" class="align-center">Localidad</label>
			<input type="text" id="ciudad" name="ciudad">
		</div>
		<div class="form-line">
			<button type="submit">Registrarme</button>
		</div>
	</form>
</div>