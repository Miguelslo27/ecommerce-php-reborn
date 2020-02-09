<header>
  <div class="header-inner">
    <div class="site-nav">
      <div class="logo">
        DEMO
      </div>
    </div>

    <div class="store-nav">
      <nav class="navigation">
        <a href="/" class="access-menu normal-tab <?php if ($GLOBALS['appPlace'] == "home") echo 'is-active'; ?>">Home</a>

        <div class="dropdown-nav">
          <a href="/categorias" class="access-menu dropdown-tab <?php if ($GLOBALS['appPlace'] == "categories") echo 'is-active'; ?>">
            <i class="fas fa-bars"></i>
            <span>Categorías</span>
          </a>
          <div class="dropdown">
            <?php if (isAdmin()) : ?>
              <a href="/categoria/nueva" class="access-menu dropdown-item">Nueva</a>
              <hr>
            <?php endif ?>
            <a href="/categorias" class="access-menu dropdown-item">Test 1</a>
            <a href="/categorias" class="access-menu dropdown-item">Test 2</a>
          </div>
        </div>

        <?php if (isAdmin()) : ?>
          <div class="dropdown-nav">
            <a href="/productos" class="access-menu dropdown-tab <?php if ($GLOBALS['appPlace'] == "articles") echo 'is-active'; ?>">
              <i class="fas fa-bars"></i>
              <span>Productos</span>
            </a>
            <div class="dropdown">
              <a href="/producto/nuevo" class="access-menu dropdown-item">Nuevo</a>
            </div>
          </div>
        <?php else : ?>
          <a href="/productos" class="access-menu normal-tab <?php if ($GLOBALS['appPlace'] == "articles") echo 'is-active'; ?>">Productos</a>
        <?php endif ?>
        <a href="/contacto" class="access-menu normal-tab <?php if ($GLOBALS['appPlace'] == "contact") echo 'is-active'; ?>">Contacto</a>
      </nav>

      <div class="search-box">
        <form action="/busqueda/" method="GET">
          <input type="text" name="clave" class="search-input" placeholder="Qué deseas encontrar?">
          <button type="submit" class="search-button">
            <i class="fas fa-search"></i>
          </button>
        </form>
      </div>

      <div class="user-actions">
        <?php
        if (isLoggedIn()) {
          include($template_path . 'user/logged-cmds.php');
        } else {
          include($template_path . 'user/not-logged-cmds.php');
        }
        ?>
      </div>
    </div>
  </div>
</header>