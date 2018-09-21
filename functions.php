<?php
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

function formatThePrice ($price) {
    if ($price < 1000 ) {
        return ceil($price) . ' ₽';
    } else {
        $format_price = ceil($price);
        return number_format($format_price, 0, '.', ' ') . ' ₽';
    }
}

$lot_end = strtotime("22.09.2018 00:00");
$time_left = $lot_end - time();
$format_time = gmdate("H:i", $time_left);



?>