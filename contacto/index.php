<?php

$relative = '..';
require '../includes/common.php';

$userStats = loadUser();
$appPlace = 'contact';
$appSubPlace = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

?>
<div class="container">
	<?php include($templatesPath . 'pages/contact.php') ?>
</div>
<?php

loadSection("footer", $userStats);
endDocument();

?>