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

function getSessions()
{
  return $_SESSION;
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
function getServer($var = null)
{
  if (!isset($var)) return $_SERVER;
  if (!isset($_SERVER[$var])) return null;
  return $_SERVER[$var];
}

function getServers()
{
  return $_SERVER;
}

function getRealIP()
{
  if (!empty(getServer("HTTP_CLIENT_IP"))) {
    return getServer("HTTP_CLIENT_IP");
  } elseif (!empty(getServer("HTTP_X_FORWARDED_FOR"))) {
    return getServer("HTTP_X_FORWARDED_FOR");
  } elseif (!empty(getServer("HTTP_X_FORWARDED"))) {
    return getServer("HTTP_X_FORWARDED");
  } elseif (!empty(getServer("HTTP_FORWARDED_FOR"))) {
    return getServer("HTTP_FORWARDED_FOR");
  } elseif (!empty(getServer("HTTP_FORWARDED"))) {
    return getServer("HTTP_FORWARDED");
  } else {
    return getServer("REMOTE_ADDR");
  }
}

/* General Requests */
function setRequestData($var, $value)
{
  $_REQUEST[$var] = $value;
}

/**
 * Get Request Data variable
 */
function getRequestData($var)
{
  if (!isset($_REQUEST[$var])) return null;
  return htmlspecialchars(trim($_REQUEST[$var]));
}

function getRequestAll()
{
  return $_REQUEST;
}

/**
 * Get GET request variable
 */
function getGetData($var)
{
  if (!isset($_GET[$var])) return null;
  return htmlspecialchars(trim($_GET[$var]));
}

function getGetAll()
{
  return $_GET;
}

/**
 * Get POST request variable
 */
function getPostData($var)
{
  if (!isset($_POST[$var])) return null;
  return htmlspecialchars(trim($_POST[$var]));
}

function getPostAll()
{
  return $_POST;
}

/* Templating */
/**
 * Get Template Absolute Path
 */
function getTemplateAbsolutePath($isAdmin = false)
{
  return ($isAdmin || getGlobal('page') == 'admin') ? ADMIN_TEMPLATE_ROUTE : TEMPLATE_ROUTE;
}

/**
 * Get Template Relative Path
 */
function getTemplateRelativePath()
{
  $template = getGlobal('dev_template');
  return (getGlobal('page') == 'admin') ? ADMIN_TEMPLATE_PATH : TEMPLATE_PATH;
}

/**
 * Get Template
 */
function getTemplate($template, $includepath = true, $includeextension = true)
{
  $templateLocation = ($includepath ? getTemplateAbsolutePath() : getTemplateAbsolutePath(true)) . $template . ($includeextension ? '.php' : '');
  /**
   * @TODO
   * Add the hability to include index.php without specify the file name
   * just the folder
   */
  include($templateLocation);
}

function getRequestURIPath()
{
  return explode('?', getServer('REQUEST_URI'))[0];
}

function getQueryParamsByName($names = null)
{
  $params     = getServer('QUERY_STRING');
  $paramsList = [];
  $paramsObj  = [];

  if (htmlspecialchars(trim($params)) != '') {
    $paramsList = explode('&', $params);
  }

  foreach ($paramsList as $value) {
    $paramKeyValue        = explode('=', $value);
    $paramKey             = $paramKeyValue[0];
    $paramValue           = isset($paramKeyValue[1]) ? $paramKeyValue[1] : 'true';

    if (!$names || in_array($paramKey, $names)) {
      $paramsObj[$paramKey] = $paramValue;
    }
  }

  return $paramsObj;
}

/**
 * Get Query Parammeters
 */
function getQueryParams($additions = null)
{
  $paramsObj  = getQueryParamsByName();
  $returnList = [];

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

  array_reverse($returnList);
  return implode('&', $returnList);
}

/**
 * Get Parameter
 */
function getParam($paramName)
{
  $paramValue = getQueryParamsByName([$paramName])[$paramName];
  return $paramValue;
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
  $url = '?' . getQueryParams([$perpage_param => '{{per_page}}', $page_param => '{{page}}']);
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
  return isset($var1) && !empty($var1) ? $var1 : $var2;
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

function getPreformData($data, $or)
{
  if (getPostData($data)) {
    return getPostData($data);
  }

  return $or;
}

/* Debugging  */
function logToConsole($prefix, $variable, $file = null, $function = null, $line = null)
{
  if (!($logs = getGlobal('__console__logs__'))) {
    $logs = [];
  }

  $vartype = gettype($variable);
  $now     = new DateTime();
  $vardef  = $now->getTimestamp();
  $varname = '__php__variable__' . $vardef . count($logs) . '__';
  $logs[]  = "let $varname;";

  if ($vartype != 'string') {
    if (
      $vartype == 'array'
      || $vartype == 'object'
    ) {
      $variable = json_encode($variable);
      $logs[] = $varname . ' = ' . $variable . ';';
    }

    if ($vartype == 'boolean') {
      $logs[] = $varname . ' = ' . ($variable ? 'true' : 'false') . ';';
    }

    if ($vartype == 'integer') {
      $logs[] = $varname . ' = ' . $variable . ';';
    }

    if ($vartype == 'NULL') {
      $logs[] = $varname . ' = null;';
    }
  } else {
    $strvar = str_replace('`', '\`', $variable);
    $logs[] = $varname . ' = `' . $strvar .'`;';;
  }

  $date   = new DateTime('NOW', new DateTimeZone('AMERICA/MONTEVIDEO'));

  if (
    empty(getSession('ruri'))
    || getSession('ruri') != getServer('REQUEST_URI')
  ) {
    setSession('ruri', getServer('REQUEST_URI'));
    error_log('--------------------------------------------------------------' . "\n", 3, getServer('DOCUMENT_ROOT') . '/debug.txt');
    error_log('--------------- ' . getSession('ruri') . "\n", 3, getServer('DOCUMENT_ROOT') . '/debug.txt');
    error_log('--------------------------------------------------------------' . "\n", 3, getServer('DOCUMENT_ROOT') . '/debug.txt');
  } else {
    setSession('ruri', getServer('REQUEST_URI'));
  }

  if (isset($file)) {
    $logs[] = 'console.log(\'%c' . $date->format('Y-m-d H:i') . ' #PHP:[' . addslashes($file) . '][' . $function . ']:' . $line . '\', \'font-size: 14px; font-weight: bold; color: #474A8A\');';
    $logs[] = 'console.log(\'%c' . $date->format('Y-m-d H:i') . (!empty($prefix) ? ' ' . $prefix : '') . ' ->>>>> \', \'font-size: 14px; font-weight: bold;\', ' . $varname . ')';

    error_log($date->format('Y-m-d H:i') . ' [' . addslashes($file) . '][' . $function . ']:' . $line . "\n", 3, getServer('DOCUMENT_ROOT') . '/debug.txt');
    error_log($date->format('Y-m-d H:i') . (!empty($prefix) ? ' ' . $prefix : '') . ' ->>>>> ' . $variable . "\n", 3, getServer('DOCUMENT_ROOT') . '/debug.txt');
  } else {
    $logs[] = 'console.log(\'%c' . $date->format('Y-m-d H:i') . (!empty($prefix) ? ' ' . $prefix : '') . '\', \'font-size: 14px; font-weight: bold;\', ' . $varname . ')';

    error_log($date->format('Y-m-d H:i') . ' ' . (!empty($prefix) ? ' ' . $prefix : '') . $variable . "\n", 3, getServer('DOCUMENT_ROOT') . '/debug.txt');
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
  if (DEBUG) logToConsole('', $message, $file, $function, $line);
}
