<div class="form-container">   
    <!-- LIST CATEGORIES -->
    <?php if (getGlobal('section') === 'lista') : ?>
        <?php $categories = getCategories(); logToConsole('cat', $categories, '', '')?>
        <div class="form big-form" data-success="" id="list-categories">
            <h2>Categorias</h2>
            <?php if (@count($categories) > 0) : ?>
            <div class="table-row text-center">
                <div class="cell cat-id"><b>ID</b></div>
                <div class="cell cat-title"><b>Titulo</b></div>
                <div class="cell cat-dscp"><b>Descripcion</b></div>
                <div class="cell cat-b-dscp"><b>Descripcion Corta</b></div>
                <div class="cell cat-url"><b>Imagen</b></div>
                <div class="cell cat-parent"><b>Categoria Padre</b></div>
            </div>
            <?php for($i = 0; $i < @count($categories); $i++) : ?>
                <div class="table-row <?php bind(($i % 2 === 0) ? 'background' : '')?>">
                    <div class="cell cat-id"><p><?php bind($categories[$i]->id)?></p></div>
                    <div class="cell cat-title"><p><?php bind($categories[$i]->title)?></p></div>
                    <div class="cell cat-dscp"><p><p><?php bind($categories[$i]->description)?></p></p></div>
                    <div class="cell cat-b-dscp"><p><?php bind($categories[$i]->brief_description)?></p></div>
                    <div class="cell cat-url"><p><?php bind($categories[$i]->images_url)?></p></div>
                    <?php if ($categories[$i]->category_id === '0') : ?>
                        <div class="cell cat-parent">-</div>
                    <?php else : ?>
                        <div class="cell cat-parent"><p><?php bind($categories[$i]->category_id)?></p></div>
                    <?php endif ?>
                    <div class="actions list-admin-buttons">
                        <a href="/admin/categorias/?cid=lista&action=edit&id=<?php bind($categories[$i]->id)?>"><i class="fas fa-edit"></i> Editar</a>
                        <a class="remove-button remove-admin-button" data-action="<?php bind(ACTION_EDIT_SITE)?>" data-type="remove-admin" data-input="<?php bind($categories[$i]->id)?>"><i class="fas fa-trash-alt"></i> Eliminar</a>
                    </div>
                </div>
            <?php endfor ?>
            <?php else : ?>
                <h5 class="text-not-elements">De momento no hay categorias.</h5>
            <?php endif ?>
        </div>  
    <?php endif ?>
</div>