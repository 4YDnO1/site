<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/default.php";

$image = $_FILES['image'] ?? '';

if (empty($post['category_id'])) response(0, 'Ошибка. Номер категории не введён', "", 200);
if (empty($post['category_name'])) response(0, 'Ошибка. Название не введено', "category_name", 200);


$query =
"UPDATE `categories`
SET `category_name`='$post[category_name]' WHERE id = $post[category_id]";
$category_update_result = mysqli_query($connection, $query);


if ($category_update_result) {
	response(1, 'Успешно. Категория обновлена', "", 200);
} else {
	response(0, 'Ошибка. Сервер не может обработать обновление категории', "", 500);
}
