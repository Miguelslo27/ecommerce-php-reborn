<?php
$categories = getCategories(0);
$category   = getCategory();
?>

<div class="inner form-new-article">
  <h1>Agregar Articulo</h1>
  <form action="/categorias" enctype="multipart/form-data" method="POST" id="article-create-new">
    <input type="hidden" name="type" value="article">
    <input type="hidden" name="id" id="id">
    <input type="hidden" name="save" id="save">

    <div class="form-line">
      <label class="file">
        <span>Click para cargar una imagen</span>
        <input type="file" class="input" id="imagen" name="imagen">
      </label>
    </div>
    <div class="form-line">
      <label class="file">
        <span>Click para cargar colores</span>
        <input type="file" class="input" id="colores" name="colores[]" multiple="true">
      </label>
    </div>
    <div class="form-line">
      <label for="nombre">Nombre</label>
      <input type="text" class="input" id="nombre" name="nombre">
    </div>
    <div class="form-line">
      <label for="codigo">Código</label>
      <input type="text" class="input" id="codigo" name="codigo">
    </div>
    <div class="form-line">
      <label for="descripcion_breve">Descripción breve</label>
      <input type="text" class="input" id="descripcion_breve" name="descripcion_breve">
    </div>
    <div class="form-line">
      <label>Configuración</label>
      <div class="form-group">
        <label for="nuevo">Nuevo</label>
        <input type="checkbox" id="nuevo" name="nuevo">
        <label for="agotado">Agotado</label>
        <input type="checkbox" id="agotado" name="agotado">
        <label for="oferta">Oferta</label>
        <input type="checkbox" id="oferta" name="oferta">
      </div>
    </div>
    <div class="form-line">
      <label for="descripcion">Descripción</label>
      <textarea class="input" id="descripcion" name="descripcion"></textarea>
    </div>
    <div class="form-line">
      <label for="precio">Precio</label>
      <input type="text" class="input" id="precio" name="precio" value="0">
    </div>
    <div class="form-line">
      <label for="precio_oferta">Precio de oferta</label>
      <input type="text" class="input" id="precio_oferta" name="precio_oferta" value="0">
    </div>

    <div class="form-group">
      <label for="categoria_id">Categoría</label>
      <select name="categoria_id" id="categoria_id" class="input">
        <option value="0" <?php echo ($category->id == 0) ? 'selected' : ''; ?>>-- Sin Categoría --</option>
        <?php foreach ($categories as $cat) : ?>
          <option value="<?php echo $cat->id; ?>" <?php echo ($category->id == $cat->id) ? 'selected' : ''; ?>><?php echo $cat->titulo; ?></option>
        <?php endforeach ?>
      </select>
      <label for="orden">Posición</label>
      <input type="text" class="input" id="orden" value="0" name="orden">
    </div>
    <div class="form-actions">
      <button type="submit">Guardar</button>
      <button type="reset">Cancelar</button>
    </div>
  </form>
</div>