	<section id="body">
		<div class="body-inner">
			<div class="body-content">
				
<?php

$page      = $GLOBALS['page'];
$appSubPlace   = isset($GLOBALS['appSubPlace']) ? $GLOBALS['appSubPlace'] : NULL;
$userStats     = $GLOBALS['userStats'];
$template_path = getTemplatePath();

switch($page) {
case 'categories':
	$categories = getCategories(0);
	$category   = getCategory();

	if (isset($_GET['c']) && ($_GET['c'] == 'new' || $_GET['c'] == 'save')) {
		switch($_GET['c']) {
		case 'new':
			include($template_path . '/modals/new-category.php');
		break;
		case 'save':
			saveCategory();
		break;
		}
	}

	if (isset($_GET['a']) && ($_GET['a'] == 'new' || $_GET['a'] == 'save')) {
		switch($_GET['a']) {
		case 'new':
			include($template_path . '/modals/new-article.php');
		break;
		case 'save':
			saveArticle();
		break;
		}
	}

	$categories = getCategories(0);
	$category = getCategory();

	if (count($category->subcategorias) > 0) {
		include($template_path . 'categories.php');
	} else {
		include($template_path . 'articles.php');
	}
break;
case 'catalogs':
	include($template_path . 'catalogs.php');
break;
case 'online-history':
	include($template_path . 'catalogs.php');
break;
case 'contact':
	include($template_path . 'catalogs.php');
break;
}
?>