<?php
require_once ('db.php');
require_once ('functions.php');
require_once ('data.php');
$sesUser = startTheSession();
//Подключение категорий
$sql = "SELECT id, category_name FROM category";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);
//Регистрация
$tpl_data = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST['signup'];
    $errors = [];

    $required = ['password', 'name', 'message'];
    $dict = [
        'email' => 'Электронный адрес',
        'password' => 'Ваш пароль',
        'name' => 'Ваше имя',
        'message' => 'Контактные данные'
    ];
    foreach ($required as $key) {
        if (empty($form[$key])) {
            $errors[$key] = '- поле, необходимое к заполнению';
        }
    }
    $email = mysqli_real_escape_string($con, $form['email']);
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $sql);

    if (!empty($_FILES['profile_img']['name'])) {
        $tmp_name = $_FILES['profile_img']['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        $filename = 'img' . DIRECTORY_SEPARATOR . uniqid() . '.jpg';
        $form['profile_img'] = $filename;
        if ($file_type !== "image/jpeg") {
            $errors['profile_img'] = 'Загрузите картинку в формате JPEG';
        } else {
            move_uploaded_file($_FILES['profile_img']['tmp_name'], __DIR__ . DIRECTORY_SEPARATOR . $filename);
        }
    }

    if (empty($form['email'])) {
        $errors['email'] = '- поле, необходимое к заполнению';

    } elseif (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'уже занят. Пожалуйста, выберите другой.';
    } else {
        $password = password_hash($form['password'], PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users (reg_date, email, name, password, profile_img, contacts) VALUES (NOW(), ?, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($con, $sql, [$form['email'], $form['name'], $password, $form['profile_img'], $form['message']]);
        $res = mysqli_stmt_execute($stmt);
    }
    if ($res && empty($errors)) {
        header("location: /login.php");
        exit();
    }
    $tpl_data['errors'] = $errors;
    $tpl_data['values'] = $form;

}


var_dump($errors);
var_dump($_FILES);
$content =  include_template('sign-up.php', [
    'category_array' => $category_array,
    'errors' => $errors,
    'dict' => $dict,
    $tpl_data
]);
$layout_content = include_template ('layout.php', [
    'title' => 'Регистрация аккаунта',
    'content' => $content,
    'category_array' => $category_array,
    'username' => $sesUser['username'],
    'profile_img' => $sesUser['profile_img']
]);
echo $layout_content;
?>