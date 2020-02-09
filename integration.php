<?php

foreach ($_REQUEST as $request)
{
  error_log($request . "\n", 3, 'logfile.txt');
}
