<?php

$relative = '../..';
require '../../includes/common.php';

$userStats = loadUser();
$appPlace = 'home';
$appSubPlace = 'pedido-actual';

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
		text-align: center;
		padding-right: 20px;
		font-weight: bold;
	}
	</style>
	<section id="body">
		<div class="body-inner">
			<div class="body-content">
				<h1><span class="fa fa-circle"></span>Tu pedido fue enviado con éxito<span class="fa fa-circle"></span></h1>
				<span class="line-h">&nbsp;</span>
				<br>
				<h2>Revisa tu casilla de correo, recibirás una copia de tu pedido.</h2>
				<h2>En breve te estaremos contactando para coordinar la entrega.</h2>
				<h1>¡Gracias por tu compra!</h1>
				
<?php

loadSection("footer", $userStats);
endDocument();

?>