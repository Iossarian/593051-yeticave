<?php
require_once ('db.php');
require_once ('functions.php');
session_start();
//Подключение категорий
$sql = "SELECT id, category_name FROM category";
$sql_result = mysqli_query($con, $sql);
$category_array = mysqli_fetch_all($sql_result, MYSQLI_ASSOC);
//Аутентификация
if($_SERVER['REQUEST_METHOD'] =='POST') {
    $form = $_POST;
    $required = ['email', 'password'];
    $errors = [];
    foreach ($required as $field) {
        if(empty($form[$field])) {
            $errors[$field] = 'Это поле обязательно к заполнению';
        }
    }
    $email = mysqli_real_escape_string($con, $form['email']);
    $sql_email = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $sql_email);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if(!count($errors) and $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        $errors['email'] = 'Такого пользователя не существует';
    }
    if (count($errors)) {
        $content = include_template('login.php', [
                'form' => $form,
                'errors' => $errors
        ]);
    } else {
        header("Location: /index.php");
        exit;
    }
} else {
    if (isset($_SESSION['user'])) {
        $content = include_template('welcome.php', ['username' => $_SESSION['user']['name']]);
    }
}




$content =  include_template('login.php', [
    'category_array' => $category_array,
    'form' => $form,
    'errors' => $errors
]);
$layout_content = include_template ('layout.php', [
    '$title' => 'Вход в аккаунт',
    'content' => $content,
    'category_array' => $category_array
]);
echo $layout_content;
?>
