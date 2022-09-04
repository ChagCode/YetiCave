<?php
require_once('init.php');
require_once('models.php');
require_once('functions.php');
require_once('data.php');
require_once('helpers.php');

$categories = getCategories($con);
$header = include_template('header.php', ['categories' => $categories]);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$lot = getLot($con, $id);

$page_content = include_template('lot.php', [
    'lot' => $lot,
    'categories' => $categories,
    'header' => $header,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $lot['title'],
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

print($layout_content);
