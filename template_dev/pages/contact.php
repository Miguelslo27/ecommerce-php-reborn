<?php

newDocument([
  'title' => 'eCommerce - Contacto',
  'page' => 'contact',
  'components' => [
    'components/header/header',
    'components/contact-content/contact-content',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'css/forms.css'
  ],

  'beforeRender' => function ()
  {
    $classesHandler = function ($field, $class)
    {
      bind(
        !empty(getSession('request_messages'))
        && isset(getSession('request_messages')->fieldsWithErrors[$field])
          ? $class
          : ''
      );
    };

    $site       = getSite();
    $networks   = getSiteNetworks();
    $categories = getCategories('`category_id` = 0 AND `status` = 1');

    if (!empty($networks)) {
      foreach($networks as $network) {
        switch ($network->tag) {
          case 'facebook':
            $network->{"icon"} = 'fab fa-facebook-square';
          break;
          case 'instagram':
            $network->{"icon"} = 'fab fa-instagram';
          break;
          case 'twitter':
            $network->{"icon"} = 'fab fa-twitter';
          break;
          case 'youtube':
            $network->{"icon"} = 'fab fa-youtube';
          break;
          default:
            logToConsole('Unexpected switch case', '', '', '');
        }
      }
    }

    setGlobal('categories', oneOf($categories, []));
    setGlobal('classesHandler', $classesHandler);
    setGlobal('site', $site);
    setGlobal('networks', $networks);
  }
]);