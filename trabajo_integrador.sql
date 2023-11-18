-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2023 a las 01:13:14
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `trabajo integrador`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `contraseña` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `nombre`, `apellido`, `correo`, `contraseña`) VALUES
(1, 'Alberto', 'Mendoza', 'BetoMendoza@gmail.com', '$2y$10$9cyz18OdYvKI/lbLahM5juKPSODqrcjPjmglgTXAIvSZphyHT2evC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas`
--

CREATE TABLE `etiquetas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `etiquetas`
--

INSERT INTO `etiquetas` (`id`, `nombre`) VALUES
(1, 'playa'),
(2, 'Vista al mar'),
(3, 'Cerca de restuarante'),
(4, 'Montaña'),
(5, 'Ciudad'),
(6, 'Naturaleza'),
(7, 'Piscina'),
(8, 'Jacuzzi'),
(9, 'Terraza'),
(10, 'Jardín'),
(11, 'Rio'),
(12, 'Lago'),
(13, 'Bosque'),
(14, 'Paisaje'),
(15, 'Tranquilidad'),
(16, 'Confort');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas_x_alquileres`
--

CREATE TABLE `etiquetas_x_alquileres` (
  `id_oferta` int(11) NOT NULL,
  `id_etiqueta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `etiquetas_x_alquileres`
--

INSERT INTO `etiquetas_x_alquileres` (`id_oferta`, `id_etiqueta`) VALUES
(13, 9),
(13, 10),
(13, 14),
(13, 15),
(15, 3),
(15, 4),
(15, 6),
(15, 13),
(15, 14),
(15, 15),
(30, 5),
(30, 9),
(31, 1),
(31, 2),
(31, 3),
(32, 1),
(32, 2),
(32, 3),
(34, 1),
(34, 2),
(34, 3),
(35, 5),
(35, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeria`
--

CREATE TABLE `galeria` (
  `id` int(11) NOT NULL,
  `id_alquiler` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `galeria`
--

INSERT INTO `galeria` (`id`, `id_alquiler`, `foto`) VALUES
(1, 13, 'galeria/Chrysanthemum.jpg'),
(2, 13, 'galeria/Koala.jpg'),
(3, 13, 'galeria/Penguins.jpg'),
(4, 15, 'galeria/1.jpg'),
(5, 15, 'galeria/2.jpg'),
(6, 15, 'galeria/3.jpg'),
(7, 15, 'galeria/4.jpg'),
(8, 15, 'galeria/5.jpg'),
(9, 15, 'galeria/6.jpg'),
(29, 30, 'galeria/SIR1371B.jpg'),
(30, 30, 'galeria/SIR1371C.jpg'),
(31, 30, 'galeria/SIR1371D.jpg'),
(32, 31, 'galeria/7.jpg'),
(33, 31, 'galeria/8.jpg'),
(34, 31, 'galeria/9.jpg'),
(35, 31, 'galeria/10.jpg'),
(36, 31, 'galeria/11.jpg'),
(37, 31, 'galeria/12.jpg'),
(38, 32, 'galeria/7.jpg'),
(39, 32, 'galeria/8.jpg'),
(40, 32, 'galeria/9.jpg'),
(41, 32, 'galeria/10.jpg'),
(42, 32, 'galeria/11.jpg'),
(43, 32, 'galeria/12.jpg'),
(45, 34, 'galeria/7.jpg'),
(46, 34, 'galeria/8.jpg'),
(47, 34, 'galeria/9.jpg'),
(48, 34, 'galeria/10.jpg'),
(49, 34, 'galeria/11.jpg'),
(50, 34, 'galeria/12.jpg'),
(51, 35, 'galeria/SIR1371B.jpg'),
(52, 35, 'galeria/SIR1371C.jpg'),
(53, 35, 'galeria/SIR1371D.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_perfil`
--

CREATE TABLE `imagenes_perfil` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes_perfil`
--

INSERT INTO `imagenes_perfil` (`id`, `usuario_id`, `foto`) VALUES
(1, 1, 'imagenesPerfil/1_foto.jpg'),
(11, 17, 'imagenesPerfil/17_foto.jpg'),
(12, 25, 'imagenesPerfil/25_foto.jpg'),
(14, 26, 'imagenesPerfil/26_foto.jpg'),
(16, 31, 'imagenesPerfil/31_foto.jpg'),
(17, 32, 'imagenesPerfil/32_foto.jpg'),
(20, 34, 'imagenesPerfil/34_foto.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta_alquileres`
--

CREATE TABLE `oferta_alquileres` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `provincia` varchar(50) NOT NULL,
  `departamento` varchar(50) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `tiempoMinimo` int(11) NOT NULL,
  `tiempoMaximo` int(11) NOT NULL,
  `cupo` int(11) NOT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaFin` date DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 0,
  `fecha_creacion` date NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `oferta_alquileres`
--

INSERT INTO `oferta_alquileres` (`id`, `titulo`, `descripcion`, `provincia`, `departamento`, `costo`, `tiempoMinimo`, `tiempoMaximo`, `cupo`, `fechaInicio`, `fechaFin`, `estado`, `fecha_creacion`, `usuario_id`) VALUES
(13, 'cabaña feliz', 'muy feliz', 'San Luis', 'Villa Mercedes', 6900.00, 7, 30, 8, NULL, NULL, 1, '2023-11-02', 1),
(15, 'cabaña en el bosque', '2 habitaciones 1 baño etc', 'Tierra del Fuego', 'Tierra del Fuego, Antártida e Islas del Atlántico ', 4800.00, 2, 7, 4, NULL, NULL, 1, '2023-11-13', 32),
(30, 'Departamento San luis', 'Edificio Le Saige - Torre a ESTRENAR en el corazón de Villa San Martín, tradicional barrio residencial de nuestra ciudad. A 150 mts de Av Italia y 350 de Av Sarmiento, muy próximo al centro. 1 Dormitorio Dormitorio de 3 x 2,60 libres con placard completo ', 'Chaco', 'Resistencia', 4000.00, 365, 1095, 1, NULL, NULL, 1, '2023-11-14', 25),
(31, 'casa en la playa', 'es una casa, con cocina, muebles, lavaropa, 2 Dormitorio', 'Buenos Aires', 'Almirante Brown', 10000.00, 3, 30, 4, '2023-11-13', '2024-01-13', 0, '2023-11-13', 26),
(32, 'Casa en la playa', '3 dormitorio, 1 cocina', 'Buenos Aires', 'Almirante Brown', 5000.00, 3, 7, 6, '0000-00-00', '0000-00-00', 1, '2023-11-17', 17),
(34, 'casa en la playa', '3 dormitorio, 1 cocina', 'Buenos Aires', 'Almirante Brown', 5000.00, 3, 7, 6, NULL, '2023-12-17', 1, '2023-11-17', 17),
(35, 'Departamento San Juan', '1 dormitorio, 1 cocina', 'San Juan', 'Capital', 2000.00, 365, 1095, 1, NULL, NULL, 0, '2023-11-17', 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_alquiler`
--

CREATE TABLE `pedidos_alquiler` (
  `id_oferta` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `cupo` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha_pedido` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos_alquiler`
--

INSERT INTO `pedidos_alquiler` (`id_oferta`, `id_usuario`, `fecha_ini`, `fecha_fin`, `cupo`, `total`, `fecha_pedido`) VALUES
(13, 25, '0000-00-00', '0000-00-00', 1, 48300.00, '2023-11-17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseña_alquileres`
--

CREATE TABLE `reseña_alquileres` (
  `oferta_id` int(11) NOT NULL,
  `calificacion` tinyint(4) DEFAULT NULL CHECK (`calificacion` in (1,2,3,4,5)),
  `comentario` varchar(200) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `respuesta` varchar(200) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reseña_alquileres`
--

INSERT INTO `reseña_alquileres` (`oferta_id`, `calificacion`, `comentario`, `usuario_id`, `respuesta`, `fecha_creacion`) VALUES
(13, 3, 'Es de loco!', 17, 'Vuelva pronto', '2023-11-06 17:35:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`) VALUES
(1, 'Servicio de gas'),
(2, 'Servicio de luz'),
(3, 'Servicio de agua'),
(4, 'Servicio de mantenimiento'),
(5, 'Servicio de lavanderia'),
(6, 'Servicio de estacionamiento'),
(7, 'Servicio de seguridad'),
(8, 'Servicio de limpieza'),
(9, 'Servicio de internet');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_x_alquileres`
--

CREATE TABLE `servicios_x_alquileres` (
  `id_oferta` int(11) NOT NULL,
  `id_servicios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios_x_alquileres`
--

INSERT INTO `servicios_x_alquileres` (`id_oferta`, `id_servicios`) VALUES
(13, 1),
(13, 2),
(13, 3),
(13, 9),
(15, 1),
(15, 2),
(15, 3),
(15, 5),
(30, 1),
(30, 2),
(30, 3),
(31, 1),
(31, 2),
(31, 3),
(31, 9),
(32, 1),
(32, 2),
(32, 3),
(32, 9),
(34, 2),
(34, 3),
(34, 9),
(35, 1),
(35, 2),
(35, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `verificado` tinyint(1) NOT NULL DEFAULT 0,
  `bio` text DEFAULT NULL,
  `vencimiento_verificado` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `contraseña`, `verificado`, `bio`, `vencimiento_verificado`) VALUES
(1, 'Matias', 'Plan', 'dariusnoxiano@gmail.com', '$2y$10$dLu9yKM0NNf/rOI9bMOcT.aYBo/f5QrQsPN2FEm7ZYezRGRJwMP3K', 1, 'soy estudiante de programacion', '2024-10-10'),
(17, 'Eric', 'Diaz', 'dragon@gmail.com', '$2y$10$QCU4E4PB0kI7s2ytd42Pf.Xor.bPfkxhR.Y4VoBqp0Tauuw.vcfTC', 1, 'soy un dragon jaja', '2024-10-21'),
(25, 'pedro', 'perez', 'algo@gmail.com', '$2y$10$ZlkrQVjmW81neSQG6uM2o.BElPrG0CnVm0tIoVnuUaiXvPMVWp9pe', 0, 'test', NULL),
(26, 'pepe', 'piedras', 'pepito@gmail.com', '$2y$10$eBzJobDfHLeK01j9guQ5deYILifjNdlcPWhOzl6mUZ1.kop4qxoZ6', 0, 'soy pepe', NULL),
(31, 'Federico', 'Varias', 'nuevo@gmail.com', '$2y$10$l4HTXP7NkH/2dNGufFJkHOVCEA986yRK3OoLtNw7Ll1BwuNgE9P7K', 0, 'hola soy fede', NULL),
(32, 'Andres', 'Perez', 'amigo@gmail.com', '$2y$10$Zl6d2BF6rfRAfDarfH6Ovu/XK0rPYtHHIY76seVcMQZ6PCMt3wU6G', 1, 'Amigos de todo el mundo', '2024-11-17'),
(34, 'Julian', 'Paz', 'paz@gmail.com', '$2y$10$bqt2WlIrtuLYAl2hMlF1WOFQjCVXWm8zmkQgD7XdO02jjXQYgS5iG', 0, 'soy Julian', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_toman_alquileres`
--

CREATE TABLE `usuarios_toman_alquileres` (
  `usuario_id` int(11) DEFAULT NULL,
  `id_oferta` int(11) NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `cupo` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_toman_alquileres`
--

INSERT INTO `usuarios_toman_alquileres` (`usuario_id`, `id_oferta`, `fecha_ini`, `fecha_fin`, `cupo`, `total`) VALUES
(17, 13, '2023-10-24', '2023-10-31', 4, 48300.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_x_etiquetas`
--

CREATE TABLE `usuarios_x_etiquetas` (
  `usuario_id` int(11) DEFAULT NULL,
  `id_etiquetas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_x_etiquetas`
--

INSERT INTO `usuarios_x_etiquetas` (`usuario_id`, `id_etiquetas`) VALUES
(1, 13),
(1, 16),
(17, 1),
(1, 1),
(31, 1),
(31, 2),
(31, 7),
(31, 8),
(31, 11),
(31, 12),
(32, 1),
(32, 2),
(32, 3),
(32, 4),
(26, 9),
(26, 10),
(34, 1),
(34, 2),
(34, 7),
(34, 8),
(34, 11),
(34, 12),
(25, 5),
(34, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_x_documento`
--

CREATE TABLE `usuario_x_documento` (
  `usuario_id` int(11) NOT NULL,
  `archivo` varchar(255) NOT NULL,
  `estado` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_x_documento`
--

INSERT INTO `usuario_x_documento` (`usuario_id`, `archivo`, `estado`) VALUES
(1, 'documento/1_dni.jpg', 1),
(17, 'documento/17_dni.jpg', 1),
(32, 'documento/32_dni.jpg', 1),
(34, 'documento/34_dni.jpg', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `etiquetas_x_alquileres`
--
ALTER TABLE `etiquetas_x_alquileres`
  ADD PRIMARY KEY (`id_oferta`,`id_etiqueta`),
  ADD KEY `id_etiqueta` (`id_etiqueta`);

--
-- Indices de la tabla `galeria`
--
ALTER TABLE `galeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alquiler` (`id_alquiler`);

--
-- Indices de la tabla `imagenes_perfil`
--
ALTER TABLE `imagenes_perfil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `oferta_alquileres`
--
ALTER TABLE `oferta_alquileres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `pedidos_alquiler`
--
ALTER TABLE `pedidos_alquiler`
  ADD PRIMARY KEY (`id_oferta`,`fecha_ini`,`fecha_fin`) USING BTREE,
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `reseña_alquileres`
--
ALTER TABLE `reseña_alquileres`
  ADD PRIMARY KEY (`oferta_id`,`usuario_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios_x_alquileres`
--
ALTER TABLE `servicios_x_alquileres`
  ADD PRIMARY KEY (`id_oferta`,`id_servicios`),
  ADD KEY `id_servicios` (`id_servicios`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `usuarios_toman_alquileres`
--
ALTER TABLE `usuarios_toman_alquileres`
  ADD PRIMARY KEY (`id_oferta`,`fecha_ini`,`fecha_fin`),
  ADD KEY `id_usuario` (`usuario_id`),
  ADD KEY `id_oferta` (`id_oferta`);

--
-- Indices de la tabla `usuarios_x_etiquetas`
--
ALTER TABLE `usuarios_x_etiquetas`
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `id_etiquetas` (`id_etiquetas`);

--
-- Indices de la tabla `usuario_x_documento`
--
ALTER TABLE `usuario_x_documento`
  ADD PRIMARY KEY (`usuario_id`,`archivo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `galeria`
--
ALTER TABLE `galeria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `imagenes_perfil`
--
ALTER TABLE `imagenes_perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `oferta_alquileres`
--
ALTER TABLE `oferta_alquileres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `etiquetas_x_alquileres`
--
ALTER TABLE `etiquetas_x_alquileres`
  ADD CONSTRAINT `etiquetas_x_alquileres_ibfk_1` FOREIGN KEY (`id_oferta`) REFERENCES `oferta_alquileres` (`id`),
  ADD CONSTRAINT `etiquetas_x_alquileres_ibfk_2` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiquetas` (`id`);

--
-- Filtros para la tabla `galeria`
--
ALTER TABLE `galeria`
  ADD CONSTRAINT `galeria_ibfk_1` FOREIGN KEY (`id_alquiler`) REFERENCES `oferta_alquileres` (`id`);

--
-- Filtros para la tabla `imagenes_perfil`
--
ALTER TABLE `imagenes_perfil`
  ADD CONSTRAINT `imagenes_perfil_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `oferta_alquileres`
--
ALTER TABLE `oferta_alquileres`
  ADD CONSTRAINT `oferta_alquileres_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `pedidos_alquiler`
--
ALTER TABLE `pedidos_alquiler`
  ADD CONSTRAINT `pedidos_alquiler_ibfk_1` FOREIGN KEY (`id_oferta`) REFERENCES `oferta_alquileres` (`id`),
  ADD CONSTRAINT `pedidos_alquiler_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `servicios_x_alquileres`
--
ALTER TABLE `servicios_x_alquileres`
  ADD CONSTRAINT `servicios_x_alquileres_ibfk_1` FOREIGN KEY (`id_oferta`) REFERENCES `oferta_alquileres` (`id`),
  ADD CONSTRAINT `servicios_x_alquileres_ibfk_2` FOREIGN KEY (`id_servicios`) REFERENCES `etiquetas` (`id`);

--
-- Filtros para la tabla `usuarios_toman_alquileres`
--
ALTER TABLE `usuarios_toman_alquileres`
  ADD CONSTRAINT `usuarios_toman_alquileres_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `usuarios_toman_alquileres_ibfk_2` FOREIGN KEY (`id_oferta`) REFERENCES `oferta_alquileres` (`id`);

--
-- Filtros para la tabla `usuarios_x_etiquetas`
--
ALTER TABLE `usuarios_x_etiquetas`
  ADD CONSTRAINT `usuarios_x_etiquetas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `usuarios_x_etiquetas_ibfk_2` FOREIGN KEY (`id_etiquetas`) REFERENCES `etiquetas` (`id`);

--
-- Filtros para la tabla `usuario_x_documento`
--
ALTER TABLE `usuario_x_documento`
  ADD CONSTRAINT `usuario_x_documento_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
