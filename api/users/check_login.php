<?php
require_once $_SERVER['DOCUMENT_ROOT']."/require/common.php";

$q =
"SELECT * FROM `users`
WHERE `login` = '$_GET[login]'
LIMIT 0, 1";
$result = mysqli_query($c, $q);
$user_data = mysqli_fetch_assoc($result);

return print(empty($user_data) ? 'true' : 'false');
