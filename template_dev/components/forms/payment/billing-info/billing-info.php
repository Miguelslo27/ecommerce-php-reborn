<form action="" class="billing-info" method="POST">
  <fieldset>
    <legend><span>1</span> Datos de facturación</legend>

    <div class="form-group group-grid columns-3">
      <div class="span-2 form-group group-grid columns-2">
        <p><strong>Nombre completo:</strong> <?php bind(getGlobal('billing_name')) ?></p>
        <p class="<?php bind(empty(getGlobal('billing_document')) ? 'error' : '') ?>"><strong>Documento: *</strong> <?php bind(oneOf(getGlobal('billing_document'), 'Sin definir')) ?></p>
        <p class="<?php bind(empty(getGlobal('billing_fulladdress')) ? 'error' : '') ?>"><strong>Dirección: *</strong> <?php bind(oneOf(getGlobal('billing_fulladdress'), 'Sin definir')) ?></p>
        <p><strong>Teléfono:</strong> <?php bind(oneOf(getGlobal('phones'), 'Sin definir')) ?></p>
      </div>

      <div class="side-actions">
        <a href="#"
          class="button icon primary <?php bind(billingInfoIsIncomplete() ? 'disabled' : '') ?>"
          data-action="switch"
          data-selector=".billing-info-form"
          data-prevent-default="true"
          <?php bind(billingInfoIsIncomplete() ? 'data-perform="open"' : '') ?>
        ><i class="far fa-edit"></i></a>
      </div>
    </div>

    <div class="billing-info-form collapsable <?php bind(billingInfoFormHasErrors() || billingInfoIsIncomplete() ? 'open' : 'closed') ?>">
      <input type="hidden" name="action" value="<?php bind(ACTION_UPDATE_CART_BILLING_INFO) ?>">

      <div class="form-group">
        <label for="billing_name" class="<?php fieldHasError('billing_name', 'error') ?>">Nombre *</label>
        <input type="text" class="<?php fieldHasError('billing_name', 'error') ?>" name="billing_name" id="billing_name" value="<?php bind(getPreformData('billing_name', getGlobal('billing_name'))) ?>">
        <label for="billing_document" class="align-center <?php fieldHasError('billing_document', 'error') ?>">RUT o Cédula * </label>
        <input type="text" class="<?php fieldHasError('billing_document', 'error') ?>" name="billing_document" id="billing_document" value="<?php bind(getPreformData('billing_document', getGlobal('billing_document'))) ?>">
      </div>

      <div class="form-group">
        <label for="billing_address" class="<?php fieldHasError('billing_address', 'error') ?>">Dirección *</label>
        <input type="text" class="<?php fieldHasError('billing_address', 'error') ?>" name="billing_address" id="billing_address" value="<?php bind(getPreformData('billing_address', getGlobal('billing_address'))) ?>">
        <label for="billing_state" class="align-center <?php fieldHasError('billing_state', 'error') ?>">Departamento *</label>
        <input type="text" class="<?php fieldHasError('billing_state', 'error') ?>" name="billing_state" id="billing_state" value="<?php bind(getPreformData('billing_state', getGlobal('billing_state'))) ?>">
      </div>

      <div class="form-group">
        <label for="billing_city" class="<?php fieldHasError('billing_city', 'error') ?>">Localidad *</label>
        <input type="text" class="<?php fieldHasError('billing_city', 'error') ?>" name="billing_city" id="billing_city" value="<?php bind(getPreformData('billing_city', getGlobal('billing_city'))) ?>">
        <label for="billing_zipcode" class="align-center <?php fieldHasError('billing_zipcode', 'error') ?>">Código postal</label>
        <input type="text" class="<?php fieldHasError('billing_zipcode', 'error') ?>" name="billing_zipcode" id="billing_zipcode" value="<?php bind(getPreformData('billing_zipcode', getGlobal('billing_zipcode'))) ?>">
      </div>

      <div class="form-actions">
        <button type="submit">
          <i class="fas fa-check"></i> Guardar
        </button>
        <button
          type="reset"
          data-action="switch"
          data-perform="<?php bind(billingInfoIsIncomplete() ? 'open' : 'close') ?>"
          data-selector=".billing-info-form"
          <?php bind(billingInfoIsIncomplete() ? 'disabled' : '') ?>
        >
          <i class="fas fa-times"></i> Cancelar
        </button>
      </div>
    </div>
  </fieldset>
</form>