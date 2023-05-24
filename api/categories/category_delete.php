<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

if (empty($get['id'])) response(0, 'Ошибка. Номер категории не введён', "", 200);

$query =
"DELETE `c` FROM `categories` AS c WHERE c.id = '$get[id]'";
$category_delete_result = mysqli_query($connection, $query);

if ($category_delete_result) {
	response(1, 'Успешно. Категория и связаные с ней записи удалены', "", 200);
} else {
	response(0, 'Ошибка. Сервер не может обработать удаление категории', "", 500);
}
