<?php

$relative = '..';
require '../core/common.php';

$userStats = saveUser();
$appPlace = 'home';
$appSubPlace = 'register';
$template_path = getTemplatePath();

startDocument();
include($template_path . 'header.php');

?>
<div class="container">
	<?php include($template_path . 'components/forms/register.php') ?>
</div>
<?php

include($template_path . 'footer.php');
endDocument();

?>