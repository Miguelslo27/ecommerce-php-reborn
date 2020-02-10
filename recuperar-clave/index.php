<?php

$relative = '../';
require '../core/common.php';

$userStats     = loadUser();
$page          = 'home';
$sub_page      = 'password-recovery';
$template_path = getTemplatePath();

$checkEmail = checkEmail(@$_POST['email']);

startDocument();
include($template_path . 'header.php');

?>
<div class="container">
	<?php include($template_path . 'components/forms/password-recovery.php') ?>
</div>
<?php

include($template_path . 'footer.php');
endDocument();

?>