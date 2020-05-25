<footer>
  <div class="footer-columns">
    <section class="links">
      <div>
        <h3>Categorías</h3>
        <ul class="links">
          <?php if (count(getGlobal('categories')) > 0) : ?>
            <?php 
              for($i = 0; $i < 3; $i++) {
                setGlobal('category', getGlobal('categories')[$i]);
                print "<li>";
                getTemplate('components/header/category-item');
                print "</li>";
              }
            ?>
          <?php else : ?>
            <h2 class>No se encontraron categorías destacadas</h2>
          <?php endif ?>
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
      <h3>Contacto</h3>
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
      <h3>Redes sociales</h3>
      <ul>
        <li><a href="#">Facebook</a></li>
        <li><a href="#">Twitter</a></li>
        <li><a href="#">Youtube</a></li>
      </ul>
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