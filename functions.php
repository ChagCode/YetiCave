<?php
/**
 * Функция форматирования цены
 * $price - изначальная цуна
 * return "$price ₽" - отформатированная цена
 **/

function format_price($price)
{
    $price = ceil($price);
    $price = number_format($price, 0, '', ' ');
    return "$price ₽";
}

/**
 * Функция для подстета оставшегося времени
 * $dt - дата истечения срока
**/

function get_time_final($dt)
{
    date_default_timezone_set('Europe/Moscow');
    $dt_now = date_create('now');
    $dt_final = date_create($dt);
    $diff = date_diff($dt_final, $dt_now);
    $diff = date_interval_format($diff, '%d %H %i');
    $diff = explode(' ', $diff);

    $hours = $diff[0] * 24 + $diff[1];
    $minutes = intval($diff[2]);
    $hours = str_pad($hours, 2, '0', STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
    $res[] = $hours;
    $res[] = $minutes;

    return $res;
}

/**
 * Возвращает массив из объекта результата запроса
 * @param object $result_query mysqli Результат запроса к базе данных
 * @return array
 */
function get_arrow($result_query) {
    $row = mysqli_num_rows($result_query);
    if ($row === 1) {
        $arrow = mysqli_fetch_assoc($result_query);
    } else if ($row > 1) {
        $arrow = mysqli_fetch_all($result_query, MYSQLI_ASSOC);
    }

    return $arrow;
}

// ПРАВИЛО ДЛЯ ДЛИНЫ ТЕКСТА
function validateLength($value, $min, $max) {
    if ($value) {
        $len = strlen($value);
        if ($len < $min or $len > $max) {
            return "Значение должно быть от $min до $max символов";
        }
    }
}
// ПРАВИЛО ДЛЯ ПРИСУТСТВИЯ КАТЕГОРИИ
function validateCategory($id, $allowed_list) {
    if (!in_array($id, $allowed_list)) {
        return "Указанная категория отсутствует";
    }
}
// ПРАВИЛО ДЛЯ НАЧАЛЬНОЙ ЦЕНЫ
function validateNumb($numb) {
    if (!empty($numb)) {
        $numb *= 1;
        if (is_int($numb) && $numb > 0) {
            return NULL;
        }
        return "Содержимое поля должно быть целым числом больше ноля";
    }
}

// ПРАВИЛО ДЛЯ ДАТЫ
function validateDate ($date) {
    if (is_date_valid($date)) {
        $now = date_create("now");
        $date_create = date_create($date);
        $diff = date_diff($date_create, $now);
        $interval = date_interval_format($diff, "%d");

        if ($interval < 1) {
            return "Дата должна быть больше текущей не менее чем на один день";
        };
    } else {
        return "Содержимое поля «дата завершения» должно быть датой в формате «ГГГГ-ММ-ДД»";
    }
};


// ПРАВИЛО ДЛЯ EMAIL
function validateEmail ($value) {
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return "Введите корректный EMAIL";
    }
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return stmt Подготовленное выражение
 */
function db_get_prepare_stmt_version($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $key => $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);
        mysqli_stmt_bind_param(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

function getPostVal($value) {
    return $_POST[$value] ?? '';
}
