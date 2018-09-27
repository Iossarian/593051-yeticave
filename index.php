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
$sql_lots = "SELECT id, name, image, start_price, end_time, category_id FROM lots"
            . "JOIN category ON category.id = lots.category_id";
$sql_lots_result = mysqli_query($con, $sql_lots);
$lots_array = mysqli_fetch_all($sql_lots_result, MYSQLI_ASSOC);

$is_auth = rand(0, 1);
//таймер
$lot_end = strtotime("21.09.2018");
$time_left = $lot_end - time();
$format_time = date("H:i", $time_left);
$lot_end = strtotime("22.09.2018 00:00");
$time_left = $lot_end - time();
$format_time = gmdate("H:i", $time_left);

$user_name = ''; // укажите здесь ваше имя
$user_avatar = 'img/user.jpg';
//массив с категориями
$goods_array = [
    "Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"
];
//массив с лотами
$goods_list = [
    [
    'name' => '2014 Rossignol District Snowboard',
    'category' => $goods_array[0],
    'price' => 10999,
    'source' => 'img/lot-1.jpg'
    ],
    [
    'name' => 'DC Ply Mens 2016/2017 Snowboard',
    'category' => $goods_array[0],
    'price' => 159999,
    'source' => 'img/lot-2.jpg'
    ],
    $staff_3 = [
    'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
    'category' => $goods_array[1],
    'price' => 8000,
    'source' => 'img/lot-3.jpg'
    ],
    [
    'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
    'category' => $goods_array[2],
    'price' => 	10999,
    'source' => 'img/lot-4.jpg'
    ],
    [
    'name' => 'Куртка для сноуборда DC Mutiny Charocal',
    'category' => $goods_array[3],
    'price' => 7500,
    'source' => 'img/lot-5.jpg'
    ],
    [
    'name' => 'Маска Oakley Canopy',
    'category' => $goods_array[5],
    'price' => 5400,
    'source' => 'img/lot-6.jpg'
    ]
];

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
