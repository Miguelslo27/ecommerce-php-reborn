<?php

define('APP_VERSION', '0.18.0-alpha');
define('API_VERSION', '0.13.0-alpha');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
