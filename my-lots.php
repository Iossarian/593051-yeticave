<?php
date_default_timezone_set("Europe/Moscow");
require_once ('functions.php');
require_once ('db.php');
$sesUser = startTheSession();
$user_id = $_SESSION['user']['id'];
//Подключение категорий
$sql = "SELECT id, category_name FROM category";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);
//Подключение лотов
$sql_l =    " SELECT lots.name, image, start_price, end_time, category_name, category_id, bet.lot_id, bet.user_id, lots.author_id, users.id, users.contacts, lots.id, MAX(bet.price), bet.date FROM lots"
            . " JOIN category ON category.id = lots.category_id"
            . " JOIN users ON users.id = lots.author_id"
            . " JOIN bet ON bet.lot_id = lots.id"
            . " WHERE bet.user_id = " . $user_id
            . " GROUP BY bet.lot_id, bet.date ";

$sql_lots_result = mysqli_query($con, $sql_l);
$lots_array = mysqli_fetch_all($sql_lots_result, MYSQLI_ASSOC);
//
$sql_b = "SELECT MAX(price) FROM bet
        WHERE lot_id = 15";
$bet_res = mysqli_query($con, $sql_b);
$bet = mysqli_fetch_all($bet_res, MYSQLI_ASSOC);
var_dump($bet);

$content = include_template ('my-lots.php', [
    'category_array' => $category_array,
    'lots_array' => $lots_array
]);
$layout_content = include_template ('layout.php', [
    'content' => $content,
    'category_array' => $category_array,
    'username' => $sesUser['username'],
    'profile_img' => $sesUser['profile_img'],
    'title' => 'Yeticave - Мои ставки'
]);

echo $layout_content;
?>