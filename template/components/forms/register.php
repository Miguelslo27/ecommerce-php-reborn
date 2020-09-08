<div class="inner form-register">
	<h1>Registro de Usuario</h1>
	<form action="" method="POST">
		<input type="hidden" name="id" id="id" <?php echo getCurrentUser() ? 'value="' . getCurrentUser()->id . '"' : '' ?>>
		<input type="hidden" name="type" id="type" value="user">
    <input type="hidden" name="save" id="save" value="true">
		<div class="form-group">
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" id="nombre" <?php echo getCurrentUser() ? 'value="' . getCurrentUser()->nombre . '"' : '' ?>>
			<label for="apellido" class="align-center">Apellido</label>
			<input type="text" name="apellido" id="apellido" <?php echo getCurrentUser() ? 'value="' . getCurrentUser()->apellido . '"' : '' ?>>
		</div>
		<div class="form-line">
			<label for="reg_email">E-Mail</label>
			<input type="text" name="reg_email" id="reg_email" <?php echo getCurrentUser() ? 'value="' . getCurrentUser()->email . '"' : '' ?>>
		</div>
		<div class="form-group">
			<label for="reg_pass">Contraseña</label>
			<input type="password" name="reg_pass" id="reg_pass" value="">
			<label for="pass2" class="align-center">Repetir contraseña</label>
			<input type="password" name="pass2" id="pass2" value="">
		</div>

		<div class="form-line">
			<label for="rut">RUT (opcional)</label>
			<input type="text" name="rut" id="rut" <?php echo getCurrentUser() ? 'value="' . getCurrentUser()->rut . '"' : '' ?>>
		</div>

		<div class="form-line">
			<label for="direccion">Dirección completa</label>
			<input type="text" name="direccion" id="direccion" <?php echo getCurrentUser() ? 'value="' . getCurrentUser()->direccion . '"' : '' ?>>
		</div>
		<div class="form-group">
			<label for="telefono">Teléfono</label>
			<input type="text" name="telefono" id="telefono" <?php echo getCurrentUser() ? 'value="' . getCurrentUser()->telefono . '"' : '' ?>>
			<label for="celular" class="align-center">Celular</label>
			<input type="text" name="celular" id="celular" <?php echo getCurrentUser() ? 'value="' . getCurrentUser()->celular . '"' : '' ?>>
		</div>
		<div class="form-group">
			<label for="departamento">Departamento</label>
			<input type="text" name="departamento" id="departamento"<?php echo getCurrentUser() ? 'value="' . getCurrentUser()->departamento . '"' : '' ?>>
			<label for="ciudad" class="align-center">Localidad</label>
			<input type="text" name="ciudad" id="ciudad" <?php echo getCurrentUser() ? 'value="' . getCurrentUser()->ciudad . '"' : '' ?>>
		</div>
		<div class="<?php echo getCurrentUser() ? 'form-actions' : 'form-line' ?>">
			<button type="submit"><?php echo getCurrentUser() ? 'Guardar' : 'Registrarme' ?></button>
			<?php echo getCurrentUser() ? '<button type="reset">Cancelar</button>' : '' ?>
		</div>
	</form>
</div>