<?php
$category   = getCategory();
$catid      = isset($_GET['cid']) ? $_GET['cid'] : null;
?>

<div class="container category-form">
	<h2>Eliminando categoria <strong><span class="category-name"></span></strong></h2>
	<a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>

	<h3>Seguro que desea eliminar la categoría <?php echo $category->titulo ?>?</h3>
	<form action="/categorias/" method="POST">
		<input type="hidden" name="type" value="category">
		<input type="hidden" name="id" id="id" <?php echo $catid ? 'value="' . $catid . '"' : '' ?>>
		<input type="hidden" name="delete" id="delete">
		<div class="form-line form-actions">
			<button type="submit" class="btn btn-style bnt-login black">Eliminar</button>
			<button type="button" class="btn btn-style bnt-login grey action-close">Cancelar</button>
		</div>
	</form>
</div>