<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

if (empty($get['id'])) response(0, 'Ошибка. Номер продукта не введён', "", 200);

$query =
"DELETE `p` FROM `products` AS p WHERE p.id = '$get[id]'";
$product_delete_result = mysqli_query($connection, $query);

if ($product_delete_result) {
	response(1, 'Успешно. Товар и связаные с ним записи удалены', "", 200);
} else {
	response(0, 'Ошибка. Сервер не может обработать удаление товара', "", 500);
}
