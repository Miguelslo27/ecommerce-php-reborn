<?php
$categories = getCategories(0, 2);
?>

<section class="content featured-categories">
  <h1 class="shadowed-title">
    <span class="title-shadow">Categorías destacadas</span>
    <span class="title">Categorías destacadas</span>
  </h1>

  <?php if (count($categories) > 0) : ?>
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
    <div class="empty-list">
      <h2 class>No se encontraron categorías</h2>
    </div>
  <?php endif ?>
</section>