<?php

$relative = '..';
require '../core/common.php';

$userStats     = loadUser();
$appPlace      = 'categories';
$appSubPlace   = 'list';
$template_path = getTemplatePath();

$categorySaved = saveCategory();
$categories    = getCategories(0);

startDocument();
include($template_path . 'header.php');

?>
<div class="container">
	<?php include($template_path . 'components/categories/categories.php') ?>
</div>
<?php

include($template_path . 'footer.php');
endDocument();
?>