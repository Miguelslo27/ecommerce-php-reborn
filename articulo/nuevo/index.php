<?php

$relative = '../..';
require '../../includes/common.php';

$userStats     = loadUser();
$appPlace      = 'article';
$appSubPlace   = 'new';
$templatesPath = $GLOBALS['config']['templatesPath'];
// $categories    = getCategories(0);
// $category      = getCategory();

startDocument();
loadSection("header", $userStats);

// saveCategory();
// saveArticle();

?>
<div class="container categories">
  <!-- <?php include($templatesPath . 'components/breadcrumb.php') ?> -->
  <!-- <?php include($templatesPath . 'components/categories/admin-actions.php') ?> -->

  <?php include($templatesPath . 'components/admin/forms/article.php') ?>
</div>
<?php

loadSection("footer", $userStats);
endDocument();
?>