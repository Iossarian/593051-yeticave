<?php
date_default_timezone_set("Europe/Moscow");
require_once ('functions.php');
require_once ('db.php');
$sesUser = startTheSession();
//Подключение категорий
$sql = "SELECT category.id, category_name FROM category ";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);



$addLot_content = include_template ('search.php', [
    'category_array' => $category_array,
]);
$layout_content = include_template ('layout.php', [
    'content' => $addLot_content,
    'category_array' => $category_array,
    'username' => $sesUser['username'],
    'profile_img' => $sesUser['profile_img'],
    'title' => 'Yeticave - Поиск'
]);
echo $layout_content;






?>