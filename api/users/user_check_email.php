<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

$query =
"SELECT * FROM `users`
WHERE `email` = '$get[email]'
LIMIT 0, 1";
$result = mysqli_query($connection, $query);
$user_data = mysqli_fetch_assoc($result);

return print(empty($user_data) ? 'true' : 'false');
