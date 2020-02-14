<?php

require_once(CORE_LOCATION . '/db.class.php');

function getDB()
{
  return new DB(DB_NAME, DB_HOST, DB_USER, DB_PASS);
}

/* Globals */
function setGlobal($var, $value)
{
  $GLOBALS[$var] = $value;
}

function getGlobal($var)
{
  if (empty($GLOBALS[$var])) return null;
  return $GLOBALS[$var];
}

/* Session */
function setSession($var, $value)
{
  $_SESSION[$var] = $value;
}

function getSession($var)
{
  if (empty($_SESSION[$var])) return null;
  return $_SESSION[$var];
}

/* Server */
function setServer($var, $value)
{
  $_SERVER[$var] = $value;
}

function getServer($var)
{
  if (empty($_SERVER[$var])) return null;
  return $_SERVER[$var];
}

/* General Requests */
function getRequestData($var)
{
  if (empty($_REQUEST[$var])) return null;
  return $_REQUEST[$var];
}

/* Get Requests */
function getGetData($var)
{
  if (empty($_GET[$var])) return null;
  return $_GET[$var];
}

/* Post Requests */
function getPostData($var)
{
  if (empty($_POST[$var])) return null;
  return $_POST[$var];
}

/* Templating */
function getTemplateAbsolutePath()
{
  return TEMPLATE_ROUTE;
}

function getTemplateRelativePath()
{
  $template = getGlobal('dev_template');
  return TEMPLATE_PATH;
}

function getTemplate($template, $includepath = true, $includeextension = true)
{
  include(($includepath ? getTemplateAbsolutePath() : '') . $template . ($includeextension ? '.php' : ''));
}

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

function bind($var)
{
  echo $var;
}

/* Debugging  */
function logToConsole($message, $file = null, $function = null, $line = null)
{
?>
<script>
  console.log('#PHP:<?php echo !empty($file) ? '[' . $file . ']' : '' ?><?php echo !empty($function) ? '::[' . $function . ']' : '' ?>:<?php echo !empty($line) ? $line : '' ?>', '<?php echo $message ?>');
</script>
<?php
}

function debug($message, $file, $function, $line)
{
  if (DEBUG) logToConsole($message, $file, $function, $line);
}
