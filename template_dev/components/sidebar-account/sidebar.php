<?php getGlobal('sub_page'); ?>
<aside class="info-section">
  <div class="photo">
    <img src="/statics/images/Foto.jpg" alt="FotoPerfil">
  </div>
  <h2>Nombre Apellido</h2>
  <nav>
    <ul class="list-section">
      <li>
        <a href="/cuenta/" class="<?php bind(getGlobal('sub_page') == 'mis_datos' ? 'active' : ' ')?>">
          <span>
            <i class="fas fa-user"></i> | Mis datos
          </span>
          <i class="fas fa-angle-right"></i>
        </a>
      </li>

      <li>
        <a href="/cuenta/clave/">
          <span>
            <i class="fas fa-key"></i> | Contraseña
          </span>
          <i class="fas fa-angle-right"></i>
        </a>
      </li>

      <li>
        <a href="">
          <span>
            <i class="far fa-credit-card"></i> | Datos de facturación
          </span>
          <i class="fas fa-angle-right"></i>
        </a>
      </li>

      <li>
        <a href="">
          <span>
            <i class="fas fa-truck-moving"></i> | Datos de envío
          </span>
          <i class="fas fa-angle-right"></i>
        </a>
      </li>

      <li>
        <a href="">
          <span>
            <i class="fas fa-shopping-cart"></i> | Historial de pedidos
          </span>
          <i class="fas fa-angle-right"></i>
        </a>
      </li>

      <li>
        <a href="">
          <span>
            <i class="fas fa-trash-alt"></i> | Eliminar cuenta
          </span>
          <i class="fas fa-angle-right"></i>
        </a>
      </li>
    </ul>
  </nav>
</aside>