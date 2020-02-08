<?php

$relative = '..';
require '../core/common.php';

$userStats = loadUser();
$appPlace = 'home';
$appSubPlace = 'login';
$template_path = getTemplatePath();

startDocument();
include($template_path . 'header.php');

?>
<div class="container">
  <?php include($template_path . 'components/forms/login.php') ?>
</div>
<?php

include($template_path . 'footer.php');
endDocument();
?>