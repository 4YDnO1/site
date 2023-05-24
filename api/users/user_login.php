<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

if (empty($post['login'])) response(0, 'Ошибка. Логин не введён', "login", 200);
if (empty($post['password'])) response(0, 'Ошибка. Пароль не введён', "password", 200);

$query =
"SELECT * FROM `users`
WHERE `login` = '$post[login]'
LIMIT 0, 1";
$result = mysqli_query($connection, $query);
$user_data = mysqli_fetch_assoc($result);

if (empty($user_data)) response(0, 'Ошибка. Неверный Логин', "login", 200);

if (!password_verify($post['password'], $user_data['password'])) {
	response(0, 'Ошибка. Неверный пароль', "password", 200);
}

$_SESSION['user_data'] = $user_data;
response(1, 'Успешно. Вы авторизированы', '', 200);
