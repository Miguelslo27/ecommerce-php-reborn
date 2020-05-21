<header>
  <div class="header-inner">
    <div class="site-nav">
      <div class="logo">
        <a href="/" <?php if (getGlobal('page') == "home") echo 'is-active'; ?>>
          DEMO
        </a>
      </div>
    </div>

    <div class="store-nav">
      <nav class="navigation">
        <a href="/" class="access-menu normal-tab <?php if (getGlobal('page') == "home") echo 'is-active'; ?>">Home</a>

        <div class="dropdown-nav">
          <a href="/categorias" class="access-menu dropdown-tab <?php if (getGlobal('page') == "categories") echo 'is-active'; ?>">
            <i class="fas fa-bars"></i>
            <span>Categorías</span>
          </a>
          <div class="dropdown">
            <?php if (isAdmin()) : ?>
              <a href="/categoria/nueva" class="access-menu dropdown-item">Nueva</a>
              <hr>
            <?php endif ?>
            <?php if (count(getGlobal('categories')) > 7) : ?>
              <?php
                setGlobal('categories', array_slice(getGlobal('categories'), 0, 7));
                setGlobal('display_more', true);
              ?>
            <?php endif ?>
            <?php if (count(getGlobal('categories')) > 0) : ?>
              <?php foreach (getGlobal('categories') as $category) : ?>
                <?php
                  setGlobal('category', $category);
                  getTemplate('components/header/category-item')
                ?>
              <?php endforeach ?>
              <?php if ((getGlobal('display_more')) == true) : ?>
                <a href="/categorias" class="access-menu dropdown-item more-item" >Mostrar más!</a>
              <?php endif ?>
            <?php else : ?>
              <h2 class>No se encontraron categorías destacadas</h2>
              <?php if (isAdmin()) : ?>
                  <a href="/categoria/nueva">Nueva categoría +</a>
              <?php endif ?>
            <?php endif ?>
          </div>
        </div>

        <?php if (isAdmin()) : ?>
          <div class="dropdown-nav">
            <a href="/articulos" class="access-menu dropdown-tab <?php if (getGlobal('page') == "articles") echo 'is-active'; ?>">
              <i class="fas fa-bars"></i>
              <span>Productos</span>
            </a>
            <div class="dropdown">
              <a href="/articulo/nuevo" class="access-menu dropdown-item">Nuevo</a>
            </div>
          </div>
        <?php else : ?>
          <a href="/articulos" class="access-menu normal-tab <?php if (getGlobal('page') == "articles") echo 'is-active'; ?>">Productos</a>
        <?php endif ?>
        <a href="/contacto" class="access-menu normal-tab <?php if (getGlobal('page') == "contact") echo 'is-active'; ?>">Contacto</a>
      </nav>

      <div class="search-box">
        <form action="/busqueda/" method="GET">
          <input type="text" name="clave" class="search-input" placeholder="Buscar...">
          <button type="submit" class="search-button">
            <i class="fas fa-search"></i>
          </button>
        </form>
      </div>

      <div class="user-actions">
        <?php
        if (isLoggedIn()) {
          getTemplate('components/header/user-commands/logged');
        } else {
          getTemplate('components/header/user-commands/not-logged');
        }
        ?>
      </div>
    </div>
  </div>
</header>