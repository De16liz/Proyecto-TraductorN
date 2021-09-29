-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-07-2021 a las 14:03:21
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `traductor_nativo`
--

DELIMITER $$
--
-- Funciones
--
CREATE  FUNCTION `fun_agregar_palabra` (`p_palabra` VARCHAR(255), `p_id_tipo` INT, `p_id_idioma` INT) RETURNS BIT(1) BEGIN 
	DECLARE v BIT;
	SET v = IF((SELECT COUNT(*) FROM palabras t1 WHERE t1.palabra = p_palabra AND t1.id_idioma = p_id_idioma) = 0, 1, 0);
	IF (v = 1) then
		INSERT INTO palabras(palabra, id_tipo, id_idioma)
		VALUES(UPPER(p_palabra), p_id_tipo, p_id_idioma); 
		RETURN 1;
	ELSE
		RETURN 0;
	END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idiomas`
--

CREATE TABLE `idiomas` (
  `id` int(3) NOT NULL,
  `idioma` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `composicion_prosa` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `idiomas`
--

INSERT INTO `idiomas` (`id`, `idioma`, `composicion_prosa`) VALUES
(1, 'español', '1,2,3,4,5,6,7,8,9,10,'),
(4, 'tucano', '4,10,9,8,7,6,5,3,2,1,');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `palabras`
--

CREATE TABLE `palabras` (
  `id` int(11) NOT NULL,
  `palabra` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `id_tipo` int(2) NOT NULL,
  `id_idioma` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `palabras`
--

INSERT INTO `palabras` (`id`, `palabra`, `id_tipo`, `id_idioma`) VALUES
(1, 'mamá', 1, 1),
(2, 'ními', 1, 4),
(4, 'mi', 2, 1),
(6, 'mama', 1, 1),
(8, 'papá', 1, 1),
(10, 'jugar', 5, 1),
(12, 'quiere', 5, 1),
(14, 'dormir', 5, 1),
(15, 'cãrĩ', 5, 4),
(16, 'mamamá', 1, 1),
(18, 'Hola', 7, 1),
(25, 'cuántos', 1, 1),
(26, 'dicṹrã', 1, 4),
(27, 'animales', 1, 1),
(28, 'wa\'ícũrã', 1, 4),
(31, 'tío', 1, 1),
(32, 'pacú\'mami', 1, 4),
(33, 'yu\'ú', 4, 4),
(39, 'abuelos', 1, 1),
(40, 'ñekũsuma', 1, 4),
(41, 'abuelo', 1, 1),
(42, 'ñee\'cú', 1, 4),
(43, 'yo', 4, 1),
(44, 'mis', 2, 1),
(45, 'corro', 5, 1),
(46, 'omagũ\'ti', 5, 4),
(47, 'correr', 5, 1),
(48, 'omagú\'ti', 5, 4),
(49, 'apérã', 5, 4),
(50, 'juego', 5, 1),
(51, 'a\'pei\'ti', 5, 4),
(52, 'juegamos', 5, 1),
(53, 'ape\'sé', 5, 4),
(54, 'ustedes', 4, 1),
(55, 'mũsa', 4, 4),
(56, 'usted', 4, 1),
(57, 'mu\'ú ', 4, 4),
(58, 'jugamos', 5, 1),
(59, 'a\'perasa', 5, 4),
(60, 'juguemos', 5, 1),
(61, 'jueguen', 5, 1),
(62, 'duermo', 5, 1),
(63, 'cari\'tibe', 5, 4),
(64, 'dormimos', 5, 1),
(65, 'duerman', 5, 1),
(66, 'cãrĩ\'ña', 5, 4),
(67, 'cãrí\'ña', 5, 4),
(68, 'duerma', 5, 1),
(69, 'estoy', 5, 1),
(70, 'ní\'i', 5, 4),
(71, 'jugando', 5, 1),
(73, 'Yu\'ú', 4, 4),
(74, 'negros', 2, 1),
(75, 'ñii\'sé', 2, 4),
(76, 'negro', 2, 1),
(77, 'ñii\'ro', 2, 4),
(78, 'amarillo', 2, 1),
(79, 'e\'búro', 2, 4),
(80, 'amarillos', 2, 1),
(81, 'e\'búri', 2, 4),
(82, 'blancos', 2, 1),
(83, 'bu\'tise', 2, 4),
(84, 'blanco', 2, 1),
(85, 'bu\'tiro', 2, 4),
(86, 'azul', 2, 1),
(87, 'yasa\'borero', 2, 4),
(88, 'azules', 2, 1),
(89, 'yasa\'bocuresé', 2, 4),
(90, 'rojos', 2, 1),
(91, 'sua\'sé', 2, 4),
(92, 'rojo', 2, 1),
(93, 'sua\'ro', 2, 4),
(94, 'verdes', 2, 1),
(95, 'yasa\'sé', 2, 4),
(96, 'verde', 2, 1),
(97, 'yasa\'ro', 2, 4),
(98, 'morado', 2, 1),
(99, 'soa\'bocũrero', 2, 4),
(100, 'morados', 2, 1),
(101, 'soa\'bocure\'sé', 2, 4),
(102, 'naranja', 2, 1),
(103, 'soabocũre\'ro', 2, 4),
(104, 'naranjas', 2, 1),
(105, 'soati\'sé', 2, 4),
(106, 'perro', 2, 1),
(107, 'Diayi', 2, 4),
(108, 'gato', 2, 1),
(109, 'pisana', 1, 4),
(110, 'loro', 2, 1),
(111, 'we\'co', 2, 4),
(112, 'perros', 2, 1),
(113, 'Diayia', 2, 4),
(114, 'loros', 2, 1),
(115, 'we\'cũa', 2, 4),
(116, 'guacamaya', 2, 1),
(117, 'ma\'ja', 2, 4),
(118, 'guibo', 2, 1),
(119, 'piro', 2, 4),
(120, 'guibos', 2, 1),
(121, 'piro\'áá', 2, 4),
(122, 'mojojoy', 2, 1),
(123, 'pico\'rú', 2, 4),
(124, 'mojojoys', 2, 1),
(125, 'pico\'rá', 2, 4),
(126, 'tucan', 2, 1),
(127, 'yataro', 2, 4),
(128, 'cocodrilo', 2, 1),
(129, 'u\'so', 2, 4),
(130, 'pez', 2, 1),
(131, 'wai', 2, 4),
(132, 'cocodrilos', 2, 1),
(133, 'u\'sua', 2, 4),
(134, 'peces', 2, 1),
(135, 'wá\'ya', 2, 4),
(136, 'mono', 2, 1),
(137, 'ake suagu', 2, 4),
(138, 'monos', 2, 1),
(139, 'akea sua\'rá', 2, 4),
(140, 'pajaro', 2, 1),
(141, 'miri\'cú', 2, 4),
(142, 'pajaros', 2, 1),
(143, 'miri\'ca', 2, 4),
(144, 'mico', 2, 1),
(145, 'micos', 2, 1),
(146, 'tigrillo', 2, 1),
(147, 'yai', 2, 4),
(148, 'tigre', 2, 1),
(149, 'jaguar', 2, 1),
(150, 'tigrillos', 2, 1),
(151, 'yaiya', 2, 4),
(152, 'tigres', 2, 1),
(153, 'jaguares', 2, 1),
(154, 'danta', 2, 1),
(155, 'dantas', 2, 1),
(156, 'we\'cúa', 2, 4),
(157, 'venado', 2, 1),
(158, 'ñama', 2, 4),
(159, 'venados', 2, 1),
(160, 'ñama\'ra', 2, 4),
(161, 'lapa', 2, 1),
(162, 'se\'me', 2, 4),
(163, 'lapas', 2, 1),
(164, 'se\'mea', 2, 4),
(165, 'pavo', 2, 1),
(166, 'pajui', 2, 4),
(167, 'pava', 2, 1),
(168, 'cũta\'casoro', 2, 4),
(169, 'pavas', 2, 1),
(170, 'cũta\'casoroa', 2, 4),
(171, 'duerme', 5, 1),
(172, 'cãrĩmí', 5, 4),
(173, 'corre', 5, 1),
(174, 'omamí', 5, 4),
(179, 'dos', 2, 1),
(180, 'puáru', 2, 4),
(181, '2', 2, 1),
(182, 'uno', 2, 1),
(183, 'ni\'cú', 2, 4),
(184, '1', 2, 1),
(185, 'tres', 2, 1),
(186, 'i\'tiara', 2, 4),
(187, '3', 2, 1),
(188, 'cuatro', 2, 1),
(189, 'ba\'pari\'tina', 2, 4),
(190, 'cinco', 2, 1),
(191, 'ni\'camoucũ\'ra', 2, 4),
(192, '5', 2, 1),
(193, 'río', 1, 1),
(194, 'dia', 1, 4),
(195, 'ríos', 1, 1),
(196, 'dia\'ri', 1, 4),
(197, 'casa', 1, 1),
(198, 'vi\'i', 1, 4),
(199, 'caños', 1, 1),
(200, 'mari\'ca', 1, 4),
(201, 'casas', 1, 1),
(202, 'vi\'seri', 1, 4),
(203, 'chagra', 2, 1),
(204, 've\'se', 2, 4),
(205, 've\'seri', 2, 4),
(206, 'puerto', 1, 1),
(207, 'pe\'ta', 1, 1),
(208, 'puertos', 1, 1),
(209, 'pe\'tari', 1, 4),
(210, 'pueblo', 1, 1),
(211, 'ma\'ca', 1, 4),
(212, 'pueblos', 1, 1),
(213, 'ma\'cari', 1, 4),
(214, 'ciudad', 1, 1),
(215, 'pajiri\'maca', 1, 4),
(216, 'ciudades', 1, 1),
(217, 'paca\'se maca\'ri', 1, 4),
(218, 'monte', 1, 1),
(219, 'nũ\'cú', 1, 4),
(220, 'montes', 1, 1),
(221, 'un\'cũri', 1, 4),
(222, 'ropa', 1, 1),
(223, ' su\'ti', 1, 4),
(224, 'jefe', 1, 1),
(225, 'wiógu', 1, 4),
(226, 'cuál', 6, 1),
(227, 'dicó', 6, 4),
(228, 'cual', 6, 1),
(229, 'cómo', 6, 1),
(230, 'de´ró', 6, 4),
(231, 'quién', 4, 1),
(232, 'noá', 4, 4),
(233, 'como', 6, 1),
(234, 'agua', 1, 1),
(235, 'acó', 1, 4),
(236, 'nosotros', 4, 1),
(237, 'ũsằ', 4, 4),
(238, 'ay', 7, 1),
(239, 'agú', 7, 4),
(240, 'oh', 7, 1),
(241, 'a\'yú', 7, 4),
(242, 'malo', 2, 1),
(243, 'ña\'á', 2, 4),
(244, 'mujer', 1, 1),
(245, 'numíe', 1, 4),
(246, 'muy', 6, 1),
(247, 'pṹrõ', 6, 4),
(248, 'caliente', 2, 1),
(249, 'así', 2, 4),
(250, 'hermano', 1, 1),
(251, 'pánumu', 1, 4),
(252, 'banano', 1, 1),
(253, 'Ojò', 1, 4),
(254, 'hoy', 6, 1),
(255, '  ní\'cãcã', 6, 4),
(256, 'mucho', 2, 1),
(257, 'asé', 2, 4),
(258, 'ella', 4, 1),
(259, 'A-mo', 4, 4),
(260, 'viejo', 2, 1),
(261, 'Bucú', 2, 4),
(262, 'ña\'á', 2, 4),
(263, 'bueno', 2, 1),
(264, 'añurằ', 2, 4),
(265, 'bien', 6, 1),
(266, 'añurṍ', 6, 4),
(267, 'este', 2, 1),
(268, 'a\'tí', 2, 4),
(269, 'mañana', 6, 1),
(270, 'ñami', 6, 4),
(271, 'mes', 1, 1),
(272, 'mujĩpũ', 1, 4),
(273, 'vamos', 5, 1),
(274, 'te\'á', 5, 4),
(275, 'tambien', 6, 1),
(276, 'que\'rãrẽ', 6, 4),
(277, 'entonces', 6, 1),
(278, 'tojó', 6, 4),
(279, 'juegan', 5, 1),
(280, 'juega', 5, 1),
(281, 'malos', 2, 1),
(282, 'ña\'agṹ', 2, 4),
(283, 'negra', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacion_palabras`
--

CREATE TABLE `relacion_palabras` (
  `id` int(11) NOT NULL,
  `id_palabra_origen` int(11) NOT NULL,
  `id_palabra_traduccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `relacion_palabras`
--

INSERT INTO `relacion_palabras` (`id`, `id_palabra_origen`, `id_palabra_traduccion`) VALUES
(1, 1, 2),
(18, 4, 33),
(28, 10, 49),
(8, 14, 15),
(14, 25, 26),
(15, 27, 28),
(17, 31, 32),
(22, 39, 40),
(23, 41, 42),
(24, 43, 33),
(25, 44, 33),
(26, 45, 46),
(27, 47, 48),
(29, 50, 51),
(30, 52, 53),
(31, 54, 55),
(32, 56, 57),
(33, 58, 59),
(34, 60, 59),
(35, 61, 59),
(36, 62, 63),
(37, 64, 63),
(38, 65, 66),
(39, 65, 67),
(40, 68, 67),
(41, 69, 70),
(42, 71, 51),
(44, 74, 75),
(45, 76, 77),
(46, 78, 79),
(47, 80, 81),
(48, 82, 83),
(49, 84, 85),
(50, 86, 87),
(51, 88, 89),
(52, 90, 91),
(53, 92, 93),
(54, 94, 95),
(55, 96, 97),
(56, 98, 99),
(57, 100, 101),
(58, 102, 103),
(59, 104, 105),
(60, 106, 107),
(61, 108, 109),
(62, 110, 111),
(63, 112, 113),
(64, 114, 115),
(65, 116, 117),
(66, 118, 119),
(67, 120, 121),
(68, 122, 123),
(69, 124, 125),
(70, 126, 127),
(71, 128, 129),
(72, 130, 131),
(73, 132, 133),
(74, 134, 135),
(75, 136, 137),
(76, 138, 139),
(77, 140, 141),
(78, 142, 143),
(79, 144, 137),
(80, 145, 139),
(81, 146, 147),
(82, 148, 147),
(83, 149, 147),
(84, 150, 151),
(85, 152, 151),
(86, 153, 151),
(87, 154, 111),
(88, 155, 156),
(89, 157, 158),
(90, 159, 160),
(91, 161, 162),
(92, 163, 164),
(93, 165, 166),
(94, 167, 168),
(95, 169, 170),
(96, 171, 172),
(97, 173, 174),
(100, 179, 180),
(101, 181, 180),
(102, 182, 183),
(103, 184, 183),
(104, 185, 186),
(105, 187, 186),
(106, 188, 189),
(107, 190, 191),
(108, 192, 191),
(109, 193, 194),
(110, 195, 196),
(111, 197, 198),
(112, 199, 200),
(113, 201, 202),
(114, 203, 204),
(115, 203, 205),
(116, 206, 207),
(117, 208, 209),
(118, 210, 211),
(119, 212, 213),
(120, 214, 215),
(121, 216, 217),
(122, 218, 219),
(123, 220, 221),
(124, 222, 223),
(125, 224, 225),
(126, 226, 227),
(127, 228, 227),
(128, 229, 230),
(129, 231, 232),
(130, 233, 230),
(131, 234, 235),
(132, 236, 237),
(133, 238, 239),
(134, 240, 241),
(135, 242, 243),
(145, 242, 262),
(136, 244, 245),
(137, 246, 247),
(138, 248, 249),
(139, 250, 251),
(140, 252, 253),
(141, 254, 255),
(142, 256, 257),
(143, 258, 259),
(144, 260, 261),
(146, 263, 264),
(147, 265, 266),
(148, 267, 268),
(149, 269, 270),
(150, 271, 272),
(151, 273, 274),
(152, 275, 276),
(153, 277, 278),
(154, 279, 59),
(155, 280, 51),
(156, 281, 282),
(157, 283, 75);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id` int(2) NOT NULL,
  `tipo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`id`, `tipo`, `descripcion`) VALUES
(1, 'sustantivo', 'Palabra que se usa para nombrar a una persona, lugar, cosa, idea o cualidad. Acepta artículos y flexiones plurales.<br>Niño, mesa, profesor, belleza, automóvil, campos…<br>El <b>hombre</b> entró en la <b>habitación </b>sin hacer <b>ruido</b>.<br>Entre las <b>frutas</b> que <b>Julia</b> prefiere están: las <i>peras</i> y las <b>fresas</b>.'),
(2, 'adjetivo', 'Palabra que se usa para modificar o limitar un nombre.<br>Rojo, azul, alto, bella, feliz, diez.<br>Los <b>mejores</b> promedios son de los alumnos <b>aplicados</b>.'),
(3, 'artículo', 'Palabra que determina un sustantivo. &nbsp;Pueden ser determinados: el, la, los, las; o indeterminados: un, una, unos, unas.<br><b>Los</b> quejosos trajeron <b>unas</b> pancartas.'),
(4, 'pronombre', 'Palabra que se usa en lugar de un sustantivo:<br>Yo, tú, él, nosotros, ustedes, ellos, que, quien, me, mi, su…<br><b>Ella </b>dijo que <b>se lo</b> compraría a <b>ustedes</b>.'),
(5, 'verbo', 'Palabra que se usa para expresar una acción o un estado del ser. Por definición, el verbo contiene información relativa a tiempo y persona, por ello, éste siempre debe estar conjugado.<br>Estudiamos, has jugado, soñó, trabaja, va a vivir, descansarán…<br>Él <b>cantó </b>mientras la orquesta <b>tocaba</b> (verbos de acción).<br><b>Estamos</b> felices de <b>saber </b>que <b>luces</b> mejor (verbos copulativos).'),
(6, 'adverbio', 'Palabra que se usa para modificar el significado de un verbo, de un adjetivo o de otro adverbio.<br>Rápidamente, obviamente, más, muy, demasiado, hoy, ayer, sí, no…<br><b>Repentinamente</b> gritó la verdad (modifica al verbo “gritó”). <br>La miel es <b>demasiado</b> dulce para mi gusto (modifica al adjetivo “dulce”).<br>Corrió <b>muy rápidamente</b> (modifica al adverbio “rápidamente”).'),
(7, 'interjección', 'Una palabra usada para expresar emoción repentina; no tiene conexión gramatical con el resto de la oración.<br>Híjole, chin, bah, ah, oh, hey, ¿ah, sí?, ah bueno, wow…<br>¡<b>Ah</b>!, ¿eras tú el que estaba tocando la puerta como si viniera a cobrar?'),
(8, 'conjunción', 'Una palabra que se usa para conectar palabras, frases y cláusulas dentro de las oraciones. Se clasifican en coordinantes (unen elementos de la misma categoría) y subordinantes (introducen oraciones subordinadas que se unen con una oración independiente).<br>Y, o, pero, que, porque, si, cuando<br>Los tuvieron a pan <b>y</b> agua (la conjunción une dos sustantivos).<br>El cielo muestra notables cambios en la mañana <b>y</b> en la noche (la conjunción une frases).<br>Mariana se quedó en casa <b>porque</b> quiere estudiar (la conjunción une cláusulas: una independiente y otra subordinada).'),
(9, 'preposición', 'Una palabra que se usa para mostrar la relación entre un nombre o pronombre y otra parte de la oración.<br>A, ante, bajo, cabe, con, contra, de, desde, en, entre, hacia, hasta, para, por, según, sin, so, sobre, tras.<br>Lola viajó <b>a</b> Monterrey <b>para</b> el concurso <b>de </b>canto (“a Monterrey” y “para el concurso de canto” son frases preposicionales; “Monterrey” y “el concurso de canto” son los objetos de las preposiciones “a” y “para”).'),
(10, 'objeto', 'El objeto directo y el objeto indirecto son estructuras sintácticas que modifican al verbo y, por ende, están presentes en el predicado de la oración. Por ejemplo: Entregamos el <b>diploma</b> a María');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(3) NOT NULL,
  `usuario` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `contrasena` varchar(255) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contrasena`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_idiomas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_idiomas` (
`conteo` bigint(21)
,`idioma` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_palabras`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_palabras` (
`conteo` bigint(21)
,`palabra` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_idiomas`
--
DROP TABLE IF EXISTS `vista_idiomas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_idiomas`  AS SELECT count(0) AS `conteo`, `t1`.`idioma` AS `idioma` FROM `idiomas` AS `t1` WHERE `t1`.`id` <> 0 GROUP BY `t1`.`idioma` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_palabras`
--
DROP TABLE IF EXISTS `vista_palabras`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_palabras`  AS SELECT count(0) AS `conteo`, `t1`.`palabra` AS `palabra` FROM `palabras` AS `t1` WHERE `t1`.`id` <> 0 GROUP BY `t1`.`palabra` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `idiomas`
--
ALTER TABLE `idiomas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `palabras`
--
ALTER TABLE `palabras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_idioma` (`id_idioma`),
  ADD KEY `FK_id_tipo` (`id_tipo`);

--
-- Indices de la tabla `relacion_palabras`
--
ALTER TABLE `relacion_palabras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_palabra` (`id_palabra_origen`,`id_palabra_traduccion`),
  ADD KEY `id_palabra_traduccion` (`id_palabra_traduccion`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
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
-- AUTO_INCREMENT de la tabla `idiomas`
--
ALTER TABLE `idiomas`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `palabras`
--
ALTER TABLE `palabras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT de la tabla `relacion_palabras`
--
ALTER TABLE `relacion_palabras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `palabras`
--
ALTER TABLE `palabras`
  ADD CONSTRAINT `palabras_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `palabras_ibfk_2` FOREIGN KEY (`id_idioma`) REFERENCES `idiomas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `relacion_palabras`
--
ALTER TABLE `relacion_palabras`
  ADD CONSTRAINT `relacion_palabras_ibfk_1` FOREIGN KEY (`id_palabra_origen`) REFERENCES `palabras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relacion_palabras_ibfk_2` FOREIGN KEY (`id_palabra_traduccion`) REFERENCES `palabras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
