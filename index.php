<?php

$relative = '.';
include('./core/common.php');

$userStats     = loadUser();
$appPlace      = 'home';
$appSubPlace   = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
include($templatesPath . 'header.php');

?>
<div class="container home">
  <?php
  include($templatesPath . 'components/hero.php');
  include($templatesPath . 'components/categories/featuredCategories.php');
  include($templatesPath . 'components/articles/newArticles.php');
  include($templatesPath . 'components/articles/featuredArticles.php');
  ?>
</div>
<?php

include($templatesPath . 'footer.php');
endDocument();
?>