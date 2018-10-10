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
//Получаем текущую стоимость
function getCurPrice ($lot) {
    if (isset($lot['MAX(bet.price)'])) {
        echo $lot['MAX(bet.price)'] . ' ₽';
    } else {
    echo $lot['start_price'] . ' ₽';
    }
}
//Получаем минимальную ставку
function getMinBet ($lot) {
    if (isset($lot['MAX(bet.price)'])) {
        echo ($lot['bet_step']) + ($lot['MAX(bet.price)']);
    } else {
        echo ($lot['start_price']) + ($lot['bet_step']);
    }
}
//Функция-обработчик
/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных.
 *
 * @param mysqli $con Ресурс соединения
 * @param string $sql  SQL запрос с плейсхолдерами вместо значений
 * @param array  $data Данные для вставки на место плейсхолдеров
 *
 * @throws \UnexpectedValueException Если тип параметра не поддерживается
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt(mysqli $con, string $sql , array $data = [])
{
    $stmt = mysqli_prepare($con, $sql );
    if (empty($data)) {
        return $stmt;
    }
    static $allowed_types = [
        'integer' => 'i',
        'double' => 'd',
        'string' => 's',
    ];
    $types = '';
    $stmt_data = [];
    foreach ($data as $value) {
        $type = gettype($value);
        if (!isset($allowed_types[$type])) {
            throw new \UnexpectedValueException(sprintf ('Unexpected parameter type "%s".', $type, var_dump($form)));

        }
        $types .= $allowed_types[$type];
        $stmt_data[] = $value;
    }
    mysqli_stmt_bind_param($stmt, $types, ...$stmt_data);
    return $stmt;
}
function startTheSession() {
    session_start();
    $sesUser = [];
    if (!empty($_SESSION['user'])) {
        $sesUser['username'] = $_SESSION['user']['name'];
        $sesUser['profile_img'] = $_SESSION['user']['profile_img'];
    }
    else {
        $sesUser['username'] = $sesUser['profile_img'] = NULL;
    }
    return $sesUser;
}
function authorizedCheck () {
    if (isset($_SESSION['user'])) {
        
    } else {
        http_response_code(403);
    }
}
?>

