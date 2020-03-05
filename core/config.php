<?php

define('APP_VERSION', '0.7.7');
define('API_VERSION', '0.4.9');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
