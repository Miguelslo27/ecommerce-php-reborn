<section class="inner contact-section">
  <h1 class="shadowed-title normal-title">
    <span class="title-shadow">Contacto</span>
    <span class="title">Contacto</span>
  </h1>
  <div class="contact-container">
    <div class="contact-div info-container">
      <!-- INFO SECTION -->
      <div class="info-div">
        <ul>
          <li>
            <i class="fas fa-map-marker-alt"></i>
            <span>Direccion 1 y 2</span>
          </li>
          <li>
            <i class="fas fa-phone-alt"></i>
            <span>000 0000 000</span>
          </li>
          <li>
            <i class="fas fa-envelope"></i>
            <a href="#">mail@mail.com</a>
          </li>
        </ul>
      </div>
      <!-- NESLATTER SECTION -->
      <div class="news-div">
        <h4>Suscribirme</h4>
        <p>Suscribite y recibí ofertas especiales, promociones y todas las novedades</p>
        <form action="/suscripcion/" method="POST">
          <input type="email" class="subscribe-input" placeholder="Email">
          <button type="submit" class="subscribe-button">Suscribirme</button>
        </form>
      </div>
      <!-- SOCIAL SECTION -->
      <div class="social-networks">
        <ul>
          <li>
            <a href="https://www.youtube.com"><i class="fab fa-youtube"></i></a>
          </li>
          <li>
            <a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a>
          </li>
          <li>
            <a href="https://www.facebook.com"><i class="fab fa-facebook-square"></i></a>
          </li>
        </ul>
      </div>
    </div>
    <div class="contact-div form-container">
      <!-- FORM SECTION -->
      <div class="form-div">
        <form action="" method="POST">
        <input type="hidden" name="action" value="<?php bind(ACTION_SEND_EMAIL) ?>">
          <div class="form-placeholder">
            <input type="text" placeholder="Nombre">
          </div>
          <div class="form-placeholder">
            <input type="text" placeholder="Empresa">
          </div>
          <div class="form-placeholder">
            <input type="text" placeholder="Telefono">
          </div>
          <div class="form-placeholder">
            <input type="text" placeholder="Email">
          </div>
          <div class="form-placeholder">
            <textarea placeholder="Mensaje"></textarea>
          </div>
          <div class="form-actions">
            <button class="btn-100" type="submit">ENVIAR CONSULTA</button>
          </div>
        </form>
      </div>
    </div>
  </div>      
  <h1 class="shadowed-title mobile-title">
    <span class="title-shadow">Contacto</span>
    <span class="title">Contacto</span>
  </h1>
</section>