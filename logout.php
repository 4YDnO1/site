<?php require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

session_start();
session_destroy();
$_COOKIE['PHPSESSID'] = '';
unset($_SESSION['user_data']);
$_SESSION['user_data'] = [];

header('Location: /index.php');
exit(0);
