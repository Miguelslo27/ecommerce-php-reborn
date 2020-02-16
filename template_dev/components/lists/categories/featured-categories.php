<section class="inner">
  <h1 class="shadowed-title">
    <span class="title-shadow">Categorías destacadas</span>
    <span class="title">Categorías destacadas</span>
  </h1>

  <?php if (count(getGlobal('featuredCategories')) > 0) : ?>
  <ul class="categories">
    <?php foreach (getGlobal('featuredCategories') as $category) : ?>
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
    <h2 class>No se encontraron categorías destacadas</h2>
    <?php if (isAdmin()) : ?>
    <div class="list-actions">
      <div class="admin-actions">
        <a href="/categoria/nueva">Nueva categoría +</a>
      </div>
    </div>
    <?php endif ?>
  </div>
  <?php endif ?>
</section>