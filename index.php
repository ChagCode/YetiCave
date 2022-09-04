<?php
require_once('helpers.php');
require_once('functions.php');
require_once('data.php');
require_once('init.php');
require_once('models.php');

$products = getQueryLots($con);

$categories = getCategories($con);

$page_content = include_template('main.php', [
    'categories' => $categories,
    'products' => $products,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => "Главная",
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

print($layout_content);
