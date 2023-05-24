<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

if (empty($post['surname'])) response(0, 'Ошибка. Фамилия не введена', 'surname', 200);
if (empty($post['name'])) response(0, 'Ошибка. Имя не введено', "name", 200);
if (empty($post['patronymic'])) response(0, 'Ошибка. Отчество не введено', "patronymic", 200);
if (empty($post['login'])) response(0, 'Ошибка. Логин не введен', "login", 200);
if (empty($post['email'])) response(0, 'Ошибка. Почта не введена', "email", 200);
if (empty($post['password'])) response(0, 'Ошибка. Пароль не введён', "password", 200);
if (empty($post['password_repeat'])) response(0, 'Ошибка. Повторный пароль не введён', "password_repeat", 200);

if ($post['password'] !== $post['password_repeat']) response(0, 'Ошибка. Введённые пароли не совпадают', "password_repeat", 200);

$query =
"SELECT * FROM `users`
WHERE `email` = '$post[email]'
LIMIT 0, 1";
$res = mysqli_query($connection, $query);
$user_data = mysqli_fetch_assoc($res);

if (!empty($user_data)) response(0, 'Ошибка. Аккаунт с такой почтой уже существует', "email", 200);

$query =
"SELECT * FROM `users`
WHERE `login` = '$post[login]'
LIMIT 0, 1";
$result = mysqli_query($connection, $query);
$user_data = mysqli_fetch_assoc($result);

if (!empty($user_data)) response(0, 'Ошибка. Аккаунт с таким логином уже существует', "login", 200);

// $avatar = $_FILES['avatar_image'];
// $avatar_type = $avatar['type'];
// $avatar_name = md5(microtime()).'.'.substr($avatar_type, strlen("image/"));
// $avatar_file = $sp."/uploads/avatars/".$avatar_name;

// if(!move_uploaded_file($avatar['tmp_name'], $avatar_file)) {
// 	response(0, 'Что-то пошло не так при загрузке изображения', "", 200);
// }

$password_hash = password_hash($post['password_repeat'], PASSWORD_BCRYPT);

$query =
"INSERT INTO `users` (`user_surname`, `user_name`, `user_patronymic`, `login`, `email`, `password`)
VALUES ('$post[surname]', '$post[name]', '$post[patronymic]', '$post[login]', '$post[email]', '$password_hash')";
$insert_result = mysqli_query($connection, $query);

if ($insert_result) {
	$query =
	"SELECT * FROM `users`
	WHERE `login` = '$post[login]'
	LIMIT 0, 1";
	$result = mysqli_query($connection, $query);
	$user_data = mysqli_fetch_assoc($result);
	$_SESSION['user_data'] = $user_data;
	response(1, 'Успешно. Пользователь зарегистрирован', "", 200);
} else {
	response(0, 'Ошибка. Сервер не может обработать регистрацию', "", 500);
}
