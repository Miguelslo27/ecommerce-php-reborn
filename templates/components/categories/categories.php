<?php
$categories = getCategories(0);
?>

<section class="inner categories">
  <h1>Categorías</h1>

  <?php if (count($categories) == 0) : ?>
    <p class="is-empty-message">No se encontraron categorías</p>
  <?php endif; ?>

  <?php if (count($categories) > 0) : ?>
    <ul class="categories">
      <?php foreach ($categories as $cat) : ?>
        <li>
          <article>
            <img src="<?php echo $cat->imagen_url ?>" alt="<?php echo $cat->titulo ?>">
            <div class="cat-info">
              <span><?php echo $cat->descripcion_breve ?></span>
              <a href="<?php // category link ?>"><?php echo $cat->titulo ?></a>
              <span>0 articulos<?php // articles in the category ?></span>
            </div>
          </article>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section>