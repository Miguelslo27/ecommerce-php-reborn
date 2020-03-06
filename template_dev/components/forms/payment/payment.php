<section class="payment-form">
  <form action="" method="POST">
    <fieldset>
      <legend>Datos personales</legend>

      <div class="form-group">
        <label for="nombre">Nombre *</label>
        <input type="text" class="" name="nombre" id="nombre" value="<?php getPreformData('nombre', getCurrentUser()->nombre) ?>">
        <label for="apellido" class="align-center">Apellido *</label>
        <input type="text" class="" name="apellido" id="apellido" value="<?php getPreformData('nombre', getCurrentUser()->apellido) ?>">
      </div>

      <div class="form-line">
        <label for="email">E-Mail *</label>
        <input type="text" name="email" id="email" value="<?php getPreformData('email', getCurrentUser()->email) ?>">
      </div>

      <div class="form-line">
        <label for="rut">RUT o CI * </label>
        <input type="text" name="rut" id="rut" value="<?php getPreformData('rut', getCurrentUser()->rut) ?>">
      </div>

      <div class="form-group">
        <label for="telefono" class="">Teléfono *</label>
        <input type="text" class="" name="telefono" id="telefono" value="<?php getPreformData('telefono', getCurrentUser()->telefono) ?>">
        <label for="celular" class="align-center">Celular *</label>
        <input type="text" class="" name="celular" id="celular" value="<?php getPreformData('celular', getCurrentUser()->celular) ?>">
      </div>
    </fieldset>

    <fieldset>
      <legend>Datos de envío</legend>

      <div class="form-group group-grid columns-2">
        <label for="shipping-receive">
          <input type="radio" name="shipping" id="shipping-receive" value="receive" checked>
          <span>Deceo recibir mi pedido</span>
        </label>

        <label for="shipping-withdraw">
          <input type="radio" name="shipping" id="shipping-withdraw" value="withdraw">
          <span>Deceo retirar en el local</span>
        </label>
      </div>
    </fieldset>

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
  </form>
</section>