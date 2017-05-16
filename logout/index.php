<?php

$relative = '..';
require '../includes/common.php';

$userStats = logout();
$appPlace = 'home';
$appSubPlace = 'logout';

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
				<h1><span class="fa fa-circle"></span> Gracias por comprar en <span class="fa fa-circle"></span> <span class="marca">Monique.com.uy</span> <span class="fa fa-circle"></span></h1>
				<!-- <span class="line-h">&nbsp;</span> -->
				<h2>¡Vuelve pronto!</h2>
				<script>
					setTimeout(function () {
						document.location.href = '/';
					}, 2000);
				</script>
				
<?php

loadSection("footer", $userStats);
endDocument();

?>