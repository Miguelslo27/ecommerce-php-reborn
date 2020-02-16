<pre style="display: none;">
<?php
  var_dump(getGlobal('currentCategory'));
?>
</pre>
<section>
  <header>
    <img src="<?php bind(getGlobal('currentCategory')->imagen_url) ?>" alt="<?php bind(getGlobal('currentCategory')->titulo) ?>">
    <div class="cat-info">
      <p><?php bind(getGlobal('currentCategory')->descripcion_breve) ?></p>
      <h1><?php bind(getGlobal('currentCategory')->titulo) ?></h1>
      <!-- articles in the category -->
      <p>0 articulos</p>
    </div>
  </header>
  <section class="inner">
    <?php if (!empty(getGlobal('categories'))) : ?>
      <?php getTemplate('components/lists/sidebar/sidebar') ?>
    <?php endif ?>

    <?php getTemplate('components/lists/articles/articles') ?>
  </section>
</section>