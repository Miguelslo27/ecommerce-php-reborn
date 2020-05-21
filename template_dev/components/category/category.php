<section>
  <header>
    <?php if (isset(getGlobal('currentCategory')->images_url)) : ?>
      <img src="<?php bind(getGlobal('currentCategory')->images_url) ?>" alt="<?php bind(getGlobal('currentCategory')->title) ?>">
    <?php endif ?>
    <div class="cat-info">
      <?php if (isset(getGlobal('currentCategory')->brief_description)) : ?>
        <p><?php bind(getGlobal('currentCategory')->brief_description) ?></p>
      <?php endif ?>

      <h1><?php bind(getGlobal('currentCategory')->title) ?></h1>
      <p><?php bind(count(getGlobal('articles'))) ?> articulos</p>
    </div>
  </header>
  <section class="inner">
    <?php if (!empty(getGlobal('categoriesArticles'))) : ?>
      <?php getTemplate('components/lists/sidebar/sidebar') ?>
    <?php endif ?>

    <?php getTemplate('components/lists/articles/articles') ?>
  </section>
</section>