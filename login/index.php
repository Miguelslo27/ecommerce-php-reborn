<?php

$relative = '..';
require '../core/common.php';

$userStats = loadUser();
$appPlace = 'home';
$appSubPlace = 'login';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
include($templatesPath . 'header.php');

?>
<div class="container">
  <?php include($templatesPath . 'components/forms/login.php') ?>
</div>
<?php

include($templatesPath . 'footer.php');
endDocument();
?>