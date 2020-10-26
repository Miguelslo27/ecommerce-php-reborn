<section class="inner contact-section">
  <h1 class="shadowed-title normal-title">
    <span class="title-shadow">Contacto</span>
    <span class="title">Contacto</span>
  </h1>
  <div class="contact-container">
    <div class="contact-div info-container">
      <!-- INFO SECTION -->
      <?php if (getGlobal('site')->address !== '' || getGlobal('site')->contact_phone !== '' || getGlobal('site')->contact_email !== '') : ?>
        <div class="info-div">
          <ul>
            <?php if (getGlobal('site')->address !== '') : ?>
              <li>
                <i class="fas fa-map-marker-alt"></i>
                <span><?php bind(getGlobal('site')->address)?></span>
              </li>
            <?php endif ?>
            <?php if (getGlobal('site')->contact_phone !== '') : ?>
              <li>
                <i class="fas fa-phone-alt"></i>
                <span><?php bind(getGlobal('site')->contact_phone)?></span>
              </li>
            <?php endif ?>
            <?php if (getGlobal('site')->contact_email !== '') : ?>
              <li>
                <i class="fas fa-envelope"></i>
                <a href="#"><?php bind(getGlobal('site')->contact_email)?></a>
              </li>
            <?php endif ?>
          </ul>
        </div>
      <?php endif ?>
      <!-- NEWSLATTER SECTION -->
      <div class="news-div">
        <h4>Suscribirme</h4>
        <p>Suscribite y recibí ofertas especiales, promociones y todas las novedades</p>
        <form action="/suscripcion/" method="POST">
          <input type="email" class="subscribe-input" placeholder="Email">
          <button type="submit" class="subscribe-button">Suscribirme</button>
        </form>
      </div>
      <!-- SOCIAL SECTION -->
      <?php if (getGlobal('networks') !== null) : ?>
        <div class="social-networks">
          <ul>
            <?php foreach(getGlobal('networks') as $network) : ?>
              <?php if ($network->uri !== '') : ?>
                <li>
                  <a href="<?php bind($network->uri)?>" target="_blank"><i class="<?php bind($network->icon)?>"></i></a>
                </li>
              <?php endif ?>
            <?php endforeach ?>
          </ul>
        </div>
      <?php endif ?>  
    </div>
    <div class="contact-div form-container">
      <?php getTemplate('components/forms/contact') ?>
    </div>
  </div>      
  <h1 class="shadowed-title mobile-title">
    <span class="title-shadow">Contacto</span>
    <span class="title">Contacto</span>
  </h1>
</section>