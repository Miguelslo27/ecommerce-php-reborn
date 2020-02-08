<?php

$relative = '..';
require '../core/common.php';

$userStats     = loadUser();
$appPlace      = 'articles';
$appSubPlace   = 'list';
$templatesPath = $GLOBALS['config']['templatesPath'];

$articleSaved  = saveArticle();
$categories    = getCategories(0);
$articles      = getArticles();

startDocument();
include($templatesPath . 'header.php');

?>
<div class="container">
	<?php include($templatesPath . 'components/articles/articles.php') ?>
</div>
<?php

include($templatesPath . 'footer.php');
endDocument();
?>