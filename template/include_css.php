<?php

$page     = $GLOBALS['page'];
$sub_page = $GLOBALS['sub_page'];
$revision = 'revision=' . rand(1, 3000);

?>

<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Muli'>
<link rel="stylesheet" href="/template/statics/css/frameworks/fontawesome/font-awesome.min.css?<?php echo $revision; ?>">
<link rel="stylesheet" href="/template/statics/css/layout.css?<?php echo $revision; ?>">

<?php if ($page === 'home') : ?>
<link rel="stylesheet" href="/template/statics/css/home.css?<?php echo $revision; ?>">
<?php endif ?>

<?php if ($page === 'categories') : ?>
<link rel="stylesheet" href="/template/statics/css/categories.css?<?php echo $revision; ?>">
<?php endif ?>

<?php if (isAdmin()) : ?>
<link rel="stylesheet" href="/template/statics/css/administrador.css?<?php echo $revision; ?>">
<?php endif ?>
