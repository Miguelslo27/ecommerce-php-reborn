<?php

$relative = '../..';
require '../../includes/common.php';

$userStats     = loadUser();
$appPlace      = 'article';
$appSubPlace   = 'new';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

?>
<div class="container">
  <?php include($templatesPath . 'components/admin/forms/article.php') ?>
</div>
<?php

loadSection("footer", $userStats);
endDocument();
?>