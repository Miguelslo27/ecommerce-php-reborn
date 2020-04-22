<?php

define('APP_VERSION', '0.10.1');
define('API_VERSION', '0.5.12');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
