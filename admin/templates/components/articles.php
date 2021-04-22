<div class="form-container">
  <!-- NEW ARTICLE -->
  <?php $categories = getCategories('`status` = 1') ?>
  <?php if (getQueryParam('section') === 'nuevo' || getQueryParam('section') === 'editar') : ?>
  <form class="form" action="" method="POST">
    <?php if (getGlobal('section') === 'nuevo') : ?>
    <h2>Crear Articulo</h2>
    <?php else : ?>
    <h2>Editar Articulo</h2>
    <?php endif ?>
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
        value="<?php getPreformData('article_category', '') ?>" <?php empty($categories) ? bind('disabled') : '' ?>>
        <?php if (!empty($categories)) : ?>
        <option value="no-category"> - </option>
        <?php foreach ($categories as $category) : ?>
        <option value="<?php bind($category->title) ?>+<?php bind($category->id) ?>"
          <?php bind((isset($cat_parent) && $category->id == $cat_parent->id) ? 'selected' : '') ?>>
          <?php bind($category->title) ?></option>
        <?php endforeach ?>
        <?php endif ?>
      </select>
    </div>
    <div class="form-checkbox-group">
      <label for="article_new">
        <input type="checkbox" name="article_new" id="article_new"
        <?php bind($current_article->new == 1 ? 'checked' : '') ?>>
        <span>Nuevo</span>
      </label>
      <label for="article_spent">
        <input type="checkbox" name="article_spent" id="article_spent">
        <?php bind($current_article->spent == 1 ? 'checked' : '') ?>
        <span>Agotado</span>
      </label>
      <label for="article_offer">
        <input type="checkbox" name="article_offer" id="article_offer">
        <?php bind($current_article->offer == 1 ? 'checked' : '') ?>
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
  <div class="form big-form" id="list-articles">
    <h2>Lista De Articulos</h2>
    <div class="table-row text-center">
      <div class="cell article-url"><b>Imagen</b></div>
      <div class="cell article-name"><b>Nombre</b></div>
      <div class="cell article-code"><b>Código</b></div>
      <div class="cell article-b-dscp"><b>Descripcion Corta</b></div>
      <div class="cell article-price"><b>Precio $</b></div>
      <div class="cell article-new"><b>Nuevo</b></div>
      <div class="cell article-parent"><b>Categoria</b></div>
    </div>
    <?php $articles = getArticles('`status` = 1'); ?>
    <?php logToConsole('Count articles', count($articles)) ?>

    <?php for ($a = 0; $a < @count($articles); $a++) : ?>
    <div class="table-row <?php bind(($a % 2 === 0) ? 'background' : '') ?>">

      <div class="cell article-url">
        <img href="<?php bind($articles[$a]->images_url) ?>">
      </div>
      <div class="cell article-name">
        <?php bind($articles[$a]->name) ?>
      </div>
      <div class="cell article-code">
        <?php bind($articles[$a]->code) ?>
      </div>
      <div class="cell article-b-dscp">
        <?php bind($articles[$a]->brief_description) ?></p>
      </div>
      <div class="cell article-price">
        <?php if ($articles[$a]->price_offer !== '0') : ?>
        <span class="price-offer">
          $<?php bind($articles[$a]->price_offer) ?>
        </span>
        <?php endif ?>
        <span class="price <?php bind($articles[$a]->price_offer !== "0" ? 'line-through' : '') ?>">
          $<?php bind($articles[$a]->price) ?>
        </span>
      </div>
      <div class="cell article-new">
        <?php if ($articles[$a]->new !== '0') : ?>
        <?php bind($articles[$a]->new !== "0" ? 'Si' : '')?>
        <?php endif ?>
      </div>

      <div class="cell article-parent">
        <?php $category = getCategoryById($articles[$a]->category_id);?>
        <?php bind(oneOf(@$category->title, '')) ?>
      </div>

      <?php if (getQueryParam('section') === 'lista') : ?>
      <div class="actions list-admin-buttons">
        <a href="/admin/articulos/?section=editar&aid=<?php bind($articles[$a]->id) ?>"><i class="fas fa-edit"></i>
          Editar</a>
        <a class="remove-button " data-action="<?php bind(ACTION_REMOVE_ARTICLE) ?>" data-type="remove-article"
          data-id="<?php bind($articles[$a]->code)?>"><i class="fas fa-trash-alt"></i>
          Eliminar</a>
      </div>
      <?php else : ?>
      <div class="actions list-admin-buttons">
        <a class="restore-button" data-action="<?php bind(ACTION_RESTORE_ARTICLE) ?>" data-type="restore-article"
          data-id="<?php bind($articles[$a]->code)?>"><i class="fas fa-trash-restore"></i>
          Restaurar</a>
      </div>
      <?php endif ?>

    </div>
    <?php endfor ?>
  </div>
  <?php endif ?>

  <div class="form-container form-xl">
    <div class="form-container">
      <!-- DELETED ARTICLES -->
      <?php if (getGlobal('section') === 'eliminados' && getGlobal('action') === null) : ?>
      <div class="form big-form" data-success="" id="list-articles">
        <?php $articles = getArticles('`status` = 0'); ?>
        <h2>Articulos Eliminados</h2>
        <?php if (@count($articles) > 0) : ?>
        <div class="table-row text-center">
          <div class="cell article-name"><b>Nombre</b></div>
          <div class="cell article-code"><b>Código</b></div>
          <div class="cell article-b-dscp"><b>Descripcion Corta</b></div>
          <div class="cell article-price"><b>Precio</b></div>
          <div class="cell article-offer-price"><b>Precio Oferta</b></div>
          <div class="cell article-new"><b>Nuevo</b></div>
          <div class="cell article-spent"><b>Agotado</b></div>
          <div class="cell article-offer"><b>Oferta</b></div>
          <div class="cell article-url"><b>Imagen</b></div>
          <div class="cell article-parent"><b>Categoria</b></div>
        </div>
        <?php for ($i = 0; $i < @count($articles); $i++) : ?>
        <div class="table-row <?php bind(($i % 2 === 0) ? 'background' : '') ?>">
          <div class="cell article-name">
            <p><?php bind($articles[$i]->name) ?></p>
          </div>
          <div class="cell article-code">
            <p><?php bind($articles[$i]->code) ?></p>
          </div>
          <div class="cell article-b-dscp">
            <p><?php bind($articles[$i]->brief_description) ?></p>
          </div>
          <div class="cell article-price">
            <p>$<?php bind($articles[$i]->price) ?></p>
          </div>
          <div class="cell article-offer-price">
            <p>
              <?php if ($articles[$i]->price_offer === '0') : ?>
              -
              <?php else : ?>
              $<?php bind($articles[$i]->price_offer) ?>
              <?php endif ?>
            </p>
          </div>
          <div class="cell article-new">
            <p>
              <?php if ($articles[$i]->new === '1') : ?>
              <i class="fas fa-check"></i>
              <?php else : ?>
              <i class="fas fa-times"></i>
              <?php endif ?>
            </p>
          </div>
          <div class="cell article-spent">
            <p>
              <?php if ($articles[$i]->spent === '1') : ?>
              <i class="fas fa-check"></i>
              <?php else : ?>
              <i class="fas fa-times"></i>
              <?php endif ?>
            </p>
          </div>
          <div class="cell article-offer">
            <p>
              <?php if ($articles[$i]->offer === '1') : ?>
              <i class="fas fa-check"></i>
              <?php else : ?>
              <i class="fas fa-times"></i>
              <?php endif ?>
            </p>
          </div>
          <div class="cell article-url">
            <p><?php bind($articles[$i]->images_url) ?></p>
          </div>
          <?php if ($articles[$i]->category_id === '0') : ?>
          <div class="cell article-parent">-</div>
          <?php else : ?>
          <div class="cell article-parent">
            <p><?php bind($articles[$i]->category_id) ?></p>
          </div>
          <?php endif ?>
          <div class="actions list-admin-buttons">
            <a class="restore-button restore-article-button" data-action="<?php bind(ACTION_RESTORE_ARTICLE) ?>"
              data-type="restore-article" data-id="<?php bind($articles[$i]->id) ?>"><i
                class="fas fa-trash-restore"></i>
              Restaurar</a>
          </div>
        </div>
        <?php endfor ?>
        <?php else : ?>
        <h5 class="text-not-elements">De momento no hay articulos eliminados.</h5>
        <?php endif ?>
      </div>
      <?php endif ?>
      <!-- NEW ARTICLE -->
      <?php $categories = getCategories('`status` = 1') ?>
      <?php if (getGlobal('section') === 'nuevo') : ?>
      <form class="form" action="" method="POST">
        <h2>Crear Articulo</h2>
        <input type="hidden" name="action" value="<?php bind(ACTION_HANDLE_ARTICLE) ?>">
        <div class="form-group">
          <label for="article_name">Nombre:</label>
          <input name="article_name" id="article_name" type="text"
            class="<?php fieldHasError('article_name', 'error') ?>" value="<?php getPreformData('article_name', '') ?>">
        </div>
        <div class="form-group">
          <label for="article_code">Código:</label>
          <input name="article_code" id="article_code" type="text"
            class="<?php fieldHasError('article_code', 'error') ?>"
            class="<?php fieldHasError('article_code', 'error') ?>" value="<?php getPreformData('article_code', '') ?>">
        </div>
        <div class="form-group">
          <label for="article_description">Descripción:</label>
          <textarea name="article_description" id="article_description" type="text"
            class="<?php fieldHasError('article_description', 'error') ?>"><?php getPreformData('article_description', '') ?></textarea>
        </div>
        <div class="form-group">
          <label for="article_brief_description">Descripción Corta:</label>
          <textarea name="article_brief_description" id="article_brief_description" type="text"
            class="<?php fieldHasError('article_brief_description', 'error') ?>"><?php getPreformData('article_brief_description', '') ?></textarea>
        </div>
        <div class="form-group">
          <label for="article_price">Precio:</label>
          <input name="article_price" id="article_price" type="number"
            class="<?php fieldHasError('article_price', 'error') ?>"
            value="<?php getPreformData('article_price', '') ?>">
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
            value="<?php getPreformData('article_category', '') ?>" <?php empty($categories) ? bind('disabled') : '' ?>>
            <?php if (!empty($categories)) : ?>
            <option value="no-category"> - </option>
            <?php foreach ($categories as $category) : ?>
            <option value="<?php bind($category->title) ?>+<?php bind($category->id) ?>"
              <?php bind((isset($cat_parent) && $category->id == $cat_parent->id) ? 'selected' : '') ?>>
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
    </div>