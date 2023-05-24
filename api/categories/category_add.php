<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

if (empty($post['category_name'])) response(0, 'Ошибка. Название не введено', "category_name", 200);

$query =
"SELECT * FROM `categories`
WHERE `category_name` = '$post[category_name]'
LIMIT 0, 1";
$category_result = mysqli_query($connection, $query);
$category_data = mysqli_fetch_assoc($category_result);

if (!empty($category_data)) response(0, 'Ошибка. Категория с таким именем уже существует', "category_name", 200);

$query =
"INSERT INTO `categories`
(`category_name`)
VALUES
('$post[category_name]'])";
$category_insert_result = mysqli_query($connection, $query);

if ($category_insert_result) {
	response(1, 'Успешно. Категория добавлена', "", 200);
} else {
	response(0, 'Ошибка. Сервер не может обработать добавление категории', "", 500);
}
