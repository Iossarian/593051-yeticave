<?php
date_default_timezone_set("Europe/Moscow");

//подключение БД
$con = mysqli_connect("localhost", "root", "", "Yeticave");
mysqli_set_charset($con, "utf8");
//проверка подключения
if ($con == false) {
    print ("Ошибка подключения: " . mysqli_connect_error());
    die();
}
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

require_once ('functions.php');
$lot_content = include_template ('lot.php', [
    'category_array' => $category_array,
    'lots_array' => $lots_array,
    'format_time' => $format_time
]);


if (isset($_GET['lot']) && $_GET['lot'] == '$id') {
    $sql_lots = "SELECT lots.id, name, image, start_price, end_time, category_name FROM lots
            JOIN category ON category.id = lots.category_id
            ORDER BY create_date DESC";
    $res = mysqli_query($con, $sql_lots);
    $lots_array = mysqli_fetch_all($sql_lots, MYSQLI_ASSOC);
}
echo $lot_content;













?>