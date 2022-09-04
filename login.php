<?php
require_once('init.php');
require_once('models.php');
require_once('functions.php');
require_once('data.php');
require_once('helpers.php');


$categories = getCategories($con);

$header = include_template('header.php', compact('categories'));

$page_content = include_template('login.php', compact('categories', 'header'));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $require_fields = ['email', 'user_password'];
    $errors = [];

    $rules = [
        'email' => function($value) {
            return validateEmail($value);
        },
    ];
    $user = filter_input_array(INPUT_POST,
        [
            'email' => FILTER_DEFAULT,
            'user_password' => FILTER_DEFAULT,
        ]);
    foreach ($user as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }
        if (in_array($key, $require_fields) && empty($value)) {
            $errors[$key] = "Поле $key необходимо заполнить";
        }
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $page_content = include_template('login.php', compact('user', 'errors', 'categories', 'header'));
    } else {
        $sql_users = getLogin($con, $user['email']);
        if ($sql_users) {
            if (password_verify($user['user_password'], $sql_users['user_password'])) {
                session_start();
                $_SESSION['userName'] = $sql_users['user_name'];
                $_SESSION['userId'] = $sql_users['id'];

                header('location: index.php');
                //echo "<script type='text/javascript'>  window.location='index.php'; </script>";
            } else {
                return $errors['user_password'] = "Вы ввели неверный пароль";
            }
        } else {
            return $errors['email'] = "Пользователь с таким E-mail не зарегистрирован";
        }
        if (count($errors)) {
            $page_content = include_template('login.php', compact('user', 'errors', 'categories', 'header'));
        }
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'Вход пользователя',
]);

print($layout_content);
