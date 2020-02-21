<?php

require_once(CORE_LOCATION . 'lib/db.class.php');

/**
 * Get DB connection
 */
function getDB()
{
  return new DB(DB_NAME, DB_HOST, DB_USER, DB_PASS);
}

/* Globals */
/**
 * Set Global variable
 */
function setGlobal($var, $value)
{
  $GLOBALS[$var] = $value;
}

/**
 * Get Global variable
 */
function getGlobal($var)
{
  if (!isset($GLOBALS[$var])) return null;
  return $GLOBALS[$var];
}

/**
 * Get all Global variables
 */
function getGlobals()
{
  return $GLOBALS;
}

/* Session */
/**
 * Set Session variable
 */
function setSession($var, $value)
{
  $_SESSION[$var] = $value;
}

/**
 * Get Session variable
 */
function getSession($var)
{
  if (!isset($_SESSION[$var])) return null;
  return $_SESSION[$var];
}

/* Server */
/**
 * Set Server variable
 * ** Can we?? **
 */
function setServer($var, $value)
{
  $_SERVER[$var] = $value;
}

/**
 * Get Server variable
 */
function getServer($var)
{
  if (!isset($_SERVER[$var])) return null;
  return $_SERVER[$var];
}

/* General Requests */
/**
 * Get Request Data variable
 */
function getRequestData($var)
{
  if (!isset($_REQUEST[$var])) return null;
  return htmlspecialchars(trim($_REQUEST[$var]));
}

/**
 * Get GET request variable
 */
function getGetData($var)
{
  if (!isset($_GET[$var])) return null;
  return htmlspecialchars(trim($_GET[$var]));
}

/**
 * Get POST request variable
 */
function getPostData($var)
{
  if (!isset($_POST[$var])) return null;
  return htmlspecialchars(trim($_POST[$var]));
}

/* Templating */
/**
 * Get Template Absolute Path
 */
function getTemplateAbsolutePath()
{
  return TEMPLATE_ROUTE;
}

/**
 * Get Template Relative Path
 */
function getTemplateRelativePath()
{
  $template = getGlobal('dev_template');
  return TEMPLATE_PATH;
}

/**
 * Get Template
 */
function getTemplate($template, $includepath = true, $includeextension = true)
{
  include(($includepath ? getTemplateAbsolutePath() : '') . $template . ($includeextension ? '.php' : ''));
}

/**
 * Get Query Parammeters
 */
function getQueryParams($additions = null)
{
  $params     = getServer('QUERY_STRING');
  $paramsList = [];
  $paramsObj  = [];
  $returnList = [];

  if (htmlspecialchars(trim($params)) != '') {
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

/**
 * Get Pagination
 */
function getPager($model, $where, $perpage) {
  $collectionCount    = getDB()->countOf($model, $where);
  $pager              = new stdClass();
  $per_page_param     = $model . '_per_page';
  $active_page_param  = $model . '_page';
  $pager->model       = $model;
  $pager->per_page    = intval(oneOf(getGetData($per_page_param), $perpage));
  $pager->active      = intval(oneOf(getGetData($active_page_param), 1));
  $pager->offset      = intval(($pager->active - 1) * $pager->per_page);
  $pager->pages       = intval(ceil($collectionCount / $pager->per_page));
  $pager->items_count = $collectionCount;
  $pager->url         = constructPagerUrl($pager->per_page, $per_page_param, $active_page_param);

  return $pager;
}

/**
 * Construct Pager URL
 */
function constructPagerUrl($perpage, $perpage_param, $page_param)
{
  $url = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '?' . $perpage_param .  '={{per_page}}&' . $page_param . '={{page}}';
  $url = preg_replace('/' . $perpage_param . '=\d+/i', $perpage_param . '={{per_page}}', $url);
  $url = preg_replace('/' . $page_param . '=\d+/i', $page_param . '={{page}}', $url);
  $url = str_replace('{{per_page}}', $perpage, $url);

  return $url;
}

/**
 * Get Previous Page URL
 */
function getPrevPageUrl($pager) {
  if ($pager->active > 1) {
    return str_replace('{{page}}', ($pager->active - 1), $pager->url);
  }

  return str_replace('{{page}}', $pager->pages, $pager->url);
}

/**
 * Get Next Page URL
 */
function getNextPageUrl($pager) {
  if ($pager->active < $pager->pages) {
    return str_replace('{{page}}', ($pager->active + 1), $pager->url);
  }

  return str_replace('{{page}}', 1, $pager->url);
}

/**
 * Get Page URL
 */
function getPageUrl($pager, $page) {
  return str_replace('{{page}}', $page, $pager->url);
}

/**
 * Bind Variable in template
 */
function bind($var)
{
  echo $var;
}

/**
 * Select Variable 2 if Variable 1 is not set
 */
function oneOf($var1, $var2)
{
  return $var1 ? $var1 : $var2;
}

function executeJavaScript($sentence) {
?>
<script>
  <?php echo $sentence ?>;
</script>
<?php
}

function newStatusObject()
{
  $status                   = new stdClass();
  $status->succeeded        = false;
  $status->success          = '';
  $status->errors           = [];
  $status->warnings         = [];
  $status->fieldsWithErrors = [];

  return $status;
}

/* Debugging  */
function logToConsole($variable, $file = null, $function = null, $line = null)
{
  if (!($logs = getGlobal('__console__logs__'))) {
    $logs = [];
  }

  $vartype = gettype($variable);
  $now     = new DateTime();
  $vardef  = $now->getTimestamp();
  $logs[]  = 'let __php__variable__' . $vardef . count($logs) . '__;';

  if ($vartype != 'string') {
    if (
      $vartype == 'array'
      || $vartype == 'object'
    ) {
      $variable = json_encode($variable);
      $logs[] = '__php__variable__ = ' . $variable . ';';
    }

    if (
      $vartype == 'boolean'
      || $vartype == 'integer') {
      $logs[] = '__php__variable__ = ' . $variable . ';';
    }
  } else {
    $logs[] = '__php__variable__ = "' . $variable .'";';
  }

  $date = new DateTime('NOW', new DateTimeZone('AMERICA/MONTEVIDEO'));

  if (isset($file)) {
    $logs[] = 'console.log(\'' . $date->format('Y-m-d H:i') . ' #PHP:[' . addslashes($file) . '][' . $function . ']:' . $line . '\');';
    $logs[] = 'console.log(\'' . $date->format('Y-m-d H:i') . ' ->>>>> \', __php__variable__)';
  } else {
    $logs[] = 'console.log(\'' . $date->format('Y-m-d H:i') . '\', __php__variable__)';
  }

  setGlobal('__console__logs__', $logs);
}

function logDebugging()
{
  $consolelogs = getGlobal('__console__logs__');

  if (!empty($consolelogs)) {
  ?>
  <script>
  <?php
    bind(implode("\n", $consolelogs));
  ?>
  </script>
  <?php
  }
}

function debug($message, $file, $function, $line)
{
  if (DEBUG) logToConsole($message, $file, $function, $line);
}
