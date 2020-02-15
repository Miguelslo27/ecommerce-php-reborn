<section class="inner">
  <h1 class="shadowed-title">
    <span class="title-shadow">Categorías destacadas</span>
    <span class="title">Categorías destacadas</span>
  </h1>

  <?php if (count(getGlobal('featuredCategories')) > 0) : ?>
  <ul class="categories">
    <?php foreach (getGlobal('featuredCategories') as $category) : ?>
    <li>
      <article>
        <img src="<?php bind($category->imagen_url) ?>" alt="<?php bind($category->titulo) ?>">
        <div class="cat-info">
          <span><?php bind($category->descripcion_breve) ?></span>
          <a href="/categories/?c=<?php bind($category->id) ?>"><?php bind($category->titulo) ?></a>
          <!-- articles in the category -->
          <span>0 articulos</span>
        </div>
        <?php if (isAdmin()) : ?>
          <div class="admin-category-controls">
            <a href="/categoria/editar/?cid=<?php bind($category->id) ?>"><i class="far fa-edit"></i></a>
            <a href="/categoria/eliminar/?cid=<?php bind($category->id) ?>"><i class="far fa-trash-alt"></i></a>
          </div>
        <?php endif ?>
      </article>
    </li>
    <?php endforeach ?>
  </ul>
  <?php else : ?>
  <div class="empty-list">
    <h2 class>No se encontraron categorías</h2>
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