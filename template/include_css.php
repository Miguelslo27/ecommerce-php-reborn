<?php

$page     = getGlobal('page');
$sub_page = getGlobal('sub_page');

?>

<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Muli'>
<link rel="stylesheet" href="/template/statics/css/frameworks/fontawesome/font-awesome.min.css">
<link rel="stylesheet" href="/template/statics/css/layout.css">

<?php if ($page === 'home') : ?>
<link rel="stylesheet" href="/template/statics/css/home.css">
<?php endif ?>

<?php if ($page === 'categories') : ?>
<link rel="stylesheet" href="/template/statics/css/categories.css">
<?php endif ?>

<?php if ($page === '404') : ?>
<link rel="stylesheet" href="/template/statics/css/404.css">
<?php endif ?>

<?php if (isAdmin()) : ?>
<link rel="stylesheet" href="/template/statics/css/administrador.css">
<?php endif ?>
