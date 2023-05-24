<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/default.php";

$image = $_FILES['image'] ?? '';

if (empty($post['product_name'])) response(0, 'Ошибка. Название не введено', "product_name", 200);
if (empty($post['category_id'])) response(0, 'Ошибка. Категория не выбрана', "category_id", 200);
if (empty($image)) response(0, 'Ошибка. Изображение не выбрано', "excursion_image", 200);
if (empty($post['price'])) response(0, 'Ошибка. Цена не введена', "price", 200);
if (empty($post['year'])) response(0, 'Ошибка. Год не введён', "amount", 200);
if (empty($post['country'])) response(0, 'Ошибка. Страна не введена', "time", 200);
if (empty($post['amount'])) response(0, 'Ошибка. Количество не введено', "time", 200);

if (!empty($image)) {
	$image_type = $image['type'];
	$image_name = md5(microtime()).'.'.substr($image_type, strlen("image/"));
	$image_file = $sp."/uploads/excursions/".$image_name;

	if(!move_uploaded_file($image['tmp_name'], $image_file)) {
		response(0, 'Что-то пошло не так при загрузке изображения', "", 200);
	}

    $query =
    "UPDATE `products`
    SET `product_name`='$post[product_name]',`category_id`='$post[category_id]',`image_name`='$image_name',`price`='$post[price]',`year`='$post[year]',`country`='$post[country]',`amount`='$post[amount]' WHERE id = $post[id]";
    $product_update_result = mysqli_query($connection, $query);
} else {
    $query =
    "UPDATE `products`
    SET `product_name`='$post[product_name]',`category_id`='$post[category_id]',`price`='$post[price]',`year`='$post[year]',`country`='$post[country]',`amount`='$post[amount]' WHERE id = $post[id]";
    $product_update_result = mysqli_query($connection, $query);
}

if ($product_update_result) {
	response(1, 'Успешно. Экскурсия обновлена', "", 200);
} else {
	response(0, 'Ошибка. Сервер не может обработать обновление экскурсии', "", 500);
}
