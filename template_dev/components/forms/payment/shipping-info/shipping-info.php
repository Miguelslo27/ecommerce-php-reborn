<form action="" class="shipping-info" method="POST">
  <fieldset>
    <legend><span>2</span> Datos de envío</legend>

    <div class="form-group group-grid columns-3">
      <label for="shipping-receive">
        <input
          type="radio"
          name="shipping"
          id="shipping-receive"
          value="receive"
          checked
          data-selector=".shipping-form"
        >
        <!--
          data-action="switch"
          data-perform="open"
        -->
        <span>Quiero recibir mi pedido</span>
      </label>

      <label for="shipping-withdraw">
        <input
          type="radio"
          name="shipping"
          id="shipping-withdraw"
          value="withdraw"
          data-action="switch"
          data-perform="close"
          data-selector=".shipping-form"
          data-height="0"
        >
        <span>Retiro personalmente</span>
      </label>

      <label for="copy-billing-address">
        <input
          type="checkbox"
          name="copy-billing-address"
          id="copy-billing-address"
          checked
        >
        <span>Usar dirección de facturación</span>
      </label>
    </div>

    <div class="shipping-form collapsable closed">
      <div class="form-line">
        <label for="direccion">Dirección</label>
        <input type="text" name="direccion" id="direccion" value="<?php getPreformData('direccion', getCurrentUser()->address) ?>">
      </div>

      <div class="form-group">
        <label for="departamento" class="">Departamento</label>
        <input type="text" class="" name="departamento" id="departamento" value="<?php getPreformData('departamento', getCurrentUser()->state) ?>">
        <label for="ciudad" class="align-center">Localidad</label>
        <input type="text" class="" name="ciudad" id="ciudad" value="<?php getPreformData('ciudad', getCurrentUser()->city) ?>">
      </div>

      <div class="form-group">
        <label for="agencia">Agencia de envío</label>
        <input type="text" name="agencia" id="agencia" value="<?php getPreformData('agencia', '') ?>">
        <label for="zipcode" class="align-center">Código postal</label>
        <input type="text" name="zipcode" id="zipcode" value="<?php getPreformData('zipcode', '') ?>">
      </div>

      <div class="form-line">
        <label for="additional_notes">Comentarios adicionales</label>
        <textarea name="additional_notes" id="additional_notes" cols="30" rows="5"></textarea>
      </div>

      <div class="form-actions">
        <button type="submit">
          <i class="fas fa-check"></i> Guardar
        </button>
        <button type="reset">
          <i class="fas fa-times"></i> Cancelar
        </button>
      </div>
    </div>
  </fieldset>
</form>