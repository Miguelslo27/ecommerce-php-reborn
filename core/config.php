<?php

define('APP_VERSION', '0.14.2-alpha');
define('API_VERSION', '0.10.2-alpha');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
