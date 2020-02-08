<?php

$relative = '..';
require '../core/common.php';

$userStats = loadUser();
$appPlace = 'contact';
$appSubPlace = '';
$template_path = getTemplatePath();

startDocument();
include($template_path . 'header.php');

?>
<div class="container">
	<?php include($template_path . 'pages/contact.php') ?>
</div>
<?php

include($template_path . 'footer.php');
endDocument();

?>