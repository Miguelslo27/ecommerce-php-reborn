<?php

$relative = '.';
include('./includes/common.php');

$userStats = loadUser(isset($_GET['a']) ? $_GET['a'] : false);
$appPlace = 'home';
$appSubPlace = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

?>
	<section id="body">
		<div class="body-inner">
			<div class="body-content">

<?php

	if ($userStats['user']) {

		switch($userStats['status']) {

		case 'REGISTER_SUCCESS':

			if ($appSubPlace == "register") {
				include($templatesPath . 'reg-success.php');
			}

		break;
		case 'LOGGED':

			if ($appSubPlace == "register" || $appSubPlace == "login") {
				include($templatesPath . 'justlogged.php');
			}

		break;

		}

	} else {

		switch($userStats['status']) {

		case 'NO_DATA_SETTED':

			include($templatesPath . 'reg-without-content.php');

		break;
		case 'LOGGED_OUT':

			if ($appSubPlace == "logout") {
				include($templatesPath . 'logout.php');
			}

		break;

		}

	}

	include($templatesPath . 'home/slide.php');

// section body, inner y content, se cierran en el footer
loadSection("footer", $userStats);
endDocument();

?>