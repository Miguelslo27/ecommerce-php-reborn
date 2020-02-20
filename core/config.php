<?php

define('APP_VERSION', '0.5.1');
define('API_VERSION', '0.3.1');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
