<?php

$relative = '..';
require '../includes/common.php';

// $userStats = loginUser();
$userStats = loadUser();
$appPlace = 'home';
$appSubPlace = 'login';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);
// loadSection("content", $userStats);

?>
<div class="container">
  <?php include($templatesPath . 'components/forms/login.php') ?>
</div>
<?php

loadSection("footer", $userStats);
endDocument();
?>