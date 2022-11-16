-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-11-2022 a las 23:38:47
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agenda`
--
CREATE DATABASE IF NOT EXISTS `agenda` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `agenda`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credenciales`
--

DROP TABLE IF EXISTS `credenciales`;
CREATE TABLE IF NOT EXISTS `credenciales` (
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `credenciales`
--

-- Credenciales validas:
-- usuario: normaluser ; password: usudwes
-- usuario: adminuser ; password: admindwes

INSERT INTO `credenciales` (`usuario`, `password`) VALUES
('normaluser', '$2y$10$kG2p/4hVn6sZKNsTo6Je4uWWdO4cqZii2MBm2LPNuaes3cbNI.os2'),
('adminuser', '$2y$10$73wSQqyAYSbk3YSJ1K0Yu.Tyo0xNvPcPCupGArTRwX5D1jQVzJZO2');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
