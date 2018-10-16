<?php
require_once ('db.php');
require_once ('functions.php');
require_once ('data.php');
$sesUser = startTheSession();
$page_content = include_template('all-lots.php', [

]);
$layout_content = include_template ('layout.php', [
    'content' => $page_content,
    'title' => 'Yeticave - Все категории'
]);
echo $layout_content;
?>