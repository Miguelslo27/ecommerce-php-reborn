<?php

$relative = '../..';
require '../../includes/common.php';

$userStats     = loadUser();
$appPlace      = 'category';
$appSubPlace   = 'edit';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

?>
<div class="container">
  <?php include($templatesPath . 'components/admin/forms/category.php') ?>
</div>
<?php

loadSection("footer", $userStats);
endDocument();
?>