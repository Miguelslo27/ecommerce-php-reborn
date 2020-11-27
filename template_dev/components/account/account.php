<section class="inner">
  <h1 class="shadowed-title">
    <span class="title-shadow"> Mi cuenta</span>
    <span class="title"> Mi cuenta</span>
  </h1>
  <div class="div-account">

    <?php getTemplate('../template_dev/components/sidebar-account/sidebar'); ?>

    <section class="form-section">
      <form method="post" class="form-margin">
        <input type="hidden" name="action" value="<?php bind(ACTION_USER_EDITION); ?>" />

        <h2 class="title-account">
          Datos de la cuenta
        </h2>

        <div class="form-group">
          <label for="name">Nombre</label>
          <input type="text" placeholder="Nombre" id="name" name="name"
            value="<?php bind(oneOf(getGlobal('user')->name, '')) ?>">
          <label class="label-center" for="lastname">Apellido</label>
          <input type="text" placeholder="Apellido" id="lastname" name="lastname"
            value="<?php bind(oneOf(getGlobal('user')->lastname, '')) ?>">
        </div>

        <div class="form-line">
          <label for="address">Dirección Completa</label>
          <input type="text" placeholder="Direccion" id="address" name="address"
            value="<?php bind(oneOf(getGlobal('user')->address, '')) ?>">
        </div>

        <div class="form-group">

          <label for="city">Localidad</label>
          <input type="text" placeholder="Barrio" id="city" name="city"
            value="<?php bind(oneOf(getGlobal('user')->city, '')) ?>">

          <Label class="label-center" for="state">Departamento</Label>
          <select list="city" placeholder="Departamento" id="state" name="state"
            value="<?php bind(oneOf(getGlobal('user')->state, '')) ?>">

            <option>Artigas</option>
            <option>Canelones</option>
            <option>Cerro Largo</option>
            <option>Colonia</option>
            <option>Durazno</option>
            <option>Flores</option>
            <option>Florida</option>
            <option>Lavalleja</option>
            <option>Maldonado</option>
            <option>Montevideo</option>
            <option>Paysandu</option>
            <option>Rio Negro</option>
            <option>Rivera</option>
            <option>Rocha</option>
            <option>Salto</option>
            <option>San Jose</option>
            <option>Soriano</option>
            <option>Tacuarembo</option>
            <option>Treinta y Tres</option>
          </select>
        </div>

        <div class="form-group">
          <label for="phone">Teléfono</label>
          <input type="tel" placeholder="Telefono" id="phone" name="phone"
            value="<?php bind(oneOf(getGlobal('user')->phone, '')) ?>">

          <label class="label-center" for="cellphone">Celular</label>
          <input type="tel" placeholder="Celular" id="cellphone" name="cellphone"
            value="<?php bind(oneOf(getGlobal('user')->cellphone, '')) ?>">
        </div>

        <div class="form-actions">
          <button type="submit" class="button primary" id="button-center">Guardar</button>
          <button type="reset" class="button secondary" id="button-center">Cancelar</button>
        </div>
      </form>
    </section>

  </div>
</section>