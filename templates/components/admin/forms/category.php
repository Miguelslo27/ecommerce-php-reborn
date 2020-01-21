<?php
$categories = getCategories(0);
$category   = getCategory();
saveCategory();
?>

<div class="container category-form">
  <h2>Nueva categoría</h2>
  <a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>

  <h3>Registrar una nueva categoría</h3>
  <form action="?<?php echo $_SERVER["QUERY_STRING"] ?>" enctype="multipart/form-data" method="POST" id="category-create-new">
    <input
      type="hidden"
      name="type"
      value="category"
    >
    <input
      type="hidden"
      name="id"
      id="id"
      <?php echo $_GET['cid'] ? 'value="' . $_GET['cid'] . '"' : '' ?>
    >
    <input
      type="hidden"
      name="save"
      id="save"
    >
    <div class="form-line">
      <label for="orden">Orden</label>
      <input
        type="text"
        class="input"
        id="orden"
        value="<?php echo $_GET['cid'] ? $category->orden : '0' ?>" name="orden"
      >
    </div>
    <div class="form-line">
      <label for="titulo">Titulo</label>
      <input
        type="text"
        class="input"
        id="titulo"
        name="titulo"
        value="<?php echo $_GET['cid'] ? $category->titulo : '' ?>"
      >
    </div>
    <div class="form-line">
      <label for="descripcion_breve">Descripción breve</label>
      <input
        type="text"
        class="input"
        id="descripcion_breve"
        name="descripcion_breve"
        value="<?php echo $_GET['cid'] ? $category->descripcion_breve : '' ?>"
      >
    </div>
    <div class="form-line">
      <label for="descripcion">Descripción</label>
      <textarea
        class="input"
        id="descripcion"
        name="descripcion"
      ><?php echo $_GET['cid'] ? $category->descripcion : '' ?></textarea>
    </div>
    <div class="form-line">
      <label for="imagen">Imagen</label>
      <input
        type="file"
        class="input"
        id="imagen"
        name="imagen"
      >
    </div>
    <div class="form-line">
      <label for="categoria_id">Categoría padre</label>
      <select
        name="categoria_id"
        id="categoria_id"
        class="input">
        <option value="0" <?php echo ($category->categoria_id == 0) ? 'selected' : ''; ?>>-- No tiene padre --</option>
        <?php foreach ($categories as $cat) : ?>
          <option value="<?php echo $cat->id; ?>" <?php echo ($category->categoria_id == $cat->id) ? 'selected' : ''; ?>><?php echo $cat->titulo; ?></option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="form-line form-commands">
      <button type="submit" class="btn btn-style bnt-login black">Guardar</button>
      <button type="button" class="btn btn-style bnt-login grey action-close">Cancelar</button>
    </div>
  </form>
</div>