<?php

$relative = '../';
require '../core/common.php';

newDocument('order', null, [
  'pages/cart'
], function ()
{
  setGlobal('cart', getCart());
});
