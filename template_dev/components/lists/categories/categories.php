<section class="inner categories-component">
  <h1 class="shadowed-title">
    <span class="title-shadow">Categorías</span>
    <span class="title">Categorías</span>
  </h1>

  <?php if (count(getGlobal('categoriesTotal')) > 0) : ?>
  <div class="list-actions">
    <?php setGlobal('pager', getGlobal('categories_pager')) ?>
    <?php setGlobal('pager_per_page', CATEGORIES_PER_PAGE) ?>
    <?php getTemplate('components/lists/pager/pager') ?>
  </div>

  <ul class="categories">
    <?php foreach (getGlobal('categoriesTotal') as $category) : ?>
    <li>
      <?php
      setGlobal('category', $category);
      getTemplate('components/lists/categories/category');
      ?>
    </li>
    <?php endforeach ?>
  </ul>
  <?php else : ?>
  <div class="empty-list">
    <h2 class>No se encontraron categorías</h2>
  </div>
  <?php endif ?>
</section>