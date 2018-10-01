<?php
//Функция-шаблонизатор
function include_template($name, $data) {
$name = 'templates/' . $name;
$result = '';

if (!file_exists($name)) {
return $result;
}

ob_start();
extract($data);
require_once $name;

$result = ob_get_clean();
return $result;
}
//Функция форматирования цены лота
function formatThePrice ($price) {
    if ($price < 1000 ) {
        return ceil($price) . ' ₽';
    } else {
        $format_price = ceil($price);
        return number_format($format_price, 0, '.', ' ') . ' ₽';
    }
}

if (isset($_GET['lot']) && $_GET['id'] == 'lots.id') {
    $sql = "SELECT lots.id, name, image, start_price, end_time, category_name FROM lots
            JOIN category ON category.id = lots.category_id";
    $sql_lot_id_result = mysqli_query($con, $sql_lots);
    $lots_id_array = mysqli_fetch_all($sql_lots_result, MYSQLI_ASSOC);
    }
?>