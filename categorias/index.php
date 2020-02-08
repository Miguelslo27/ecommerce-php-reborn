<?php

$relative = '..';
require '../core/common.php';

$userStats     = loadUser();
$appPlace      = 'categories';
$appSubPlace   = 'list';
$templatesPath = $GLOBALS['config']['templatesPath'];

$categorySaved = saveCategory();
$categories    = getCategories(0);

startDocument();
include($templatesPath . 'header.php');

?>
<div class="container">
	<?php include($templatesPath . 'components/categories/categories.php') ?>
</div>
<?php

include($templatesPath . 'footer.php');
endDocument();
?>