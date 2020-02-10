<?php

$level = 0;
function printRecursively($object)
{
  $spaces = array();

  for ($i = 0; $i < $GLOBALS['level']; $i ++) {
    $spaces[] = '  ';
  }

  foreach ($object as $key => $value) {
    if (gettype($value) === 'array' || gettype($value) === 'object') {
      $GLOBALS['level'] ++;
      error_log(implode('', $spaces) . $key . " = [" . "\n", 3, 'logfile.txt');
      printRecursively($value);
      error_log(implode('', $spaces) . "]" . "\n", 3, 'logfile.txt');
      $GLOBALS['level'] --;
    } else {
      error_log(implode('  ', $spaces) . $key . " = " . $value . "\n", 3, 'logfile.txt');
    }
  }
}

// Chequear si el eveno de git es push
// De no ser así, salir del programa
// Chequear si el cliente tiene configurado la integración continua
// De no ser así, salir del programa

error_log("----------------------------------------------\n", 3, 'logfile.txt');
error_log("---------------    REQUEST    ----------------\n", 3, 'logfile.txt');
error_log("----------------------------------------------\n", 3, 'logfile.txt');

printRecursively(apache_request_headers());

error_log("----------------------------------------------\n", 3, 'logfile.txt');

$request = json_decode(file_get_contents("php://input"), true);

printRecursively($request);

exec('git checkout -- .', $commandOutput);
exec('git pull', $commandOutput);
exec('chmod -R 755 ./');

error_log("----------------------------------------------\n", 3, 'logfile.txt');

printRecursively($commandOutput);
