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

function getCurPrice ($lot) {
    if (isset($lot['MAX(bet.price)'])) {
        echo $lot['MAX(bet.price)'];
    } else {
    echo $lot['start_price'];
    }
}

function getMinBet ($lot) {
    if (isset($lot['MAX(bet.price)'])) {
        echo ($lot['bet_step']) + ($lot['MAX(bet.price)']) . ' ₽';
    } else {
        echo ($lot['start_price']) + ($lot['bet_step']) . ' ₽';
    }

}
?>