<?php
// ЗАПРОС НА ПОЛУЧЕНИЕ ЛОТОВ
function getQueryLots ($con) {
        $sql = "SELECT lots.id, lots.img, categories.category, lots.title, lots.start_price, lots.date_finish FROM lots JOIN categories ON lots.category_id = categories.id ORDER BY date_creation DESC";
        $results = mysqli_query($con, $sql);
        if ($results) {
            $products = get_arrow($results);
            return $products;
        } else {
            print("Оштбка MySQL: " . mysqli_error($con));
    }
}

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
        JOIN categories ON lots.category_id=categories.id WHERE lots.id = '$id'";
    } else {
        print("Оштбка MySQL: " . mysqli_error($con));
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

// EMAIL без дубликатов

/**
 * SQL-запрос на добавление зарегистрированного пользователя
 */
function addUser () {
    return "INSERT INTO users (email, user_password, user_name, contacts, date_registration) VALUES (?, ?, ?, ?, NOW())";
}

//
function createLot ($user_id) {
    return "INSERT INTO lots (title, category_id, lot_description, start_price, step, date_finish, img, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, $user_id)";
}

// ЗАПРОС НА ПОЛУЧЕНИЕ EMAIL для регистрации
function getEmailUsers ($con) {
    if ($con) {
        $sql = "SELECT email FROM users";
    } else {
        print("Оштбка MySQL: " . mysqli_error($con));
    }
    $res_sql = mysqli_query($con, $sql);
    if ($res_sql) {
        $tb_email = get_arrow($res_sql);
        return $tb_email;
    } else {
        print("Оштбка MySQL: " . mysqli_error($con));
    }
}


// ЗАПРОС НА ПОЛУЧЕНИЕ ЮЗЕРОВ
function getLogin ($con, $email) {
    if ($con) {
        $sql = "SELECT id, user_name, email, user_password FROM users WHERE email='$email'";
    } else {
        print("Ошибка MySQL: " . mysqli_error($con));
    }
    $res_sql = mysqli_query($con, $sql);
    if ($res_sql) {
        $tb_users = get_arrow($res_sql);
        return $tb_users;
    } else {
        print("Оштбка MySQL: " . mysqli_error($con));
    }
}
