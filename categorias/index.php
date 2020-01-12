<?php

$relative = '..';
require '../includes/common.php';

$userStats     = loadUser();
$appPlace      = 'categories';
$appSubPlace   = '';
$templatesPath = $GLOBALS['config']['templatesPath'];
$categories    = getCategories(0);
$category      = getCategory();

startDocument();
loadSection("header", $userStats);

// saveCategory();
// saveArticle();

?>
<div class="container categories">
	<!-- <?php include($templatesPath . 'components/breadcrumb.php') ?> -->
	<?php include($templatesPath . 'components/categories/admin-actions.php') ?>
	<?php include($templatesPath . 'components/categories/categories.php') ?>
	<!-- <?php include($templatesPath.'components/categories/articles.php') ?> -->
</div>
<?php

loadSection("footer", $userStats);
endDocument();
?>