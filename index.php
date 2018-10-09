<?php
date_default_timezone_set("Europe/Moscow");

//подключение БД
require_once ('db.php');
require_once ('functions.php');
require_once ('data.php');

//Подключение категорий
$sql = "SELECT id, category_name FROM category";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);

//Подключение лотов
$sql_lots = "SELECT lots.id, name, image, start_price, end_time, category_name FROM lots
            JOIN category ON category.id = lots.category_id
            ORDER BY create_date DESC";
$sql_lots_result = mysqli_query($con, $sql_lots);
$lots_array = mysqli_fetch_all($sql_lots_result, MYSQLI_ASSOC);

$page_content = include_template('index.php', [
    'goods_array' => $goods_array,
    'format_time' => $format_time,
    'category_array' => $category_array,
    'lots_array' => $lots_array
]);
$layout_content = include_template ('layout.php', [
    'content' => $page_content,
    'is_auth' => $is_auth,
    'category_array' => $category_array,
    'title' => 'Yeticave - Главная страница'
]);
echo $layout_content;

?>
