<section class="inner categories-component">
  <h1 class="shadowed-title">
    <span class="title-shadow">Categorías</span>
    <span class="title">Categorías</span>
  </h1>

  <?php if (count($categories) > 0) : ?>
    <?php if (isAdmin()) : ?>
      <div class="list-actions">
        <div class="admin-actions">
          <a href="/categoria/nueva">Nueva categoría +</a>
        </div>
      </div>
    <?php endif ?>

    <div class="list-actions">
      <?php paginateCategories() ?>
    </div>

    <ul class="categories">
      <?php foreach ($categories as $category) : ?>
        <li>
          <article>
            <img src="<?php echo $category->imagen_url ?>" alt="<?php echo $category->titulo ?>">
            <div class="cat-info">
              <span><?php echo $category->descripcion_breve ?></span>
              <a href="/categories/?c=<?php echo $category->id ?>"><?php echo $category->titulo ?></a>
              <span>0 articulos<?php // articles in the category 
                                ?></span>
            </div>
            <?php if (isAdmin()) : ?>
              <div class="admin-category-controls">
                <a href="/categoria/editar/?cid=<?php echo $category->id ?>"><i class="far fa-edit"></i></a>
                <a href="/categoria/eliminar/?cid=<?php echo $category->id ?>"><i class="far fa-trash-alt"></i></a>
              </div>
            <?php endif ?>
          </article>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else : ?>
    <?php if (isAdmin()) : ?>
      <div class="list-actions">
        <div class="admin-actions">
          <a href="/categoria/nueva">Nueva categoría +</a>
        </div>
      </div>
    <?php endif ?>
    <div class="empty-list">
      <h2 class>No se encontraron categorías</h2>
    </div>
  <?php endif ?>
</section>