<?php

require_once('db.class.php');

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
function getTemplatePath()
{
  return TEMPLATE;
}
