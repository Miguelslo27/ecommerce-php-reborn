<?php
$article = getArticle();
$artid   = isset($_GET['aid']) ? $_GET['aid'] : null;
?>

<div class="inner form-delete-article">
	<h1>Estás a punto de eliminar el artículo</h1>
	<form action="/articulos/" method="POST">
	  <h3>Seguro que desea eliminar el artículo <?php echo $article->nombre ?>?</h3>
		<input type="hidden" name="type" value="article">
		<input type="hidden" name="id" id="id" <?php echo $artid ? 'value="' . $artid . '"' : '' ?>>
		<input type="hidden" name="delete" id="delete">
		<div class="form-actions">
			<button type="submit">Eliminar</button>
			<button type="reset">Cancelar</button>
		</div>
	</form>
</div>