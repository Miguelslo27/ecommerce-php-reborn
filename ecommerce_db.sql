-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-03-2018 a las 15:39:17
-- Versión del servidor: 5.1.73
-- Versión de PHP: 5.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- C:\> cmd.exe /c "mysql -u root -p db_name < backup-file.sql"
-- C:\> cmd.exe /c "mysql -u root -p < e:\ecommerce_db.sql"

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ecommerce_db`
--
-- CREATE DATABASE IF NOT EXISTS `ecommerce_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
-- USE `ecommerce_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `brief_description` tinytext NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `price_offer` double NOT NULL,
  `category_id` int(11) NOT NULL,
  `new` tinyint(1) NOT NULL,
  `spent` tinyint(1) NOT NULL,
  `offer` tinyint(1) NOT NULL,
  `images_url` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `_created_at_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updated_at_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `in_order_articles`
--

DROP TABLE IF EXISTS `in_order_articles`;
CREATE TABLE IF NOT EXISTS `in_order_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `current_price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` double NOT NULL,
  `_created_at_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updated_at_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `brief_description` tinytext NOT NULL,
  `description` text NOT NULL,
  `images_url` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `_created_at_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updated_at_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

-- EMPTY

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `subtotal` double NOT NULL,
  `taxes` double NOT NULL, 
  `discount` double NOT NULL,
  `total` double NOT NULL,
  `shipping_method` tinyint(1) NOT NULL,
  `shipping_address` varchar(100) NOT NULL,
  `shipping_state` varchar(100) NOT NULL,
  `shipping_city` varchar(100) NOT NULL,
  `shipping_zipcode` varchar(100) NOT NULL,
  `shipping_agency` varchar(100) NOT NULL,
  `additional_comments` text NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `notified` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `_created_at_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updated_at_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `_created_at_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updated_at_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `document_number` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `verification_code` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `cellphone` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `_created_at_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updated_at_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

-- EMPTY

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
