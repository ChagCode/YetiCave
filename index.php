<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");

if ($con) {
    //показ лотов на главной странице
    $sql_lots = "SELECT lots.id, lots.img, categories.category, lots.title, lots.start_price, lots.date_finish FROM lots JOIN categories ON lots.category_id = categories.id ORDER BY date_creation DESC";

    // ВЫПОЛНЕНИЕ ЗАПРОСА SQL И ПОЛУЧЕНИЕ ОБЪЕКТА В ВИДЕ РЕЗУЛЬТАТА
    $result_lots = mysqli_query($con, $sql_lots);

    // ПРОВЕРКА ПРАВИЛЬНОСТИ ИСПОЛНЕНИЯ ЗАПРОСА
    if ($result_lots) {

        //ПРЕОБРАЗОВАНИЕ ОБЪЕКТА В 2 МЕРНЫЙ МАССИВ
        $products = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
    }
        else {
            print("Ошибка MySQL:  " . mysqli_error($con));
        }
}

// ПОЛУЧЕНИЕ СПИСКА КАТЕГОРИЙ
$sql_cat = "SELECT character_code, category FROM categories";

// ВЫПОЛНЕНИЕ ЗАПРОСА SQL И ПОЛУЧЕНИЕ ОБЪЕКТА В ВИДЕ РЕЗУЛЬТАТА
$results_cat = mysqli_query($con, $sql_cat);

if ($results_cat) {
    //ПРЕОБРАЗОВАНИЕ ОБЪЕКТА В 2 МЕРНЫЙ МАССИВ
    $categories = mysqli_fetch_all($results_cat, MYSQLI_ASSOC);
} else {
    print("Ошибка MySQL:  ". mysqli_error($con));
}

$page_content = include_template("main.php", [
    "categories" => $categories,
    "products" => $products,
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Главная",
    "is_auth" => $is_auth,
    "user_name" => $user_name,
]);

print($layout_content);

