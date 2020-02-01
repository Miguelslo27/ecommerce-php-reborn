<?php

$relative = '..';
require '../includes/common.php';

$userStats     = loadUser();
$appPlace      = 'categories';
$appSubPlace   = 'list';
$templatesPath = $GLOBALS['config']['templatesPath'];

$categorySaved = saveCategory();
$categories    = getCategories(0);

startDocument();
loadSection("header", $userStats);

?>
<div class="container">
	<?php include($templatesPath . 'components/categories/categories.php') ?>
</div>
<?php

loadSection("footer", $userStats);
endDocument();
?>