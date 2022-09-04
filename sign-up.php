<?php
require_once('init.php');
require_once('models.php');
require_once('functions.php');
require_once('data.php');
require_once('helpers.php');

$categories = getCategories($con);

$header = include_template('header.php', ['categories' => $categories]);

$page_content = include_template('sign-up.php', [
    'categories' => $categories,
    'header' => $header,
]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $require_fields = ['email', 'user_password', 'user_name', 'contacts',];
    $errors = [];

    $rules = [
        'email' => function($value) {
            return validateEmail($value);
        },
        'user_password' => function($value) {
            return validateLength($value, 6, 100);
        },
    ];

    $user = filter_input_array(INPUT_POST,
        [
            'email' => FILTER_DEFAULT,
            'user_password' => FILTER_DEFAULT,
            'user_name' => FILTER_DEFAULT,
            'contacts' => FILTER_DEFAULT,
        ], true);

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
        $page_content = include_template('sign-up.php',
        [
            'user' => $user,
            'errors' => $errors,
            'categories' => $categories,
            'header' => $header,
        ]);
    } else {
        $sql_users = getEmailUsers($con);
        $emails_col = array_column($sql_users, 'email');
        if (in_array($user['email'], $emails_col)) {
            $errors['email'] = "Такой email уже зарегистрирован на этом сайте";
        }
        if (count($errors)) {
            $page_content = include_template('sign-up.php', [
                'user' => $user,
                'errors' => $errors,
                'categories' => $categories,
                'header' => $header,
            ]);
        } else {
            $sql = addUser();
            $user['user_password'] = password_hash($user['user_password'], PASSWORD_DEFAULT);
            $stmt = db_get_prepare_stmt_version($con, $sql, $user);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                header('Location: /login.php');
            } else {
                print("Ошибка MySQL: " . mysqli_error($con));
            }
        }
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'Регистрация пользователя',
]);

print($layout_content);
