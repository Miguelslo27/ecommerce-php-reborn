<div class="form-container">
  <!-- NEW ARTICLE -->
  <?php $categories = getCategories('`status` = 1')?>
  <?php if (getQueryParam('section') === 'nuevo') : ?>
  <form class="form" action="" method="POST">
    <h2>Crear Articulo</h2>
    <input type="hidden" name="action" value="<?php bind('ACTION_HANDLE_ARTICLE') ?>">
    <div class="form-group">
      <label for="article_name">Nombre:</label>
      <input name="article_name" id="article_name" type="text" class="<?php fieldHasError('article_name', 'error') ?>"
        value="<?php getPreformData('article_name', '') ?>">
    </div>
    <div class="form-group">
      <label for="article_code">Código:</label>
      <input name="article_code" id="article_code" type="text" class="<?php fieldHasError('article_code', 'error') ?>"
        class="<?php fieldHasError('article_code', 'error') ?>" value="<?php getPreformData('article_code', '') ?>">
    </div>
    <div class="form-group">
      <label for="article_description">Descripción:</label>
      <textarea name="article_description" id="article_description" type="text"
        class="<?php fieldHasError('article_description', 'error') ?>">
          <?php getPreformData('article_description', '') ?>
        </textarea>
    </div>
    <div class="form-group">
      <label for="article_brief_description">Descripción Corta:</label>
      <textarea name="article_brief_description" id="article_brief_description" type="text"
        class="<?php fieldHasError('article_brief_description', 'error') ?>">
          <?php getPreformData('article_brief_description', '') ?>
        </textarea>
    </div>
    <div class="form-group">
      <label for="article_price">Precio:</label>
      <input name="article_price" id="article_price" type="number"
        class="<?php fieldHasError('article_price', 'error') ?>" value="<?php getPreformData('article_price', '') ?>">
    </div>
    <div class="form-group">
      <label for="article_img_url">Imagenes (URL):</label>
      <input name="article_img_url" id="article_img_url" type="text"
        class="<?php fieldHasError('article_img_url', 'error') ?>"
        value="<?php getPreformData('article_img_url', '') ?>">
    </div>
    <div class="form-group">
      <label for="article_category">Categoría Padre:</label>
      <select name="article_category" id="article_category" type="text"
        value="<?php getPreformData('article_category', '')?>" <?php empty($categories) ? bind('disabled') : '' ?>>
        <?php if (!empty($categories)) : ?>
        <option value="no-category"> - </option>
        <?php foreach ($categories as $category) : ?>
        <option value="<?php bind($category->title) ?>+<?php bind($category->id) ?>"
          <?php bind((isset($cat_parent) && $category->id == $cat_parent->id) ? 'selected' : '')?>>
          <?php bind($category->title) ?></option>
        <?php endforeach ?>
        <?php endif ?>
      </select>
    </div>
    <div class="form-checkbox-group">
      <label for="article_new">
        <input type="checkbox" name="article_new" id="article_new">
        <span>Nuevo</span>
      </label>
      <label for="article_spent">
        <input type="checkbox" name="article_spent" id="article_spent">
        <span>Agotado</span>
      </label>
      <label for="article_offer">
        <input type="checkbox" name="article_offer" id="article_offer">
        <span>En oferta</span>
      </label>
    </div>
    <div class="form-group collapsable-box closed" data-height="0">
      <label for="article_price_offer" id="article_price_offer_label" class="">Precio Oferta:</label>
      <input name="article_price_offer" id="article_price_offer" type="number"
        class="<?php fieldHasError('article_price_offer', 'error') ?>"
        value="<?php getPreformData('article_price_offer', '') ?>">
    </div>
    <div class="button-container">
      <button class="button" type="submit">
        <i class="fas fa-check"></i> Guardar
      </button>
    </div>
  </form>
  <?php endif ?>
  <?php if (getQueryParam('section') === 'lista') : ?>
  <!-- LISTA DE ARTICULOS -->


  <?php endif ?>
</div>