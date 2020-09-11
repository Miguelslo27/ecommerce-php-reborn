<aside class="categories_sidebar">
  <h2>Categorías</h2>
  <ul>
    <?php foreach (getGlobal('categories') as $category) : ?>
    <li
      class="<?php
        bind(
          getGetData('cid') == $category->id
            ? 'active'
            : ''
        );
      ?>"
    >
      <a href="/categoria/?cid=<?php bind($category->id) ?>">
        <i class="fas fa-chevron-right"></i>
        <span><?php bind($category->title) ?></span>
      </a>
    </li>
    <?php $subcats = getCategories("`category_id` = $category->id AND `status` = 1") ?>
    <?php if (!empty($subcats)) : ?>
    <?php foreach ($subcats as $subcat) : ?>
    <li
      class="<?php
        bind(
          getGetData('cid') == $subcat->id
            ? 'active'
            : ''
        );
      ?> <?php
        bind(
          $subcat->category_id != 0
            ? 'subcategory'
            : ''
        );
      ?>"
    >
      <a href="/categoria/?cid=<?php bind($subcat->id) ?>">
        <i class="fas fa-chevron-right"></i>
        <span><?php bind($subcat->title) ?></span>
      </a>
    </li>
    <?php endforeach ?>
    <?php endif ?>
    <?php endforeach ?>
  </ul>
</aside>