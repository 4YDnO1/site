<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

if (empty($_POST['surname'])) response(0, 'Ошибка. Фамилия не введена', 'surname', 200);
if (empty($_POST['name'])) response(0, 'Ошибка. Имя не введено', "name", 200);
if (empty($_POST['patronymic'])) response(0, 'Ошибка. Отчество не введено', "patronymic", 200);
if (empty($_POST['login'])) response(0, 'Ошибка. Логин не введен', "login", 200);
if (empty($_POST['email'])) response(0, 'Ошибка. Почта не введена', "email", 200);
if (empty($_POST['password'])) response(0, 'Ошибка. Пароль не введён', "password", 200);
if (empty($_POST['password_repeat'])) response(0, 'Ошибка. Повторный пароль не введён', "password_repeat", 200);

if ($_POST['password'] !== $_POST['password_repeat']) response(0, 'Ошибка. Введённые пароли не совпадают', "password_repeat", 200);

$q =
"SELECT * FROM `users`
WHERE `email` = '$_POST[email]'
LIMIT 0, 1";
$res = mysqli_query($c, $q);
$user_data = mysqli_fetch_assoc($res);

if (!empty($user_data)) response(0, 'Ошибка. Аккаунт с такой почтой уже существует', "email", 200);

$q =
"SELECT * FROM `users`
WHERE `login` = '$_POST[login]'
LIMIT 0, 1";
$res = mysqli_query($c, $q);
$user_data = mysqli_fetch_assoc($res);

if (!empty($user_data)) response(0, 'Ошибка. Аккаунт с таким логином уже существует', "login", 200);

// $avatar = $_FILES['avatar_image'];
// $avatar_type = $avatar['type'];
// $avatar_name = md5(microtime()).'.'.substr($avatar_type, strlen("image/"));
// $avatar_file = $sp."/uploads/avatars/".$avatar_name;

// if(!move_uploaded_file($avatar['tmp_name'], $avatar_file)) {
// 	response(0, 'Что-то пошло не так при загрузке изображения', "", 200);
// }

$password_hash = password_hash($_POST['password_repeat'], PASSWORD_BCRYPT);

$q =
"INSERT INTO `users` (`user_surname`, `user_name`, `user_patronymic`, `login`, `email`, `password`)
VALUES ('$_POST[surname]', '$_POST[name]', '$_POST[patronymic]', '$_POST[login]', '$_POST[email]', '$password_hash')";
$ins_res = mysqli_query($c, $q);

if ($ins_res) {
	$q =
	"SELECT * FROM `users`
	WHERE `login` = '$_POST[login]'
	LIMIT 0, 1";
	$res = mysqli_query($c, $q);
	$user_data = mysqli_fetch_assoc($res);
	$_SESSION['user_data'] = $user_data[0];
	response(1, 'Успешно. Пользователь зарегистрирован', "", 200);
} else {
	response(0, 'Ошибка. Сервер не может обработать регистрацию', "", 500);
}
