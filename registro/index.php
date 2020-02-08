<?php

$relative = '..';
require '../core/common.php';

$userStats = saveUser();
$appPlace = 'home';
$appSubPlace = 'register';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
include($templatesPath . 'header.php');

?>
<div class="container">
	<?php include($templatesPath . 'components/forms/register.php') ?>
</div>
<?php

include($templatesPath . 'footer.php');
endDocument();

?>