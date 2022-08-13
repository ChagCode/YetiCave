<?php
require_once('init.php');
require_once('models.php');
require_once('functions.php');
require_once('data.php');
require_once('helpers.php');

$categories = getCategories($con);
$categories_id = array_column($categories, 'id');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // СПИСОК ОБЯЗАТЕЛЬНЫХ ПОЛЕЙ
    $require_fields = ['title', 'category', 'lot_description', 'img', 'start_price', 'step', 'date_finish',];
    $errors = [];
    //СПИСОК ФУНКЦИЙ ДЛЯ ВАЛИДАЦИИ
    $rules = [
        'category' => function($value) use ($categories_id) {
            return validateCategory($value, $categories_id);
        },
        'start_price' => function($value) {
            return validateNumb($value);
        },
        'step' => function($value) {
            return validateNumb($value);
        },
        'date_finish' => function($value) {
            return validateDate($value);
        }
    ];
    //ПОЛУЧАЕМ ЗНАЧЕНИЯ ИЗ ФОРМЫ
    $lot = filter_input_array(INPUT_POST,
    [
        'title' => FILTER_DEFAULT,
        'category' => FILTER_DEFAULT,
        'lot_description' => FILTER_DEFAULT,
        'start_price' => FILTER_DEFAULT,
        'step' => FILTER_DEFAULT,
        'date_finish' => FILTER_DEFAULT
    ], true);
    //ПРОХОДИМСЯ ПО ПОЛУЧЕННЫМ ЗНАЧЕНИЯМ И ПРИМЕНЯЕМ ФУНКЦИИ ВАЛИДАЦИИ, А ТАКЖЕ
    foreach ($lot as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }//ПРОВЕРКА ПОЛЯ НА НЕОБХОДИМОСТЬ ЗАПОЛНЕНИЯ
        if (in_array($key, $require_fields) && empty($value)) {
            $errors[$key] = "Поле $key нужно заполнить";
        }
    }
    //УБИРАЕМ ИЗ МАССИВА ЗНАЧЕНИЯ type NULL
    //ОСТАНУТЬСЯ СООБЩЕНИЯ ТОЛЬКО О НЕВАЛИДНЫХ ПОЛЯХ
    $errors = array_filter($errors);

    if (!empty($_FILES['img']['name'])) {
        $tmp_name = $_FILES['img']['tmp_name'];
        $path = $_FILES['img']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type === 'image/jpeg') {
            $ext = '.jpg';
        } else if ($file_type === 'image/png') {
            $ext = '.png';
        };
        if ($ext) {
            $filename = uniqid() . $ext;
            $lot['path'] = 'uploads/'. $filename;
            move_uploaded_file($_FILES['img']['tmp_name'], 'uploads/'. $filename);
        } else {
            $errors['img'] = 'Допустимые форматы файлов: jpg, jpeg, png';
        }
    } else {
        $errors['img'] = 'Вы не загрузили изображение';
    }
    if (count($errors)) {
        $page_content = include_template('add2.php', [
            'lot' => $lot,
            'errors' => $errors,
            'categories' => $categories,
        ]);
    } else {
        $sql = "INSERT INTO lots (title, category_id, lot_description, start_price, step, date_finish, img, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
        $stmt = db_get_prepare_stmt_version($con, $sql, $lot);
        $res = mysqli_stmt_execute($stmt);


        if ($res) {
            $lot_id = mysqli_insert_id($con);
            header("Location: lot.php?id=" . $lot_id);
        }
    }

}


$page_content = include_template('add2.php', [
    'categories' => $categories,
]);

$layout_content = include_template('layout.php', [
   'content' => $page_content,
   'categories' => $categories,
   'is_auth' => $is_auth,
   'user_name' => $user_name,
   'title' => 'Добавление лота',
]);

print($layout_content);
