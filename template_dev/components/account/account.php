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
            value="<?php bind(oneOf(getPreformData('name', ''), getGlobal('user')->name)) ?>">

          <label class=" label-center" for="lastname">Apellido</label>
          <input type="text" placeholder="Apellido" id="lastname" name="lastname"
            value="<?php bind(oneOf(getPreformData('lastname', ''), getGlobal('user')->lastname)) ?>">
        </div>

        <div class="form-line">
          <label for="address">Dirección Completa</label>
          <input type="text" placeholder="Direccion" id="address" name="address"
            value="<?php bind(oneOf(getPreformData('address', ''), getGlobal('user')->address)) ?>">
        </div>

        <div class="form-group">

          <label for="city">Localidad</label>
          <input type="text" placeholder="Barrio" id="city" name="city"
            value="<?php bind(oneOf(getPreformData('city', ''), getGlobal('user')->city)) ?>">

          <Label class="label-center" for="state">Departamento</Label>
          <select list="city" id="state" name="state"
            value="<?php bind(oneOf(getPreformData('state', ''), getGlobal('user')->state)) ?>">

            <option <?php bind(getGlobal('user')->state === "Artigas" ? 'selected' : '') ?> value="Artigas">Artigas
            </option>
            <option <?php bind(getGlobal('user')->state === "Canelones" ? 'selected' : '') ?> value="Canelones">
              Canelones</option>
            <option <?php bind(getGlobal('user')->state === "Cerro Largo" ? 'selected' : '') ?> value="Cerro Largo">
              Cerro Largo</option>
            <option <?php bind(getGlobal('user')->state === "Colonia" ? 'selected' : '') ?> value="Colonia">Colonia
            </option>
            <option <?php bind(getGlobal('user')->state === "Durazno" ? 'selected' : '') ?> value="Durazno">Durazno
            </option>
            <option <?php bind(getGlobal('user')->state === "Flores" ? 'selected' : '') ?> value="Flores">Flores
            </option>
            <option <?php bind(getGlobal('user')->state === "Florida" ? 'selected' : '') ?> value="Florida">Florida
            </option>
            <option <?php bind(getGlobal('user')->state === "Lavalleja" ? 'selected' : '') ?> value="Lavalleja">
              Lavalleja</option>
            <option <?php bind(getGlobal('user')->state === "Maldonado" ? 'selected' : '') ?> value="Maldonado">
              Maldonado</option>
            <option <?php bind(getGlobal('user')->state === "Montevideo" ? 'selected' : '') ?> value="Montevideo">
              Montevideo</option>
            <option <?php bind(getGlobal('user')->state === "Paysandu" ? 'selected' : '') ?> value="Paysandu">Paysandu
            </option>
            <option <?php bind(getGlobal('user')->state === "Rio Negro" ? 'selected' : '') ?> value="Rio Negro">Rio
              Negro</option>
            <option <?php bind(getGlobal('user')->state === "Rivera" ? 'selected' : '') ?> value="Rivera">Rivera
            </option>
            <option <?php bind(getGlobal('user')->state === "Rocha" ? 'selected' : '') ?> value="Rocha">Rocha</option>
            <option <?php bind(getGlobal('user')->state === "Salto" ? 'selected' : '') ?> value="Salto">Salto</option>
            <option <?php bind(getGlobal('user')->state === "San Jose" ? 'selected' : '') ?> value="San Jose">San Jose
            </option>
            <option <?php bind(getGlobal('user')->state === "Soriano" ? 'selected' : '') ?> value="Soriano">Soriano
            </option>
            <option <?php bind(getGlobal('user')->state === "Tacuarembo" ? 'selected' : '') ?> value="Tacuarembo">
              Tacuarembo</option>
            <option <?php bind(getGlobal('user')->state === "Treinta y Tres" ? 'selected' : '') ?>
              value="Treinta y Tres">Treinta y Tres</option>
          </select>
        </div>

        <div class="form-group">
          <label for="phone">Teléfono</label>
          <input type="tel" placeholder="Telefono" id="phone" name="phone"
            value="<?php bind(oneOf(getPreformData('phone', ''), getGlobal('user')->phone)) ?>">

          <label class="label-center" for="cellphone">Celular</label>
          <input type="tel" placeholder="Celular" id="cellphone" name="cellphone"
            value="<?php bind(oneOf(getPreformData('cellphone', ''), getGlobal('user')->cellphone)) ?>">
        </div>

        <div class="form-actions">
          <button type="submit" class="button primary" id="button-center">Guardar</button>
          <button type="reset" class="button secondary" id="button-center">Cancelar</button>
        </div>
      </form>
    </section>

  </div>
</section>