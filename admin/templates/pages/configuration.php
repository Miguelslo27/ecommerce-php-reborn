<?php

newDocument([
  'title' => 'eCommerce - Administrar Configuración',
  'page' => 'admin',
  'sub_page' => 'configuration',
  'components' => [
    'components/navbar',
    'components/searcher',
    'components/configuration'
  ],
  'styles' => [
    'components/css/fontawesome/css/all.min.css',
    'components/css/admin.css',
    'components/css/forms.css'
  ],
  'scripts' => [
    'components/admin.js'
  ],
  'beforeRender' => function ()
  {
    if (!isAdmin()) {
      header('Location: /');
      exit;
    }

    if (!isSuperAdmin()) {
      header('Location: /admin');
      exit;
    }

    $id = getServer('REQUEST_URI');
    $id = explode("=", $id);
    $query_param = null;
    $second_query_param = null;

    if (@$id[3] !== null) {
      $second_query_param = $id[3];
    }
    if (@$id[2] !== null) {
      $query_param = $id[2];
      $id = $id[1];
      $id = explode("&", $id);
      $id = $id[0];
    } else {
      $id = $id[1];
    }
    
    //NETWORKS
    $facebook         = new stdClass();
    $facebook->title  = 'Facebook';
    $facebook->name   = 'facebook';
    $facebook->icon   = 'fa-facebook-square';
    $facebook->uri    = @getGlobal('uri_networks')->facebook;

    $instagram        = new stdClass();
    $instagram->title = 'Instagram';
    $instagram->name  = 'instagram';
    $instagram->icon  = 'fa-instagram-square';
    $instagram->uri   = @getGlobal('uri_networks')->instagram;

    $twitter          = new stdClass();
    $twitter->title   = 'Twitter';
    $twitter->name    = 'twitter';
    $twitter->icon    = 'fa-twitter';
    $twitter->uri     = @getGlobal('uri_networks')->twitter;

    $youtube          = new stdClass();
    $youtube->title   = 'Youtube';
    $youtube->name    = 'youtube';
    $youtube->icon    = 'fa-youtube';
    $youtube->uri     = @getGlobal('uri_networks')->youtube;

    $networks_object = [$facebook, $instagram, $twitter, $youtube];

    setGlobal('section', $id);
    setGlobal('query_param', $query_param);
    setGlobal('networks_object', $networks_object);
    setGlobal('second_query_param', $second_query_param);
  }
]);

function fieldHasError($field, $class)
{
  bind(
    !empty(getSession('request_messages'))
    && isset(getSession('request_messages')->fieldsWithErrors[$field])
    && getSession('request_messages')->fieldsWithErrors[$field]
      ? $class
      : ''
  );
}