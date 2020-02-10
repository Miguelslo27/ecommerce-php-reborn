<?php

$relative = '../';
require '../core/common.php';

$userStats     = loadUser();
$page          = 'search';
$sub_page      = '';
$template_path = getTemplatePath();

startDocument();
include($template_path . 'header.php');

$resultado = searchForArticles($_GET['clave']);
$categories = getCategories(0);

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

				include($template_path . 'search-result.php');

include($template_path . 'footer.php');
endDocument();

?>