<?php

$relative = '../..';
require '../../core/common.php';

$userStats     = loadUser();
$page          = 'admin';
$sub_page      = 'orders';
$template_path = getTemplatePath();

protectFromNotAdminUsers();

// @TODO create an admin saveUser function
// $userSaved     = saveUser();
// $users         = getUsers();

startDocument();
include($template_path . 'header.php');

?>
<div class="container">
  <!-- <?php include($template_path . 'components/admin/collections/users.php') ?> -->
</div>
<?php

include($template_path . 'footer.php');
endDocument();

?>
