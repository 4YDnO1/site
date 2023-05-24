<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

$image = $_FILES['image'] ?? NULL;

if (empty($post['product_name'])) response(0, 'Ошибка. Название не введено', "product_name", 200);
if (empty($post['category_id'])) response(0, 'Ошибка. Категория не выбрана', "category_id", 200);
if (empty($image)) response(0, 'Ошибка. Изображение не выбрано', "excursion_image", 200);
if (empty($post['price'])) response(0, 'Ошибка. Цена не введена', "price", 200);
if (empty($post['year'])) response(0, 'Ошибка. Год не введён', "amount", 200);
if (empty($post['country'])) response(0, 'Ошибка. Страна не введена', "time", 200);
if (empty($post['amount'])) response(0, 'Ошибка. Количество не введено', "time", 200);

$query =
"SELECT * FROM `products`
WHERE `product_name` = '$post[product_name]'
LIMIT 0, 1";
$product_result = mysqli_query($connection, $query);
$product_data = mysqli_fetch_assoc($product_result);

if (!empty($product_data)) response(0, 'Ошибка. Товар с таким именем уже существует', "name", 200);

$image_type = $image['type'];
$image_name = md5(microtime()).'.'.substr($image_type, strlen("image/"));
$image_file = $sp."/uploads/products/".$image_name;

if(!move_uploaded_file($image['tmp_name'], $image_file)) response(0, 'Что-то пошло не так при загрузке изображения', "", 200);

$query =
"INSERT INTO `products`
(`product_name`, `category_id`, `image_name`, `price`, `year`, `country`, `amount`)
VALUES
('$post[product_name]', '$post[category_id]', '$image_name', '$post[price]', '$post[year]', '$post[country]', '$post[amount]')";
$product_insert_result = mysqli_query($connection, $query);

if ($product_insert_result) {
	response(1, 'Успешно. Товар добавлен', "", 200);
} else {
	response(0, 'Ошибка. Сервер не может обработать добавление товара', "", 500);
}
