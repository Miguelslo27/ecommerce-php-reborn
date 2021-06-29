<?php

define('APP_VERSION', '0.22.14-alpha');
define('API_VERSION', '0.16.10-alpha');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
