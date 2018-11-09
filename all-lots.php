<?php
require_once ('db.php');
require_once ('functions.php');
$sesUser = startTheSession();
//Подключение категорий
$category_id = intval($_GET['category']);
$sql = "SELECT id, category_name FROM category";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);
//Подключение лотов
$sql_l =    "SELECT lots.id, name, image, start_price, end_time, category_name, category_id FROM lots"
            . " JOIN category ON category.id = lots.category_id"
            . " WHERE category_id = " . $category_id ;

$sql_lots_result = mysqli_query($con, $sql_l);
$lots_array = mysqli_fetch_all($sql_lots_result, MYSQLI_ASSOC);

//
$category_sql = "SELECT category_name FROM category WHERE id = $category_id";
$sql_category = mysqli_query($con, $category_sql);
$category_name = mysqli_fetch_assoc($sql_category)['category_name'];



$page_content = include_template('all-lots.php', [
    'category_array' => $category_array,
    'lots_array' => $lots_array,
    'category_name' => $category_name

]);
$layout_content = include_template ('layout.php', [
    'content' => $page_content,
    'category_array' => $category_array,
    'title' => 'Yeticave - Все категории'
]);
echo $layout_content;
?>