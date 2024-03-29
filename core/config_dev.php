<?php

define('DEBUG', false);

/* TEMPLATE */
define('TEMPLATE_PATH', '/template_dev/');
define('ADMIN_TEMPLATE_PATH', '/admin/templates/');
define('TEMPLATE_ROUTE', $_SERVER['DOCUMENT_ROOT'] . TEMPLATE_PATH);
define('ADMIN_TEMPLATE_ROUTE', $_SERVER['DOCUMENT_ROOT'] . ADMIN_TEMPLATE_PATH);
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

define('SMTPHOST', getenv('SMTPHOST'));
define('SMTPUSER', getenv('SMTPUSER'));
define('SMTPPASS', getenv('SMTPPASS'));

/* CONSTANTS FOR COMMON USE */
define('ACTION_LOGIN', 'login');
define('ACTION_LOGOUT', 'logout');
define('ACTION_USER_REGISTRATION', 'user_registration');
define('ACTION_USER_EDITION', 'user_edition');
define('ACTION_SAVE_CATEGORY', 'save_category');
define('ACTION_SAVE_ARTICLE', 'save_article');
define('ACTION_ADD_TO_CART', 'add_to_cart');
define('ACTION_SEND_EMAIL', 'send_email');
define('ACTION_OBTAIN_PASSWORD', 'obtain_password');
define('ACTION_CHANGE_PASSWORD', 'change_password');
define('ACTION_EDIT_SITE', 'site_edition');
define('ACTION_EDIT_SITE_NETWORKS', 'site_networks_edition');
define('ACTION_HANDLE_CATEGORY', 'handle_category');
define('ACTION_REMOVE_CATEGORY', 'remove_category');
define('ACTION_RESTORE_CATEGORY', 'restore_category');
define('ACTION_HANDLE_ARTICLE', 'handle_article');
define('ACTION_RESTORE_ARTICLE', 'restore_article');
define('ACTION_REMOVE_ARTICLE', 'remove_article');
define('ACTION_HANDLE_SUSPEND_USER', 'handle_suspend_user');
define('ACTION_CREATE_USER', 'create_user');

/* CONSTANTS FOR PAYMENT */
define('ACTION_UPDATE_CART_BILLING_INFO', 'update_cart_billing_info');
define('ACTION_UPDATE_CART_SHIPPING_INFO', 'update_cart_shipping_info');
define('ACTION_UPDATE_CART_PAYMENT_INFO', 'update_cart_payment_info');

/* REGULAR EXPRESSIONS */
define('REG_EXP_EMAIL_FORMAT', '/^[a-z0-9]+[a-z0-cribir9_.-]+@[a-z0-9_.-]{3,}.[a-z0-9_.-]{1,}.$/');
define('REG_EXP_STRING_FORMAT', '/^[\w \.\,\/]*$/');
define('REG_EXP_NAME_FORMAT', '/^[\[a-zA-Z \.]*$/');
define('REG_EXP_STRING_NUMBER_FORMAT', '/^[\d]+[\d \-]*[\d]+$/');
define('REG_EXP_NUMBER_FORMAT', '/^[\d]+$/');
define('REG_EXP_URI_FORMAT', '/^[-a-zA-Z0-9@:%_\+.~.\#?&\/=]*$/');

/* DEFAULT REQUIRED TEMPLATES PATHS */
define('ERROR_404_TEMPLATE', 'pages/404');
define('HOME_TEMPLATE', 'pages/home');
define('SEARCH_TEMPLATE', 'pages/search');
define('CONTACT_TEMPLATE', 'pages/contact');
define('CATEGORIES_TEMPLATE', 'pages/categories');
define('CATEGORY_TEMPLATE', 'pages/category');
define('ARTICLES_TEMPLATE', 'pages/articles');
define('ARTICLE_TEMPLATE', 'pages/article');
define('REGISTER_TEMPLATE', 'pages/register');
define('LOGIN_TEMPLATE', 'pages/login');
define('FORGOT_PASS_TEMPLATE', 'pages/forgot');
define('ACCOUNT_TEMPLATE', 'pages/acount');
define('PASSWORD_TEMPLATE', 'pages/password');
define('CART_TEMPLATE', 'pages/cart');
define('ORDER_TEMPLATE', 'pages/order');
define('BILLING_FORM_TEMPLATE', 'pages/billing');
define('PAYMENT_TEMPLATE', 'pages/payment');
define('SHIPPING_TEMPLATE', 'pages/shipping');


define('ADMIN_TEMPLATE', 'pages/dashboard');
define('ADMIN_TEMPLATE_CONFIG', 'pages/configuration');
define('ADMIN_TEMPLATE_CATEGORIES', 'pages/categories');
define('ADMIN_TEMPLATE_ARTICLES', 'pages/articles');
define('ADMIN_TEMPLATE_USERS', 'pages/users');