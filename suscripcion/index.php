<?php

$relative = '..';
require '../includes/common.php';

$userStats   = array('user' => NULL, 'cart' => $pedido,  'status' => 'READY_TO_LOGIN');
$suscripcion = suscribir($_POST['email']);
$appPlace    = 'home';
$appSubPlace = 'subscription';

if (!$suscripcion) {
	header('Location: /?subscription=error');
} else {
	?>

	<script>
		localStorage.suscribeMessageViewed = 'true';
	</script>

	<?php
}

startDocument();
loadSection("header", $userStats);

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
				<h1><span class="fa fa-circle"></span> Gracias por suscribirte a nuestro boletín <span class="fa fa-circle"></span></h1>
				<h1><span class="fa fa-circle"></span> <span class="marca">Monique.com.uy</span> <span class="fa fa-circle"></span></h1>
				<script>
					setTimeout(function () {
						document.location.href = '/';
					}, 2000);
				</script>
				
<?php

loadSection("footer", $userStats);
endDocument();

?>