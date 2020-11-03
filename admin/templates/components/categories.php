<div class="form-container">   
    <!-- LIST CATEGORIES -->
    <?php if (getGlobal('section') === 'lista') : ?>
        <?php $categories = getCategories('`status` = 1');?>
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
    <!-- NEW CATEGORY -->
    <?php if (getGlobal('section') === 'nueva') : ?>
        <?php $parentCategories = getCategories('`category_id` = 0 AND `status` = 1');?>
        <form class="form" action="" method="POST">
            <h2>Crear Categoría</h2>
            <input type="hidden" name="action" value="<?php bind('ACTION_CREATE_CATEGORY') ?>">
            <div class="form-group">
                <label for="category_title">Titulo:</label>
                <input name="category_title" id="category_title" type="text" class="<?php fieldHasError('category_title', 'error') ?>" value="<?php bind(getPreformData('category_title', '')) ?>">
            </div>
            <div class="form-group">
                <label for="category_dscp">Descripción:</label>
                <input name="category_dscp" id="category_dscp" type="text" class="<?php fieldHasError('category_dscp', 'error') ?>" value="<?php bind(getPreformData('category_dscp', '')) ?>">
            </div>
            <div class="form-group">
                <label for="category_dscp_short">Descripción Corta:</label>
                <input name="category_dscp_short" id="category_dscp_short" type="text" class="<?php fieldHasError('category_dscp_short', 'error') ?>" value="<?php bind(getPreformData('category_dscp_short', '')) ?>">
            </div>
            <div class="form-group">
                <label for="category_img_url">Imagenes (URL):</label>
                <input name="category_img_url" id="category_img_url" type="text" class="<?php fieldHasError('category_img_url', 'error') ?>" value="<?php bind(getPreformData('category_img_url', '')) ?>">
            </div>
            <div class="form-group">
                <label for="category_parent">Categoría Padre:</label>
                <select name="category_parent" id="category_parent" type="text" value="<?php bind(getPreformData('category_parent', '')) ?>" <?php empty($parentCategories) ? bind('disabled') : ''?>>
                    <?php if (!empty($parentCategories)) : ?>
                        <?php foreach($parentCategories as $category) : ?>
                            <option value="<?php bind($category->title)?>"><?php bind($category->title)?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
            <div class="button-container">
                <button class="button" type="submit">
                <i class="fas fa-check"></i> Guardar
                </button>
            </div>
        </form>  
    <?php endif ?>
</div>