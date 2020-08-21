<?php

newDocument([
  'title' => 'eCommerce - Mi Cuenta',
  'page' => 'password',
  'components' => [
    'components/header/header',
    'components/account/password/password',
    'components/footer/footer'
  ],
  'styles' => [
    'components/account/account.css',
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'css/forms.css',
    'components/account/password/form-password.css'
  ],
]);