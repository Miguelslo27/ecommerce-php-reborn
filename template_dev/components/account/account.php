<h1 class="shadowed-title title-account">
          <span class="title-shadow"> Mi cuenta</span>
          <span class="title"> Mi cuenta</span>
        </h1>
  <div class="div-account inner">
    <aside class="info-section">
    <div class="photo">
      <img src="/statics/images/Foto.jpg" alt="FotoPerfil">
    </div>
      <h2 class= "h2-account">Nombre Apellido</h2>
      <nav>
      <ul class="list-section">
      <li>
      <a href="">
    <span>
      <i class="fas fa-user"></i> | Cuenta
    </span>
      <i class="fas fa-angle-right"></i>
  </a>
</li>

<li>
  <a href="">
    <span>
      <i class="fas fa-key"></i> | Contraseña 
    </span>
      <i class="fas fa-angle-right"></i>
  </a>
</li>

<li>
  <a href="">
    <span>
      <i class="far fa-credit-card"></i> |  Datos de facturación
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

    <section class="form-section">
      <form action="" class="form-margin">
        <h2 class="shadowed-title">
          <span class="title-shadow"> Datos de la cuenta</span>
          <span class="title"> Datos de la cuenta</span>
        </h2>
        <div class="form-group">
          <label for="">Nombre</label>
          <input type="text" placeholder="Nombre"> 
          <label class="label-center" for="">Apellido</label>
          <input type="text" placeholder="Apellido">
        </div>

        <div class="form-line">
          <label for="">Nombre de Empresa</label>
          <input type="text" placeholder="Nombre Empresa">
        </div>

        <div class="form-line">
          <label for="">Dirección Completa</label>
          <input type="text" placeholder="Calle 1245, esq Dir">
        </div>

        <div class="form-group">
          <Label>Departamento</Label>
          <input list="city" placeholder="Montevideo">
          <datalist id="city">
            <option value="Artigas">
            <option value="Canelones">
            <option value="Cerro Largo">
            <option value="Colonia">
            <option value="Durazno">
            <option value="Flores">
            <option value="Florida">
            <option value="Lavalleja">
            <option value="Maldonado">
            <option value="Montevideo">
            <option value="Paysandu">
            <option value="Rio Negro">
            <option value="Rivera">
            <option value="Rocha">
            <option value="Salto">
            <option value="San Jose">
            <option value="Soriano">
            <option value="Tacuarembo">
            <option value="Treinta y Tres">
          </datalist>

            <label class="label-center" for="">Localidad</label>
            <input type="text" placeholder="Barrio">
        </div>

        <div class="form-group">
          <label for="">Teléfono</label>
          <input type="tel" placeholder="12345678">

          <label class="label-center" for="">Celular</label>
          <input type="tel" placeholder="12345678">
        </div>

        <button class="button primary" id="button-center">Guardar</button>
        <button class="button secondary" id="button-center">Reset</button>

      </form>

    </section>
  </div>