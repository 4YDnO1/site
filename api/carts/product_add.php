<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

if (empty($post['product_id'])) response(0, 'Ошибка. Номер товара не передан', "id", 200);

// Поиск товара в базе данных
$query =
"SELECT * FROM `products` AS p
WHERE p.id = $post[product_id]";
$product_result = mysqli_query($connection, $query);
$product = mysqli_fetch_assoc($product_result);

// Проверка есть ли текущая корзина у пользователя
$query =
"SELECT * FROM `carts` AS cr
WHERE cr.is_ordered = 0 and cr.user_id = ".$_SESSION['user_data']['id'];
$cart_result = mysqli_query($connection, $query);
$cart = mysqli_fetch_assoc($cart_result);

if (!$cart) {
    // Создание если нет
    $query =
    "INSERT INTO `carts` (`user_id`)
    VALUES (".$_SESSION['user_data']['id'].")";
    $insert_result = mysqli_query($connection, $query);
}

// Повторное взятие корзины
$query =
"SELECT * FROM `carts` AS cr
WHERE cr.is_ordered = 0 and cr.user_id = ".$_SESSION['user_data']['id'];
$cart_result = mysqli_query($connection, $query);
$cart = mysqli_fetch_assoc($cart_result);

// Проверка товара в корзине
$query =
"SELECT * FROM `carts_products` AS cp
WHERE cp.cart_id = ".$cart['id']." and cp.product_id = $post[product_id]";
$cart_product_result = mysqli_query($connection, $query);
$cart_product = mysqli_fetch_assoc($cart_product_result);

if ($cart_product) {
    if ($product['amount'] <= $cart_product['amount']) {
        response(0, 'Ошибка. Товара больше нет. <br />Выбрано максимальное колчество!', "", 200);
    }
    $query =
    "UPDATE `carts_products` AS cp
    SET cp.amount = ".(int)$cart_product['amount'] + 1 . " WHERE cp.cart_id = $cart[id] and cp.product_id = $post[product_id]";
    $cart_product_update_result = mysqli_query($connection, $query);
} else {
    $query =
    "INSERT INTO `carts_products` (`cart_id`, `product_id`, `amount`)
    VALUES ($cart[id], $post[product_id], 1)";
    $cart_product_update_result = mysqli_query($connection, $query);
}


if ($cart_product_update_result) {
	response(1, 'Успешно. Товар добавлен', "", 200);
} else {
	response(0, 'Ошибка. Сервер не может обработать добовление товара', "", 500);
}