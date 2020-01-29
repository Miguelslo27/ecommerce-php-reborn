<?php

$relative = '..';
require '../includes/common.php';

$userStats = saveUser();
$appPlace = 'home';
$appSubPlace = 'register';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

?>
<div class="container">
	<?php include($templatesPath . 'components/forms/register.php') ?>
</div>
<?php

loadSection("footer", $userStats);
endDocument();

?>