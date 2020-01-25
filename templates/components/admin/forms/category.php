<?php
$categories = getCategories(0);
$category   = getCategory();
$catid      = isset($_GET['cid']) ? $_GET['cid'] : null;
?>

<div class="inner form-new-category">
  <h1>Agregar Categoría</h1>
  <form action="/categorias/" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="type" value="category">
    <input type="hidden" name="id" id="id" <?php echo $catid ? 'value="' . $catid . '"' : '' ?>>
    <input type="hidden" name="save" id="save">
    <div class="form-line">
      <label class="file">
        <span>Click para cargar una imagen</span>
        <input type="file" class="input" id="imagen" name="imagen">
      </label>
    </div>
    <div class="form-line">
      <label for="titulo">Titulo</label>
      <input type="text" class="input" id="titulo" name="titulo" value="<?php echo $catid ? $category->titulo : '' ?>">
    </div>
    <div class="form-line">
      <label for="descripcion_breve">Descripción breve</label>
      <input type="text" class="input" id="descripcion_breve" name="descripcion_breve" value="<?php echo $catid ? $category->descripcion_breve : '' ?>">
    </div>
    <hr>
    <div class="form-line">
      <label for="descripcion">Descripción</label>
      <textarea class="input" id="descripcion" name="descripcion"><?php echo $catid ? $category->descripcion : '' ?></textarea>
    </div>
    <div class="form-group">
      <label for="categoria_id">Categoría padre</label>
      <select name="categoria_id" id="categoria_id" class="input">
        <option value="0" <?php echo ($category->categoria_id == 0) ? 'selected' : ''; ?>>-- No tiene padre --</option>
        <?php foreach ($categories as $cat) : ?>
          <option value="<?php echo $cat->id; ?>" <?php echo ($category->categoria_id == $cat->id) ? 'selected' : ''; ?>><?php echo $cat->titulo; ?></option>
        <?php endforeach ?>
      </select>
      <label for="orden">Posición</label>
      <input type="number" class="input" id="orden" value="<?php echo $catid ? $category->orden : '0' ?>" name="orden">
    </div>
    <div class="form-actions">
      <button type="submit">Guardar</button>
      <button type="reset">Cancelar</button>
    </div>
  </form>
</div>