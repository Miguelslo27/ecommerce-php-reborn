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

            <option value="Artigas">Artigas</option>
            <option value="Canelones">Canelones</option>
            <option value="Cerro Largo">Cerro Largo</option>
            <option value="Colonia">Colonia</option>
            <option value="Durazno">Durazno</option>
            <option value="Flores">Flores</option>
            <option value="Florida">Florida</option>
            <option value="Lavalleja">Lavalleja</option>
            <option value="Maldonado">Maldonado</option>
            <option value="Montevideo">Montevideo</option>
            <option value="Paysandu">Paysandu</option>
            <option value="Rio Negro">Rio Negro</option>
            <option value="Rivera">Rivera</option>
            <option value="Rocha">Rocha</option>
            <option value="Salto">Salto</option>
            <option value="San Jose">San Jose</option>
            <option value="Soriano">Soriano</option>
            <option value="Tacuarembo">Tacuarembo</option>
            <option value="Treinta y Tres">Treinta y Tres</option>
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