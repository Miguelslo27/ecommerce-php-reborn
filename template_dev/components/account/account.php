<style>
.info-section nav {
  width: 80%;
}
ul.sidebar-nav {
  list-style: none;
  margin: 0;
  padding: 0;
}
ul.sidebar-nav li > a {
  display: flex;
  flex-direction: row;
  width: 100%;
  padding: 15px;
  justify-content: space-between;
  border-bottom: 1px solid;
  color: #333;
  text-decoration: none;
}
ul.sidebar-nav li > a:hover {
  color: #b52299;
}
ul.sidebar-nav li > a:hover > span {
  padding-left: 10px;
}
/* ul.sidebar-nav li > a > * {
} */
</style>
<body>
  <div class="div-account">
    <section class="info-section">
      <div class="photo">
        <img src="/statics/images/Foto.jpg" alt="FotoPerfil">
      </div>
      <h2 class= "h2-account">Nombre Apellido</h2>

      <nav>
        <ul class="sidebar-nav">
          <li>
            <a href="#">
              <span>
                <i class="fas fa-user"></i> | Cuenta
              </span>
              <i class="fas fa-angle-right"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <span>
                <i class="fas fa-user"></i> | Cuenta
              </span>
              <i class="fas fa-angle-right"></i>
            </a>
          </li>
        </ul>
      </nav>
        <!-- <a class="list-flex">
          <li class="list-one"> <i class="fas fa-user"></i> | Cuenta </li>
          <li class="list-two"> <i class="fas fa-angle-right"></i></li>
        </a>
        
         <a class="list-flex">
          <li class="list-one"><i class="fas fa-key"></i> | Contraseña </li>
          <li class="list-two"> <i class="fas fa-angle-right"></i></li>
          </a>

        <a class="list-flex">
          <li class="list-one"><i class="far fa-credit-card"></i> |  Datos de facturación</li>
          <li class="list-two"> <i class="fas fa-angle-right"></i></li>
          </a>

        <a class="list-flex">
          <li class="list-one"><i class="fas fa-truck-moving"></i> | Datos de envío  </li>
          <li class="list-two"><i class="fas fa-angle-right"></i></li>
        </a>
        
        <a class="list-flex" href="">
          <li class="list-one"><i class="fas fa-shopping-cart"></i> | Historial de pedidos </li>
          <li class="list-two"> <i class="fas fa-angle-right"></i></li>
        </a>
      
      
          <a class="list-flex" href="">
          <li class="list-one"><i class="fas fa-trash-alt"></i> | Eliminar cuenta </li>
          <li class="list-two"><i class="fas fa-angle-right"></i></li>
          </a> -->
        <!-- </ul> -->
    </section>

    <section class="form-section">
      <form action="" class="form-margin">
        <h2 class="shadowed-title">
          <span class="title-shadow"> Datos de Facturación</span>
          <span class="title"> Datos de Facturación</span>
        </h2>
        <div class="form-group">
          <label class="label-center" for="">Nombre</label>
          <input type="text" placeholder="Nombre"> 
          <label class="label-center" for="">Apellido</label>
          <input type="text" placeholder="Apellido">
        </div>

        <div class="form-line">
          <label class="label-center" for="">Nombre de Empresa</label>
          <input type="text" placeholder="Nombre Empresa">
        </div>

        <div class="form-line">
          <label class="label-center" for="">Dirección Completa</label>
          <input type="text" placeholder="Calle 1245, esq Dir">
        </div>

        <div class="form-group">
          <Label class="label-center">Departamento</Label>
          <input list="city" placeholder="Montevideo">
            <datalist id="city">
              <option value="Montevideo">
              <option value="Canelones">
              <option value="Lavalleja">
              <option value="Maldonado">
              <option value="Artigas">
              <option value="Flores">
              <option value="Florida">
              <option value="Rio Negro">
              <option value="Tacuarembo">
              <option value="Treinta y Tres">
              <option value="Cerro Largo">
              <option value="Rivera">
              <option value="Salto">
              <option value="Paysandu">
              <option value="San Jose">
              <option value="Soriano">
              <option value="Colonia">
              <option value="Durazno">
              <option value="Rocha">
            </datalist>

            <label class="label-center" for="">Localidad</label>
            <input type="text" placeholder="Barrio">
        </div>

        <div class="form-group">
          <label class="label-center" for="">Teléfono</label>
          <input type="tel" placeholder="12345678">

          <label class="label-center" for="">Celular</label>
          <input type="tel" placeholder="12345678">
        </div>

        <button class="button primary" id="button-center">Guardar</button>
        <button class="button secondary" id="button-center">Reset</button>

      </form>

    </section>
  </div>
</body>