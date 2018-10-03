<?php
date_default_timezone_set("Europe/Moscow");
require_once ('functions.php');
//подключение БД
$con = mysqli_connect("localhost", "root", "", "Yeticave");
mysqli_set_charset($con, "utf8");
//проверка подключения
if ($con == false) {
    print ("Ошибка подключения: " . mysqli_connect_error());
    die();
}

$addLot_content = include_template ('add-lot.php', [

]);

echo $addLot_content;








?>