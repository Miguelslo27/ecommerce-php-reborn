<?php

$relative = '..';
require '../includes/common.php';

$userStats     = loadUser();
$appPlace      = 'categories';
$appSubPlace   = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

?>
<div class="container categories">
	<?php

	saveCategory();
	saveArticle();

	$categories = getCategories(0);
	$category   = getCategory();

	if (count($category->subcategorias) > 0) {
		include($templatesPath . 'categories.php');
	} else {
		include($templatesPath . 'articles.php');
	}

	?>
</div>
<?php

loadSection("footer", $userStats);
endDocument();
?>