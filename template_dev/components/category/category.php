<pre style="display: none;">
<?php
  var_dump(getGlobal('currentCategory'));
?>
</pre>
<section>
  <header>
    <div class="inner">
      <img src="<?php bind(getGlobal('currentCategory')->imagen_url) ?>" alt="<?php bind(getGlobal('currentCategory')->titulo) ?>">
      <div class="cat-info">
        <p><?php bind(getGlobal('currentCategory')->descripcion_breve) ?></p>
        <h1><?php bind(getGlobal('currentCategory')->titulo) ?></h1>
        <!-- articles in the category -->
        <p>0 articulos</p>
      </div>
    </div>
  </header>
  <aside>
    <!-- @TODO Show list of subcategories -->
    <!-- @TODO Move this to a reusable component -->
  </aside>
  <section>
    <!-- @TODO Show list of articles, reuse current component -->
    <?php getTemplate('components/lists/articles/articles') ?>
  </section>
</section>