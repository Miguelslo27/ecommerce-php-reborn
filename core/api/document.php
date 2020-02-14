<?php

// @To-Do
function newDocument($settings)
{
  debug('settings = ' . json_encode($settings), __FILE__, __FUNCTION__, __FUNCTION__, __LINE__);

  $title         = isset($settings['title']) ? $settings['title'] : DEFAULT_DOCUMENT_TITLE;
  $page_name     = isset($settings['page']) ? $settings['page'] : DEFAULT_PAGE_NAME;
  $sub_page_name = isset($settings['sub_page']) ? $settings['sub_page'] : DEFAULT_SUB_PAGE_NAME;
  $includes      = isset($settings['components']) ? $settings['components'] : null;
  $callbefore    = isset($settings['callbefore']) ? $settings['callbefore'] : null;

  debug('$title = ' . $title, __FILE__, __FUNCTION__, __LINE__);
  debug('$page_name = ' . $page_name, __FILE__, __FUNCTION__, __LINE__);
  debug('$sub_page_name = ' . $sub_page_name, __FILE__, __FUNCTION__, __LINE__);
  debug('$components = ' . json_encode($includes), __FILE__, __FUNCTION__, __LINE__);
  debug('$callbefore = ' . json_encode($callbefore), __FILE__, __FUNCTION__, __LINE__);

  if (empty($includes)) {
    if (DEBUG) {
      debug('ERROR: newDocument(): [components] list is required to render the document', __FILE__, __FUNCTION__, __LINE__);
    } else {
      throw new Error('newDocument(): [components] list is required to render the document');
    }
  }

  setGlobal('title', $title);
  setGlobal('page', $page_name);
  setGlobal('sub_page', $sub_page_name);

  debug('getGlobal(title) = ' . getGlobal('title'), __FILE__, __FUNCTION__, __LINE__);
  debug('getGlobal(page) = ' . getGlobal('page'), __FILE__, __FUNCTION__, __LINE__);
  debug('getGlobal(sub_page) = ' . getGlobal('sub_page'), __FILE__, __FUNCTION__, __LINE__);

  if (isset($callbefore) && gettype($callbefore) === 'object') {
    $callbefore();
  }

  startNewDocument();

  foreach ($includes as $file) {
    include(getTemplatePath() . $file . '.php');
  }

  endNewDocument();
}

function startNewDocument()
{
  $classes = ['container'];
  if (getGlobal('page') && trim(getGlobal('page')) !== '') {
    $classes[] = '__' . getGlobal('page') . '__';
  }

  if (getGlobal('sub_page') && getGlobal('sub_page') !== '') {
    $classes[] = '__' . getGlobal('sub_page') . '__';
  }

  debug('$classes = ' . json_encode($classes), __FILE__, __FUNCTION__, __LINE__);

  ?>
  <!doctype html>
  <html lang="es">
  <head>
    <title><?php bind(getGlobal('title')) ?></title>
    <?php getTemplate('include_metatags') ?>
    <?php getTemplate('include_css') ?>
  </head>
  <body class="page_<?php bind(getGlobal('page')) ?>">
    <?php getTemplate('header') ?>
  <?php
}

function endNewDocument()
{
  ?>
    <?php getTemplate('footer') ?>
    <?php getTemplate('include_js') ?>
  </body>
  </html>
  <?php
}
