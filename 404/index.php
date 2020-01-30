<?php

$relative = '..';
include('../includes/common.php');

$userStats = loadUser();
$appPlace = '404';
$appSubPlace = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

?>

<!-- @TODO -->
<!-- Poner todo esto en una page -->
<div class="container home">
  <div class="inner">

    <!-- @TODO -->
    <!-- Crear estilos para pagina 404 -->
    <h1 style="font-size: 56px">
      ¡Ups!
    </h1>
    <h1 style="font-size: 56px">
      Parece que te perdiste...
    </h1>

    <!-- @TODOs -->
    <!-- Crear componente de formulario de busqueda -->
    <!-- Crear estilos propios de este formulario de busqueda -->
    <form action="/busqueda/" method="GET">
      <div class="form-line">
        <label for="clave">Buscar</label>
        <input type="text" name="clave" class="search-input" placeholder="Qué deseas encontrar?">
      </div>
      <div class="form-actions">
        <button type="submit">Buscar</button>
        <button type="reset">Regresar</button>
      </div>
    </form>

    <?php
    include($templatesPath . 'components/categories/featuredCategories.php');
    include($templatesPath . 'components/articles/featuredArticles.php');
    ?>
  </div>
</div>
<?php

loadSection("footer", $userStats);
endDocument();
?>