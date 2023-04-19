-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-04-2023 a las 06:39:24
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ruleta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugador`
--

CREATE TABLE `jugador` (
  `id_jugador` int(2) NOT NULL,
  `dni` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `jugador`
--

INSERT INTO `jugador` (`id_jugador`, `dni`) VALUES
(5, '75888893'),
(6, '98765432'),
(7, '987444555'),
(8, '75832364'),
(9, '11223686');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugador_sorteo`
--

CREATE TABLE `jugador_sorteo` (
  `id_jugador_sorteo` int(2) NOT NULL,
  `id_sorteo` int(2) NOT NULL,
  `id_jugador` int(2) NOT NULL,
  `intentos` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `jugador_sorteo`
--

INSERT INTO `jugador_sorteo` (`id_jugador_sorteo`, `id_sorteo`, `id_jugador`, `intentos`) VALUES
(2, 8, 5, 2),
(3, 8, 6, 5),
(4, 8, 7, 7),
(5, 8, 8, 6),
(7, 9, 8, 1),
(8, 9, 9, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `premios`
--

CREATE TABLE `premios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `caracteristicas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `premios`
--

INSERT INTO `premios` (`id`, `nombre`, `imagen`, `caracteristicas`) VALUES
(16, 'cuchara', 'Assets/images/premios/cuchara.jpg', 'Nueva y de buena marca'),
(17, 'Carretilla', 'Assets/images/premios/carretilla.jpg', 'Marcha Honda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `premio_sorteo`
--

CREATE TABLE `premio_sorteo` (
  `id_premio_sorteo` int(11) NOT NULL,
  `id_sorteo` int(2) NOT NULL,
  `id_premio` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `premio_sorteo`
--

INSERT INTO `premio_sorteo` (`id_premio_sorteo`, `id_sorteo`, `id_premio`) VALUES
(1, 8, 17),
(5, 9, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sorteos`
--

CREATE TABLE `sorteos` (
  `id` int(2) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `intentos` int(2) NOT NULL,
  `estado` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sorteos`
--

INSERT INTO `sorteos` (`id`, `nombre`, `fecha_inicio`, `fecha_fin`, `intentos`, `estado`) VALUES
(8, 'Sorteo loticaja', '2023-03-10', '2023-04-01', 3, 0),
(9, 'Nurevo', '2023-04-01', '2023-04-27', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `perfil` varchar(100) DEFAULT NULL,
  `clave` varchar(200) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `telefono`, `direccion`, `perfil`, `clave`, `token`, `fecha`, `estado`, `rol`) VALUES
(1, 'Angel Bonilla', 'Gonzalez', 'abonillago@gmail.com', '99999999', 'los girasoles 992', 'Programador', '$2y$10$WpEeYrAZV6qiTblQuOl5BuXJCsIXV3qHPITV0niBCOU8885M5IX3.', NULL, '2023-03-20 06:47:26', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `jugador`
--
ALTER TABLE `jugador`
  ADD PRIMARY KEY (`id_jugador`);

--
-- Indices de la tabla `jugador_sorteo`
--
ALTER TABLE `jugador_sorteo`
  ADD PRIMARY KEY (`id_jugador_sorteo`),
  ADD KEY `id_jugador` (`id_jugador`),
  ADD KEY `id_sorteo` (`id_sorteo`);

--
-- Indices de la tabla `premios`
--
ALTER TABLE `premios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `premio_sorteo`
--
ALTER TABLE `premio_sorteo`
  ADD PRIMARY KEY (`id_premio_sorteo`),
  ADD KEY `id_sorteo` (`id_sorteo`),
  ADD KEY `id_premio` (`id_premio`);

--
-- Indices de la tabla `sorteos`
--
ALTER TABLE `sorteos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `jugador`
--
ALTER TABLE `jugador`
  MODIFY `id_jugador` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `jugador_sorteo`
--
ALTER TABLE `jugador_sorteo`
  MODIFY `id_jugador_sorteo` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `premios`
--
ALTER TABLE `premios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `premio_sorteo`
--
ALTER TABLE `premio_sorteo`
  MODIFY `id_premio_sorteo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sorteos`
--
ALTER TABLE `sorteos`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `jugador_sorteo`
--
ALTER TABLE `jugador_sorteo`
  ADD CONSTRAINT `jugador_sorteo_ibfk_1` FOREIGN KEY (`id_jugador`) REFERENCES `jugador` (`id_jugador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jugador_sorteo_ibfk_2` FOREIGN KEY (`id_sorteo`) REFERENCES `sorteos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `premio_sorteo`
--
ALTER TABLE `premio_sorteo`
  ADD CONSTRAINT `premio_sorteo_ibfk_1` FOREIGN KEY (`id_sorteo`) REFERENCES `sorteos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `premio_sorteo_ibfk_2` FOREIGN KEY (`id_premio`) REFERENCES `premios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
