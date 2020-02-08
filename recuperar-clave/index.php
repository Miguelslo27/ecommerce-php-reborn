<?php

$relative = '..';
require '../core/common.php';

$userStats = loadUser();
$appPlace = 'home';
$appSubPlace = 'password-recovery';
$templatesPath = $GLOBALS['config']['templatesPath'];

$checkEmail = checkEmail(@$_POST['email']);

startDocument();
include($templatesPath . 'header.php');

?>
<div class="container">
	<?php include($templatesPath . 'components/forms/password-recovery.php') ?>
</div>
<?php

include($templatesPath . 'footer.php');
endDocument();

?>