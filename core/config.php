<?php

define('APP_VERSION', '0.7.11');
define('API_VERSION', '0.4.11');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
