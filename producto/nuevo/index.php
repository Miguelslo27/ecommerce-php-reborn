<?php

$relative = '../..';
require '../../core/common.php';

$userStats     = loadUser();
$appPlace      = 'article';
$appSubPlace   = 'new';
$templatesPath = $GLOBALS['config']['templatesPath'];

protectFromNotAdminUsers();
startDocument();
include($templatesPath . 'header.php');

?>
<div class="container">
  <?php include($templatesPath . 'components/admin/forms/article.php') ?>
</div>
<?php

include($templatesPath . 'footer.php');
endDocument();
?>