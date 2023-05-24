<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

if (empty($post['cart_id'])) response(0, 'Ошибка. Номер корзины не передан', "", 200);
if (empty($post['password'])) response(0, 'Ошибка. Пароль не передан', "password", 200);

// Поиск пользователя
$query =
"SELECT * FROM `users` AS u
WHERE u.id = ". $_SESSION['user_data']['id']." LIMIT 0, 1";
$user_result = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($user_result);

if(!password_verify($post['password'], $user['password'])) {
    response(0, 'Ошибка. Введённый пароль не верный', "password", 200);
}

$query =
"SELECT * FROM `carts_products` AS cr
WHERE cr.id = $post[cart_id]";
$cart_products_result = mysqli_query($connection, $query);

$query =
"INSERT INTO `orders` (`user_id`) VALUES (".$_SESSION['user_data']['id'].")";
$order_result = mysqli_query($connection, $query);

if ($order_result) {
	$id = mysqli_insert_id($connection);

	$query =
	"INSERT INTO `orders_products` (`order_id`, `product_id`, `amount`) VALUES ";
	$insert = "";

	while ($product = mysqli_fetch_assoc($cart_products_result)) {
		$insert .= "($id, $product[product_id], $product[amount]), ";
	}
	$insert = mb_substr($insert, 0, -2);
	$query .=  $insert;

	$order_products_result = mysqli_query($connection, $query);
} else {
	response(0, 'Ошибка. Сервер не может обработать создание закза', "", 500);
}

if ($order_products_result) {
	$query =
	"UPDATE `carts` (`user_id`) VALUES (".$_SESSION['user_data']['id'].")";
	$order_result = mysqli_query($connection, $query);

	"UPDATE `carts`
    SET `is_orderes`=1 WHERE id = $post[cart_id]";
    $cart_update_result = mysqli_query($connection, $query);
}

if ($order_products_result && $cart_update_result) {
	response(1, 'Успешно. Заказ оформлен. Его номер №', "", 200);
} else {
	response(0, 'Ошибка. Сервер не может обработать оформление заказа', "", 500);
}