-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-03-2018 a las 15:39:17
-- Versión del servidor: 5.1.73
-- Versión de PHP: 5.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "-03:00";

-- C:\> cmd.exe /c "mysql -u root -p db_name < backup-file.sql"
-- C:\> cmd.exe /c "mysql -u root -p < e:\ecommerce_db.sql"

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ecommerce_db`
--
CREATE DATABASE IF NOT EXISTS `ecommerce_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ecommerce_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `position` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `code` VARCHAR(20) NOT NULL,
  `brief_description` TINYTEXT NOT NULL,
  `description` TEXT NOT NULL,
  `price` DOUBLE NOT NULL,
  `price_offer` DOUBLE NOT NULL,
  `category_id` INT NOT NULL,
  `new` TINYINT(1) NOT NULL,
  `spent` TINYINT(1) NOT NULL,
  `offer` TINYINT(1) NOT NULL,
  `images_url` VARCHAR(255) NOT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT '1',
  `_created_at_` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updated_at_` TIMESTAMP NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `name` (`name`,`code`),
  KEY `category_id` (`category_id`),
  KEY `offer` (`offer`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `articles`
--

TRUNCATE TABLE `articles`;
--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`id`, `position`, `name`, `code`, `brief_description`, `description`, `price`, `price_offer`, `category_id`, `new`, `spent`, `offer`, `images_url`, `status`, `_created_at_`, `_updated_at_`) VALUES
(1, 0, 'hub usb c 5 en 1', 'hubusbc_1', '', '', 89, 0, 1, 1, 0, 0, '/statics/images/articles/1/thumbnail.webp', 1, '2020-03-11 18:03:58', '2020-03-11 18:03:58'),
(2, 0, 'hub usb c 6 en 1 multipuerto aluminio', 'hubusb_2', '', '', 37, 0, 1, 1, 0, 0, '/statics/images/articles/2/thumbnail.webp', 1, '2020-03-11 18:07:05', '2020-03-11 18:07:05'),
(3, 0, 'mini llavero grabador atto digital', 'mini01', '', '', 69, 0, 1, 1, 0, 0, '/statics/images/articles/3/thumbnail.webp', 1, '2020-03-11 18:07:05', '2020-03-11 18:07:36'),
(4, 0, 'tarjeta de sonido usb creative sound blaster x G5', 'tarjsousb001', '', '', 194, 0, 1, 1, 0, 0, '/statics/images/articles/4/thumbnail.webp', 1, '2020-03-11 18:11:20', '2020-03-11 18:11:20'),
(5, 0, 'tarjeta gráfica dual asus gforce gtx1 1660', 'graph1660', '', '', 194, 0, 1, 1, 0, 0, '/statics/images/articles/5/thumbnail.webp', 1, '2020-03-11 18:11:20', '2020-03-11 18:11:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `in_order_articles`
--

DROP TABLE IF EXISTS `in_order_articles`;
CREATE TABLE IF NOT EXISTS `in_order_articles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `article_id` INT NOT NULL,
  `current_price` DOUBLE NOT NULL,
  `quantity` INT NOT NULL,
  `subtotal` DOUBLE NOT NULL,
  `_created_at_` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updated_at_` TIMESTAMP NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `in_order_articles`
--

TRUNCATE TABLE `in_order_articles`;
--
-- Volcado de datos para la tabla `in_order_articles`
--

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `position` INT NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  `brief_description` TINYTEXT NOT NULL,
  `description` TEXT NOT NULL,
  `images_url` VARCHAR(255) NOT NULL,
  `category_id` INT NOT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT '1',
  `_created_at_` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updated_at_` TIMESTAMP NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `category_id` (`category_id`,`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `categories`
--

TRUNCATE TABLE `categories`;
--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `position`, `title`, `brief_description`, `description`, `images_url`, `category_id`, `status`, `_created_at_`, `_updated_at_`) VALUES
(1, 0, 'Componentes', '', '', '/statics/images/categories/1/thumbnail.webp', 0, 1, '2020-03-09 18:32:56', '2020-03-11 18:01:33'),
(2, 0, 'Computadoras', '', '', '', 0, 1, '2020-03-09 18:47:02', '2020-03-09 18:47:02'),
(3, 0, 'Electrónica', '', '', '', 0, 1, '2020-03-09 18:47:02', '2020-03-09 18:47:02'),
(4, 0, 'Gammers', '', '', '', 0, 1, '2020-03-09 18:47:32', '2020-03-09 18:47:32'),
(5, 0, 'Multimedia', '', '', '', 0, 1, '2020-03-09 18:47:32', '2020-03-09 18:47:32'),
(6, 0, 'Redes y Adaptadores', '', '', '', 0, 1, '2020-03-09 18:48:01', '2020-03-09 18:48:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  -- SUMMARY
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` VARCHAR(20) NOT NULL,
  `date` DATETIME NOT NULL,
  `subtotal` DOUBLE NOT NULL,
  `taxes` DOUBLE NOT NULL, 
  `discount` DOUBLE NOT NULL,
  `total` DOUBLE NOT NULL,
  -- BILLING
  `billing_name` VARCHAR(100) NOT NULL, 
  `billing_document` VARCHAR(100) NOT NULL,
  `billing_address` VARCHAR(100) NOT NULL,
  `billing_state` VARCHAR(100) NOT NULL,
  `billing_city` VARCHAR(100) NOT NULL,
  `billing_zipcode` VARCHAR(100) NOT NULL,
  -- SHIPPING
  `shipping_method` TINYINT(1) NOT NULL,
  `shipping_address` VARCHAR(100) NOT NULL,
  `shipping_state` VARCHAR(100) NOT NULL,
  `shipping_city` VARCHAR(100) NOT NULL,
  `shipping_zipcode` VARCHAR(100) NOT NULL,
  `shipping_agency` VARCHAR(100) NOT NULL,
  `additional_comments` TEXT NOT NULL,
  -- PAYMENT
  `payment_method` VARCHAR(100) NOT NULL,
  `notified` TINYINT(1) NOT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT '1',
  `_created_at_` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updated_at_` TIMESTAMP NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `orders`
--

TRUNCATE TABLE `orders`;
--
-- Volcado de datos para la tabla `orders`
--

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `_created_at_` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updated_at_` TIMESTAMP NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `subscriptions`
--

TRUNCATE TABLE `subscriptions`;
--
-- Volcado de datos para la tabla `subscriptions`
--

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `lastname` VARCHAR(100) NOT NULL,
  `document` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `verification_code` VARCHAR(100) NOT NULL,
  `address` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(100) NOT NULL,
  `cellphone` VARCHAR(100) NOT NULL,
  `state` VARCHAR(100) NOT NULL,
  `city` VARCHAR(100) NOT NULL,
  `isadmin` TINYINT(1) NOT NULL DEFAULT '0',
  `status` TINYINT(1) NOT NULL DEFAULT '1',
  `_created_at_` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updated_at_` TIMESTAMP NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `name` (`name`,`lastname`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `users`
--

TRUNCATE TABLE `users`;
--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `document`, `email`, `password`, `verification_code`, `address`, `phone`, `cellphone`, `state`, `city`, `isadmin`, `status`, `_created_at_`, `_updated_at_`) VALUES
(1, 'Miguel', 'Sosa', '34900078', 'miguelmail2006@gmail.com', 'b6b2c10d1acdfcc71eb332c3a6c7f036', 'ae01ca4477d78b54248bbb2c24c6472a', '39 y J', '', '091 066 416', 'Canelones', 'Parque del Plata', 1, 1, '2020-03-10 19:56:46', '2020-03-11 15:39:48'),
(2, 'Demo', 'Demo', '000', 'demo@demo.com', '0d0105c8bac42b5655f1773948064a96', '53444f91e698c0c7caa2dbc3bdbf93fc', '', '', '111', '', '', 0, 1, '2020-03-11 18:17:05', '2020-03-15 14:38:37');

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
