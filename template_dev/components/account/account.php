<section class="inner">
  <h1 class="shadowed-title">
    <span class="title-shadow"> Mi cuenta</span>
    <span class="title"> Mi cuenta</span>
  </h1>
  <div class="div-account">

    <?php getTemplate('../template_dev/components/sidebar-account/sidebar'); ?>

    <section class="form-section">
      <form action="" class="form-margin">
        <h2 class="title-account">
          Datos de la cuenta
        </h2>
        <div class="form-group">
          <label for="">Nombre</label>
          <input type="text" placeholder="Nombre" value="<?php bind(oneOf(getGlobal('user')->name, '')) ?>">
          <label class="label-center" for="">Apellido</label>
          <input type="text" placeholder="Apellido" value="<?php bind(oneOf(getGlobal('user')->lastname, '')) ?>">
        </div>

        <div class="form-line">
          <label for="">Dirección Completa</label>
          <input type="text" placeholder="Calle 1245, esq Dir"
            value="<?php bind(oneOf(getGlobal('user')->address, '')) ?>">
        </div>

        <div class="form-group">

          <label class="label-center" for="">Localidad</label>
          <input type="text" placeholder="Barrio" value="<?php bind(oneOf(getGlobal('user')->city, '')) ?>">

          <Label>Departamento</Label>
          <input list="city" placeholder="Montevideo" value="<?php bind(oneOf(getGlobal('user')->state, '')) ?>">
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
          <label for="">Teléfono</label>
          <input type="tel" placeholder="12345678" value="<?php bind(oneOf(getGlobal('user')->phone, '')) ?>">

          <label class="label-center" for="">Celular</label>
          <input type="tel" placeholder="12345678" value="<?php bind(oneOf(getGlobal('user')->cellphone, '')) ?>">
        </div>

        <button class="button primary" id="save-account">Guardar</button>
        <button class="button secondary" id="reset-account">Reset</button>

      </form>
    </section>

  </div>
</section>