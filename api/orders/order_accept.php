<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

if (empty($post['order_id'])) response(0, 'Ошибка. Номер заказа не передан', "", 200);

"UPDATE `orders`
SET `status_id`=2 WHERE id = $post[order_id]";
$order_update_result = mysqli_query($connection, $query);


if ($order_update_result) {
	response(1, 'Успешно. Заказ обновлён. Подтверждён', "", 200);
} else {
	response(0, 'Ошибка. Сервер не может обработать подтверждение заказа', "", 500);
}