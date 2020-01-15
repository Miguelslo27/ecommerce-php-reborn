<?php
$categories = getCategories(0, 4);
?>

<section class="content featured-categories">
  <h1 class="shadowed-title">
    <span class="title-shadow">Categorías destacadas</span>
    <span class="title">Categorías destacadas</span>
  </h1>

  <?php if (count($categories) == 0) : ?>
    <hr>
    <p class="shadowed-title">
      <span class="title-shadow">No se encontraron categorías destacadas</span>
      <span class="title">No se encontraron categorías destacadas</span>
    </p>
    <hr>
  <?php endif; ?>

  <?php if (count($categories) > 0) : ?>
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
  <?php endif; ?>
</section>