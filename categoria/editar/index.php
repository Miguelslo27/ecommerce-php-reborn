<?php

$relative = '../..';
require '../../core/common.php';

$userStats     = loadUser();
$appPlace      = 'category';
$appSubPlace   = 'edit';
$templatesPath = $GLOBALS['config']['templatesPath'];

protectFromNotAdminUsers();
startDocument();
include($templatesPath . 'header.php');

?>
<div class="container">
  <?php include($templatesPath . 'components/admin/forms/category.php') ?>
</div>
<?php

include($templatesPath . 'footer.php');
endDocument();
?>