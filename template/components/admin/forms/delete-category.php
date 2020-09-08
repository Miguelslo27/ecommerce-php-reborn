<?php
$category   = getCategory();
$catid      = isset($_GET['cid']) ? $_GET['cid'] : null;
?>

<div class="inner form-delete-category">
	<h1>Estás a punto de eliminar la categoria</h1>
	<form action="/categorias/" method="POST">
	  <h3>Seguro que desea eliminar la categoría <?php echo $category->titulo ?>?</h3>
		<input type="hidden" name="type" value="category">
		<input type="hidden" name="id" id="id" <?php echo $catid ? 'value="' . $catid . '"' : '' ?>>
		<input type="hidden" name="delete" id="delete">
		<div class="form-actions">
			<button type="submit">Eliminar</button>
			<button type="reset">Cancelar</button>
		</div>
	</form>
</div>