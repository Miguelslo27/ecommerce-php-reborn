<section class="inner articles-component">
  <h1 class="shadowed-title">
    <span class="title-shadow">Artículos</span>
    <span class="title">Artículos</span>
  </h1>

  <?php if (isAdmin()) : ?>
  <div class="list-actions">
    <div class="admin-actions">
      <a href="/producto/nuevo">Nuevo artículo +</a>
    </div>
  </div>
  <?php endif ?>

  <?php if (count($articles) > 0) : ?>
  <div class="list-actions">
    <?php paginateArticles() ?>
  </div>
  <ul class="articles">
    <?php foreach ($articles as $article) : ?>
    <li>
      <?php include(getTemplatePath() . 'components/articles/article.php') ?>
    </li>
    <?php endforeach ?>
  </ul>
  <?php else : ?>
  <div class="empty-list">
    <h2 class>No se encontraron artículos</h2>
  </div>
  <?php endif ?>
</section>