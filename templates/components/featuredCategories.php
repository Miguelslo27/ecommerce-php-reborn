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
          <div style="display: none">
            <?php var_dump($cat); ?>
          </div>
          <article>
            <p><?php echo $cat->descripcion_breve; ?></p>
            <a href="/categorias?c=<?php echo $cat->id; ?>"><?php echo $cat->titulo; ?></a>
            <p>23 artículos en esta categoría</p>
          </article>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section>