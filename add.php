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

//Подключение категорий
$sql = "SELECT category.id, category_name FROM category ";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);

$addLot_content = include_template ('add-lot.php', [
    'category_array' => $category_array,
]);
//Запрос на добавление лота
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST['lot'];

    $filename = uniqid() . '.jpg';
    $lot['image'] = $filename;
    move_uploaded_file($_FILES['image']['tmp_name'], 'image/' . $filename);

    $sql_post = 'INSERT INTO lots (create_date, category_id, author_id, lots.name, description, start_price, bet_step, end_time, image ) VALUES (NOW(), ?, 5, ?, ?, ?, ?, ?, ?)';

    $stmt = db_get_prepare_stmt($con, $sql_post, [$lot['category_id'], $lot['name'], $lot['description'], $lot['image'], (int)$lot['start_price'], $lot['bet_step'], $lot['end_time']]);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        $lot_id = mysqli_insert_id($con);

        header("Location: lot.php?id=" . $lot_id);
    }
}
//ar_dump($sql_result);
//var_dump($con);
//var_dump($sql);
//var_dump($stmt);
//var_dump($res);
var_dump(mysqli_error($con));
var_dump($lot['start_price']);

echo $addLot_content;
?>