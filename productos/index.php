<?php

$relative = '..';
require '../includes/common.php';

$userStats     = loadUser();
$appPlace      = 'categories';
$appSubPlace   = 'list';
$templatesPath = $GLOBALS['config']['templatesPath'];
$categories    = getCategories(0);
$articles      = getArticles();

// If comes from category form, save the category
$messages      = saveArticle();

startDocument();
loadSection("header", $userStats);

?>
<div class="container">
	<?php include($templatesPath . 'components/articles/articles.php') ?>
</div>
<?php

loadSection("footer", $userStats);
endDocument();
?>