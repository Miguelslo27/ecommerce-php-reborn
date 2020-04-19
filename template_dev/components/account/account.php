<body>
  <div class="div-account">
    <section class="info-section">
      <img src="Foto.jpg" alt="FotoPerfil">
      <h2 class= "h2-name">Nombre Apellido</h2>
        <ol>
          <a><ul class="menu"><i class="fas fa-user"></i> | Cuenta </ul></a>
          <a><ul class="menu"><i class="fas fa-key"></i> | Contraseña </ul></a>
          <a><ul class="menu"><i class="far fa-credit-card"></i> | Datos de facturación </ul></a>
          <a><ul class="menu"><i class="fas fa-truck-moving"></i> | Datos de envio </ul></a>
          <a><ul class="menu"><i class="fas fa-shopping-cart"></i> | Historial de pedidos </ul></a>
          <a><ul class="menu"><i class="fas fa-trash-alt"></i> | Eliminar cuenta </ul></a>
        </ol>
    </section>

    <section class="form-edit">
      <form action="" class="form-margin">
        <div class="form-group">
          <label for="">Nombre</label>
          <input type="text" placeholder="Nombre"> 
          <label for="">Apellido</label>
          <input type="text" placeholder="Apellido">
        </div>

        <div class="form-line">
          <label for="">Nombre de Empresa</label>
          <input type="text" placeholder="Nombre Empresa">
        </div>

        <div class="form-group">
          <label for="">Direccion</label>
          <input class="input-space" type="text" placeholder="Calle 1245">
          <input type="text" placeholder="Apt, Suite, etc">
        </div>

        <div class="form-line">
          <Label>Departamento</Label>
          <input list="city">
            <datalist id="city" default="Montevideo">
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
        </div>

        <button class="button primary" id="button-center">Save</button>
      </form>

    </section>
  </div>
</body>