<article>
  <?php if (!empty(getGlobal('category')->images_url)) : ?>
    <img src="<?php bind(getGlobal('category')->images_url) ?>" alt="<?php bind(getGlobal('category')->title) ?>">
  <?php else : ?>
    <img src="/template_dev/media/no-image.png" alt="<?php bind(getGlobal('category')->title) ?>">
  <?php endif ?>
  <div class="cat-info">
    <span><?php bind(getGlobal('category')->brief_description) ?></span>
    <a href="/categoria/?cid=<?php bind(getGlobal('category')->id) ?>"><?php bind(getGlobal('category')->title) ?></a>
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