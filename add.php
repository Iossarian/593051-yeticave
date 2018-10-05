<?php
date_default_timezone_set("Europe/Moscow");
require_once ('functions.php');
//подключение БД
require_once ('db.php');

//Подключение категорий
$sql = "SELECT category.id, category_name FROM category ";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);

//Запрос на добавление лота
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST['lot'];
//Валидация
    $required = ['name', 'category', 'discription', 'start_price', 'bet_step', 'image', 'end_time' ];
    $dict = [
        'name' => 'Название лота',
        'category' => 'Категория лота',
        'discription' => 'Описание лота',
        'image' => 'Изображение лота',
        'start_price' => 'Стартовая цена лота',
        'bet_step' => 'Шаг ставки',
        'end_time' => 'Время завершения аукциона'
    ];
    $valid_errors = [];
    foreach ($required as $key) {
        if (empty($lot[$key])) {
            $valid_errors[$key] = 'Это поле необходимо заполнить';
        }
    }
//Проверка файла
    if (!empty($_FILES['lot']['name']['image'])) {
        $tmp_name = $_FILES['lot']['tmp_name']['image'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/jpeg") {
            $valid_errors['image'] = 'Загрузите картинку в формате JPEG';
        } else {
            $filename = 'img' . DIRECTORY_SEPARATOR . uniqid() . '.jpg';
            $lot['image'] = $filename;
            move_uploaded_file($_FILES['lot']['tmp_name']['image'], __DIR__ . DIRECTORY_SEPARATOR . $filename);
        }
    } else {
        $valid_errors['image'] = 'Вы не загрузили файл';
    }
    if (count($valid_errors) > 0) {
        $content = include_template('add.php', ['lot' => $lot, 'valid_errors' => $valid_errors, 'dict' => $dict]);
    } else {
        $sql_post = 'INSERT INTO lots (create_date, category_id, author_id, name, description, start_price, bet_step, end_time, image ) VALUES (NOW(), ?, 5, ?, ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($con, $sql_post, [$lot['category_id'], $lot['name'], $lot['description'], (int)$lot['start_price'], $lot['bet_step'], $lot['end_time'], $lot['image']]);
        $res = mysqli_stmt_execute($stmt);
        $dir = __DIR__ . '/' . $filename;

        if ($res) {
            $lot_id = mysqli_insert_id($con);
            header("Location: lot.php?id=" . $lot_id);
        }
    }
}
var_dump($valid_errors);
$addLot_content = include_template ('add-lot.php', [
    'category_array' => $category_array
]);
$layout_content = include_template ('layout.php', [
    'content' => $addLot_content,
    'is_auth' => $is_auth,
    'category_array' => $category_array,
    'title' => 'Yeticave - Добавление лота'
]);
echo $layout_content;


?>


