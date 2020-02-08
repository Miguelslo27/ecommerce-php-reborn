<section class="inner articles-component">
  <h1 class="shadowed-title">
    <span class="title-shadow">Artículos</span>
    <span class="title">Artículos</span>
  </h1>

  <?php if (@$userStats['user']->administrador == 1) : ?>
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
        <?php
        $class = '';
        if ($article->nuevo === '1') {
          $class = 'new';
        }

        if ($article->oferta === '1') {
          $class = 'offer';
        }

        if ($article->agotado === '1') {
          $class = 'spent';
        }
        ?>
        <li>
          <article class="<?php echo $class ?>">
            <img src="<?php echo $article->imagenes_url ?>" alt="<?php echo $article->nombre ?>">
            <div class="article-info">
              <span><?php echo $article->descripcion_breve ?></span>
              <a href="<?php echo $article->id ?>"><?php echo $article->nombre ?></a>

              <?php if ($article->oferta === '1') : ?>
                <span class="price before">$<?php echo $article->precio ?></span>
                <span class="price after">$<?php echo $article->precio_oferta ?></span>
              <?php else : ?>
                <span class="price">$<?php echo $article->precio ?></span>
              <?php endif ?>
            </div>
            <hr>
            <div class="actions">
              <a href="<?php echo $article->id ?>">Agregar al carrito +</a>
            </div>

            <?php if (@$userStats['user']->administrador == 1) : ?>
              <div class="admin-article-controls">
                <a href="/producto/editar/?aid=<?php echo $article->id ?>"><i class="far fa-edit"></i></a>
                <a href="/producto/eliminar/?aid=<?php echo $article->id ?>"><i class="far fa-trash-alt"></i></a>
              </div>
            <?php endif ?>
          </article>
        </li>
      <?php endforeach ?>
    </ul>
  <?php else : ?>
    <div class="empty-list">
      <h2 class>No se encontraron artículos</h2>
    </div>
  <?php endif ?>
</section>