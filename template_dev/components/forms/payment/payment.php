<section class="payment-form">
  <form action="" method="POST">
    <fieldset>
      <legend><span>1</span> Datos de facturación</legend>

      <div class="form-group group-grid columns-3">
        <div class="span-2 form-group group-grid columns-2">
          <p><strong>Nombre completo:</strong> <?php bind(getGlobal('billing_name')) ?></p>
          <p><strong>Documento:</strong> <?php bind(oneOf(getGlobal('billing_document'), 'Sin definir')) ?></p>
          <p><strong>Dirección:</strong> <?php bind(oneOf(getGlobal('billing_fulladdress'), 'Sin definir')) ?></p>
          <p><strong>Teléfono:</strong> <?php bind(oneOf(getGlobal('phones'), 'Sin definir')) ?></p>
        </div>

        <div class="side-actions">
          <a href="#"
            class="button icon primary"
            data-action="switch"
            data-selector=".billing-info-form"
            data-prevent-default="true"
          ><i class="far fa-edit"></i></a>
        </div>
      </div>

      <div class="billing-info-form collapsable <?php formHasError('open', 'closed') ?>">
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
          <button type="reset">
            <i class="fas fa-times"></i> Cancelar
          </button>
        </div>
      </div>
    </fieldset>
  </form>

  <!-- <form action="">
    <fieldset>
      <legend>Datos de envío</legend>

      <div class="form-group group-grid columns-2">
        <label for="shipping-receive">
          <input
            type="radio"
            name="shipping"
            id="shipping-receive"
            value="receive"
            checked
            data-action="switch"
            data-selector=".shipping-form"
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
            data-selector=".shipping-form"
            data-height="0"
          >
          <span>Retiro en el local</span>
        </label>
      </div>

      <div class="shipping-form collapsed visible">
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

        <div class="form-line">
          <label for="agencia">Agencia de envío</label>
          <input type="text" name="agencia" id="agencia" value="<?php getPreformData('agencia', '') ?>">
        </div>
      </div>
    </fieldset>
  </form> -->

  <!-- <form action="">
    <fieldset>
      <legend>Método de pago</legend>

      <div class="form-group group-grid columns-4">
        <label for="payment_cash">
          <input type="radio" name="payment" id="payment_cash" value="cash" checked>
          <span>Efectivo</span>
        </label>

        <label for="payment_bank-brou">
          <input type="radio" name="payment" id="payment_bank-brou" value="bank-brou">
          <span>Depósito BROU</span>
        </label>

        <label for="payment_bank-santander">
          <input type="radio" name="payment" id="payment_bank-santander" value="bank-santander">
          <span>Depósito SANTANDER</span>
        </label>

        <label for="payment_net-abitab">
          <input type="radio" name="payment" id="payment_net-abitab" value="recnet-abitabeive">
          <span>Giro Abitab</span>
        </label>

        <label for="payment_net-redpagos">
          <input type="radio" name="payment" id="payment_net-redpagos" value="net-redpagos">
          <span>Giro RedPagos</span>
        </label>

        <label for="payment_net-mercadopago">
          <input type="radio" name="payment" id="payment_net-mercadopago" value="net-mercadopago">
          <span>MercadoPago</span>
        </label>

        <label for="payment_net-pagosweb">
          <input type="radio" name="payment" id="payment_net-pagosweb" value="net-pagosweb">
          <span>PagosWEB</span>
        </label>

        <label for="payment_net-cobrosya">
          <input type="radio" name="payment" id="payment_net-cobrosya" value="net-cobrosya">
          <span>CobrosYA</span>
        </label>
      </div>
    </fieldset>
  </form> -->
</section>