<?php

function getQueryParams($additions = null)
{
  $params     = getServer('QUERY_STRING');
  $paramsList = [];
  $paramsObj  = [];
  $returnList = [];

  if (trim($params) != '') {
    $paramsList = explode('&', $params);
  }

  foreach ($paramsList as $value) {
    $paramKeyValue        = explode('=', $value);
    $paramKey             = $paramKeyValue[0];
    $parmaValue           = isset($paramKeyValue[1]) ? $paramKeyValue[1] : 'true';
    $paramsObj[$paramKey] = $parmaValue;
  }

  if ($additions) {
    foreach ($additions as $addition => $value) {
      if ($value) {
        $paramsObj[$addition] = $value;
      } else {
        unset($paramsObj[$addition]);
      }
    }
  }

  foreach ($paramsObj as $param => $value) {
    $returnList[] = "$param=$value";
  }

  return implode('&', $returnList);
}

// @To-Do
function newDocument($page_name, $sub_page_name, $includes, $getbefore = null)
{
  if (isset($getbefore) && gettype($getbefore) === 'object') {
    $getbefore();
  }

  startNewDocument();

  $classes = ['container'];
  if (isset($page_name) && trim($page_name) !== '') {
    $classes[] = '__' . $page_name . '__';
  }

  if (isset($sub_page_name) && trim($sub_page_name) !== '') {
    $classes[] = '__' . $sub_page_name . '__';
  }

  ?>
  <div class="<?php echo implode(' ', $classes) ?>">
  <?php
  
  foreach ($includes as $file) {
    include(getTemplatePath() . $file . '.php');
  }

  ?>
  </div>
  <?php

  endNewDocument();
}

function startNewDocument()
{
  ?>
  <!doctype html>
  <html lang="es">
  <head>
    <title>Demo Site - e-Com.uy</title>
    <?php include(getTemplatePath() . 'include_metatags.php') ?>
    <?php include(getTemplatePath() . 'include_css.php') ?>
  </head>
  <body class="page_<?php echo getGlobal('page') ?>">
    <?php include(getTemplatePath() . 'header.php') ?>
  <?php
}

function endNewDocument()
{
  ?>
    <?php include(getTemplatePath() . 'footer.php') ?>
    <?php include(getTemplatePath() . 'include_js.php') ?>
  </body>
  </html>
  <?php
}
