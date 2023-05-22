<?php
session_start();
$uri = explode('?', $_SERVER["REQUEST_URI"])[0]; 
$sp = $_SERVER['DOCUMENT_ROOT'];
$appn = 'Цветочек';

$c = mysqli_connect("127.0.0.1", "root", "", "flowers", 3308);

function response(bool $res_status, string $res_message, string $res_error_field, int $res_code, array $res_data = []): void {
	$data = [
		'res_status' => $res_status,
		'res_message' => $res_message,
		'res_error_field' => $res_error_field,
		'res_data' => $res_data
	];
	http_response_code($res_code);
	echo json_encode($data, JSON_UNESCAPED_UNICODE);
	exit(0);
}