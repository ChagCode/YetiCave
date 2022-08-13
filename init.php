<?php

// подключение к БД

$con = mysqli_connect("localhost", "root", "root", "yeticave");

// установка кодировки
mysqli_set_charset($con, "utf8");

if (!$con) {

    print("Ошибка подключения:  ". mysqli_connect_error());
}

