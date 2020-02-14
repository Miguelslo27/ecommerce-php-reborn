<?php

define('APP_VERSION', '0.6.4');
define('TEMPLATE', $_SERVER['DOCUMENT_ROOT'] . '/template/');

define('CATEGORIES_PER_PAGE', 6);
define('ARTICLES_PER_PAGE', 6);
define('USERS_PER_PAGE', 10);

define('DB_NAME', getenv('DB_NAME'));
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));

/* CONSTANTS FOR COMMON USE */
define('ACTION_LOGIN', 'login');
define('ACTION_USER_REGISTRATION', 'user_registration');
define('ACTION_SAVE_CATEGORY', 'save_category');
define('ACTION_SAVE_ARTICLE', 'save_article');
define('ACTION_ADD_TO_CART', 'add_to_cart');
