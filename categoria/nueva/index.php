<?php

$relative = '../..';
require '../../core/common.php';

$userStats     = loadUser();
$page      = 'category';
$appSubPlace   = 'new';
$template_path = getTemplatePath();

protectFromNotAdminUsers();
startDocument();
include($template_path . 'header.php');

?>
<div class="container">
  <?php include($template_path . 'components/admin/forms/category.php') ?>
</div>
<?php

include($template_path . 'footer.php');
endDocument();
?>