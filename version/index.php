<?php

require_once '../core/core.php';

newDocument([
  'title' => 'eCommerce Demo App',
  'page' => 'home',
  'components' => [
    'components/header/header',
    'components/test',
    'components/footer/footer'
  ],
  'styles' => [
    'css/layout.css',
    'css/forms.css'
  ],
  'scripts' => [],
  'beforeRender' => function ()
  {
    // getSession('request_messages');
  }
]);
