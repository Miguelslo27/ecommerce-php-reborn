	<div class="modal-bg"></div>
	<div class="modal-cont">
<?php

$page          = getGlobal('page');
$sub_page      = $GLOBALS['sub_page'];
$userStats     = getGlobal('user');
$template_path = getTemplatePath();

switch($userStats['status']) {
	case 'NO_USERS':
		include($template_path . 'modals/superuser-register.php');
	break;
	case 'READY_TO_LOGIN':
	case 'USER_DOESNT_EXIST':
	case 'ERROR_EMAIL_OR_PASS':
		include($template_path . 'modals/login.php');
		include($template_path . 'modals/pre-pedido-login.php');
	break;
}

switch($sub_page) {
	case 'register':
		include($template_path . 'modals/login.php');
	break;
	case 'pedido-actual':
		include($template_path . 'modals/confirmar-pedido.php');
		include($template_path . 'modals/compra-menor-al-limite.php');
	break;
}

switch($page) {
	case 'search':
	case 'categories':
		if (isAdmin()) {
			$categories = $GLOBALS['categories'];
			$category = $GLOBALS['category'];

			include($template_path . 'modals/new-category.php');
			include($template_path . 'modals/new-article.php');
			include($template_path . 'modals/delete-category.php');
			include($template_path . 'modals/delete-article.php');
		} else if (!getCurrentUser()) {
			include($template_path . 'modals/accesso-restringido.php');
		} else {
			include($template_path . 'modals/mensaje-nueva-forma-compra.php');
		}
	break;
	default:
		include($template_path.'modals/suscripcion.php');
}

?>
	</div>