<?php
$articles = getArticles(0);
?>

<section class="inner articles-component">
  <h1 class="shadowed-title">
    <span class="title-shadow">Articulos</span>
    <span class="title">Artículos</span>
  </h1>

  <?php if (count($articles) > 0) : ?>
    <?php if (@$userStats['user']->administrador == 1) : ?>
      <div class="list-actions">
        <?php include($templatesPath . 'components/admin/admin-actions.php') ?>
      </div>
    <?php endif ?>
    <div class="list-actions">
      <div class="pagination">
        <a href="#"><i class="fas fa-arrow-left"></i></a>
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#"><i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="per-page">
        <span>Mostrar:</span>
        <a href="#">6</a>
        <a href="#">12</a>
        <a href="#">24</a>
      </div>
    </div>

    <ul class="articles">
      <?php foreach ($articles as $art) : ?>
        <li>
          <article>
            <img src="/statics/images/articles/1.jpg" alt="Auriculares Rocca">
            <div class="article-info">
              <span>Lorem ipsum dolor sit amet consectetur adipisicing elit.</span>
              <a href="#">Lorem ipsum</a>
              <span class="price before">$250</span>
              <span class="price after">$150</span>
            </div>
            <hr>
            <div class="actions">
              <a href="#">Agregar al carrito +</a>
            </div>
          </article>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else : ?>
    <?php if (@$userStats['user']->administrador == 1) : ?>
      <div class="list-actions">
        <?php include($templatesPath . 'components/admin/admin-actions.php') ?>
      </div>
    <?php endif ?>
    <hr>
    <p class="shadowed-title">
      <span class="title-shadow">No se encontraron artículos</span>
      <span class="title">No se encontraron artículos</span>
    </p>
    <hr>
  <?php endif ?>
</section>