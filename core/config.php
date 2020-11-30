<?php

define('APP_VERSION', '0.21.4-alpha');
define('API_VERSION', '0.15.3-alpha');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
