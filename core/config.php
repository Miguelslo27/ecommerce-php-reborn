<?php

define('APP_VERSION', '0.17.1-alpha');
define('API_VERSION', '0.12.2-alpha');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
