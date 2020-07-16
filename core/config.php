<?php

define('APP_VERSION', '0.14.1-alpha');
define('API_VERSION', '0.10.1-alpha');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
