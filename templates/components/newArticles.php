<?php
$categories = getCategories(0, 'sarasa');
?>

<section class="content new-articles">
  <h1>Artículos nuevos</h1>

  <?php if (count($categories) == 0) : ?>
    <!-- <p class="is-empty-message">No se encontraron artículos nuevos</p> -->
    <ul class="articles news">
      <li>
        <article class="news">
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
        <article class="news">
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
        <article class="news">
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
  <?php endif; ?>

  <?php if (count($categories) > 0) : ?>
    <ul class="categories">
      <li>Category</li>
      <li>Category</li>
      <li>Category</li>
    </ul>
  <?php endif; ?>
</section>