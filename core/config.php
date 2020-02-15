<?php

define('APP_VERSION', '0.6.4');
define('API_VERSION', '0.2.4');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
