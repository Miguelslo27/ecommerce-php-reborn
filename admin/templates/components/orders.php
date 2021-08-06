<div class="form-container form-xl">
    <div class="form-container">
        <div class="form big-form" data-success="" id="list-users">
            <?php $users = getUsers('`status` = 1'); ?>
            <h2>Lista de Usuarios</h2>
            <div class="table-row text-center">
                <div class="cell num-id"><b>Numero Identificador</b></div>
                <div class="cell name-pedido"><b>Nombre</b></div>
                <div class="cell img-pedido"><b>Imagen</b></div>
                <div class="cell precio-pedido"><b>Precio</b></div>
            </div>
        </div>
    </div>