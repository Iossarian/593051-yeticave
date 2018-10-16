<?php
date_default_timezone_set("Europe/Moscow");
require_once ('functions.php');
require_once ('db.php');
$sesUser = startTheSession();
//Подключение категорий
$sql = "SELECT category.id, category_name FROM category ";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);

$search = trim($_GET['search']);
$safe_search = mysqli_real_escape_string($con, $search);
$error = [];

if ($safe_search && $safe_search !== '') {
    $sql = "SELECT lots.id, name, description, image, start_price, end_time, category_name FROM lots"
        . " JOIN category ON category.id = lots.category_id"
        . " WHERE MATCH(name, description) AGAINST(?)"
        . "ORDER BY create_date DESC";

    $stmt = db_get_prepare_stmt($con, $sql, [$safe_search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (!count($lots)) {
        $error['search'] = 'По вашему запросу ничего не найдено';
    }
}
if (empty($search)) {
    $error['search'] = 'Введите поисковой запрос';
}

$addLot_content = include_template ('search.php', [
    'category_array' => $category_array,
    'lots' => $lots ?? '',
    'safe_search' => $safe_search,
    'error' => $error ?? ''
]);
$layout_content = include_template ('layout.php', [
    'content' => $addLot_content,
    'category_array' => $category_array,
    'username' => $sesUser['username'],
    'profile_img' => $sesUser['profile_img'],
    'title' => 'Yeticave - Поиск'
]);
echo $layout_content;
?>