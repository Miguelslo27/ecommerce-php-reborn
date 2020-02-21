<?php

define('APP_VERSION', '0.6.1');
define('API_VERSION', '0.4.2');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
