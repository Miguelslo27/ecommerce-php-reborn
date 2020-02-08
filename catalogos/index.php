<?php

$relative = '..';
require '../core/common.php';

$userStats = loadUser();
$appPlace = 'catalogs';
$appSubPlace = '';

startDocument();
include($template_path . 'header.php');

?>
	<style>
	.body-content { 
	/*	text-align: center;
		padding-top: 0!important;*/
		overflow: hidden;
		/*width: 820px;*/
		margin: auto;
	}
	.body-content h2 { 
		clear: both;
	}
	/*#links { display: none; }
	.blueimp-gallery-carousel {
		padding-bottom: 70%;
		margin-top: 0;
	}*/
	.catalogo-preview {
		border: 1px solid #888888;
	    float: left;
	    overflow: hidden;
	    padding: 10px;
	    width: 280px;
	    margin: 9px;
	}
	.catalogo-preview {
		height: 254px;
		display: inline-block;
		overflow: hidden;
	}
	.catalogo-preview img {
		width: 100%;
	}

	h1 {
		border: 3px solid #1A1A1A;
	    border-radius: 20px;
	    box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.65);
	    float: left;
	    height: 40px;
	    line-height: 40px;
	    margin-left: 15px;
	    margin-top: 20px;
	    padding-left: 15px;
	}
	h1 .title-icon {
		background: #fff url(/statics/images/iconos.png) -5px -7px no-repeat;
	    border: 3px solid #000000;
	    border-radius: 35px;
	    box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.65);
	    display: inline-block;
	    height: 60px;
	    left: -30px;
	    position: relative;
	    top: -13px;
	    width: 60px;
	}
	h1 span.title {
		font-size: 24px;
	    font-weight: normal;
	    left: -18px;
	    position: relative;
	    top: -35px;
	}
	</style>
	<section id="body">
		<div class="body-inner">
			<?php

			if (isset($_GET['c']) && $_GET['c'] == 'todos') {

			?>
			<h1>Catálogos</h1>
			<?php

			} else {

			?>
			<h1><span class="title-icon"></span><span class="title">Catálogos Anteriores</span></h1>
			<div style="clear: both;"></div>
			<?php

			}

			?>
			<div class="body-content">
				
				<?php

				if (isset($_GET['c']) && $_GET['c'] == 'todos') {

				?>

				<h2>Actual</h2>

				<?php

				$directorioActual = '../statics/images/catalogos/actual';
				$dir = opendir($directorioActual);
				$arc = readdir($dir);

				$imagenesDelCatalogo = array();

				while ($imagen = readdir($dir)) {

					if (!is_dir($imagen)) {

						$imagenesDelCatalogo[] = $imagen;

					}

				}

				natcasesort($imagenesDelCatalogo);

				$indice = 0;
				$auxImagenes = array();
				foreach ($imagenesDelCatalogo as $img) {

					$auxImagenes[$indice] = $img;
					$indice ++;

				}

				?>
				<div class="catalogo-preview">
					<a href="/catalogo?c=actual"><img src="<?php echo $directorioActual . '/' . $auxImagenes[0]; ?>"></a>
				</div>
				<br />
				<?php } ?>
				<?php

				if (isset($_GET['c']) && $_GET['c'] == 'todos') {

				?>
				<h2>Anteriores</h2>
				<?php

				}

				?>

				<?php

				$directorioAnteriores = "../statics/images/catalogos/anteriores";

				if (file_exists($directorioAnteriores)) {

					$dir = opendir($directorioAnteriores);
					$carpetasCatalogosAnteriores = array();

					while ($arc = readdir($dir)) {

						if (!is_dir($arc) && $arc != '.' && $arc != '..') {

							$carpetasCatalogosAnteriores[] = $arc;

						}

					}

					natcasesort($carpetasCatalogosAnteriores);
					$carpetasCatalogosAnteriores = array_reverse($carpetasCatalogosAnteriores);

					foreach ($carpetasCatalogosAnteriores as $carp) {

						// sino muestro el primero que encuentre
						$dir = opendir($directorioAnteriores . '/' . $carp);
						$arc = readdir($dir);

						$imagenesDelCatalogo = array();

						while ($imagen = readdir($dir)) {

							if (!is_dir($imagen)) {

								$imagenesDelCatalogo[] = $imagen;

							}

						}

						natcasesort($imagenesDelCatalogo);

						$indice = 0;
						$auxImagenes = array();

						foreach ($imagenesDelCatalogo as $img) {

							$auxImagenes[$indice] = $img;
							$indice ++;

						}

						?>
						<div class="catalogo-preview">
							<a href="/catalogo?c=<?php echo rawurlencode ($carp); ?>"><img src="<?php echo $directorioAnteriores . '/' . rawurlencode ($carp) . '/' . $auxImagenes[0]; ?>" style="box-shadow: 0 0 5px #000"></a>
							<a href="/catalogo?c=<?php echo rawurlencode ($carp); ?>" style="text-transform: capitalize; font-size: 16px; text-align: center; text-decoration: none; display: block; margin-top: 8px;">
								- <?php echo utf8_encode (preg_replace("/^[0-9]* - /", "", $carp)); ?> -
							</a>
						</div>
						<?php

					}

				}

				?>
				<br />

<?php

include($template_path . 'footer.php');
endDocument();

?>