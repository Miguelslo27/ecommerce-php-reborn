<section>
  <header>
    <div class="cat-info">
      <!-- si encuentra 1 o mas articulos -->
      <h1>RESULTADOS DE LA BÚSQUEDA "<?php bind(getGlobal('key'))?>"</h1>
      <!-- si no encuentra articulos -->
      <!-- <h1>NO SE HAN ENCONTRADO PRODUCTOS</h1> -->
      <p><?php bind(count(getGlobal('articles'))) ?> articulos</p>
    </div>
  </header>
  <section class="inner">
    <?php if (!empty(getGlobal('categories'))) : ?>
      <?php getTemplate('components/lists/sidebar/sidebar') ?>
    <?php endif ?>

    <?php getTemplate('components/lists/articles/articles') ?>
  </section>
</section>