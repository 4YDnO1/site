<?php
// Старт новой сессии или получение существующей
session_start();

// Переменный для удобной работы с файлами и сервером
$uri = explode("?", $_SERVER["REQUEST_URI"])[0]; 
$server_path = $_SERVER["DOCUMENT_ROOT"];
$app_name = "CopyStar";

// Соединение с базой данных
$connection = mysqli_connect("127.0.0.1", "root", "", "music_shop");

// Функция отчистки данных get и post
// (экранизация и фильтрация от кросс скриптинга и sql инъекций)
function clean_data(array $data): array {
	foreach ($data as &$data_value) {
		$data_value = htmlspecialchars(strip_tags($data_value));
	}
	return $data;
}

// Отчищенные данные
$get = clean_data($_GET);
$post = clean_data($_POST);

// Функция выдачи ответа от сервера в виде json
function response(bool $status, string $message, string $error_field, int $code, array $data = []): void {
	$data = [
		"status" => $status,
		"message" => $message,
		"error_field" => $error_field,
		"data" => $data
	];
	http_response_code($code);
	echo json_encode($data, JSON_UNESCAPED_UNICODE);
	exit(0);
}
