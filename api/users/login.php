<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

if (empty($_POST['login'])) response(0, 'Ошибка. Логин не введён', "login", 200);
if (empty($_POST['password'])) response(0, 'Ошибка. Пароль не введён', "password", 200);

$q =
"SELECT * FROM `users`
WHERE `login` = '$_POST[login]'
LIMIT 0, 1";
$result = mysqli_query($c, $q);
$user_data = mysqli_fetch_assoc($result);

if (empty($user_data)) response(0, 'Ошибка. Неверный Логин', "login", 200);

if (!password_verify($_POST['password'], $user_data['password']))
	response(0, 'Ошибка. Неверный пароль', "password", 200);

$_SESSION['user_data'] = $user_data;
response(1, 'Успешно. Вы авторизированы', '', 200);
