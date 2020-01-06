<?php

$relative = '..';
require '../includes/common.php';

$userStats = loadUser();
$appPlace = 'categories';
$appSubPlace = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

?>
	<section id="body">
		<div class="body-inner">

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

loadSection("footer", $userStats);
endDocument();

?>