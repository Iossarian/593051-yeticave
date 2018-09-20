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


$page_content = include_template('index.php', [
        'goods' => $goods_array

]);
$layout_content = include_template ('layout.php', [
    'content' => $page_content,
    'title' => 'Yeticave - Главная страница'
]);
echo $layout_content;
?>