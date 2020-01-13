<?php
$categories = getCategories(0, 3);
?>

<section class="content featured-categories">
  <h1>Categorías destacadas</h1>

  <?php if (count($categories) == 0) : ?>
    <!-- <p class="is-empty-message">No se encontraron categorías destacadas</p> -->
    <ul class="categories">
      <li>
        <article>
          <img src="/statics/images/categories/chargers.jpg" alt="Chargers for mobile">
          <div class="cat-info">
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit.</span>
            <a href="#">Lorem ipsum</a>
            <span>23 artículos</span>
          </div>
        </article>
      </li>
      <li>
        <article>
          <img src="/statics/images/categories/chargers.jpg" alt="Chargers for mobile">
          <div class="cat-info">
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit.</span>
            <a href="#">Lorem ipsum</a>
            <span>23 artículos</span>
          </div>
        </article>
      </li>
      <li>
        <article>
          <img src="/statics/images/categories/chargers.jpg" alt="Chargers for mobile">
          <div class="cat-info">
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit.</span>
            <a href="#">Lorem ipsum</a>
            <span>23 artículos</span>
          </div>
        </article>
      </li>
    </ul>
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