<?php

$relative = '..';
require '../core/common.php';

$userStats = loadUser();
$appPlace = 'catalogs';
$appSubPlace = '';

startDocument();
loadSection("header", $userStats);

?>
	<section id="body">
		<div class="body-inner">
			<div class="body-content">
				<style>
				.body-content { 
					text-align: center;
					padding-top: 0!important;
				}
				#links { display: none; }
				.blueimp-gallery-carousel {
					padding-bottom: 70%;
					margin-top: 0;
				}
				</style>
				<div id="links">

					<?php

					$directorioDelCatalogo = '../statics/images/catalogos/';
					if ($_GET['c'] == 'actual') {

						$directorioDelCatalogo .= 'actual/';

					} else {

						$directorioDelCatalogo .= 'anteriores/' . $_GET['c'];

					}

					$dir = opendir($directorioDelCatalogo);
					$imagenesDelCatalogo = array();

					?>

					<pre style="display: none;">
						<?php var_dump ($dir); ?>
						<?php var_dump ($directorioDelCatalogo); ?>
					</pre>

					<?php

					while ($imagen = readdir($dir)) {

						if (!is_dir($imagen)) {

							$imagenesDelCatalogo[] = $imagen;

						}

					}

					natcasesort($imagenesDelCatalogo);

					?>

					<pre style="display: none;">
						<?php var_dump ($imagenesDelCatalogo); ?>
					</pre>

					<?php

					foreach ($imagenesDelCatalogo as $imagen) {

						// $directorioDeLaImagen = $directorioDelCatalogo. '/' . $imagen;
						$directorioDeLaImagen = '../statics/images/catalogos/' . ($_GET['c'] == 'actual' ? 'actual/' : 'anteriores/' . rawurlencode ($_GET['c'])) . '/' . $imagen;
						?>

						<pre style="display: none;">
							<?php var_dump ($directorioDeLaImagen); ?>
						</pre>

						<?php
						?>
						<a href="<?php echo $directorioDeLaImagen; ?>"><img src="<?php echo $directorioDeLaImagen; ?>" width="965"></a>
						<?php

					}

					?>

				</div>

				<div id="blueimp-image-carousel" class="blueimp-gallery blueimp-gallery-carousel blueimp-gallery-controls">
					<div class="slides"></div>
					<h3 class="title"></h3>
					<a class="prev">‹</a>
					<a class="next">›</a>
					<a class="play-pause"></a>
					<ol class="indicator"></ol>
				</div>

<?php

loadSection("footer", $userStats);
endDocument();

?>