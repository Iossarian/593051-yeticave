<?php
date_default_timezone_set("Europe/Moscow");
require_once ('functions.php');
require_once ('db.php');
require_once ('data.php');
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

//Подключение параметра запроса
$id = intval($_GET['id']);
$sql_l =    "SELECT lots.id, lots.name, image, start_price, description, MAX(bet.price), bet_step, end_time, category_name FROM lots "
            . "JOIN category ON category.id = lots.category_id "
            . "JOIN bet ON bet.lot_id = lots.id "
            . "WHERE lots.id = " .$id;

if ($result = mysqli_query($con, $sql_l)) {
    if (!mysqli_num_rows($result)) {
        http_response_code(404);
    } else {
        $lot = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
}

$lot_content = include_template ('lot.php', [
    'category_array' => $category_array,
    'lots_array' => $lots_array,
    'lot' => $lot,
    'bet' => $bet,
    'format_time' => $format_time
]);
$layout_content = include_template ('layout.php', [
    'content' => $lot_content,
    'is_auth' => $is_auth,
    'category_array' => $category_array,
    'username' => $userSes['username'],
    'profile_img' => $userSes['profile_img'],
    'title' => 'Yeticave - Просмотр лота'
]);

echo $layout_content;













?>