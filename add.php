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

    $filename = 'img/' . uniqid() . '.jpg';
    $lot['image'] = $filename;
    move_uploaded_file($_FILES['image']['tmp_name'],   __DIR__ . '/' . $filename);

    $sql_post = 'INSERT INTO lots (create_date, category_id, author_id, name, description, start_price, bet_step, end_time, image ) VALUES (NOW(), ?, 5, ?, ?, ?, ?, ?, ?)';

    $stmt = db_get_prepare_stmt($con, $sql_post, [$lot['category_id'], $lot['name'], $lot['description'], (int)$lot['start_price'], $lot['bet_step'], $lot['end_time'], $lot['image']]);
    $res = mysqli_stmt_execute($stmt);
    $dir = __DIR__ . '/' . $filename;

    if ($res) {
        $lot_id = mysqli_insert_id($con);
        //var_dump($_FILES);
        //var_dump($filename);
        //var_dump($move);
        //var_dump($lot['image']);
        //var_dump(is_dir($upload_dir) && is_writable($upload_dir));
        var_dump($upload_dir);
        //header("Location: lot.php?id=" . $lot_id);
    }
}

//var_dump(mysqli_error($con));

echo $addLot_content;
?>
