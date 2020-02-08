<?php

$relative = '..';
require '../core/common.php';

$userStats = loadUser();
$appPlace = 'contact';
$appSubPlace = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
include($templatesPath . 'header.php');

?>
<div class="container">
	<?php include($templatesPath . 'pages/contact.php') ?>
</div>
<?php

include($templatesPath . 'footer.php');
endDocument();

?>