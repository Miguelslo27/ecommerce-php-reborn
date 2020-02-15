<section class="inner articles-component">
  <h1 class="shadowed-title">
    <span class="title-shadow">Artículos nuevos</span>
    <span class="title">Artículos nuevos</span>
  </h1>

  <?php if (isAdmin()) : ?>
  <div class="list-actions">
    <div class="admin-actions">
      <a href="/articulo/nuevo">Nuevo artículo +</a>
    </div>
  </div>
  <?php endif ?>

  <?php if (count(getGlobal('recentlyAddedArticles')) > 0) : ?>
  <ul class="articles">
    <?php foreach (getGlobal('recentlyAddedArticles') as $article) : ?>
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
    <h2 class>No se encontraron artículos nuevos</h2>
  </div>
  <?php endif ?>
</section>