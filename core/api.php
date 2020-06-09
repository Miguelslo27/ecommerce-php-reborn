<?php

session_start();
require_once('requires.php');

header('Content-type: application/json');

$request = json_decode(file_get_contents("php://input"));

if (empty($request->action)) {
  header(getServer('SERVER_PROTOCOL') . ' 404 Action not found');
  echo '404 Action not found';
  exit;
}

if ($request->action == ACTION_ADD_TO_CART) {
  setRequestData('aid', $request->aid);
  setRequestData('qty', $request->qty);
  $status = addToCart($request->qty);

  loadCart();

  $status->data = getSession('cart');
  $response     = json_encode($status);
}

if (!isset($status)) {
  header(getServer('SERVER_PROTOCOL') . ' 500 Internal server error');
  exit;
}

if ($status->succeeded) {
  header(getServer('SERVER_PROTOCOL') . ' 200 Transaction succeeded');
} else {
  header(getServer('SERVER_PROTOCOL') . ' 500 Internal server error');
}

echo $response;

?>