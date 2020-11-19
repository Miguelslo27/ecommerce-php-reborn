<?php

define('APP_VERSION', '0.21.1-alpha');
define('API_VERSION', '0.15.1-alpha');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
