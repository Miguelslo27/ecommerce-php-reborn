<?php

require_once '../core/core.php';

newDocument([
  'title' => 'eCommerce Demo App',
  'page' => 'home',
  'components' => [
    'components/header/header',
    'components/footer/footer'
  ],
  'stylesheets' => [
    'css/layout.css'
  ],
  'scripts' => []
]);
