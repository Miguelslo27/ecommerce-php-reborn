<?php
  $uri = getRequestURIPath();
  $articleURI = ($uri == '/articulo/') ? true : false;
  setGlobal('articleURI', $articleURI);
?>

<section class="inner articles-component">
  <h1 class="shadowed-title">
    <span class="title-shadow">Artículos destacados</span>
    <span class="title">Artículos destacados</span>
  </h1>

  <?php if (isAdmin()) : ?>
  <div class="list-actions">
    <div class="admin-actions">
      <a href="/articulo/nuevo">Nuevo artículo +</a>
    </div>
  </div>
  <?php endif ?>

  <?php if (count(getGlobal('featuredArticles')) > 0) : ?>
  <ul class="articles">
    <?php foreach (getGlobal('featuredArticles') as $article) : ?>
    <li>
      <?php 
      setGlobal('article', $article);
      getTemplate('components/lists/articles/article');
      ?>
    </li>
    <?php endforeach ?>
  </ul>
  <?php else : ?>
  <div class="empty-list">
    <h2 class>No se encontraron artículos destacados</h2>
  </div>
  <?php endif ?>
</section>