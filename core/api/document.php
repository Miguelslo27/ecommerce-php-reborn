<?php

/**
 * New Document
 */
function newDocument($settings)
{
  $title         = isset($settings['title']) ? $settings['title'] : DEFAULT_DOCUMENT_TITLE;
  $page_name     = isset($settings['page']) ? $settings['page'] : DEFAULT_PAGE_NAME;
  $sub_page_name = isset($settings['sub_page']) ? $settings['sub_page'] : DEFAULT_SUB_PAGE_NAME;

  setGlobal('title', $title);
  setGlobal('page', $page_name);
  setGlobal('sub_page', $sub_page_name);

  call_beforeRender_function($settings);
  renderDocument($settings);
  call_afterRender_function($settings);
}

/**
 * Handle Call Before Render Function
 */
function call_beforeRender_function($settings)
{
  $beforeRender = isset($settings['beforeRender']) ? $settings['beforeRender'] : null;

  if (isset($beforeRender) && gettype($beforeRender) === 'object') {
    $beforeRender();
  }
}

/**
 * Handle Call After Render Function
 */
function call_afterRender_function($settings)
{
  // TODO
  $afterRender = isset($settings['afterRender']) ? $settings['afterRender'] : null;

  if (isset($afterRender) && gettype($afterRender) === 'object') {
    $afterRender();
  }
}

/**
 * Render Document
 */
function renderDocument($settings)
{
  $components = isset($settings['components']) ? $settings['components'] : null;

  if (empty($components)) {
    if (DEBUG) {
      debug('ERROR: newDocument(): [components] list is required to render the document', __FILE__, __FUNCTION__, __LINE__);
    } else {
      throw new Error('newDocument(): [components] list is required to render the document');
    }
  }

  startNewDocument($settings);
  foreach ($components as $file) {
    getTemplate($file, getGlobal('page') == 'admin' ? false : true);
  }
  endNewDocument($settings);
}

/**
 * Render the beginning of the Document
 */
function startNewDocument($settings)
{
  $classes = ['container'];

  if (getGlobal('page') && trim(getGlobal('page')) !== '') {
    $classes[] = '__' . getGlobal('page') . '__';
  }

  if (getGlobal('sub_page') && getGlobal('sub_page') !== '') {
    $classes[] = '__' . getGlobal('sub_page') . '__';
  }

  ?>
  <!doctype html>
  <html lang="es">

  <head>
    <title><?php bind(getGlobal('title')) ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">
    <?php getStyleSheets($settings) ?>
  </head>

  <body class="page_<?php bind(getGlobal('page')) ?>">
  <?php
}

/**
 * Render the end of the Document
 */
function endNewDocument($settings)
{
  logDebugging();
  @getTemplate('components/notifications/notifications');
  getJavaScript($settings);
  ?>
  </body>

  </html>
  <?php
}

/**
 * Render the Stylesheets
 */
function getStyleSheets($settings)
{
  $components  = oneOf(@$settings['components'], []);
  $stylesheets = oneOf(@$settings['styles'], []);

  foreach ($components as $style) {
    if (file_exists(getTemplateAbsolutePath() . $style . '.css')) {
    ?>
      <link rel="stylesheet" href="<?php bind(getTemplateRelativePath() . $style . '.css') ?>">
    <?php
    }
  }

  foreach ($stylesheets as $style) {
    if (file_exists(getTemplateAbsolutePath() . $style)) {
    ?>
      <link rel="stylesheet" href="<?php bind(getTemplateRelativePath() . $style) ?>">
    <?php
    }
  }
}

/**
 * Render the JavaScript
 */
function getJavaScript($settings)
{
  $scripts    = oneOf(@$settings['scripts'], []);
  $components = oneOf(@$settings['components'], []);

  foreach ($scripts as $script) {
    if (file_exists(getTemplateAbsolutePath() . $script)) {
    ?>
      <script src="<?php bind(getTemplateRelativePath() . $script) ?>"></script>
    <?php
    }
  }

  foreach ($components as $script) {
    if (file_exists(getTemplateAbsolutePath() . $script . '.js')) {
    ?>
      <script src="<?php bind(getTemplateRelativePath() . $script . '.js') ?>"></script>
    <?php
    }
  }
}
