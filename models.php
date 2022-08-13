<?php
// ВОЗВРАЩАЕТ МАССИВ КАТЕГОРИЙ ИЗ БД
function getCategories($con) {
    if ($con) {
        $sql_cat = "SELECT id, category, character_code FROM categories";
        $result_sql = mysqli_query($con, $sql_cat);
        if ($result_sql) {
            $categories = get_arrow($result_sql);
            return $categories;
        } else {
            print("Оштбка MySQL: " . mysqli_error($con));
        }
    }
}

function getLot($con, $id) {
    if ($id) {
        $sql_lot = "SELECT lots.id, lots.date_creation, lots.img, lots.title, lots.lot_description,
        lots.start_price, lots.date_finish, lots.step, user_id, categories.category FROM lots
        JOIN categories ON lots.category_id=categories.id WHERE lots.id = $id;";
    } else {
        http_response_code(404);
        die();
    }
    $result_sql = mysqli_query($con, $sql_lot);
    if ($result_sql) {
        $lot = get_arrow($result_sql);
        return $lot;
    } else {
        print("Оштбка MySQL: " . mysqli_error($con));
    }
    if (!id) {
        http_response_code(404);
        die();
    }

}

/**
// SQL-запрос для добавления нового лота
function get_query_create_lot($user_id) {
    return "INSERT INTO lots (title, category_id, lot_description, start_price, step, date_finish, img, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, $user_id);";
}
*/
