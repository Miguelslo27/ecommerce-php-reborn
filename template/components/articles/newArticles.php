<?php
$articles = getArticles();
?>

<section class="inner new-articles">
  <h1 class="shadowed-title">
    <span class="title-shadow">Artículos nuevos</span>
    <span class="title">Artículos nuevos</span>
  </h1>
  <?php if (count($articles) > 0) : ?>
  <ul class="articles new">
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