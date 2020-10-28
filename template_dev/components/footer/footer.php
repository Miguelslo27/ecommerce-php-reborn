<?php
  $site     = getSite();
  $networks = getSiteNetworks();
?>

<footer>
  <div class="footer-columns">
    <section class="links">
      <div>
        <h3>Categorías</h3>
        <ul class="links">
          <?php foreach (getGlobal('categories') as $category) : ?>
            <li>
              <?php
                setGlobal('category', $category);
                getTemplate('components/header/category-item');
              ?>
            </li>
          <?php endforeach ?>
        </ul>
      </div>
      <div>
        <h3>Enlaces de interés</h3>
        <ul class="links">
          <li><a href="#">Productos</a></li>
          <li><a href="#">Preguntas frecuentes</a></li>
          <li><a href="#">Contacto</a></li>
        </ul>
      </div>
    </section>
    <section class="contact-info">
      <?php if (!empty($site->address) || !empty($site->contact_phone) || !empty($site->contact_email)) : ?>
        <h3>Contacto</h3>
        <ul>
          <?php if (!empty($site->address)) : ?>
            <li>
              <i class="fas fa-map-marker-alt"></i>
              <span><?php bind($site->address) ?></span>
            </li>
          <?php endif ?>
          <?php if (!empty($site->contact_phone)) : ?>
            <li>
              <i class="fas fa-phone-alt"></i>
              <span class="contact-phone"><?php bind($site->contact_phone) ?></span>
            </li>
          <?php endif ?>
          <?php if (!empty($site->contact_email)) : ?>
            <li>
              <i class="fas fa-envelope"></i>
              <a href="#"><?php bind($site->contact_email) ?></a>
            </li>
          <?php endif ?>
        </ul>
      <?php endif ?>
      <?php if (!empty($networks)) : ?>
        <h3>Redes sociales</h3>
        <ul>
          <?php foreach($networks as $network) : ?>
            <li><a href="<?php bind($network->uri)?>" target="_blank"><?php bind(ucwords($network->tag)) ?></a></li>
          <?php endforeach ?>
        </ul>
      <?php endif ?>
    </section>
    <section class="subscribe">
      <h3>Suscribirme</h3>
      <p>Suscribite y recibí ofertas especiales, promociones y todas las novedades</p>
      <form action="/suscripcion/" method="POST">
        <input type="email" class="subscribe-input" placeholder="Email">
        <button type="submit" class="subscribe-button">Suscribirme</button>
      </form>
    </section>
  </div>
  <p class="rights">
    Copyright ©2020 - Todos los derechos reservados | e-com.uy
    <br>
    Versión: App <?php bind(APP_VERSION) ?> | Api <?php bind(API_VERSION) ?>
  </p>
</footer>