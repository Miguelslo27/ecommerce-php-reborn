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
          <input type="text" placeholder="Nombre" id="name" value="<?php bind(oneOf(getGlobal('user')->name, '')) ?>">
          <label class="label-center" for="lastname">Apellido</label>
          <input type="text" placeholder="Apellido" id="lastname"
            value="<?php bind(oneOf(getGlobal('user')->lastname, '')) ?>">
        </div>

        <div class="form-line">
          <label for="">Nombre de Empresa</label>
          <input type="text" placeholder="Nombre Empresa">
        </div>

        <div class="form-line">
          <label for="address">Dirección Completa</label>
          <input type="text" placeholder="Direccion" id="address"
            value="<?php bind(oneOf(getGlobal('user')->address, '')) ?>">
        </div>

        <div class="form-group">

          <label for="city">Localidad</label>
          <input type="text" placeholder="Barrio" id="city" value="<?php bind(oneOf(getGlobal('user')->city, '')) ?>">

          <Label class="label-center" for="state">Departamento</Label>
          <input list="city" placeholder="Departamento" id="state"
            value="<?php bind(oneOf(getGlobal('user')->state, '')) ?>">
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

        </div>

        <div class="form-group">
          <label for="phone">Teléfono</label>
          <input type="tel" placeholder="Telefono" id="phone"
            value="<?php bind(oneOf(getGlobal('user')->phone, '')) ?>">

          <label class="label-center" for="cellphone">Celular</label>
          <input type="tel" placeholder="Celular" id="cellphone"
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