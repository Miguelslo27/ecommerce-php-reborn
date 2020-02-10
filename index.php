<?php

$relative = './';
include('./core/common.php');

$userStats     = loadUser();
$page          = 'home';
$sub_page      = '';
$template_path = getTemplatePath();

startDocument();
include($template_path . 'header.php');

?>
<div class="container home">
  <?php
  include($template_path . 'components/hero.php');
  include($template_path . 'components/categories/featuredCategories.php');
  include($template_path . 'components/articles/newArticles.php');
  include($template_path . 'components/articles/featuredArticles.php');
  ?>
</div>
<?php

include($template_path . 'footer.php');
endDocument();
?>