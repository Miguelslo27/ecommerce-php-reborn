<?php
// /administrar-usuarios/fixdatabase.php?auth=miguelmail2006@gmail.com:buitres2
require '../includes/common.php';

function obtenerTodosLosUsuarios() {

	$db = $GLOBALS['db'];
	$sql = 'SELECT `email`, `id`, `nombre`, `apellido`, `clave`, `codigo` FROM `usuario` ORDER BY `email` ASC';

	$r = $db->getObjects($sql);

	return $r;

}

function envioEmail($nombredeusuario, $email, $clavederecuperacion) {

	$db = $GLOBALS['db'];

	$asunto = 'eCommerce - Recuperación de cuenta';

	$mensaje = ''.
	'<h2>Recuperación de su cuenta de eCommerce</h2>'.
	'<p>Estimad@ '.$nombredeusuario.', este email se ha autogenerado para reparar cuentas de usuario de eCommerce que han sido creadas incorrectamente, por lo que dichas cuentas han dejado de funcionar.</p>'.
	'<p>Su cuenta registrada con el email '.$email.' ha sido reparada, y requiere que usted modifique su clave a la brevedad, haciendo click en el link a continuación.</p>'.
	'<p><a href="/recuperar-clave/index.php?c='.$clavederecuperacion.'">Click aquí para cambiar contraseña</a></p>'.
	'<p>Si por cualquier motivo no puedes hacer click en el link anterior, copia la siguente dirección y pégala en la barra de direcciones de tu navegador</p>'.
	'<p>/recuperar-clave/index.php?c='.$clavederecuperacion.'</p>'.
	'<p>Si tiene dudas o consultas al respecto, por favor, no dude en comunicarse con nosotros al teléfono <strong>099106243</strong> o por email a <strong><a href="mailto:miguelmail2006@gmail.com">miguelmail2006@gmail.com</a></strong>.</p>'.
	'<p>Por favor sepa disculpar las molestias ocasionadas, hemos estado trabajando para mejorar la experiencia de usuario.</p>'.
	'<p>Gracias por confiar en eCommerce</p>'.
	'<p>Este correo se ha autogenerado para recuperar cuentas erroneas, si usted considera que su cuenta es correcta y puede ingresar a eCommerce con ella, entonces ignore este correo.</p>'.
	'<p>No conteste a este correo.</p>';

	$mail = new PHPMailer();

	$mail->addAddress('miguelmail2006@gmail.com', 'eCommerce');
	$mail->addAddress('esteban.leyton@hotmail.com', 'Miguel Sosa');
	$mail->addAddress('no-responder@eCommerce', 'eCommerce');
	$mail->addAddress($email, $nombredeusuario);

	$mail->setFrom('no-responder@eCommerce', 'eCommerce - Tienda Online');

	$mail->Subject = utf8_decode($asunto);
	$mail->msgHTML(utf8_decode($mensaje));

	if ($mail->send()) {

		return array('status' => 'EMAIL_SENT');

	} else {

		return array('status' => 'EMAIL_ERROR');

	}

}

if($_GET['auth'] && $_GET['auth'] == "miguelmail2006@gmail.com:buitres2") {
	
	$db = $GLOBALS['db'];
	$usuarios = obtenerTodosLosUsuarios();
	
	foreach($usuarios as $usuario) {
		if(!preg_match('/^[a-z0-9]+[a-z0-9_.-]+@[a-z0-9_.-]{3,}$/', $usuario->email)) {
			echo '--'.$usuario->email.'--'."<br />";

			// reparar
			$email = str_replace(" ", "", strtolower($usuario->email));
			echo '--'.$email.'--'."<br />";

			if(!preg_match('/^[a-z0-9]+[a-z0-9_.-]+@[a-z0-9_.-]{3,}$/', $email)) {

				// echo 'Deleted'."\n\n";

			} else {

				// chequeo si el usuario existe en otro registro
				$sql_1 = 'SELECT * FROM `usuario` WHERE `email` = "'.$email.'"';
				$exist = $db->getObject($sql_1);

				if($exist) {

					$sql_2 = 'DELETE FROM `usuario` WHERE `id` = '.$usuario->id;
					$db->insert($sql_2);

					$sql_3 = 'UPDATE `usuario` SET `clave` = "'.md5('nuevaclave'.$email).'", `codigo` = "'.md5($email).'" WHERE `id` = '.$exist->id;
					$db->insert($sql_3);

				} else {

					$sql = 'UPDATE `usuario` SET `email` = "'.$email.'", `clave` = "'.md5('nuevaclave'.$email).'", `codigo` = "'.md5($email).'" WHERE `id` = '.$usuario->id;
					$db->insert($sql);

				}

				envioEmail($usuario->nombre.' '.$usuario->apellido, $email, md5($email));
				echo 'La cuenta ha sido reparada y se ha notificado.'."<br /><br />";

				// exit;

			}
		}
	}

} else {
	echo "Acceso denegado";
}

?>