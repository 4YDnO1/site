<?php

session_start();
session_destroy();
$_COOKIE['PHPSESSID'] = '';
unset($_SESSION['user']);
$_SESSION['user'] = [];

header('Location: /index.php');
exit(0);
