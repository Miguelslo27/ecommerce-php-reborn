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
CREATE DATABASE IF NOT EXISTS `ecommerce_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ecommerce_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

DROP TABLE IF EXISTS `articulo`;
CREATE TABLE IF NOT EXISTS `articulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `descripcion_breve` varchar(255) NOT NULL,
  `descripcion` tinytext NOT NULL,
  `precio` double NOT NULL,
  `talle` varchar(20) NOT NULL,
  `talle_surtido` varchar(20) NOT NULL,
  `adaptable` tinyint(1) NOT NULL,
  `colores_url` varchar(100) NOT NULL,
  `colores_surtidos_url` varchar(100) NOT NULL,
  `packs` varchar(20) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `nuevo` tinyint(1) NOT NULL,
  `agotado` tinyint(1) NOT NULL,
  `oferta` tinyint(1) NOT NULL,
  `surtido` tinyint(1) NOT NULL,
  `precio_oferta` double NOT NULL,
  `precio_surtido` int(11) NOT NULL,
  `precio_oferta_surtido` int(11) NOT NULL,
  `imagenes_url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nombre` (`nombre`,`codigo`),
  KEY `categoria_id` (`categoria_id`),
  KEY `oferta` (`oferta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `articulo`
--

TRUNCATE TABLE `articulo`;
--
-- Volcado de datos para la tabla `articulo`
--

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo_pedido`
--

DROP TABLE IF EXISTS `articulo_pedido`;
CREATE TABLE IF NOT EXISTS `articulo_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `articulo_id` int(11) NOT NULL,
  `surtido` tinyint(1) NOT NULL,
  `talle` varchar(20) NOT NULL,
  `color` varchar(20) NOT NULL,
  `precio_actual` double NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`,`articulo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `articulo_pedido`
--

TRUNCATE TABLE `articulo_pedido`;
--
-- Volcado de datos para la tabla `articulo_pedido`
--

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion_breve` tinytext NOT NULL,
  `descripcion` text NOT NULL,
  `imagen_url` varchar(100) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titulo_2` (`titulo`),
  KEY `titulo` (`titulo`,`categoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `categoria`
--

TRUNCATE TABLE `categoria`;
--
-- Volcado de datos para la tabla `categoria`
--

-- EMPTY

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` double NOT NULL,
  `estado` int(11) NOT NULL,
  `retira` tinyint(1) NOT NULL,
  `compra_en_local` tinyint(1) NOT NULL,
  `direccion_de_entrega` varchar(100) NOT NULL,
  `agencia_de_envio` varchar(100) NOT NULL,
  `forma_de_pago` varchar(100) NOT NULL,
  `lugar` varchar(80) NOT NULL,
  `notificado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `pedido`
--

TRUNCATE TABLE `pedido`;
--
-- Volcado de datos para la tabla `pedido`
--

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripciones`
--

DROP TABLE IF EXISTS `suscripciones`;
CREATE TABLE IF NOT EXISTS `suscripciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `suscripciones`
--

TRUNCATE TABLE `suscripciones`;
--
-- Volcado de datos para la tabla `suscripciones`
--

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `rut` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `celular` varchar(100) NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `administrador` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `nombre` (`nombre`,`apellido`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `usuario`
--

TRUNCATE TABLE `usuario`;
--
-- Volcado de datos para la tabla `usuario`
--

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

DROP TABLE IF EXISTS `articulo`;
CREATE TABLE IF NOT EXISTS `articulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `descripcion_breve` varbinary(255) NOT NULL,
  `descripcion` tinytext NOT NULL,
  `precio` double NOT NULL,
  `talle` varchar(20) NOT NULL,
  `talle_surtido` varchar(20) NOT NULL,
  `adaptable` tinyint(1) NOT NULL,
  `colores_url` varchar(100) NOT NULL,
  `colores_surtidos_url` varchar(100) NOT NULL,
  `packs` varchar(20) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `nuevo` tinyint(1) NOT NULL,
  `agotado` tinyint(1) NOT NULL,
  `oferta` tinyint(1) NOT NULL,
  `surtido` tinyint(1) NOT NULL,
  `precio_oferta` double NOT NULL,
  `precio_surtido` int(11) NOT NULL,
  `precio_oferta_surtido` int(11) NOT NULL,
  `imagenes_url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nombre` (`nombre`,`codigo`),
  KEY `categoria_id` (`categoria_id`),
  KEY `oferta` (`oferta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `articulo`
--

TRUNCATE TABLE `articulo`;
--
-- Volcado de datos para la tabla `articulo`
--

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo_pedido`
--

DROP TABLE IF EXISTS `articulo_pedido`;
CREATE TABLE IF NOT EXISTS `articulo_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `articulo_id` int(11) NOT NULL,
  `surtido` tinyint(1) NOT NULL,
  `talle` varchar(20) NOT NULL,
  `color` varchar(20) NOT NULL,
  `precio_actual` double NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`,`articulo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `articulo_pedido`
--

TRUNCATE TABLE `articulo_pedido`;
--
-- Volcado de datos para la tabla `articulo_pedido`
--

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion_breve` tinytext NOT NULL,
  `descripcion` text NOT NULL,
  `imagen_url` varchar(100) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titulo_2` (`titulo`),
  KEY `titulo` (`titulo`,`categoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `categoria`
--

TRUNCATE TABLE `categoria`;
--
-- Volcado de datos para la tabla `categoria`
--

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` double NOT NULL,
  `estado` int(11) NOT NULL,
  `retira` tinyint(1) NOT NULL,
  `compra_en_local` tinyint(1) NOT NULL,
  `direccion_de_entrega` varchar(100) NOT NULL,
  `agencia_de_envio` varchar(100) NOT NULL,
  `forma_de_pago` varchar(100) NOT NULL,
  `lugar` varchar(80) NOT NULL,
  `notificado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `pedido`
--

TRUNCATE TABLE `pedido`;
--
-- Volcado de datos para la tabla `pedido`
--

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripciones`
--

DROP TABLE IF EXISTS `suscripciones`;
CREATE TABLE IF NOT EXISTS `suscripciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `suscripciones`
--

TRUNCATE TABLE `suscripciones`;
--
-- Volcado de datos para la tabla `suscripciones`
--

-- EMPTY

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `rut` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `celular` varchar(100) NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `administrador` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `nombre` (`nombre`,`apellido`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Truncar tablas antes de insertar `usuario`
--

TRUNCATE TABLE `usuario`;
--
-- Volcado de datos para la tabla `usuario`
--

-- EMPTY

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
