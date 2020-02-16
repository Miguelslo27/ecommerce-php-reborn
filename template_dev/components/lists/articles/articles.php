<section class="inner articles-component">
  <?php if (isAdmin()) : ?>
  <div class="list-actions">
    <div class="admin-actions">
      <a href="/articulo/nuevo">Nuevo artículo +</a>
    </div>
  </div>
  <?php endif ?>

  <?php if (count(getGlobal('articles')) > 0) : ?>
  <ul class="articles">
    <?php foreach (getGlobal('articles') as $article) : ?>
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
    <h2 class>No se encontraron artículos</h2>
  </div>
  <?php endif ?>
</section>