<div class="form-container">
  <!-- LIST CATEGORIES / DELETED CATEGORIES -->
  <?php if ((getGlobal('section') === 'lista' || getGlobal('section') === 'eliminadas') && getGlobal('action') === null) : ?>
    <div class="form big-form" data-success="" id="list-categories">
      <?php if (getGlobal('section') === 'lista') : ?>
        <?php $categories = getCategories('`status` = 1'); ?>
        <h2>Categorias</h2>
      <?php else : ?>
        <?php $categories = getCategories('`status` = 0'); ?>
        <h2>Categorias Eliminadas</h2>
      <?php endif ?>
      <?php if (@count($categories) > 0) : ?>
        <div class="table-row text-center">
          <div class="cell cat-id"><b>ID</b></div>
          <div class="cell cat-title"><b>Titulo</b></div>
          <div class="cell cat-dscp"><b>Descripcion</b></div>
          <div class="cell cat-b-dscp"><b>Descripcion Corta</b></div>
          <div class="cell cat-url"><b>Imagen</b></div>
          <div class="cell cat-parent"><b>Categoria Padre</b></div>
        </div>
        <?php for ($i = 0; $i < @count($categories); $i++) : ?>
          <div class="table-row <?php bind(($i % 2 === 0) ? 'background' : '') ?>">
            <div class="cell cat-id">
              <p><?php bind($categories[$i]->id) ?></p>
            </div>
            <div class="cell cat-title">
              <p><?php bind($categories[$i]->title) ?></p>
            </div>
            <div class="cell cat-dscp">
              <p>
                <p><?php bind($categories[$i]->description) ?></p>
              </p>
            </div>
            <div class="cell cat-b-dscp">
              <p><?php bind($categories[$i]->brief_description) ?></p>
            </div>
            <div class="cell cat-url">
              <p><?php bind($categories[$i]->images_url) ?></p>
            </div>
            <?php if ($categories[$i]->category_id === '0') : ?>
              <div class="cell cat-parent">-</div>
            <?php else : ?>
              <div class="cell cat-parent">
                <p><?php bind($categories[$i]->category_id) ?></p>
              </div>
            <?php endif ?>
            <?php if (getGlobal('section') === 'lista') : ?>
              <div class="actions list-admin-buttons">
                <a href="/admin/categorias/?cid=lista&action=edit&id=<?php bind($categories[$i]->id) ?>"><i class="fas fa-edit"></i> Editar</a>
                <a class="remove-button remove-category-button" data-action="<?php bind(ACTION_REMOVE_CATEGORY) ?>" data-type="remove-category" data-id="<?php bind($categories[$i]->id)?>"><i class="fas fa-trash-alt"></i> Eliminar</a>
              </div>
              <?php else : ?>
                <div class="actions list-admin-buttons">
                <a class="restore-button restore-category-button" data-action="<?php bind(ACTION_RESTORE_CATEGORY) ?>" data-type="restore-category" data-id="<?php bind($categories[$i]->id)?>"><i class="fas fa-trash-restore"></i> Restaurar</a>
              </div>
            <?php endif ?>
          </div>
        <?php endfor ?>
      <?php else : ?>
        <h5 class="text-not-elements">De momento no hay categorias.</h5>
      <?php endif ?>
    </div>
  <?php endif ?>
  <!-- NEW / EDIT CATEGORY -->
  <?php if (getGlobal('section') === 'nueva' || getGlobal('action') === 'edit') : ?>
    <form class="form" action="" method="POST" id="category-form">
      <?php if (getGlobal('action') === 'edit') : ?>
        <?php $current_category = getCategoryById(getGlobal('id'));
              $current_category_children = getCategoriesByParentId(getGlobal('id'));
              $cat_parent = getCategoryById($current_category->category_id);
              $cat_parent_value = $current_category->category_id === '0' ? "" : "$cat_parent->title+$cat_parent->id";
              $parentCategories = getCategories("`category_id` = 0 AND `status` = 1 AND `id` != $current_category->id");?>
        <input type="hidden" name="category_id" value="<?php bind($current_category->id) ?>">
        <h2>Editar Categoría</h2>
      <?php else : ?>
        <?php $cat_parent = null;
              $current_category = null;
              $parentCategories = getCategories('`category_id` = 0 AND `status` = 1'); ?>
        <h2>Crear Categoría</h2>
      <?php endif ?>
      <input type="hidden" name="action" value="<?php bind(ACTION_HANDLE_CATEGORY) ?>">
      <input type="hidden" name="button-action" id="button-action" value="">
      <div class="form-group">
        <label for="category_title">Titulo:</label>
        <input name="category_title" id="category_title" type="text" class="<?php fieldHasError('category_title', 'error') ?>" value="<?php getGlobal('action') === 'edit' ? bind(oneOf(getPreformData('category_title', ''), $current_category->title)) : bind(getPreformData('category_title', '')) ?>">
      </div>
      <div class="form-group">
        <label for="category_description">Descripción:</label>
        <textarea name="category_description" id="category_description" type="text" class="<?php fieldHasError('category_description', 'error') ?>"><?php getGlobal('action') === 'edit' ? bind(oneOf(getPreformData('category_description', ''), $current_category->description)) : bind(getPreformData('category_description', '')) ?></textarea>
      </div>
      <div class="form-group">
        <label for="category_brief_description">Descripción Corta:</label>
        <textarea name="category_brief_description" id="category_brief_description" type="text" class="<?php fieldHasError('category_brief_description', 'error') ?>"><?php getGlobal('action') === 'edit' ? bind(oneOf(getPreformData('category_brief_description', ''), $current_category->brief_description)) : bind(getPreformData('category_brief_description', '')) ?></textarea>
      </div>
      <div class="form-group">
        <label for="category_img_url">Imagenes (URL):</label>
        <input name="category_img_url" id="category_img_url" type="text" class="<?php fieldHasError('category_img_url', 'error') ?>" value="<?php getGlobal('action') === 'edit' ? bind(oneOf(getPreformData('category_img_url', ''), $current_category->images_url)) : bind(getPreformData('category_img_url', '')) ?>">
      </div>
      <div class="form-group">
        <label for="category_parent">Categoría Padre:</label>
        <select name="category_parent" id="category_parent" type="text" value="<?php getGlobal('action') === 'edit' ? bind(oneOf(getPreformData('category_parent', ''), $cat_parent_value)) : bind(getPreformData('category_parent', '')) ?>" <?php empty($parentCategories) || (isset($current_category_children) && !empty($current_category_children)) ? bind('disabled') : '' ?>>
          <?php if (!empty($parentCategories)) : ?>
            <option value="no-category"> - </option>
            <?php foreach ($parentCategories as $category) : ?>
              <option value="<?php bind($category->title) ?>+<?php bind($category->id) ?>" <?php bind((isset($cat_parent) && $category->id == $cat_parent->id) ? 'selected' : '')?>><?php bind($category->title) ?></option>
            <?php endforeach ?>
          <?php endif ?>
        </select>
        <?php if (isset($current_category_children) && !empty($current_category_children)) : ?>
          <div class="explanation-container">
            <small>Esta categoría no puede contener categoría padre porque tiene categorías hijas.</small>
          </div>
        <?php endif ?>
      </div>
      <?php if (getGlobal('action') === 'edit') : ?>
        <div class="button-container">
          <button class="button" type="submit">
            <i class="fas fa-check"></i> Guardar
          </button>
        </div>
      <?php else : ?>
        <div class="button-container multiple-buttons">
          <button class="button" type="submit">
            <i class="fas fa-check"></i> Guardar
          </button>
          <button class="button button-secondary" data-success="<?php bind(!empty(getSession('request_messages')) ? getSession('request_messages')->succeeded : "")?>" id="category-button-secondary" type="submit">
            <i class="fas fa-check"></i> Guardar y crear otra
          </button>
        </div>
      <?php endif ?>
    </form>
  <?php endif ?>
</div>