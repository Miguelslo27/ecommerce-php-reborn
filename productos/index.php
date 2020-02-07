<?php

$relative = '..';
require '../core/common.php';

$userStats     = loadUser();
$appPlace      = 'categories';
$appSubPlace   = 'list';
$templatesPath = $GLOBALS['config']['templatesPath'];

$articleSaved  = saveArticle();
$categories    = getCategories(0);
$articles      = getArticles();

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