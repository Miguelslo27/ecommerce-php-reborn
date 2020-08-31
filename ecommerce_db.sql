-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-08-2020 a las 14:56:29
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ecommerce_db_1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
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
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `_created_at_` timestamp NOT NULL DEFAULT current_timestamp(),
  `_updated_at_` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`id`, `position`, `name`, `code`, `brief_description`, `description`, `price`, `price_offer`, `category_id`, `new`, `spent`, `offer`, `images_url`, `status`, `_created_at_`, `_updated_at_`) VALUES
(1, 0, 'Hub USB C 5 en 1', 'hubusbc_1', 'HUB Premium 5 en 1', 'Hub USB-C Premium: Estación de datos USB, de vídeo y de Internet - 3 puertos USB estándar, 1 puerto HDMI multimedia y 1 puerto Ethernet para conectividad a Internet, todo en un solo concentrador. - Accede a velocidades de transferencia de datos de 5 Gbps, junto con una vibrante transmisión HDMI 4K.', 89, 44, 7, 1, 0, 1, '/statics/images/articles/1/thumbnail.webp', 1, '2020-03-11 21:03:58', '2020-03-11 21:03:58'),
(2, 0, 'Hub USB C 6 en 1 Multipuerto Aluminio', 'hubusb_2', 'HUB USB 6 en 1', 'Hub USB-C Premium: Estación de datos USB, de vídeo y de Internet - 3 puertos USB estándar, 1 puerto HDMI multimedia y 1 puerto Ethernet para conectividad a Internet, todo en un solo concentrador. - Accede a velocidades de transferencia de datos de 5 Gbps, junto con una vibrante transmisión HDMI 4K.', 37, 0, 1, 1, 0, 0, '/statics/images/articles/2/thumbnail.webp', 1, '2020-03-11 21:07:05', '2020-03-11 21:07:05'),
(3, 0, 'Mini Llavero Grabador ATTO digital', 'mini01', 'Mini Llavero Dig', 'Llavero digital con 3 nucelos integrados', 69, 65, 1, 1, 0, 1, '/statics/images/articles/3/thumbnail.webp', 1, '2020-03-11 21:07:05', '2020-03-11 21:07:36'),
(4, 0, 'Tarjeta de Sonido USB Creative Sound Blaster XG5', 'tarjsousb001', 'Tarjeta compatible con cualquier SO', 'Tarjeta compatible con cualquier SO. De gran calidad', 194, 0, 1, 1, 1, 0, '/statics/images/articles/4/thumbnail.webp', 1, '2020-03-11 21:11:20', '2020-03-11 21:11:20'),
(5, 0, 'Tarjeta Gráfica Dual Asus GFORCE GTX1 1660', 'graph1660', 'Grafica gamer.', '', 194, 0, 1, 1, 0, 0, '/statics/images/articles/5/thumbnail.webp', 1, '2020-03-11 21:11:20', '2020-03-11 21:11:20'),
(6, 0, 'USB 128 GB', '', '', '', 123, 0, 3, 0, 0, 0, '/statics/images/articles/5/thumbnail.webp', 1, '2020-06-09 18:08:05', '0000-00-00 00:00:00'),
(7, 0, 'Soporte Monitor 24\"', '', '', '', 390, 2, 0, 0, 0, 0, '', 1, '2020-06-09 18:08:42', '0000-00-00 00:00:00'),
(8, 0, 'USB 8GB', '', '', '', 0, 0, 0, 0, 0, 0, '', 1, '2020-06-10 16:32:57', '0000-00-00 00:00:00'),
(9, 0, 'Cable Cargador De Datos Usb 3 En 1 Retractil', '', '', '', 0, 0, 3, 0, 0, 0, '', 1, '2020-06-11 14:25:05', '0000-00-00 00:00:00'),
(10, 0, 'Cargador De Pared 2a+ Cable Micro-usb Samsung Xiaomi Huawei®\r\n', '', '', '', 0, 0, 3, 0, 0, 0, '', 1, '2020-06-11 14:25:38', '0000-00-00 00:00:00'),
(11, 0, 'Disco Duro Externo Toshiba Canvio 1 Tb Usb 3.0 Amv', '', '', '', 0, 0, 4, 0, 0, 0, '', 1, '2020-06-11 14:25:59', '0000-00-00 00:00:00'),
(12, 0, 'relleno1', 'rell1', '', '', 123, 122, 1, 0, 0, 1, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 0, 'relleno3', 'rell3', '', '', 123, 122, 1, 0, 0, 1, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 0, 'relleno4', 'rell4', '', '', 123, 122, 1, 0, 0, 1, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 0, 'relleno5', 'rell5', '', '', 123, 122, 1, 0, 0, 1, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 0, 'relleno6', 'rell6', '', '', 123, 122, 1, 0, 0, 1, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 0, 'relleno2', 'rell2', '', '', 123, 122, 1, 0, 0, 1, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `brief_description` tinytext NOT NULL,
  `description` text NOT NULL,
  `images_url` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `_created_at_` timestamp NOT NULL DEFAULT current_timestamp(),
  `_updated_at_` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `position`, `title`, `brief_description`, `description`, `images_url`, `category_id`, `status`, `_created_at_`, `_updated_at_`) VALUES
(1, 0, 'Componentes', '', '', '/statics/images/categories/1/thumbnail.webp', 0, 1, '2020-03-09 21:32:56', '2020-03-11 21:01:33'),
(2, 0, 'Computadoras', '', '', '', 0, 1, '2020-03-09 21:47:02', '2020-03-09 21:47:02'),
(3, 0, 'Electrónica', '', '', '', 0, 1, '2020-03-09 21:47:02', '2020-03-09 21:47:02'),
(4, 0, 'Gammers', '', '', '', 0, 1, '2020-03-09 21:47:32', '2020-03-09 21:47:32'),
(5, 0, 'Multimedia', '', '', '', 0, 1, '2020-03-09 21:47:32', '2020-03-09 21:47:32'),
(6, 0, 'Redes y Adaptadores', '', '', '', 0, 1, '2020-03-09 21:48:01', '2020-03-09 21:48:01'),
(7, 0, 'AMD', '', '', '', 1, 1, '2020-06-02 15:13:01', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `in_order_articles`
--

CREATE TABLE `in_order_articles` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `current_price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` double NOT NULL,
  `_created_at_` timestamp NOT NULL DEFAULT current_timestamp(),
  `_updated_at_` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `in_order_articles`
--

INSERT INTO `in_order_articles` (`id`, `order_id`, `article_id`, `current_price`, `quantity`, `subtotal`, `_created_at_`, `_updated_at_`) VALUES
(97, 50, 2, 37, 5, 185, '2020-05-04 21:26:46', '0000-00-00 00:00:00'),
(98, 50, 4, 194, 5, 970, '2020-05-04 21:26:51', '0000-00-00 00:00:00'),
(99, 50, 5, 194, 5, 970, '2020-05-04 21:26:52', '0000-00-00 00:00:00'),
(100, 50, 3, 69, 5, 345, '2020-05-04 21:27:00', '0000-00-00 00:00:00'),
(102, 53, 2, 37, 2, 74, '2020-05-04 21:28:08', '0000-00-00 00:00:00'),
(103, 53, 1, 89, 1, 89, '2020-05-04 21:28:11', '0000-00-00 00:00:00'),
(104, 53, 3, 69, 1, 69, '2020-05-04 21:28:12', '0000-00-00 00:00:00'),
(105, 53, 4, 194, 2, 388, '2020-05-04 21:28:20', '0000-00-00 00:00:00'),
(106, 53, 5, 194, 1, 194, '2020-05-04 21:28:21', '0000-00-00 00:00:00'),
(109, 50, 1, 89, 2, 178, '2020-05-04 21:29:35', '0000-00-00 00:00:00'),
(153, 57, 3, 65, 2, 130, '2020-06-03 22:51:47', '0000-00-00 00:00:00'),
(154, 57, 5, 194, 5, 970, '2020-06-04 19:51:39', '0000-00-00 00:00:00'),
(155, 57, 1, 44, 3, 132, '2020-06-04 19:53:03', '0000-00-00 00:00:00'),
(160, 57, 2, 37, 30, 1110, '2020-06-04 20:07:01', '0000-00-00 00:00:00'),
(161, 58, 2, 37, 28, 1036, '2020-06-05 01:33:47', '0000-00-00 00:00:00'),
(162, 58, 3, 65, 1, 65, '2020-06-05 02:14:32', '0000-00-00 00:00:00'),
(163, 58, 5, 194, 2, 388, '2020-06-05 02:15:53', '0000-00-00 00:00:00'),
(176, 59, 3, 65, 10, 650, '2020-06-06 01:27:27', '0000-00-00 00:00:00'),
(177, 60, 2, 37, 9, 333, '2020-06-08 16:10:45', '0000-00-00 00:00:00'),
(178, 60, 5, 194, 43, 8342, '2020-06-09 00:55:20', '0000-00-00 00:00:00'),
(179, 61, 5, 194, 1, 194, '2020-07-14 20:45:03', '0000-00-00 00:00:00'),
(181, 61, 4, 194, 2, 388, '2020-07-14 20:45:24', '0000-00-00 00:00:00'),
(182, 61, 3, 65, 1, 65, '2020-07-15 14:26:48', '0000-00-00 00:00:00'),
(183, 62, 14, 122, 1, 122, '2020-07-16 22:50:38', '0000-00-00 00:00:00'),
(184, 62, 15, 122, 1, 122, '2020-07-16 22:51:01', '0000-00-00 00:00:00'),
(185, 63, 2, 37, 1, 37, '2020-07-20 13:11:16', '0000-00-00 00:00:00'),
(186, 64, 5, 194, 1, 194, '2020-07-20 14:35:44', '0000-00-00 00:00:00'),
(188, 65, 5, 194, 1, 194, '2020-07-22 22:36:50', '0000-00-00 00:00:00'),
(193, 66, 2, 37, 1, 37, '2020-07-27 18:26:05', '0000-00-00 00:00:00'),
(194, 67, 2, 37, 1, 37, '2020-08-11 16:15:12', '0000-00-00 00:00:00'),
(195, 68, 2, 37, 1, 37, '2020-08-19 16:10:21', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  `subtotal` double NOT NULL,
  `taxes` double NOT NULL,
  `discount` double NOT NULL,
  `total` double NOT NULL,
  `billing_name` varchar(100) NOT NULL,
  `billing_document` varchar(100) NOT NULL,
  `billing_address` varchar(100) NOT NULL,
  `billing_state` varchar(100) NOT NULL,
  `billing_city` varchar(100) NOT NULL,
  `billing_zipcode` varchar(100) NOT NULL,
  `shipping_method` tinyint(1) NOT NULL,
  `shipping_address` varchar(100) NOT NULL,
  `shipping_state` varchar(100) NOT NULL,
  `shipping_city` varchar(100) NOT NULL,
  `shipping_zipcode` varchar(100) NOT NULL,
  `shipping_agency` varchar(100) NOT NULL,
  `additional_comments` text NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `notified` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `_created_at_` timestamp NOT NULL DEFAULT current_timestamp(),
  `_updated_at_` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `date`, `subtotal`, `taxes`, `discount`, `total`, `billing_name`, `billing_document`, `billing_address`, `billing_state`, `billing_city`, `billing_zipcode`, `shipping_method`, `shipping_address`, `shipping_state`, `shipping_city`, `shipping_zipcode`, `shipping_agency`, `additional_comments`, `payment_method`, `notified`, `status`, `_created_at_`, `_updated_at_`) VALUES
(50, '3', '2020-05-04 18:26:46', 0, 0, 0, 2648, '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0, 4, '2020-05-04 21:26:46', '0000-00-00 00:00:00'),
(53, '4', '2020-05-04 18:28:08', 0, 0, 0, 814, '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0, 4, '2020-05-04 21:28:08', '0000-00-00 00:00:00'),
(59, '3', '2020-06-04 23:16:37', 0, 0, 0, 650, '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0, 4, '2020-06-05 02:16:37', '0000-00-00 00:00:00'),
(60, '3', '2020-06-08 13:10:45', 0, 0, 0, 8675, '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0, 4, '2020-06-08 16:10:45', '0000-00-00 00:00:00'),
(61, '3', '2020-07-14 17:45:03', 0, 0, 0, 647, '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0, 4, '2020-07-14 20:45:03', '0000-00-00 00:00:00'),
(62, '3', '2020-07-16 19:50:38', 0, 0, 0, 244, '', '', '', '', '', '', 0, 'abc', '', '', '', '', '', '', 0, 4, '2020-07-16 22:50:38', '0000-00-00 00:00:00'),
(64, '3', '2020-07-20 11:35:44', 0, 0, 0, 194, 'fefe', '123456789', 'Picaso 123', 'Roma', 'Manto', '31000', 0, '', '', '', '', '', '', '', 0, 4, '2020-07-20 14:35:44', '0000-00-00 00:00:00'),
(65, '3', '2020-07-22 19:01:34', 0, 0, 0, 194, 'fede', '123654', 'Hera 2315', 'Mdeo', 'Cerrito', '31000', 1, 'Hera 2315', 'po', 'asd', '321', 'opo', '', '', 0, 4, '2020-07-22 22:01:34', '0000-00-00 00:00:00'),
(66, '3', '2020-07-27 10:31:13', 0, 0, 0, 37, 'Federico', '51780924', 'Heraclio Fajardo 3435', 'Montevideo', 'Cerrito', '31000', 2, 'Heraclio Fajardo 3435', 'Montevideo', 'Cerrito', '31000', 'tr', 'asd', '', 0, 4, '2020-07-27 13:31:13', '0000-00-00 00:00:00'),
(67, '3', '2020-08-11 13:15:12', 0, 0, 0, 37, '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0, 4, '2020-08-11 16:15:12', '0000-00-00 00:00:00'),
(68, '3', '2020-08-19 13:10:21', 0, 0, 0, 37, '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0, 4, '2020-08-19 16:10:21', '0000-00-00 00:00:00'),
(69, '3', '2020-08-24 14:11:45', 0, 0, 0, 0, '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0, 4, '2020-08-24 17:11:45', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site`
--

CREATE TABLE `site` (
  `id` int(11) NOT NULL,
  `user_admin` int(11) NOT NULL,
  `version_history` float NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(100) CHARACTER SET utf8 NOT NULL,
  `contact_email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `contact_phone` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_admins`
--

CREATE TABLE `site_admins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` varchar(100) CHARACTER SET utf8 NOT NULL,
  `site_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_networks`
--

CREATE TABLE `site_networks` (
  `id` int(11) NOT NULL,
  `tag` varchar(100) CHARACTER SET utf8 NOT NULL,
  `uri` varchar(100) CHARACTER SET utf8 NOT NULL,
  `site_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `_created_at_` timestamp NOT NULL DEFAULT current_timestamp(),
  `_updated_at_` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `document` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `verification_code` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `cellphone` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `_created_at_` timestamp NOT NULL DEFAULT current_timestamp(),
  `_updated_at_` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `document`, `email`, `password`, `verification_code`, `address`, `phone`, `cellphone`, `state`, `city`, `isadmin`, `status`, `_created_at_`, `_updated_at_`) VALUES
(1, 'Miguel', 'Sosa', '34900078', 'miguelmail2006@gmail.com', 'b6b2c10d1acdfcc71eb332c3a6c7f036', 'ae01ca4477d78b54248bbb2c24c6472a', '39 y J', '', '091 066 416', 'Canelones', 'Parque del Plata', 0, 1, '2020-03-10 22:56:46', '2020-03-11 18:39:48'),
(2, 'Demo', 'Demo', '000', 'demo@demo.com', '123456', '53444f91e698c0c7caa2dbc3bdbf93fc', '', '', '111', '', '', 1, 1, '2020-03-11 21:17:05', '2020-03-15 17:38:37'),
(3, 'Federico', 'SOSa', '123', 'fdsosa.35@gmail.com', 'd7415f76853dd5bac451f4a2e05f3af4', '5fa3efef8e662269245e95fe1886d0f2', 'Follas Novas 4542', '123', '123', 'Montevideo', 'Sayago', 1, 1, '2020-05-01 20:26:55', '0000-00-00 00:00:00'),
(4, 'asd', 'asd', '123', 'fdsosa.351@gmail.com', '64ce5c835187c9a86372b883e7019fbc', '07104beaa3fff4e00d3cf44f9c2060f3', '', '123', '123', '', '', 1, 1, '2020-05-02 00:34:15', '0000-00-00 00:00:00'),
(5, 'Federico', 'asd', '123', 'federicososa999@gmail.com', 'fb3f3d1369c52d3c2cbb949120bf1bba', '260ffc5e6fce4769d27b9b8c44975d21', '123', '123', '123', 'sd', 'asd', 1, 1, '2020-06-16 20:41:07', '0000-00-00 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`,`code`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `offer` (`offer`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `category_id` (`category_id`,`title`);

--
-- Indices de la tabla `in_order_articles`
--
ALTER TABLE `in_order_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`,`article_id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `version_history` (`version_history`),
  ADD KEY `user_admin` (`user_admin`);

--
-- Indices de la tabla `site_admins`
--
ALTER TABLE `site_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `site_networks`
--
ALTER TABLE `site_networks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `site_id` (`site_id`);

--
-- Indices de la tabla `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `name` (`name`,`lastname`,`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `in_order_articles`
--
ALTER TABLE `in_order_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `site`
--
ALTER TABLE `site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `site_admins`
--
ALTER TABLE `site_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `site_networks`
--
ALTER TABLE `site_networks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT de la tabla `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
