<?php

$relative = '..';
require '../includes/common.php';

$userStats = loadUser();
$appPlace = 'search';
$appSubPlace = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

$resultado = buscarArticulos($_GET['clave']);

?>

	<section id="body">
		<div class="body-inner">
			<h1>Resultados de búsqueda</h1>
			<span class="line-h"></span>
			<div class="body-content">
				<?php

				if (isset($_GET['clave'])) {

				?>
				<h2>Su búsqueda para <strong>"<?php echo $_GET['clave']; ?>"</strong> devolvió los siguientes resultados</h2>
				<?php

				} else {

				?>
				<h2>No se ha especificado un parámetro de búsqueda</h2>
				<?php

				}

				include($templatesPath . 'search-result.php');

loadSection("footer", $userStats);
endDocument();

?>