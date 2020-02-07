<?php
$categories = getCategories(0);
$category   = getCategory();
$artid      = isset($_GET['cid']) ? $_GET['cid'] : null;
?>

<div class="inner form-new-article">
  <h1>Agregar Articulo</h1>
  <form action="/productos/" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="type" id="type" value="article">
    <input type="hidden" name="id" id="id" <?php echo $artid ? 'value="' . $artid . '"' : '' ?>>
    <input type="hidden" name="save" id="save">

    <div class="form-line">
      <label class="file">
        <span>Click para cargar una imagen</span>
        <input type="file" name="imagen" id="imagen">
      </label>
    </div>
    <div class="form-line">
      <label for="nombre">Nombre</label>
      <input type="text" name="nombre" id="nombre">
    </div>
    <div class="form-line">
      <label for="codigo">Código</label>
      <input type="text" name="codigo" id="codigo">
    </div>
    <div class="form-line">
      <label for="descripcion_breve">Descripción breve</label>
      <input type="text" name="descripcion_breve" id="descripcion_breve">
    </div>
    <hr>
    <div class="form-line">
      <label>Configuración</label>
      <div class="form-group">
        <label for="nuevo">Nuevo</label>
        <input type="checkbox" name="nuevo" id="nuevo">
        <label for="agotado">Agotado</label>
        <input type="checkbox" name="agotado" id="agotado">
        <label for="oferta">Oferta</label>
        <input type="checkbox" name="oferta" id="oferta">
      </div>
    </div>
    <div class="form-line">
      <label for="descripcion">Descripción</label>
      <textarea name="descripcion" id="descripcion"></textarea>
    </div>
    <div class="form-group">
      <label for="precio">Precio</label>
      <input type="text" name="precio" id="precio" value="0">
      <label for="precio_oferta" class="align-center">Precio de oferta</label>
      <input type="text" name="precio_oferta" id="precio_oferta" value="0">
    </div>
    <div class="form-group">
      <label for="categoria_id">Categoría</label>
      <select name="categoria_id" id="categoria_id">
        <option value="0" <?php echo ($category->id == 0) ? 'selected' : ''; ?>>-- Sin Categoría --</option>
        <?php foreach ($categories as $cat) : ?>
          <option value="<?php echo $cat->id; ?>" <?php echo ($category->id == $cat->id) ? 'selected' : ''; ?>><?php echo $cat->titulo; ?></option>
        <?php endforeach ?>
      </select>
      <label for="orden" class="align-center">Posición</label>
      <input type="text" name="orden" id="orden" value="0">
    </div>
    <div class="form-actions">
      <button type="submit">Guardar</button>
      <button type="reset">Cancelar</button>
    </div>
  </form>
</div>