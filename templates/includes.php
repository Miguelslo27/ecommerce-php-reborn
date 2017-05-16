<?php
$appPlace    = $GLOBALS['appPlace'];
$appSubPlace = $GLOBALS['appSubPlace'];
$userStats   = $GLOBALS['userStats'];
$revision    = 'revision='.rand(1,3000);

switch($place) {

case 'head':
?>

	<meta charset="UTF-8">
	
	<meta http-equiv=”Expires” content=”0″>
	<meta http-equiv=”Last-Modified” content=”0″>
	<meta http-equiv=”Cache-Control” content=”no-cache, mustrevalidate”>
	<meta http-equiv=”Pragma” content=”no-cache”>
	
	<title>Monique.com.uy | Portada</title>

	<!--[if lt IE 9]>
	<script type="text/javascript">
		document.createElement("nav");
		document.createElement("header");
		document.createElement("footer");
		document.createElement("section");
		document.createElement("article");
		document.createElement("aside");
		document.createElement("hgroup");
	</script>
	<![endif]-->

	<!-- css -->
	<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Muli'>
	<link rel="stylesheet" href="/statics/css/layout.css?<?php echo $revision; ?>">
	<link rel="stylesheet" href="/statics/css/frameworks/fontawesome/font-awesome.min.css?<?php echo $revision; ?>">
	<link rel="stylesheet" href="/statics/css/fontsaddict.css?<?php echo $revision; ?>">
	<link rel="stylesheet" href="/statics/css/blueimp-gallery.min.css?<?php echo $revision; ?>">
	
	<?php
	
	switch($appPlace) {

	case 'home':
	?>

	<!-- home css -->
	<link rel="stylesheet" href="/statics/css/home.css?<?php echo $revision; ?>">
		
	<?php
	break;
	case 'search':
	case 'categories':
	?>

	<!-- home css -->
	<link rel="stylesheet" href="/statics/css/categories.css?<?php echo $revision; ?>">
		
	<?php
	break;

	}

	// estilos que solo se usaran en paginas de administrador
	if (@$userStats['user']->administrador == 1) {
	?>

	<link rel="stylesheet" href="/statics/css/administrador.css?<?php echo $revision; ?>">

	<?php
	}

	?>

<?php
break;

case 'body-end':
?>
	
	<!-- plugin scripts -->
	<script src="/statics/js/plugins/jquery-1.11.0.js?<?php echo $revision; ?>"></script>
	<script src="/statics/js/plugins/backstretch.js?<?php echo $revision; ?>"></script>
	<script src="/statics/js/generals.js?<?php echo $revision; ?>"></script>

	<?php
	
	switch($appPlace) {

	case 'home':
	?>

	<!-- site scripts -->
	<script src="/statics/js/home.js?<?php echo $revision; ?>"></script>
		
	<?php

	break;
	case 'search':
	case 'categories':
	?>

	<!-- site scripts -->
	<script src="/statics/js/categorias.js?<?php echo $revision; ?>"></script>
		
	<?php

	break;

	case 'catalogs':
	?>

	<script src="/statics/js/jquery.blueimp-gallery.min.js?<?php echo $revision; ?>"></script>
	<script>
	var catalogo = blueimp.Gallery(document.getElementById('links').getElementsByTagName('a'), {
		container: '#blueimp-image-carousel',
		carousel: true,
	});

	</script>
		
	<?php

	break;

	}

	switch($appSubPlace) {

		case 'pedido-actual':

		?>

		<script src="/statics/js/carrito.js?<?php echo $revision; ?>"></script>

		<?php

		break;

		case 'register':

		?>

		<script>

		if ($("#ya-registrado").length) {

			$(".user-cmd-dropdown.bloqueo-de-catalogo")
				.fadeIn();

		}

		$("#btn-hacer-registro").on("click", function (e) {

			e.preventDefault();

			var $form = $("#first-time-register-form");
			var $formElements = $form.find("input");
			var $errorsTemp = $("#mensajes-de-error");
			var enviar = true;
			var errors = [];
			var errorsHTML = "";

			$formElements.each(function (index, element) {

				var elName = $(element).data("label");
				if (elName.toLowerCase() != "rut" && elName.toLowerCase() != "telefono" && elName.toLowerCase() != "celular") {

					if ($(element).val() == "") {

						enviar = false;
						errors.push("El campo <b>" + elName + "</b> es obligatorio");

					}

				}

			});

			if ($("#pass").val() != $("#pass2").val()) {

				enviar = false;
				errors.push("<b>Contraseña</b> y <b>Repetir Contraseña</b> deben ser idénticas.");
				errors.push("Ha introducido <b>claves</b> diferentes para su cuenta, vuelva a escribir e intente nuevamente.");

			}

			if ($("#telefono").val() == "" && $("#celular").val() == "") {

				enviar = false;
				errors.push("Un <b>Teléfono</b> o <b>Celular</b> es requerido.");
				errors.push("Debe completar al menos uno de los números telefónicos.");

			}

			if (enviar) {

				$form.submit();

			} else {

				errorsHTML = "<p>" + errors.join("</p></p>") + "</p>";
				$errorsTemp
					.find(".datos-de-error")
					.html(errorsHTML);
				$errorsTemp.fadeIn();

			}

		});
		</script>

		<?php

		break;

	}

	// scripts que solo se usaran en paginas de administrador
	if (@$userStats['user']->administrador == 1) {
	?>

	<script src="/statics/js/administrador.js?<?php echo $revision; ?>"></script>

	<?php
	}

	?>

<?php
break;

}
?>