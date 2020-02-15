<?php if (getGlobal('pager')->pages > 1) : ?>
  <div class="pagination">
    <!-- <a href="<?php bind(getPrevPageUrl(getGlobal('pager'))) ?>"><i class="fas fa-arrow-left"></i></a> -->
    <a href="<?php bind(getPrevPageUrl(getGlobal('pager'))) ?>">Anterior</a>

    <?php for ($page = 1; $page <= getGlobal('pager')->pages; $page++) : ?>
      <a class="<?php bind(getGlobal('pager')->active == $page ? 'active' : '') ?>" href="<?php bind(getPageUrl(getGlobal('pager'), $page)) ?>"><?php echo $page ?></a>
    <?php endfor ?>

    <!-- <a href="<?php bind(getNextPageUrl(getGlobal('pager'))) ?>"><i class="fas fa-arrow-right"></i></a> -->
    <a href="<?php bind(getNextPageUrl(getGlobal('pager'))) ?>">Siguiente</a>
  </div>
<?php endif ?>
<div class="per-page">
  <span>Mostrar:</span>

  <a class="<?php
    bind(
      getGetData(
        getGlobal('pager')->model . '_per_page'
      ) == (
        getGlobal('pager_per_page')
      ) ? 'active' : ''
    )
  ?>" href="?<?php
    bind(
      getQueryParams(
        [
          getGlobal('pager')->model . '_per_page' => getGlobal('pager_per_page'),
          getGlobal('pager')->model . '_page' => 1
        ]
      )
    )
  ?>"><?php bind(intval(getGlobal('pager_per_page'))) ?></a>
  
  <a class="<?php
    bind(
      getGetData(
        getGlobal('pager')->model . '_per_page'
      ) == (
        getGlobal('pager_per_page') * 2
      ) ? 'active' : ''
    )
  ?>" href="?<?php
    bind(
      getQueryParams(
        [
          getGlobal('pager')->model . '_per_page' => getGlobal('pager_per_page') * 2,
          getGlobal('pager')->model . '_page' => 1
        ]
      )
    )
  ?>"><?php bind(getGlobal('pager_per_page') * 2) ?></a>

  <a class="<?php
    bind(
      getGetData(
        getGlobal('pager')->model . '_per_page'
      ) == (
        getGlobal('pager_per_page') * 4
      ) ? 'active' : ''
    )
  ?>" href="?<?php
    bind(
      getQueryParams(
        [
          getGlobal('pager')->model . '_per_page' => getGlobal('pager_per_page') * 4,
          getGlobal('pager')->model . '_page' => 1
        ]
      )
    )
  ?>"><?php bind(getGlobal('pager_per_page') * 4) ?></a>
</div>