<?php
date_default_timezone_set("Europe/Moscow");
require_once ('db.php');
require_once ('functions.php');
$sesUser = startTheSession();

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

$cur_page = (int)($_GET['page'] ?? 1);
$page_items = 6;

$result = mysqli_query($con, "SELECT COUNT(*) as cnt FROM lots");
$item_count = mysqli_fetch_assoc($result)['cnt'];
$page_count = ceil($item_count / $page_items);
$offset = ($cur_page - 1) * $page_items;

$pages = range(1, $page_count);
$sql = "SELECT lots.id, name, image, start_price, end_time, category_name FROM lots
            JOIN category ON category.id = lots.category_id
            ORDER BY create_date DESC" . $page_items . ' OFFSET ' . $offset;


$page_content = include_template('index.php', [
    'category_array' => $category_array,
    'lots_array' => $lots_array
]);
$layout_content = include_template ('layout.php', [
    'content' => $page_content,
    'category_array' => $category_array,
    'username' => $sesUser['username'],
    'profile_img' => $sesUser['profile_img'],
    'title' => 'Yeticave - Главная страница'
]);
echo $layout_content;

?>
