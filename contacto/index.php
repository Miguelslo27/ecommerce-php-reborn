<?php

$relative = '..';
require '../includes/common.php';

$userStats = loadUser();
$appPlace = 'contact';
$appSubPlace = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

?>
	<style>
	.body-inner {
		overflow: hidden;
	}
	.columna-1,
	.columna-2 {	
		/*width: 450px;*/
		float: left;
	}
	.columna-1 {
		width: 350px;
		margin-right: 30px;
	}
	.columna-2 {
		width: 310px;
	}
	.columna-1 p {
		line-height: 30px;
		color: #666;
	}
	.columna-1 p a {
		text-decoration: none;
	}
	.columna-1 p strong {
		color: #555;
	}
	#contact-form label {
		width: 90px;
	}
	#contact-form .input {
		width: 195px;
		float: left;
	}
	#contact-form textarea.input {
		height: 80px;
	}
	#contact-form .form-line.form-commands {
		text-align: left;
	}
	#contact-form .form-line.form-commands .btn {
		margin-left: 90px;
	}
	.line-v {
		background: none repeat scroll 0 0 #AAAAAA;
	    bottom: 20px;
	    display: block;
	    left: 485px;
	    position: absolute;
	    top: 105px;
	    width: 1px;
	}
	.contacto-wrap {
		box-shadow: -10px 10px 10px rgba(0,0,0,0.45);
    	margin-left: 25px;
	}
	.contacto-inn {
		box-shadow: -5px -5px 10px rgba(0, 0, 0, 0.45) inset;
		border: 1px solid #aaa;
	}
	.contacto-cont {
		background: url("/statics/images/espiral.png") repeat-y scroll 0 0 rgba(0, 0, 0, 0);
	    left: -30px;
	    margin: 40px 0;
	    padding: 0 100px 0 140px;
	    position: relative;
	    right: 0;
	    overflow: hidden;
	}
	.fa-facebook-square {
		font-size: 22px;
	    margin-left: 10px;
	    position: relative;
	    top: 3px;
	}
	/*.como-comprar-wrap {
		box-shadow: -10px 10px 10px rgba(0,0,0,0.45);
    	margin-left: 25px;
	}
	.como-comprar-inn {
		box-shadow: -5px -5px 10px rgba(0, 0, 0, 0.45) inset;
		border: 1px solid #aaa;
	}
	.como-comprar-cont {
		background: url("/statics/images/espiral.png") repeat-y scroll 0 0 rgba(0, 0, 0, 0);
	    left: -30px;
	    margin: 40px 0;
	    padding: 0 100px 0 140px;
	    position: relative;
	    right: 0;
	}*/
	</style>
	<section id="body">
		<div class="body-inner">
			<div class="contacto-wrap">
				<div class="contacto-inn">
					<div class="contacto-cont">
						<div class="columna-1">
							<h1>Contacto</h1>
							<!-- <span class="line-h"></span> -->
							<div class="body-content">
								<p><strong>Dirección:</strong> Arenal Grande 2380</p>
								<p><strong>Comunicate al:</strong> 2200 33 28 / 2209 81 51</p>
								<p><strong>Email:</strong> moniqueindumentaria@hotmail.com</p>
								<p><strong>Seguinos en <a class="fa fa-2x fa-facebook-square" target="_blank" href="https://www.facebook.com/monique.ventasxmayor"></a></strong></p>
							</div>
						</div>
						<!-- <span class="line-v"></span> -->
						<div class="columna-2">
							<h1>Envianos tu consulta</h1>
							<!-- <span class="line-h"></span> -->
							<div class="body-content">
								<?php
								$enviar = true;
								$errores = array();
								if (isset($_POST['submit'])) {

									if($_POST['email'] == "") {

										$enviar = false;
										$errores[] = "Tu email es obligatorio";

									}

									if($_POST['nombre'] == "") {

										$enviar = false;
										$errores[] = "Tu nombre es obligatorio";

									}

									if($_POST['asunto'] == "") {

										$enviar = false;
										$errores[] = "El asunto es obligatorio";

									}

									if($_POST['mensaje'] == "") {

										$enviar = false;
										$errores[] = "El mensaje es obligatorio";

									}

									if ($enviar) {

										$mail = new PHPMailer();

										$mail->addAddress('moniqueindumentaria@hotmail.com', 'Monique.com.uy');
										$mail->addAddress('gahecht@hotmail.com', 'Gabriela Hecht');
										// $mail->addAddress('miguelmail2006@gmail.com', 'Monique.com.uy');
										$mail->setFrom('monique@monique.com.uy', $_POST['nombre'] . ' ' . $_POST['apellido']);
										$mail->addReplyTo($_POST['email'], $_POST['nombre'] . ' ' . $_POST['apellido']);
										$mail->Subject = '(Monique.com.uy) ' . utf8_decode($_POST['asunto']);
										$mail->msgHTML(utf8_decode($_POST['mensaje']));

										if ($mail->send()) {

										?>

										<div class="mensaje-enviado">
											<p>Tu mensaje se ha enviado correctamente.</p>
											<p>Nos pondremos en contacto a la brevedad.</p>
										</div>

										<?php

										} else {

										?>

										<div class="mensaje-no-enviado">
											<p>Tu mensaje no se ha enviado!</p>
											<p>Intenta nuevamente en un momento.</p>
										</div>

										<?php

										}

									} else {

										?>

										<div class="mensaje-no-enviado">
											<p>Tu mensaje no se ha enviado!</p>
											<p>Recuerda que tu nombre, tu email, el asunto y el mensaje, son campos obligatorios.</p>
											<!-- <p>Intenta nuevamente en un momento.</p> -->
											<!-- print_r($errores); -->
										</div>

										<?php

									}

									?>

									<script>
									setTimeout(function () {
										document.location.href = "/contacto/";
									}, 5000);
									</script>

									<?php

								}

								?>
								<form action="/contacto/index.php" method="POST" id="contact-form">
									<div class="form-line">
										<label for="nombre">Nombre</label>
										<input type="text" class="input" id="nombre" name="nombre">
									</div>
									<div class="form-line">
										<label for="apellido">Apellido</label>
										<input type="text" class="input" id="apellido" name="apellido">
									</div>
									<div class="form-line">
										<label for="email">E-Mail</label>
										<input type="text" class="input" id="email" name="email">
									</div>
									<div class="form-line">
										<label for="asunto">Asunto</label>
										<input type="text" class="input" id="asunto" name="asunto">
									</div>
									<div class="form-line">
										<label for="mensaje">Mensaje</label>
										<textarea class="input" id="mensaje" name="mensaje"></textarea>
									</div>
									<div class="form-line form-commands">
										<button type="submit" name="submit" value="enviar" class="btn bnt-login black btn-style">Enviar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

<?php

loadSection("footer", $userStats);
endDocument();

?>