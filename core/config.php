<?php

define('APP_VERSION', '0.7.9');
define('API_VERSION', '0.4.10');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
