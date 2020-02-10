<?php

$relative = '../';
require '../core/common.php';

$userStats     = loadUser();
$page          = 'articles';
$sub_page      = 'list';
$template_path = getTemplatePath();

$articleSaved  = saveArticle();
$categories    = getCategories(0);
$articles      = getArticles();

startDocument();
include($template_path . 'header.php');

?>
<div class="container">
	<?php include($template_path . 'components/articles/articles.php') ?>
</div>
<?php

include($template_path . 'footer.php');
endDocument();
?>