-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 13-02-2025 a las 17:44:29
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
-- Base de datos: `db_patitas_sos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bd_especie`
--

CREATE TABLE `bd_especie` (
  `id_especie` int(11) NOT NULL,
  `nombre_especie` varchar(85) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bd_especie`
--

INSERT INTO `bd_especie` (`id_especie`, `nombre_especie`) VALUES
(1, 'Gato'),
(2, 'Perro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bd_mascota`
--

CREATE TABLE `bd_mascota` (
  `id_mascota` int(11) NOT NULL,
  `nombre_mascota` varchar(85) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` varchar(6) DEFAULT NULL,
  `largo_pelo` varchar(10) DEFAULT NULL,
  `tamano` varchar(9) DEFAULT NULL,
  `esterilizado` tinyint(1) DEFAULT NULL,
  `peso` decimal(10,0) DEFAULT NULL,
  `id_especie` int(11) DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `foto_mascota` varchar(500) DEFAULT NULL,
  `estado_adopcion` tinyint(1) DEFAULT NULL,
  `estado_medico` varchar(500) DEFAULT NULL,
  `telefono_dueño` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bd_mascota`
--

INSERT INTO `bd_mascota` (`id_mascota`, `nombre_mascota`, `fecha_nacimiento`, `sexo`, `largo_pelo`, `tamano`, `esterilizado`, `peso`, `id_especie`, `descripcion`, `foto_mascota`, `estado_adopcion`, `estado_medico`, `telefono_dueño`) VALUES
(1, 'Rocky', '2023-05-01', 'Macho', 'Corto', 'Mediano', 0, 8, 2, 'Rocky es un perro joven y enérgico. Con un pelaje brillante y ojos llenos de vida, es una mezcla de energía y dulzura.', 'https://diariocorreo.pe/resizer/rKIvB-Kgtf1jpsESIQI5VnwgGRM=/1200x900/smart/filters:format(jpeg):quality(75)/cloudfront-us-east-1.images.arcpublishing.com/elcomercio/W22R3VL7AFA7JICSZ4INUZDMUE.jpg', 0, 'En excelente estado. ', '988678438'),
(2, 'Max', '2024-03-21', 'Macho', 'Corto', 'Pequeño', 0, 3, 2, 'Max es un cachorro muy activo y curioso.', 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcQgByBT5IiAT_a2x9pUVb4VMoOrlzHH7Jrzj-HB5jzHlR4lNLMS', 1, 'Bien.', '957995431'),
(3, 'Ami', '2020-11-26', 'Hembra', 'Mediano', 'Pequeño', 1, 7, 2, 'Está entrenada en casa y obedece órdenes básicas como sentarse, quedarse quieto y dar la pata. ', 'https://i.pinimg.com/736x/1e/0a/be/1e0abe63b2f7a88dad9afe6824cff06e.jpg', 1, 'Vacunado y en buen estado de salud.', '967456198'),
(4, 'Blanca', '2023-05-10', 'Hembra', 'Mediano', 'Pequeño', 1, 10, 1, 'Blanca es una gatita encantadora que está buscando un hogar amoroso donde pueda crecer y florecer. Su pelaje blanco y su mirada curiosa hacen de ella una compañera adorable y especial.', 'https://www.lavanguardia.com/files/image_948_465/uploads/2019/11/27/5fa5323f8cab7.jpeg', 0, 'Blanca está en excelente salud y ha recibido todas las vacunas recomendadas para su edad. Además, ha sido esterilizada, lo que contribuye a su salud a largo plazo y ayuda a controlar la población de gatos.', '955444221'),
(5, 'Zeus', '2023-11-08', 'Macho', 'Corto', 'Mediano', 0, 10, 2, 'Este joven perrito es extremadamente juguetón y cariñoso. Le encanta interactuar con las personas y otros perros, mostrando una naturaleza amigable y sociable. ', 'https://static.wixstatic.com/media/a27d24_9f7fe613fa9e4156bfe353fc2506669d~mv2.jpg/v1/fill/w_640,h_552,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/a27d24_9f7fe613fa9e4156bfe353fc2506669d~mv2.jpg', 0, 'Está en excelente salud y ha recibido todas las vacunas necesarias para su edad. Sin embargo, no ha sido esterilizado.', '999586223'),
(6, 'Princesa', '2024-03-20', 'Hembra', 'Corto', 'Pequeño', 0, 3, 1, 'Gatita de dos meses llena de energía y curiosidad. Es juguetona y traviesa, siempre explorando su entorno con entusiasmo.', 'https://imagenes.20minutos.es/files/image_1920_1080/uploads/imagenes/2020/09/17/un-gato-curioseando-alrededor-de-una-planta.jpeg', 0, 'Princesa está en excelente estado de salud. Ha sido revisada por un veterinario y ha recibido todas sus vacunas.', '922555789'),
(7, 'Gustavo', '2023-08-15', 'Macho', 'Corto', 'Mediano', 1, 6, 1, 'Es un felino tranquilo y observador, que prefiere pasar su tiempo explorando cada rincón de su hogar con calma y curiosidad. ', 'https://static.nationalgeographicla.com/files/styles/image_3200/public/01-cat-names-nationalgeographic_1525054.jpg?w=1600&h=900', 0, '956995838', '956995838'),
(8, 'Tom', '2023-11-20', 'Macho', 'Mediano', 'Mediano', 0, 6, 1, 'Tom es un gatito juguetón y curioso de seis meses de edad. Tiene un pelaje suave y brillante, con colores atigrados que hacen que sea realmente encantador a la vista. Es extremadamente cariñoso y disfruta de la compañía humana, siempre buscando caricias y mimos.', 'https://www.myhappypet.es/sites/spmhp/files/adopcion-perros-callejeros.jpg', 0, 'Está al día con todas sus vacunas y ha sido desparasitado regularmente. Es un gato muy saludable y lleno de energía, listo para encontrar un hogar donde pueda recibir todo el amor y la atención que merece.', '988799839');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_solicitud`
--

CREATE TABLE `detalle_solicitud` (
  `id_detalle` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `respuesta` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_solicitud`
--

INSERT INTO `detalle_solicitud` (`id_detalle`, `id_solicitud`, `id_pregunta`, `respuesta`) VALUES
(351, 36, 1, 'Busco compañía y afecto en mi hogar.'),
(352, 36, 2, 'Mi novia y yo.'),
(353, 36, 3, 'Casa con patio o jardín.'),
(354, 36, 4, 'Por mi experiencia.'),
(355, 36, 5, 'Si.'),
(356, 36, 6, 'Llevarla al veterinario. '),
(357, 36, 7, 'Si.'),
(358, 36, 8, 'No.'),
(359, 36, 9, 'No, ya he tenido mascotas previamente. '),
(360, 36, 10, 'No.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_solicitud`
--

CREATE TABLE `estado_solicitud` (
  `id_estado` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_solicitud`
--

INSERT INTO `estado_solicitud` (`id_estado`, `estado`) VALUES
(1, 'Pendiente.'),
(2, 'Aceptado.'),
(3, 'Rechazado.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades`
--

CREATE TABLE `novedades` (
  `id` int(11) NOT NULL,
  `tipo` enum('EVENTO','NOTICIA') NOT NULL,
  `img` varchar(700) DEFAULT NULL,
  `titulo` varchar(200) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `fecha_publicacion` date NOT NULL,
  `fecha_evento` date DEFAULT NULL,
  `lugar_hora` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `novedades`
--

INSERT INTO `novedades` (`id`, `tipo`, `img`, `titulo`, `descripcion`, `fecha_publicacion`, `fecha_evento`, `lugar_hora`) VALUES
(1, 'EVENTO', 'https://scontent.flim26-1.fna.fbcdn.net/v/t39.30808-6/469231834_1132624818422828_3389038171081969447_n.jpg?_nc_cat=110&ccb=1-7&_nc_sid=833d8c&_nc_eui2=AeHj78MCilJyGhaZinwy9muL58NTTL3qsNLnw1NMveqw0qL28WNXfCcDKKs3IcEFaOD43BihUj5vNJGVCNmOVYb8&_nc_ohc=_wYAUIpFwr0Q7kNvgHmFi5s&_nc_zt=23&_nc_ht=scontent.flim26-1.fna&_nc_gid=A89HFchlB0nCAgG7TA34xFt&oh=00_AYAKGJ5Ae-CKf9OqZFcXv5txnJ78pzTuAy1pisGKDLdQZg&oe=675A198A', '📣¡Pasa la voz!📣\r\nEl tiempo que se comparte, es el verdadero tiempo vivido.❤️', 'l domingo 15 de diciembre llevaremos a cabo nuestra Chocopatitas 2024 en el A.H. Casas Granja San Miguel de Castilla.🐶😺\r\n\r\nNo solo les llevaremos un delicioso aguadito a los callejeritos de la zona, también realizaremos una campaña veterinaria gratuita en colaboración con la Dra. Sandra Zárate, a quien agradecemos de manera especial por su apoyo.🥰', '2024-12-03', '2024-12-15', 'A.H. Casas Granja San Miguel de Castilla, 9:00 AM'),
(2, 'EVENTO', 'https://scontent.flim26-1.fna.fbcdn.net/v/t39.30808-6/462681475_1094518885566755_886727963657870192_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=833d8c&_nc_eui2=AeHfU4BrUC-x_wFe6TFS05diq-rjiHpRYJer6uOIelFgl4OTz0vrRt7SPUIr90z7oNYdSGw9oZc_G1fsdGQjhbrH&_nc_ohc=Xad7gWgQifgQ7kNvgGl9sXq&_nc_zt=23&_nc_ht=scontent.flim26-1.fna&_nc_gid=A96Nt2e9i4XVyZvWY96QGbI&oh=00_AYAWInZT_rrWG4Oy1u7ZbTvfnhXHuDa8XD_9xP9Z7KksBA&oe=675A0D55', '🎃🐾 ¡Halloguau: La pasarela canina más creativa de Piura! 🐶✨', 'Este domingo 20 de octubre, acompáñanos en Halloguau, la pasarela canina donde premiamos a los perritos con los disfraces más divertidos y creativos de Piura. Ven y disfruta de una experiencia única llena de alegría, ternura y mucho estilo perruno. ¡No te lo pierdas! 🐕🎭', '2024-10-15', '2024-10-20', 'C.C. Real Plaza, frente a Topitop, 10:00 AM'),
(4, 'EVENTO', 'https://scontent.flim26-1.fna.fbcdn.net/v/t39.30808-6/466784053_1118732283145415_3062867124455159816_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=833d8c&_nc_eui2=AeEGCmGEcW-tBuLrIGSY0T-Bf8duMmookFd_x24yaiiQV-3vQU8ZCGXME42NsuY2_eQCGCbpAAYLUiyq891VKw0R&_nc_ohc=ARl6vFvyXjEQ7kNvgHS9rQk&_nc_zt=23&_nc_ht=scontent.flim26-1.fna&_nc_gid=AVNMK5qsd0V7wWpRBRMSCAP&oh=00_AYCemKvPhZzFY-ghaT6BgJfNs2knmsp_pJAynx74us5FNw&oe=675A1B36', '\r\n🐾💉 Campaña Gratuita de Vacunación Antirrábica 🐶🐱', 'Protege a tus mascotas contra la rabia en esta jornada de vacunación gratuita para perros y gatos. Te esperamos este jueves 14 de noviembre, de 9:00 a.m. a 12:00 m., en el Centro Veterinario Municipal \"Patitas\" (A.H. Alan Perú, frente al ex camal municipal). ¡Cuidemos juntos a nuestras mascotas y a nuestra comunidad!', '2024-11-13', '2024-11-14', 'Centro Veterinario Municipal \"Patitas\", 9:00 AM'),
(5, 'NOTICIA', 'https://scontent.flim26-1.fna.fbcdn.net/v/t39.30808-6/467323158_1121502012868442_3804013850170042368_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=833d8c&_nc_eui2=AeEWGOT3_kAVX_W2DYtEYqe0w-AWY_wYJ8rD4BZj_BgnyiAahvIWGL1KBLh634PnU7_jHXwKqZS0o3ebC-dcvFP0&_nc_ohc=WsAN7-1_B70Q7kNvgFk22u5&_nc_zt=23&_nc_ht=scontent.flim26-1.fna&_nc_gid=AiXx4IiK5kIK-M3HfMrTr7l&oh=00_AYDtC9yw6rnJj-WmBLWjKlA1EWplplKiZpLzSBNhGLHweQ&oe=675A382B', '🐾✨ Jornada de Esterilización Felina 🐱🩺', 'Veterinaria Reino Animal organiza una jornada especial de esterilización y castración felina durante todo el mes de noviembre. Con cupos limitados, esta campaña busca promover el bienestar animal y controlar la población de felinos de manera responsable. Agenda tu cita al 936008176 y visita la clínica en la Urb. San José Calle 3 #1509, a espaldas del SENCICO en la Av. Grau. ¡No pierdas la oportunidad de cuidar a tus gatos con profesionales calificados!', '2024-11-17', '0000-00-00', ''),
(6, 'EVENTO', 'https://scontent.flim26-1.fna.fbcdn.net/v/t39.30808-6/469492573_1134660078219302_4914850888452778571_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=833d8c&_nc_eui2=AeG1YC3ZW8Qqh3GwoXqV4bAxbxmFjEMgsR1vGYWMQyCxHePIQeVpvgbvDNu9c-ImczVkPVKY29PdJzL9_An23uYR&_nc_ohc=8q8X4Z_B26EQ7kNvgHtNP4W&_nc_zt=23&_nc_ht=scontent.flim26-1.fna&_nc_gid=At_-po9LRepxAFPVssRZX64&oh=00_AYDamdolo-IkgfQy-tAiatlaKerzIyf9yxPudcmhBGFJVw&oe=675A196F', '🎅🐾 ¡Únete a CHOCOPATITAS 2024 y ayuda a los callejeritos! 🐶✨', 'Este domingo, sé parte de una experiencia solidaria y navideña con CHOCOPATITAS 2024. Ven a alimentar y dar amor a los perritos callejeros del A.H. Casas Granja San Miguel de Castilla (ex Quebrada del Gallo). ¡Juntos podemos hacer la diferencia en esta Navidad! 🎄💖', '2024-12-07', '2024-12-15', 'A.H. Casas Granja San Miguel de Castilla, 9:00 AM'),
(7, 'NOTICIA', 'https://scontent.flim26-1.fna.fbcdn.net/v/t39.30808-6/468939893_1130693505282626_5299931540620303681_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeG0CEe57VmlMFLdEm_ld4f6SaYaOZ-Ac5VJpho5n4BzlcXu88Hvo56uh5xMWAePsVNzqU0oGLfdAO4xyAOUtO9A&_nc_ohc=mibtHVoTcdYQ7kNvgGGCv5A&_nc_zt=23&_nc_ht=scontent.flim26-1.fna&_nc_gid=Av-x1yrXOqZM-4BLmPQoxZR&oh=00_AYAz7LM_TL0NKHOtxkYCBQ9MuMtKHLri_Ps1kBtznHUgQQ&oe=675A2697', '¡BIENVENIDO, DICIEMBRE!❤️', 'Nuestros mejores deseos para todos los amigos de los animales, que en estas fiestas que ya están cerca, renazca en nosotros el amor por los animalitos que tanto nos necesitan.\r\nRecordemos cuidar siempre de nuestras mascotas y disfrutar junto a ellos. ❤️🎄🐱🐶\r\nTambién tengamos presente a muchos callejeritos que sólo esperan por un poco de alimento y de amor. 🐶❤️🐱', '2024-12-01', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id_pregunta` int(11) NOT NULL,
  `nombre_pregunta` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id_pregunta`, `nombre_pregunta`) VALUES
(1, '¿Por qué quieres adoptar esta mascota?'),
(2, '¿Quién será el responsable de cuidar a la mascota?\r\n'),
(3, '¿Qué tipo de vivienda posee?'),
(4, '¿Por qué consideras que eres apropiado para adoptar a esta mascota?'),
(5, '¿Su familia está de acuerdo con la adopción de la mascota?'),
(6, '¿Qué hará si se enferma la mascota?'),
(7, 'En caso de convivir con niños, ¿Ellos saben cómo cuidar a la mascota?'),
(8, '¿Usted o alguno de sus convivientes tiene alguna alergia?'),
(9, '¿Es la primera vez que adopta un animal? (Adoptar implica asumir la responsabilidad de cuidar a un animal rescatado, ya sea de un refugio, una organización o de la calle, y no recibirlo como regalo o comprarlo.)'),
(10, '¿En su hogar convive con otras mascotas?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `titulo_rol` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `titulo_rol`) VALUES
(1, 'usuario'),
(2, 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `id_solicitud` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_mascota` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `reporte` varchar(600) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`id_solicitud`, `id_usuario`, `id_mascota`, `id_estado`, `descripcion`, `reporte`, `fecha`) VALUES
(36, 55, 3, 2, 'Ya puedes comunicarte con el dueño.', '', '2024-12-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `image` varchar(600) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `edad` date NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombres`, `apellidos`, `image`, `email`, `password`, `edad`, `telefono`, `ubicacion`, `descripcion`, `id_rol`) VALUES
(55, 'Jhon ', 'Cordova', 'Perfil2.jpeg', 'jacordova838@gmail.com', '$2y$10$HlHQmaOxZwzOngQKK06emu0b8RprqJcB90uMYkMQtCZ.Zu34i9IV6', '2001-05-24', '957995839', 'Sullana', 'Me gustan los perros de raza pequeña :D', 1),
(58, 'Alonso', 'Cordova', 'admin.png', 'admin@gmail.com', '$2y$10$3Q2rFHykAjNxC0ZAgxmZTuL1u/BZO5yH8gTnOq47XjjKJFPTbfKkS', '2001-05-24', '', 'Piura', '', 2),
(65, 'Michael', 'Almeyda', NULL, 'michael@gmail.con', '$2y$10$3iXp8mgGxsGyeg8Uv7IHC.E9W8OIj8zqvKRE0Nx7qqlw6zIc2h9ry', '2000-05-10', '', '', '', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bd_especie`
--
ALTER TABLE `bd_especie`
  ADD PRIMARY KEY (`id_especie`);

--
-- Indices de la tabla `bd_mascota`
--
ALTER TABLE `bd_mascota`
  ADD PRIMARY KEY (`id_mascota`),
  ADD KEY `id_especie` (`id_especie`);

--
-- Indices de la tabla `detalle_solicitud`
--
ALTER TABLE `detalle_solicitud`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_pregunta` (`id_pregunta`),
  ADD KEY `id_solicitud` (`id_solicitud`);

--
-- Indices de la tabla `estado_solicitud`
--
ALTER TABLE `estado_solicitud`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `novedades`
--
ALTER TABLE `novedades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id_pregunta`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_mascota` (`id_mascota`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `FK` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bd_especie`
--
ALTER TABLE `bd_especie`
  MODIFY `id_especie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `bd_mascota`
--
ALTER TABLE `bd_mascota`
  MODIFY `id_mascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_solicitud`
--
ALTER TABLE `detalle_solicitud`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;

--
-- AUTO_INCREMENT de la tabla `estado_solicitud`
--
ALTER TABLE `estado_solicitud`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `novedades`
--
ALTER TABLE `novedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bd_mascota`
--
ALTER TABLE `bd_mascota`
  ADD CONSTRAINT `bd_mascota_ibfk_1` FOREIGN KEY (`id_especie`) REFERENCES `bd_especie` (`id_especie`);

--
-- Filtros para la tabla `detalle_solicitud`
--
ALTER TABLE `detalle_solicitud`
  ADD CONSTRAINT `detalle_solicitud_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_solicitud_ibfk_2` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitud` (`id_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `solicitud_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solicitud_ibfk_2` FOREIGN KEY (`id_mascota`) REFERENCES `bd_mascota` (`id_mascota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solicitud_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estado_solicitud` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
