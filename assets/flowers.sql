CREATE DATABASE IF NOT EXISTS `flowers`;
USE `flowers`;

DROP TABLE IF EXISTS `orders_products`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `orders_statuses`;
DROP TABLE IF EXISTS `carts_products`;
DROP TABLE IF EXISTS `carts`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `roles`;

CREATE TABLE IF NOT EXISTS `roles` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`role_name` VARCHAR(16) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `users` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_surname` VARCHAR(32) NOT NULL,
	`user_name` VARCHAR(16) NOT NULL,
	`user_patronymic` VARCHAR(32) NOT NULL,
	`login` VARCHAR(16) NOT NULL,
	`email` VARCHAR(16) NOT NULL,
	`password` VARCHAR(64) NOT NULL,
	`role_id` INT NOT NULL DEFAULT 1,

	FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `categories` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`category_name` VARCHAR(16) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `products` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`product_name` VARCHAR(32) NOT NULL,
	`category_id` INT NOT NULL,
	`image_name` VARCHAR(70) NOT NULL,
	`price` INT NOT NULL,
	`country` VARCHAR(32) NOT NULL,
	`color` VARCHAR(32) NOT NULL,
	`amount` INT NOT NULL,
	`created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `carts` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT NOT NULL,
	`is_ordered` INT NULL DEFAULT 0,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `carts_products` (
	`cart_id` INT NOT NULL,
	`product_id` INT NOT NULL,
	`amount`  INT NOT NULL,
	FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
	FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
);

CREATE TABLE IF NOT EXISTS `orders_statuses` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`status_name` VARCHAR(32) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `orders` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT NOT NULL,
	`ordered` timestamp DEFAULT CURRENT_TIMESTAMP,
	`status_id`  INT NOT NULL,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
	FOREIGN KEY (`status_id`) REFERENCES `orders_statuses` (`id`),
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `orders_products` (
	`order_id` INT NOT NULL,
	`product_id` INT NOT NULL,
	`amount`  INT NOT NULL,
	FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
	FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
);

INSERT INTO `roles` (`role_name`)
VALUES ('Пользователь'), ('Админ');

INSERT INTO `users` (`user_surname`, `user_name`, `user_patronymic`, `login`, `email`, `password`, `role_id`)
VALUES ('Тимербулатов', 'Айрат', 'Рафаилович', 'admin', 'admin@email.ru', '$2y$10$BXrIlLgAzE24.JQbSXCMWuNeXs5m5WFCZwYGSimbpzzDXAQtk7NMO', 2);

INSERT INTO `categories` (`category_name`)
VALUES ('Цветы'), ('Упаковка'), ('Дополнительно');

INSERT INTO `products` (`product_name`, `category_id`, `image_name`, `price`, `country`, `color`, `amount`)
VALUES
('Керамическая ваза', 3, '78270_1000.jpg', 500, 'Китай', 'Жёлтая', 5),
('Глиняный горшок', 3, '093eeb78b63d66ed22d4ea99f60e6cc6.jpg', 400, 'Германия', 'Коричневый', 3),
('Сетка для цветов', 2, '155_setka_dlya_cvetov_pautina.jpg', 100, 'Россия', 'Разноцветный', 4),
('Корзинка для цветов', 2, '19363_MB.jpg', 100, 'Россия', 'Белая', 2),
('Цветок бабочка', 1, 'cvetok-babochka.jpg', 250, 'Беларусь', 'Фиолетовый', 3),
('Роза', 1, 'roza.jpg', 320, 'Китай', 'Бело-розовый', 4),
('Лентый для обвязки', 2, 'lenty.jpg', 50, 'Япония', 'Разноцветный', 4),
('Стеклянная ваза овальная', 2, '225071.950x0.jpg', 450, 'Россия', 'Прозрачный', 3);

INSERT INTO `orders_statuses` (`status_name`)
VALUES ('Новый'), ('Подтверждённый'), ('Отклонённый');