<?php
$categories = getCategories(0);
?>

<section class="inner categories-component">
  <h1 class="shadowed-title">
    <span class="title-shadow">Categorías</span>
    <span class="title">Categorías</span>
  </h1>

  <?php if (count($categories) > 0) : ?>
    <?php if (@$userStats['user']->administrador == 1) : ?>
      <div class="list-actions">
        <div class="admin-actions">
          <a href="/categoria/nueva">Nueva categoría +</a>
        </div>
      </div>
    <?php endif ?>
    <div class="list-actions">
      <div class="pagination">
        <a href="#"><i class="fas fa-arrow-left"></i></a>
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#"><i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="per-page">
        <span>Mostrar:</span>
        <a href="#">6</a>
        <a href="#">12</a>
        <a href="#">24</a>
      </div>
    </div>

    <ul class="categories">
      <?php foreach ($categories as $cat) : ?>
        <li>
          <article>
            <img src="<?php echo $cat->imagen_url ?>" alt="<?php echo $cat->titulo ?>">
            <div class="cat-info">
              <span><?php echo $cat->descripcion_breve ?></span>
              <a href="/categories/?c=<?php echo $cat->id ?>"><?php echo $cat->titulo ?></a>
              <span>0 articulos<?php // articles in the category 
                                ?></span>
            </div>
          </article>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else : ?>
    <?php if (@$userStats['user']->administrador == 1) : ?>
      <div class="list-actions">
        <?php include($templatesPath . 'components/categories/admin-actions.php') ?>
      </div>
    <?php endif ?>
    <hr>
    <p class="shadowed-title">
      <span class="title-shadow">No se encontraron categorías</span>
      <span class="title">No se encontraron categorías</span>
    </p>
    <hr>
  <?php endif ?>
</section>