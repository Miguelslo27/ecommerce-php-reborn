<section class="inner categories-component">
  <h1 class="shadowed-title">
    <span class="title-shadow">Artículos nuevos</span>
    <span class="title">Artículos nuevos</span>
  </h1>

  <?php if (count($categories) > 0) : ?>
    <?php if (@$userStats['user']->administrador == 1) : ?>
      <div class="list-actions">
        <div class="admin-actions">
          <a href="/producto/nuevo">Nuevo artículo +</a>
        </div>
      </div>
    <?php endif ?>

    <div class="list-actions">
      <?php paginateCategories() ?>
    </div>

    <ul class="articles news">
      <li>
        <article class="new">
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
      <li>
        <article class="new">
          <img src="/statics/images/articles/2.jpg" alt="Auriculares Xiami">
          <div class="article-info">
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit.</span>
            <a href="#">Lorem ipsum</a>
            <span class="price">$200</span>
          </div>
          <hr>
          <div class="actions">
            <a href="#">Agregar al carrito +</a>
          </div>
        </article>
      </li>
      <li>
        <article class="new">
          <img src="/statics/images/articles/3.jpg" alt="Auricular Bluetooth">
          <div class="article-info">
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit.</span>
            <a href="#">Lorem ipsum</a>
            <span class="price">$275</span>
          </div>
          <hr>
          <div class="actions">
            <a href="#">Agregar al carrito +</a>
          </div>
        </article>
      </li>
    </ul>
  <?php else : ?>
    <?php if (@$userStats['user']->administrador == 1) : ?>
      <div class="list-actions">
        <div class="admin-actions">
          <a href="/producto/nuevo">Nuevo artículo +</a>
        </div>
      </div>
    <?php endif ?>

    <div class="empty-list">
      <h2 class>No se encontraron artículos</h2>
    </div>
  <?php endif ?>
</section>