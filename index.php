<?php
date_default_timezone_set("Europe/Moscow");
$is_auth = rand(0, 1);

$user_name = ''; // укажите здесь ваше имя
$user_avatar = 'img/user.jpg';
$goods_array = [
    "Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"
];
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
    'goods_list' => $goods_list
]);
$layout_content = include_template ('layout.php', [
    'content' => $page_content,
    'goods_array' => $goods_array,
    'is_auth' => $is_auth,
    'title' => 'Yeticave - Главная страница'
]);
echo $layout_content;
?>
