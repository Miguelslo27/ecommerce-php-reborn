<?php

foreach ($_REQUEST as $request)
{
  error_log("type:" . $request . "\n", 3, 'logfile.txt');
}
