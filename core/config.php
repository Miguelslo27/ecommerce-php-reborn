<?php

define('APP_VERSION', '0.22.7-alpha');
define('API_VERSION', '0.16.6-alpha');

if (!empty(getenv('ENV'))) {
  require_once('config_' . getenv('ENV') . '.php');
} else {
  require_once('config_dev.php');
}
