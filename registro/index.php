<?php

$relative = '..';
require '../includes/common.php';

$userStats = saveUser();
$appPlace = 'home';
$appSubPlace = 'register';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

if(!$userStats['user'] || ($userStats['user'] && isset($_GET['id']))) {
?>
	<style>
	h1 {
		border: 3px solid #1A1A1A;
	    border-radius: 20px;
	    box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.65);
	    float: left;
	    height: 40px;
	    line-height: 40px;
	    margin-left: 15px;
	    margin-top: 20px;
	    padding-left: 15px;
	}
	h1 .title-icon {
		background: #fff url(/statics/images/iconos.png) -161px -10px no-repeat;
	    border: 3px solid #000000;
	    border-radius: 35px;
	    box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.65);
	    display: inline-block;
	    height: 60px;
	    left: -30px;
	    position: relative;
	    top: -13px;
	    width: 60px;
	}
	h1 span.title {
		font-size: 24px;
	    font-weight: normal;
	    left: -18px;
	    position: relative;
	    top: -35px;
	}
	.contacto-wrap {
		box-shadow: -10px 10px 10px rgba(0,0,0,0.45);
    	/*margin-left: 25px;*/
	}
	.contacto-inn {
		box-shadow: -5px -5px 10px rgba(0, 0, 0, 0.45) inset;
		border: 1px solid #aaa;
	}
	.contacto-cont {
		/*background: url("/statics/images/espiral.png") repeat-y scroll 0 0 rgba(0, 0, 0, 0);*/
	    left: -30px;
	    margin: 40px 0;
	    padding: 0 20px 0 70px;
	    position: relative;
	    right: 0;
	    overflow: hidden;
	}
	#first-time-register-form {
		/*width: 70%;*/
	}
	.mensaje-de-error {
		display: none;
		float: none;
		margin: auto;
		width: 60%;
	}
	</style>
	<section id="body">
		<div class="body-inner">
			<div class="contacto-wrap">
				<div class="contacto-inn">
					<div class="contacto-cont">
						<div class="body-content">
							<!-- <h1>Registro de Usuario</h1> -->
							<h1><span class="title-icon"></span><span class="title">Registro de Usuario</span></h1>
							<!-- <span class="line-h">&nbsp;</span> -->
							<div style="clear: both;"></div>
							<div id="mensajes-de-error" class="mensaje-de-error" style="<?php echo ($userStats['status'] == "DUPLICATE_EMAIL" || $userStats['status'] == "EMAIL_MALFORMED" ? "display: block;" : ""); ?>">
								<p><strong><?php echo ($userStats['status'] == "DUPLICATE_EMAIL" || $userStats['status'] == "EMAIL_MALFORMED" ? "Error en el Email de registro" : "Debe completar los siguientes campos para continuar con el registro:"); ?></strong></p>
								<div class="datos-de-error">
									<?php

									// print_r($userStats);
									if($userStats['status'] == "DUPLICATE_EMAIL") {
										?>
										<p>El <b>email</b> con el que intentas registrarte ya se encuentra registrado.</p>
										<p>Prueba ingresar con tus datos, o si has olvidado tu contraseña, ve a <a href="/recuperar-clave/">recuperar contraseña</a>.</p>
										<?php
									}

									if($userStats['status'] == "EMAIL_MALFORMED") {
										?>
										<p>El <b>email</b> con el que intentas registrarte no está correctamente formado.</p>
										<p>Para que el email sea válido, debes considerar lo siguiente:
											<ul>
												<li>Debe <strong>comenzar</strong> con un <strong>caracter alfanumerico</strong> (No se permiten <strong>puntos</strong>, <strong>guiones</strong> o <strong>espacios</strong>)</li>
												<li>Puede estar formado de <strong>letras</strong>, <strong>números</strong>, <strong>puntos</strong> y <strong>guiones</strong>.</li>
												<li>Debe incondicionalmente tener la forma <strong>nombredeusuario@dominio.com</strong> (el dominio depende de su proveedor de correo electrónico)</li>
											</ul>
										</p>
										<?php
									}

									?>
								</div>
							</div>
							<form action="/registro/index.php<?php echo (isset($_GET['id']) ? '?id=' . $_GET['id'] : ''); ?>" method="POST" id="first-time-register-form">
								<?php

								if(isset($_GET['id'])) {

									?>

									<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>">

									<?php

								}

								?>

								<div class="form-line form-error">
									<span>Alguno de los datos ingresados es incorrecto!</span>
								</div>
								<div class="form-line">
									<label for="nombre">Nombre</label>
									<input type="text" class="input" data-label="Nombre" id="nombre" name="nombre" value="<?php echo ($userStats['user'] ? $userStats['user']->nombre : ''); ?>">
								</div>
								<div class="form-line">
									<label for="apellido">Apellido</label>
									<input type="text" class="input" data-label="Apellido" id="apellido" name="apellido" value="<?php echo ($userStats['user'] ? $userStats['user']->apellido : ''); ?>">
								</div>
								<div class="form-line">
									<label for="rut">RUT (opcional)</label>
									<input type="text" class="input" data-label="RUT" id="rut" name="rut" value="<?php echo ($userStats['user'] ? $userStats['user']->rut : ''); ?>">
								</div>
								<div class="form-line">
									<label for="email">E-Mail</label>
									<input type="text" class="input" data-label="email" id="E-Mail" name="email" value="<?php echo ($userStats['user'] ? $userStats['user']->email : ''); ?>">
								</div>
								<div class="form-line">
									<label for="pass">Crear contraseña</label>
									<input type="password" class="input" data-label="Contraseña" id="pass" name="pass" value="">
								</div>
								<div class="form-line">
									<label for="pass2">Repetir contraseña</label>
									<input type="password" class="input" data-label="Repetir Contraseña" id="pass2" name="pass2">
								</div>
								<div class="form-line">
									<label for="direccion">Dirección completa</label>
									<input type="text" class="input" data-label="Direccion" id="direccion" name="direccion" value="<?php echo ($userStats['user'] ? $userStats['user']->direccion : ''); ?>">
								</div>
								<div class="form-line">
									<label for="telefono">Teléfono</label>
									<input type="text" class="input" data-label="Telefono" id="telefono" name="telefono" value="<?php echo ($userStats['user'] ? $userStats['user']->telefono : ''); ?>">
								</div>
								<div class="form-line">
									<label for="celular">Celular</label>
									<input type="text" class="input" data-label="Celular" id="celular" name="celular" value="<?php echo ($userStats['user'] ? $userStats['user']->celular : ''); ?>">
								</div>
								<div class="form-line">
									<label for="departamento">Departamento</label>
									<input type="text" class="input" data-label="Departamento" id="departamento" name="departamento" value="<?php echo ($userStats['user'] ? $userStats['user']->departamento : ''); ?>">
								</div>
								<div class="form-line">
									<label for="ciudad">Localidad</label>
									<input type="text" class="input" data-label="Localidad" id="ciudad" name="ciudad" value="<?php echo ($userStats['user'] ? $userStats['user']->ciudad : ''); ?>">
								</div>
								<div class="form-line form-commands">
									<?php

									if(isset($_GET['id'])) {

									?>

									<button type="submit" class="btn bnt-login btn-style black">Guardar</button>

									<?php

									} else {

									?>

									<button type="submit" class="btn bnt-login btn-style black" id="btn-hacer-registro">Registrarme</button>

									<?php

									}

									?>
									<!-- <button type="button" class="btn bnt-login grey btn-style action-close">Cancelar</button> -->
								</div>
							</form>
						</div>
					</div>
				</div>
<?php
} else {
?>

	<style>
	.body-content h1 {
		text-align: center;
		font-size: 46px;
	}
	.body-content h1 .fa-circle {
		color: #AAAAAA;
	    font-size: 14px;
	    margin: 0 10px;
	    position: relative;
	    top: -5px;
	}
	.body-content h1 .marca {
		color: #aaa;
	}
	.body-content h2 {
		text-align: right;
		padding-right: 20px;
		font-weight: bold;
	}
	</style>
	<section id="body">
		<div class="body-inner">
			<div class="body-content">
				<h1 id="ya-registrado"><span class="fa fa-circle"></span> Ya te has registrado en <span class="fa fa-circle"></span> <span class="marca">Monique.com.uy</span> <span class="fa fa-circle"></span></h1>
				<!-- <span class="line-h">&nbsp;</span> -->
				<h2>Puedes continuar con tus pedidos</h2>
			</div>

			<script>
				setTimeout(function () {
					document.location.href = '/';
				}, 5000);
			</script>

<?php
}

loadSection("footer", $userStats);
endDocument();

?>