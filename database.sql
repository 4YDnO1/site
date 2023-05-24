CREATE DATABASE IF NOT EXISTS `music_shop`;
USE `music_shop`;

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
	`user_name` VARCHAR(32) NOT NULL,
	`user_patronymic` VARCHAR(32) NOT NULL,
	`login` VARCHAR(32) NOT NULL,
	`email` VARCHAR(32) NOT NULL,
	`password` VARCHAR(64) NOT NULL,
	`role_id` INT NOT NULL DEFAULT 1,

	FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `categories` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`category_name` VARCHAR(32) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `products` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`product_name` VARCHAR(32) NOT NULL,
	`category_id` INT NOT NULL,
	`image_name` VARCHAR(70) NOT NULL,
	`price` INT NOT NULL,
	`year` VARCHAR(32) NOT NULL,
	`country` VARCHAR(32) NOT NULL,
	`amount` INT NOT NULL,
	`created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `carts` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT NOT NULL,
	`is_ordered` INT NULL DEFAULT 0,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `carts_products` (
	`cart_id` INT NOT NULL,
	`product_id` INT NOT NULL,
	`amount`  INT NOT NULL,
	FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
	FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `orders_statuses` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`status_name` VARCHAR(32) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `orders` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT NOT NULL,
	`order_date` timestamp DEFAULT CURRENT_TIMESTAMP,
	`status_id`  INT NOT NULL,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
	FOREIGN KEY (`status_id`) REFERENCES `orders_statuses` (`id`) ON DELETE CASCADE,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `orders_products` (
	`order_id` INT NOT NULL,
	`product_id` INT NOT NULL,
	`amount`  INT NOT NULL,
	FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
	FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
);

INSERT INTO `roles` (`role_name`)
VALUES ('Пользователь'), ('Администратор');

INSERT INTO `users` (`user_surname`, `user_name`, `user_patronymic`, `login`, `email`, `password`, `role_id`)
VALUES ('Тимербулатов', 'Айрат', 'Рафаилович', 'admin', 'admin@email.ru', '$2y$10$BXrIlLgAzE24.JQbSXCMWuNeXs5m5WFCZwYGSimbpzzDXAQtk7NMO', 2);

INSERT INTO `categories` (`category_name`)
VALUES ('Термопринтеры'), ('Струйные принтеры'), ('Лазерные принтеры');

INSERT INTO `products` (`product_name`, `category_id`, `image_name`, `price`, `year`, `country`, `amount`)
VALUES
('Название1', 3, '1.jpg', 4356, 2003, 'Россия', 5),
('Название2', 3, '2.jpg', 7569, 1999, 'Япония', 3),
('Название3', 2, '3.jpg', 4320, 2011, 'Германия', 4),
('Название4', 2, '4.jpg', 15000, 2009, 'Беларусь', 2),
('Название5', 1, '5.jpg', 7000, 2018, 'Япония', 3),
('Название6', 1, '6.jpg', 5600, 2005, 'Россия', 4),
('Название7', 2, '7.jpg', 9999, 2016, 'Германия', 4),
('Название8', 2, '8.jpg', 8945, 2016, 'Беларусь', 3);

INSERT INTO `orders_statuses` (`status_name`)
VALUES ('Новый'), ('Подтверждённый'), ('Отменённый');