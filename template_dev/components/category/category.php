<section>
  <header>
    <?php if (isset(getGlobal('currentCategory')->imagen_url)) : ?>
      <img src="<?php bind(getGlobal('currentCategory')->imagen_url) ?>" alt="<?php bind(getGlobal('currentCategory')->titulo) ?>">
    <?php endif ?>
    <div class="cat-info">
      <?php if (isset(getGlobal('currentCategory')->descripcion_breve)) : ?>
        <p><?php bind(getGlobal('currentCategory')->descripcion_breve) ?></p>
      <?php endif ?>

      <h1><?php bind(getGlobal('currentCategory')->titulo) ?></h1>
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