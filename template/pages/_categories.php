<?php
$categories = getCategories(0);
?>

<section class="inner categories">
  <h1>Categorías destacadas</h1>

  <?php if (count($categories) == 0) : ?>
    <p class="is-empty-message">No se encontraron categorías destacadas</p>
  <?php endif; ?>

  <?php if (count($categories) > 0) : ?>
    <ul class="categories">
      <li>Category</li>
      <li>Category</li>
      <li>Category</li>
    </ul>
  <?php endif; ?>
</section>