<?php

define('APP_VERSION', '0.13.0');
define('API_VERSION', '0.9.0');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
