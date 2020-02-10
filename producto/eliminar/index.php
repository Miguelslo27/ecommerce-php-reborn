<?php

$relative = '../..';
require '../../core/common.php';

$userStats     = loadUser();
$page      = 'article';
$appSubPlace   = 'new';
$template_path = getTemplatePath();

protectFromNotAdminUsers();
startDocument();
include($template_path . 'header.php');

?>
<div class="container">
  <?php include($template_path . 'components/admin/forms/delete-article.php') ?>
</div>
<?php

include($template_path . 'footer.php');
endDocument();
?>