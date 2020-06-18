<section>
  <header>
    <div class="cat-info">
      <?php if(getGlobal('articles')) : ?>
        <h1>RESULTADOS DE LA BÚSQUEDA "<?php bind(getGlobal('key'))?>"</h1>
        <p><?php bind(getGlobal('count_articles')) ?> articulos</p>
      <?php else : ?>
        <h2>NO SE ENCONTRARON ARTÍCULOS</h2>
      <?php endif ?>
    </div>
  </header>
  <section class="inner">
    <?php if (!empty(getGlobal('categories'))) : ?>
      <?php getTemplate('components/lists/sidebar/sidebar') ?>
    <?php endif ?>
    <?php if (getGlobal('articles')) : ?>
      <?php getTemplate('components/lists/articles/articles') ?>
    <?php else : ?>
      <section>
        <h2>¡Lo sentimos! No hay productos en esta sección.</h2>
        <p>Inténtalo nuevamente con otros criterios de filtrado o busca en otras secciones de nuestro catálogo.</p>
      </section>
    <?php endif ?>
  </section>
</section>