<?php
date_default_timezone_set("Europe/Moscow");
require_once ('functions.php');
require_once ('db.php');
require_once ('data.php');
$sesUser = startTheSession();
//Подключение категорий
$sql = "SELECT category.id, category_name FROM category ";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);


//Запрос на добавление лота
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = isset($_POST['lot']) ? $_POST['lot'] : null;
    $user_id = $_SESSION['user']['id'];
//Валидация
    $required = ['name', 'category_id', 'description', 'start_price', 'bet_step', 'end_time' ];
    $dict = [
        'name' => 'Название лота',
        'category_id' => 'Категория лота',
        'description' => 'Описание лота',
        'image' => 'Ошибка загрузки изображения: ',
        'start_price' => 'Стартовая цена лота',
        'bet_step' => 'Шаг ставки',
        'end_time' => 'Время завершения аукциона'
    ];
    $price_fields = ['start_price', 'bet_step'];
    $min_price = 1;
    $valid_errors = [];

 //Проверка стоимости
    foreach($price_fields as $key) {
        $i = $_POST[$key];
        if (!is_numeric($i) || $i < $min_price) {
            $valid_errors[$key] ='Укажите положительное число';
        }
    }
//Проверка даты на валидность
    if (strtotime($_POST['end_time']) < time()) {
        $valid_errors['end_time'] = 'Некорректная дата';
    }
//Проверка заполненности полей
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $valid_errors[$key] = 'Это поле необходимо заполнить';
        }
    }
//Проверка файла
    isset($valid_errors['image']) ? $valid_errors['image'] : null;
    if (!empty($_FILES['image']['name'])) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        $filename = 'img' . DIRECTORY_SEPARATOR . uniqid() . '.jpg';
        $lot['image'] = $filename;
        if ($file_type !== "image/jpeg") {
            $valid_errors['image'] = 'Загрузите картинку в формате JPEG';
        } else {
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . DIRECTORY_SEPARATOR . $filename);
        }
    } else  {
        $valid_errors['image'] = 'Вы не загрузили файл';
    }




    if (count($valid_errors) > 0) {

    } else {
        $sql_post = 'INSERT INTO lots (create_date, author_id, category_id, name, description, start_price, bet_step, end_time, image ) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($con, $sql_post, [$user_id, $_POST['category_id'], $_POST['name'], $_POST['description'], $_POST['start_price'], $_POST['bet_step'], $_POST['end_time'], $lot['image']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $lot_id = mysqli_insert_id($con);
            header("Location: lot.php?id=" . $lot_id);
        }
    }
}

$addLot_content = include_template ('add-lot.php', [
    'valid_errors' => $valid_errors ?? [],
    'dict' => $dict ?? [],
    'category_array' => $category_array
]);
$layout_content = include_template ('layout.php', [
    'content' => $addLot_content,
    'category_array' => $category_array,
    'username' => $sesUser['username'],
    'profile_img' => $sesUser['profile_img'],
    'title' => 'Yeticave - Добавление лота'
]);
echo $layout_content;


?>


