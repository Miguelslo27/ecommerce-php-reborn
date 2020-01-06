<?php
$categories = getCategories(0, 3);
?>

<section class="content featured-categories">
  <h1>Categorías destacadas</h1>

  <?php if (count($categories) == 0) : ?>
    <p class="is-empty-message">No se encontraron categorías destacadas</p>
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
            <a href="/categorias?c=<?php echo $cat->id; ?>" class="<?php echo ($cat->titulo == $category->titulo) ? 'category-selected' : '' ?>"><?php echo $cat->titulo; ?></a>
            <p>23 artículos en esta categoría</p>
          </article>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section>