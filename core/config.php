<?php

define('APP_VERSION', '0.6.3');

define('TEMPLATE', $relative . 'template/');
define('CATEGORIES_PER_PAGE', 6);
define('ARTICLES_PER_PAGE', 6);
define('USERS_PER_PAGE', 10);

define('DB_NAME', getenv('DB_NAME'));
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
