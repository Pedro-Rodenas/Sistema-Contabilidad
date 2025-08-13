-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2025 a las 19:01:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_contabilidad`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos_consumo`
--

CREATE TABLE `egresos_consumo` (
  `id_consumo` int(11) NOT NULL,
  `ruc` varchar(20) NOT NULL,
  `razon_social` varchar(255) NOT NULL,
  `nro_factura` varchar(50) NOT NULL,
  `fecha_consumo` date NOT NULL,
  `nombre_consumo` varchar(255) NOT NULL,
  `tipo_consumo` varchar(50) NOT NULL DEFAULT 'Consumo',
  `cant_consumo` varchar(50) NOT NULL,
  `precio_consumo` decimal(10,2) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('activo','anulado') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `igv` decimal(10,2) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos_productos`
--

CREATE TABLE `egresos_productos` (
  `id_producto` int(11) NOT NULL,
  `ruc` varchar(20) NOT NULL,
  `razon_social` varchar(255) NOT NULL,
  `nro_factura` varchar(50) NOT NULL,
  `fecha_compra` date NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `tipo_producto` varchar(50) NOT NULL DEFAULT 'Producto',
  `cant_productos` int(11) NOT NULL,
  `precio_producto` decimal(10,2) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('activo','anulado') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `igv` decimal(10,2) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos_servicios`
--

CREATE TABLE `egresos_servicios` (
  `id_servicio` int(11) NOT NULL,
  `ruc` varchar(20) NOT NULL,
  `razon_social` varchar(255) NOT NULL,
  `nro_factura` varchar(50) NOT NULL,
  `fecha_servicio` date NOT NULL,
  `nombre_servicio` varchar(255) NOT NULL,
  `tipo_servicio` varchar(50) NOT NULL DEFAULT 'Servicio',
  `periodo_consumo` varchar(100) NOT NULL,
  `precio_servicio` decimal(10,2) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('activo','anulado') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `igv` decimal(10,2) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `rol` enum('admin','usuario') NOT NULL DEFAULT 'usuario',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `user`, `pass`, `rol`, `created_at`) VALUES
(13, 'adei', 'adeiaprode', 'admin', '2025-05-12 21:40:17'),
(17, 'luis', 'luisaprode', 'usuario', '2025-05-15 14:00:16'),
(18, 'pedro', 'pedroaprode', 'admin', '2025-05-30 16:47:59');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `egresos_consumo`
--
ALTER TABLE `egresos_consumo`
  ADD PRIMARY KEY (`id_consumo`);

--
-- Indices de la tabla `egresos_productos`
--
ALTER TABLE `egresos_productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `egresos_servicios`
--
ALTER TABLE `egresos_servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `egresos_consumo`
--
ALTER TABLE `egresos_consumo`
  MODIFY `id_consumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `egresos_productos`
--
ALTER TABLE `egresos_productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `egresos_servicios`
--
ALTER TABLE `egresos_servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


CREATE TABLE `egresos_transferencia` (
  `id_transferencia` int(11) NOT NULL AUTO_INCREMENT,
  `dni_transferencia` int(11) NOT NULL,
  `razon_social` varchar(50) NOT NULL,
  `nro_factura` int(11) NOT NULL,
  `fecha_transferencia` date NOT NULL,
  `detalle_transferencia` varchar(50) NOT NULL,
  `monto_transferencia` int(11) NOT NULL,
  `tipo_transferencia` varchar(50) DEFAULT 'transferencia',
  `tipo` varchar(50) NOT NULL,
  `adquisicion` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_transferencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
