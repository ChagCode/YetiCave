<?php
session_start();
$is_auth = isset($_SESSION['userName']);
$user_name = $is_auth ? $_SESSION['userName'] : "";

