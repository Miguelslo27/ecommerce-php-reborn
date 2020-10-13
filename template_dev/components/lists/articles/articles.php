<section class="inner articles-component">

  <?php if (count(getGlobal('articles')) > 0) : ?>
  <div class="list-actions">
    <?php setGlobal('pager', getGlobal('articles_pager')) ?>
    <?php setGlobal('pager_per_page', ARTICLES_PER_PAGE) ?>
    <?php getTemplate('components/lists/pager/pager') ?>
  </div>

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
  
  <div class="list-actions">
    <?php setGlobal('pager', getGlobal('articles_pager')) ?>
    <?php setGlobal('pager_per_page', ARTICLES_PER_PAGE) ?>
    <?php getTemplate('components/lists/pager/pager') ?>
  </div>
  <?php else : ?>
  <div class="empty-list">
    <h2 class>No se encontraron artículos</h2>
  </div>
  <?php endif ?>
</section>