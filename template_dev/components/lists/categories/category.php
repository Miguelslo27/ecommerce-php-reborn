<article>
  <img src="<?php bind(getGlobal('category')->imagen_url) ?>" alt="<?php bind(getGlobal('category')->titulo) ?>">
  <div class="cat-info">
    <span><?php bind(getGlobal('category')->descripcion_breve) ?></span>
    <a href="/categoria/?cid=<?php bind(getGlobal('category')->id) ?>"><?php bind(getGlobal('category')->titulo) ?></a>
    <!-- articles in the category -->
    <span>0 articulos</span>
  </div>
  <?php if (isAdmin()) : ?>
    <div class="admin-category-controls">
      <a href="/categoria/editar/?cid=<?php bind(getGlobal('category')->id) ?>"><i class="far fa-edit"></i></a>
      <a href="/categoria/eliminar/?cid=<?php bind(getGlobal('category')->id) ?>"><i class="far fa-trash-alt"></i></a>
    </div>
  <?php endif ?>
</article>