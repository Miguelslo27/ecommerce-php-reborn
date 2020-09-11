<!-- <?php
$categories = getCategories(0);
$article    = getArticle();
$artid      = isset($_GET['aid']) ? $_GET['aid'] : null;
?> -->

<div class="inner form-new-article">
  <h1>Agregar Articulo</h1>
  <form action="/articulos/" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="type" id="type" value="article">
    <input type="hidden" name="id" id="id" value="<?php echo $artid ? $artid : '' ?>">
    <input type="hidden" name="save" id="save">

    <div class="form-line">
      <label class="file">
        <span>Click para cargar una imagen</span>
        <input type="file" name="imagen" id="imagen">
      </label>
    </div>
    <div class="form-line">
      <label for="nombre">Nombre</label>
      <input type="text" name="nombre" id="nombre" value="<?php echo $artid ? $article->nombre : '' ?>">
    </div>
    <div class="form-line">
      <label for="codigo">Código</label>
      <input type="text" name="codigo" id="codigo" value="<?php echo $artid ? $article->codigo : '' ?>">
    </div>
    <div class="form-line">
      <label for="descripcion_breve">Descripción breve</label>
      <input type="text" name="descripcion_breve" id="descripcion_breve" value="<?php echo $artid ? $article->descripcion_breve : '' ?>">
    </div>
    <hr>
    <div class="form-line">
      <label>Configuración</label>
      <div class="form-group">
        <label for="nuevo">Nuevo</label>
        <input type="checkbox" name="nuevo" id="nuevo" <?php echo $artid && $article->nuevo ? 'checked' : '' ?>>
        <label for="agotado">Agotado</label>
        <input type="checkbox" name="agotado" id="agotado" <?php echo $artid && $article->agotado ? 'checked' : '' ?>>
        <label for="oferta">Oferta</label>
        <input type="checkbox" name="oferta" id="oferta" <?php echo $artid && $article->oferta ? 'checked' : '' ?>>
      </div>
    </div>
    <div class="form-line">
      <label for="descripcion">Descripción</label>
      <textarea name="descripcion" id="descripcion"><?php echo $artid ? $article->descripcion : '' ?></textarea>
    </div>
    <div class="form-group">
      <label for="precio">Precio</label>
      <input type="text" name="precio" id="precio" value="<?php echo $artid ? $article->precio : '0' ?>">
      <label for="precio_oferta" class="align-center">Precio de oferta</label>
      <input type="text" name="precio_oferta" id="precio_oferta" value="<?php echo $artid ? $article->precio_oferta : '0' ?>">
    </div>
    <div class="form-group">
      <label for="categoria_id">Categoría</label>
      <select name="categoria_id" id="categoria_id">
        <option value="0" <?php echo (isset($article) && $article->id == 0) ? 'selected' : ''; ?>>-- Sin Categoría --</option>
        <?php foreach ($categories as $cat) : ?>
          <option value="<?php echo $cat->id; ?>" <?php echo (isset($article) && $article->categoria_id == $cat->id) ? 'selected' : ''; ?>><?php echo $cat->titulo; ?></option>
        <?php endforeach ?>
      </select>
      <label for="orden" class="align-center">Posición</label>
      <input type="text" name="orden" id="orden" value="<?php echo $artid ? $article->orden : '0' ?>">
    </div>
    <div class="form-actions">
      <button type="submit">Guardar</button>
      <a href="/categorias" class="button secondary">Cancelar</a>
    </div>
  </form>
</div>