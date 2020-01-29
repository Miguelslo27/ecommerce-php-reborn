<?php

$relative = '..';
require '../includes/common.php';

$userStats = loadUser();
$appPlace = 'home';
$appSubPlace = 'login';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

?>
<div class="container">
  <?php include($templatesPath . 'components/forms/login.php') ?>
</div>
<?php

loadSection("footer", $userStats);
endDocument();
?>