<?php

define('APP_VERSION', '0.10.3-alpha');
define('API_VERSION', '0.7.0-alpha');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
