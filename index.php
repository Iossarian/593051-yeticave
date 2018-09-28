<?php
date_default_timezone_set("Europe/Moscow");

//подключение БД
$con = mysqli_connect("localhost", "root", "", "Yeticave");
mysqli_set_charset($con, "utf8");
//проверка подключения
if ($con == false) {
    print ("Ошибка подключения: " . mysqli_connect_error());
} else {
    print ("Соединение с БД успешно установлено");
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

$is_auth = rand(0, 1);
//таймер
//$lot_end = strtotime("22.09.2018 00:00");
//$time_left = $lot_end - time();
//$format_time = gmdate("H:i", $time_left);

$user_name = ''; // укажите здесь ваше имя
$user_avatar = 'img/user.jpg';
//массив с категориями

require_once ('functions.php');

$page_content = include_template('index.php', [
    'goods_array' => $goods_array,
    'format_time' => $format_time,
    'category_array' => $category_array,
    'lots_array' => $lots_array,
    'goods_list' => $goods_list
]);
$layout_content = include_template ('layout.php', [
    'content' => $page_content,
    'goods_array' => $goods_array,
    'is_auth' => $is_auth,
    'category_array' => $category_array,
    'title' => 'Yeticave - Главная страница'
]);
echo $layout_content;

?>
