<?php

define('DEBUG', false);

/* TEMPLATE */
define('TEMPLATE_PATH', '/template/');
define('TEMPLATE_ROUTE', $_SERVER['DOCUMENT_ROOT'] . TEMPLATE_PATH);
define('CORE_LOCATION', $_SERVER['DOCUMENT_ROOT'] . '/core/');

/* DEFAULT SETTINGS */
define('CATEGORIES_PER_PAGE', 6);
define('ARTICLES_PER_PAGE', 6);
define('USERS_PER_PAGE', 10);
define('DEFAULT_DOCUMENT_TITLE', 'Untitled document');
define('DEFAULT_PAGE_NAME', null);
define('DEFAULT_SUB_PAGE_NAME', null);

/* DATABASE ACCESS */
define('DB_NAME', getenv('DB_NAME'));
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));

/* CONSTANTS FOR COMMON USE */
define('ACTION_LOGIN', 'login');
define('ACTION_USER_REGISTRATION', 'user_registration');
define('ACTION_USER_EDITION', 'user_edition');
define('ACTION_SAVE_CATEGORY', 'save_category');
define('ACTION_SAVE_ARTICLE', 'save_article');
define('ACTION_ADD_TO_CART', 'add_to_cart');
define('ACTION_OBTAIN_PASSWORD', 'obtain_password');
define('ACTION_CHANGE_PASSWORD', 'change_password');

/* DEFAULT REQUIRED TEMPLATES PATHS */
define('ERROR_404_TEMPLATE', 'pages/404');
define('HOME_TEMPLATE', 'pages/home');
define('SEARCH_TEMPLATE', 'pages/search');
define('CONTACT_TEMPLATE', 'pages/contact');
define('CATEGORIES_TEMPLATE', 'pages/categories');
define('CATEGORY_TEMPLATE', 'pages/category');
define('ARTICLES_TEMPLATE', 'pages/articles');
define('ARTICLE_TEMPLATE', 'pages/article');
define('LOGIN_TEMPLATE', 'pages/login');
define('REGISTER_TEMPLATE', 'pages/register');
define('FORGOT_PASS_TEMPLATE', 'pages/forgot');
define('ACCOUNT_TEMPLATE', 'pages/acount');
define('CART_TEMPLATE', 'pages/cart');
define('ORDER_TEMPLATE', 'pages/order');
define('PAYMENT_TEMPLATE', 'pages/payment');
