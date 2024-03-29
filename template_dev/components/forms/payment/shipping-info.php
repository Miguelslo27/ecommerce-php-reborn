<form action="" class="shipping-info" method="POST">
  <fieldset>
    <legend><span>2</span> Datos de envío</legend>

    <div class="shipping-info-data collapsable withdraw-auxiliar <?php bind((getGlobal('shipping_method') == "1"  || getGlobal('cart_shipping_method') == "1") && empty(getPreformData('copy-billing-address', '')) ? 'open' : 'closed') ?>" id="shipping-address-div">
      <div class="form-group group-grid columns-3">
        <div class="span-2">
          <p class="<?php bind(shippingInfoIsIncomplete() ? 'error' : '') ?>">
            <strong>Dirección de envío: *</strong><br>
            <?php bind(oneOf(getGlobal('shipping_fulladdress'), 'Sin definir')) ?>
          </p>
        </div>

        <div class="side-actions">
          <a href="#"
            class="button icon primary <?php bind(shippingInfoFormHasErrors() || shippingInfoIsIncomplete() ? 'disabled' : '') ?>"
            data-action="switch"
            data-selector=".shipping-info-form"
            data-prevent-default="true"
            <?php bind(shippingInfoFormHasErrors() || shippingInfoIsIncomplete() ? 'data-perform="open"' : '') ?>
          ><i class="far fa-edit"></i></a>
        </div>
      </div>
    </div>

    <div class="form-group group-grid columns-3">
      <label for="shipping-receive">
        <input
          type="radio"
          name="shipping"
          id="shipping-receive"
          value="receive"
          data-selector=".shipping-info-form, .shipping-info-data"
          data-success="<?php bind((getGlobal('shipping_method') != "0") && !(shippingInfoFormHasErrors() || shippingInfoIsIncomplete()) ? true : false) ?>"
          data-method="<?php bind(getGlobal('shipping_method')) ?>"
          data-cart="<?php bind(getGlobal('cart_shipping_method')) ?>"
          <?php bind(checkedInput(1) || checkedInput(2) ? 'checked' : '') ?>
        >
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
          data-selector=".shipping-info-form"
          data-height="0"
          data-success="<?php fieldHasError('additional_notes', 'error') ?>"
          data-checked="<?php bind(getGlobal('shipping_method') == "0" ? 'checked' : '') ?>"
          <?php bind(checkedInput(0) ? 'checked' : '') ?>
        >
        <span>Retiro personalmente</span>
      </label>

      <label for="copy-billing-address">
        <input
          type="checkbox"
          name="copy-billing-address"
          class="<?php bind(getGlobal('canUseBilling') ? '' : 'disabled') ?>"
          id="copy-billing-address"
          <?php bind(checkedInput(2) ? 'checked' : '') ?>
        >
        <span>Usar dirección de facturación</span>
      </label>
    </div>

    <div class="shipping-info-form collapsable <?php bind(((shippingInfoFormHasErrors() || shippingInfoIsIncomplete()) || empty(getPreformData('copy-billing-address', ''))) && ((getGlobal('shipping_method') == "1"  || getGlobal('cart_shipping_method') == "1") && getGlobal('cart_shipping_method') != "2") ? 'open' : 'closed') ?>">
      <input type="hidden" name="action" value="<?php bind(ACTION_UPDATE_CART_SHIPPING_INFO) ?>">

      <div class="form-line <?php fieldHasError('shipping_address', 'error') ?>">
        <label for="shipping_address">Dirección *</label>
        <input type="text" name="shipping_address" id="shipping_address" value="<?php bind(oneOf(getGlobal('shippingAddress'), getPreformData('shipping_address', getCurrentUser()->address))) ?>">
      </div>

      <div class="form-group">
        <label for="shipping_state" class="<?php fieldHasError('shipping_state', 'error') ?>">Departamento *</label>
        <input type="text" class="<?php fieldHasError('shipping_state', 'error') ?>" name="shipping_state" id="shipping_state" value="<?php bind(oneOf(getGlobal('shippingState'), getPreformData('shipping_state', getCurrentUser()->state))) ?>">
        <label for="shipping_city" class="align-center <?php fieldHasError('shipping_city', 'error') ?>">Localidad *</label>
        <input type="text" class="<?php fieldHasError('shipping_city', 'error') ?>" name="shipping_city" id="shipping_city" value="<?php bind(oneOf(getGlobal('shippingCity'), getPreformData('shipping_city', getCurrentUser()->city))) ?>">
      </div>
    </div>
    <div class="shipping-info-data collapsable withdraw-auxiliar">
      <div class="form-group">
        <label for="shipping_agency" class="<?php fieldHasError('shipping_agency', 'error') ?>">Agencia de envío*</label>
        <input type="text" class="disabled-withdraw <?php fieldHasError('shipping_agency', 'error') ?>" name="shipping_agency" id="shipping_agency" value="<?php bind(oneOf(getGlobal('shippingAgency'), getPreformData('shipping_agency', ''))) ?>">
        <label for="shipping_zipcode" class="align-center <?php fieldHasError('shipping_zipcode', 'error') ?>">Código postal</label>
        <input type="text" class="disabled-withdraw <?php fieldHasError('shipping_zipcode', 'error') ?>" name="shipping_zipcode" id="shipping_zipcode" value="<?php bind(oneOf(getGlobal('shippingZipcode'), getPreformData('shipping_zipcode', ''))) ?>">
      </div>
    </div>  
    <div>
      <div class="form-line <?php fieldHasError('additional_notes', 'error') ?>">
        <label for="additional_notes">Comentarios adicionales</label>
        <textarea name="additional_notes" id="additional_notes" cols="30" rows="5"><?php bind(oneOf(getGlobal('shippingComments'), getPreformData('additional_notes', ''))) ?></textarea>
      </div>

      <div class="form-actions">
        <button type="submit">
          <i class="fas fa-check"></i> Confirmar
        </button>

        <?php if (shippingInfoFormHasErrors()) : ?>
          <button
            type="reset"
            data-action="switch"
            data-perform="open"
            data-prevent-default="true"
            data-selector=".shipping-info-form"
          >
            <i class="fas fa-times"></i> Cancelar
          </button>
        <?php else : ?>
          <a
            href="#"
            class="button secondary"
            data-action="switch"
            data-perform="close"
            data-prevent-default="true"
            data-selector=".shipping-info-form"
          ><i class="fas fa-times"></i> Cancelar</a>
        <?php endif ?>

      </div>
    </div>
  </fieldset>
</form>