<?php

$relative = '..';
require '../includes/common.php';

$userStats     = loadUser();
$appPlace      = 'categories';
$appSubPlace   = 'list';
$templatesPath = $GLOBALS['config']['templatesPath'];
$categories    = getCategories(0);

// If comes from category form, save the category
$messages = saveCategory();

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