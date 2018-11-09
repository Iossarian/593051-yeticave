<?php
date_default_timezone_set("Europe/Moscow");
require_once ('functions.php');
require_once ('db.php');
$sesUser = startTheSession();
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

//Подключение параметра запроса
$id = intval($_GET['id']);
$sql_l =    "SELECT lots.id, lots.name, image, start_price, description, MAX(bet.price), bet_step, end_time, category_name, author_id  FROM lots "
            . "JOIN category ON category.id = lots.category_id "
            . "JOIN bet ON bet.lot_id = lots.id "
            . "WHERE lots.id = " .$id;

if ($result = mysqli_query($con, $sql_l)) {
    if (!mysqli_num_rows($result)) {
        http_response_code(404);
    } else {
        $lot = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
}
$bet_sql = 'SELECT bet.id,
            bet.date AS date, 
            bet.price AS price,
            bet.lot_id AS ID,
            bet.user_id,
            users.name AS user_name
            FROM bet
            JOIN users ON bet.user_id = users.id
            WHERE bet.lot_id  = "' .$id. '"
            ORDER BY date DESC;';
$bet_query_result=mysqli_query($con, $bet_sql);
if(!$bet_query_result) {
    $error = mysqli_error($con);
    print("Ошибка MySQL: " . $error);
    die();}
$bet_query_array=mysqli_fetch_all($bet_query_result, MYSQLI_ASSOC);
$res = mysqli_query($con, $bet_sql);
//Проверка на наличие ставок от юзера
$allowed = false;
if (isset($_SESSION['user'])) {
    if (allowedBet($con, $id, $_SESSION['user']['id'])) {
        $allowed = true;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error =[];
    $user_id = $_SESSION['user']['id'];
    $bet_cost = filter_var($_POST['cost']);
    $cur_price = 0;
    $start_price = $lot['start_price'];
    $bet_step = $lot['bet_step'];
    $max_price = $lot['MAX(bet.price)'];

    if(isset($max_price)) {
        $cur_price =  $max_price;
    } else {
        $cur_price =  $start_price;
    }

    if ($bet_cost < $cur_price + $bet_step) {
        $error = 'Введите корректную сумму';
    } else {
        $sql = 'INSERT INTO bet (date, price, user_id, lot_id) VALUES (NOW(), ?, ?, ?)';
        $stmt = db_get_prepare_stmt($con, $sql, [$bet_cost, $user_id, $id]);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            header("Location: lot.php?id=" . $id);
            exit();

        }
    }



}
$lot_content = include_template ('lot.php', [
    'category_array' => $category_array,
    'lots_array' => $lots_array,
    'lot' => $lot,
    'id' => $id,
    'error' => $error ?? [],
    'allowed' => $allowed,
    'bet_query_array' => $bet_query_array
]);
$layout_content = include_template ('layout.php', [
    'content' => $lot_content,
    'category_array' => $category_array,
    'username' => $sesUser['username'],
    'profile_img' => $sesUser['profile_img'],
    'title' => 'Yeticave - Просмотр лота'
]);

echo $layout_content;













?>