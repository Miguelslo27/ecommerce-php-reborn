<?php
$categories = getCategories(0, 'sarasa');
?>

<section class="content new-articles">
  <h1>Artículos nuevos</h1>

  <?php if (count($categories) == 0) : ?>
  <p class="is-empty-message">No se encontraron artículos nuevos</p>
  <?php endif; ?>

  <?php if (count($categories) > 0) : ?>
  <ul class="categories">
    <li>Category</li>
    <li>Category</li>
    <li>Category</li>
  </ul>
  <?php endif; ?>
</section>
