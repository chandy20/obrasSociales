-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-02-2018 a las 20:56:15
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_aos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_classes`
--

CREATE TABLE `acl_classes` (
  `id` int(10) UNSIGNED NOT NULL,
  `class_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_entries`
--

CREATE TABLE `acl_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `class_id` int(10) UNSIGNED NOT NULL,
  `object_identity_id` int(10) UNSIGNED DEFAULT NULL,
  `security_identity_id` int(10) UNSIGNED NOT NULL,
  `field_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ace_order` smallint(5) UNSIGNED NOT NULL,
  `mask` int(11) NOT NULL,
  `granting` tinyint(1) NOT NULL,
  `granting_strategy` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `audit_success` tinyint(1) NOT NULL,
  `audit_failure` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_object_identities`
--

CREATE TABLE `acl_object_identities` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_object_identity_id` int(10) UNSIGNED DEFAULT NULL,
  `class_id` int(10) UNSIGNED NOT NULL,
  `object_identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `entries_inheriting` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_object_identity_ancestors`
--

CREATE TABLE `acl_object_identity_ancestors` (
  `object_identity_id` int(10) UNSIGNED NOT NULL,
  `ancestor_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_security_identities`
--

CREATE TABLE `acl_security_identities` (
  `id` int(10) UNSIGNED NOT NULL,
  `identifier` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `username` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afiliadodibie`
--

CREATE TABLE `afiliadodibie` (
  `idAfiliadoDibie` int(11) NOT NULL,
  `AfiliadoDibieDesc` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `AfiliadoDibiePorcentaje` int(11) NOT NULL,
  `AfiliadoDibieEstado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `afiliadodibie`
--

INSERT INTO `afiliadodibie` (`idAfiliadoDibie`, `AfiliadoDibieDesc`, `AfiliadoDibiePorcentaje`, `AfiliadoDibieEstado`) VALUES
(1, 'SI', 10, 1),
(2, 'NO', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antiguedad`
--

CREATE TABLE `antiguedad` (
  `id` int(11) NOT NULL,
  `tiempo` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `antiguedad`
--

INSERT INTO `antiguedad` (`id`, `tiempo`) VALUES
(1, 'De 0 a 10 años'),
(2, 'No aplica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `AreaNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `AreaNombre`) VALUES
(1, 'Educacion'),
(2, 'SALUD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cantidadesbeneficio`
--

CREATE TABLE `cantidadesbeneficio` (
  `id` int(11) NOT NULL,
  `CantidadBeneficioNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `CantidadBeneficioPuntaje` int(11) NOT NULL,
  `CantidadesBeneficioEstado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cantidadesbeneficio`
--

INSERT INTO `cantidadesbeneficio` (`id`, `CantidadBeneficioNombre`, `CantidadBeneficioPuntaje`, `CantidadesBeneficioEstado`) VALUES
(1, 'NINGUNO', 20, 1),
(2, '1', 15, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cantidadesbeneficioinst`
--

CREATE TABLE `cantidadesbeneficioinst` (
  `id` int(11) NOT NULL,
  `CantidadesBeneficioDesc` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `CantidadesBeneficioInstPuntaje` int(11) NOT NULL,
  `CantidadesBeneficioInstEstado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cantidadesbeneficioinst`
--

INSERT INTO `cantidadesbeneficioinst` (`id`, `CantidadesBeneficioDesc`, `CantidadesBeneficioInstPuntaje`, `CantidadesBeneficioInstEstado`) VALUES
(1, 'NINGUNO', 20, 1),
(2, '1', 15, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conceptosjunta`
--

CREATE TABLE `conceptosjunta` (
  `id` int(11) NOT NULL,
  `solicitud_id` int(11) DEFAULT NULL,
  `ConceptoJuntaValorB` decimal(12,2) NOT NULL,
  `ConceptoJuntaTiempo` int(11) NOT NULL,
  `ConceptoJuntaValorTotalB` decimal(12,2) NOT NULL,
  `ConceptosJuntaDesc` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `ConceptosJuntaOtorgada` tinyint(1) NOT NULL,
  `ConceptosJuntaNumActa` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `conceptosjunta`
--

INSERT INTO `conceptosjunta` (`id`, `solicitud_id`, `ConceptoJuntaValorB`, `ConceptoJuntaTiempo`, `ConceptoJuntaValorTotalB`, `ConceptosJuntaDesc`, `ConceptosJuntaOtorgada`, `ConceptosJuntaNumActa`) VALUES
(1, NULL, '32132132.00', 21, '64454.00', 'ñokñlkñlkñlk', 1, '54654654');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conceptosvisita`
--

CREATE TABLE `conceptosvisita` (
  `idConceptoVisita` int(11) NOT NULL,
  `ConceptoVisitaNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ConceptosVisitaPuntaje` int(11) NOT NULL,
  `ConceptosVisitaEstado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `conceptosvisita`
--

INSERT INTO `conceptosvisita` (`idConceptoVisita`, `ConceptoVisitaNombre`, `ConceptosVisitaPuntaje`, `ConceptosVisitaEstado`) VALUES
(1, 'Totalmente Veraz', 10, 1),
(2, 'Parcialmente veraz', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadosciviles`
--

CREATE TABLE `estadosciviles` (
  `id` int(11) NOT NULL,
  `EstadoCivilNombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `estadosciviles`
--

INSERT INTO `estadosciviles` (`id`, `EstadoCivilNombre`) VALUES
(1, 'SOLTERO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fos_user_group`
--

CREATE TABLE `fos_user_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fos_user_user`
--

CREATE TABLE `fos_user_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `firstname` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `biography` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_uid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:json)',
  `twitter_uid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:json)',
  `gplus_uid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gplus_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gplus_data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:json)',
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `two_step_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `fos_user_user`
--

INSERT INTO `fos_user_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `created_at`, `updated_at`, `date_of_birth`, `firstname`, `lastname`, `website`, `biography`, `gender`, `locale`, `timezone`, `phone`, `facebook_uid`, `facebook_name`, `facebook_data`, `twitter_uid`, `twitter_name`, `twitter_data`, `gplus_uid`, `gplus_name`, `gplus_data`, `token`, `two_step_code`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', 'admin@admin.com', 1, 'no8cj5c4ybkw4ss0og8kos8kw80kk4o', 'yQgOduDPDfQHagtxy4SJMHm8geKq3LJ9YiL/FKnm88fbDlB61198BUR0Hl3+yBnNgLCorgYd8CSElUsny+s9Ng==', '2018-02-21 20:50:36', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', 0, NULL, '2018-01-09 20:26:50', '2018-02-21 20:50:36', NULL, NULL, NULL, NULL, NULL, 'u', NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, 'null', NULL, NULL, 'null', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fos_user_user_group`
--

CREATE TABLE `fos_user_user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grados`
--

CREATE TABLE `grados` (
  `id` int(11) NOT NULL,
  `GradoNombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `grados`
--

INSERT INTO `grados` (`id`, `GradoNombre`) VALUES
(1, 'Comisario'),
(2, 'Intendente'),
(3, 'Patrullero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `id` int(11) NOT NULL,
  `IngresoNombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `IngresoPuntaje` int(11) NOT NULL,
  `IngresosEstado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ingresos`
--

INSERT INTO `ingresos` (`id`, `IngresoNombre`, `IngresoPuntaje`, `IngresosEstado`) VALUES
(1, '100% salario', 5, 1),
(2, '65% y 99% salario', 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivosdeuda`
--

CREATE TABLE `motivosdeuda` (
  `id` int(11) NOT NULL,
  `MotivoDeudaNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `MotivoDeudaPuntaje` int(11) NOT NULL,
  `MotivoDeudaEstado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `motivosdeuda`
--

INSERT INTO `motivosdeuda` (`id`, `MotivoDeudaNombre`, `MotivoDeudaPuntaje`, `MotivoDeudaEstado`) VALUES
(1, 'Préstamo de Estudio', 15, 1),
(2, 'Préstamo de Estudio', 15, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `otorga`
--

CREATE TABLE `otorga` (
  `id` int(11) NOT NULL,
  `otorga` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `otorga`
--

INSERT INTO `otorga` (`id`, `otorga`) VALUES
(1, 'Si'),
(2, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parentescos`
--

CREATE TABLE `parentescos` (
  `id` int(11) NOT NULL,
  `ParentescoNombre` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `parentescos`
--

INSERT INTO `parentescos` (`id`, `ParentescoNombre`) VALUES
(1, 'PADRES'),
(2, 'HERMANO (A)'),
(3, 'CONYUGUE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personascargo`
--

CREATE TABLE `personascargo` (
  `id` int(11) NOT NULL,
  `PersonaCargoNombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `PersonasCargoPuntaje` int(11) NOT NULL,
  `PersonasCargoEstado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `personascargo`
--

INSERT INTO `personascargo` (`id`, `PersonaCargoNombre`, `PersonasCargoPuntaje`, `PersonasCargoEstado`) VALUES
(1, 'NINGUNA', 5, 1),
(2, '1 o 2', 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poblacionbeneficia`
--

CREATE TABLE `poblacionbeneficia` (
  `id` int(11) NOT NULL,
  `PoblacionBeneficiaDesc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `PoblacionBeneficiaPuntaje` int(11) NOT NULL,
  `PoblacionBeneficiaEstado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `poblacionbeneficia`
--

INSERT INTO `poblacionbeneficia` (`id`, `PoblacionBeneficiaDesc`, `PoblacionBeneficiaPuntaje`, `PoblacionBeneficiaEstado`) VALUES
(1, '0 a 300', 10, 1),
(2, '301 a 600', 15, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id` int(11) NOT NULL,
  `PresupuestoAnio` int(11) NOT NULL,
  `PresupuestoMonto` decimal(10,2) NOT NULL,
  `idArea` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `presupuestos`
--

INSERT INTO `presupuestos` (`id`, `PresupuestoAnio`, `PresupuestoMonto`, `idArea`) VALUES
(1, 12000000, '0.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `id` int(11) NOT NULL,
  `ProgramaNombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `idArea` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `programas`
--

INSERT INTO `programas` (`id`, `ProgramaNombre`, `idArea`) VALUES
(1, 'Plan padrino (Pensión)', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntaje`
--

CREATE TABLE `puntaje` (
  `id` int(11) NOT NULL,
  `valor` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccionales`
--

CREATE TABLE `seccionales` (
  `id` int(11) NOT NULL,
  `SeccionalNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `SeccionalPresupuesto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `seccionales`
--

INSERT INTO `seccionales` (`id`, `SeccionalNombre`, `SeccionalPresupuesto`) VALUES
(1, 'ANTIOQUIA', 0),
(2, 'ATLANTICO', 50000000),
(3, 'BOGOTA', 150000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `situacionesvivienda`
--

CREATE TABLE `situacionesvivienda` (
  `id` int(11) NOT NULL,
  `SituacionViviendaNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `SituacionesViviendaPuntaje` int(11) NOT NULL,
  `SituacionesViviendaEstado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `situacionesvivienda`
--

INSERT INTO `situacionesvivienda` (`id`, `SituacionViviendaNombre`, `SituacionesViviendaPuntaje`, `SituacionesViviendaEstado`) VALUES
(1, 'Propia (sin deuda)', 15, 1),
(2, 'Propia (Hipoteca)', 20, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL,
  `idingreso` int(11) DEFAULT NULL,
  `cantidadesbeneficio_id` int(11) DEFAULT NULL,
  `idtiposolicitud` int(11) DEFAULT NULL,
  `idprogramas` int(11) DEFAULT NULL,
  `idparentesco` int(11) DEFAULT NULL,
  `idviabilidadplaneacion` int(11) DEFAULT NULL,
  `idseccional` int(11) DEFAULT NULL,
  `idpoblacionbeneficia` int(11) DEFAULT NULL,
  `idestadocivil` int(11) DEFAULT NULL,
  `idzonaubicacion` int(11) DEFAULT NULL,
  `idmotivodeuda` int(11) DEFAULT NULL,
  `idcantidadesbeneficioinst` int(11) DEFAULT NULL,
  `idsituacionvivienda` int(11) DEFAULT NULL,
  `idpersonacargo` int(11) DEFAULT NULL,
  `idunidad` int(11) DEFAULT NULL,
  `SolicitudFecha` date NOT NULL,
  `SolicitudCedulaSolicita` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `SolicitudNombreSolicita` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `SolicitudCedulaFuncionario` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `SolicitudDireccionFuncionario` varchar(350) COLLATE utf8_unicode_ci NOT NULL,
  `SolicitudTelefonosFuncionario` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `SolicitudNombreFuncionario` varchar(450) COLLATE utf8_unicode_ci NOT NULL,
  `SolicitudDescripcion` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `SolicitudConceptoPre` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `totalPuntaje` int(11) DEFAULT NULL,
  `archivo` varchar(3000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idConceptoVisita` int(11) DEFAULT NULL,
  `idAfiliadoDibie` int(11) DEFAULT NULL,
  `idGrado` int(11) DEFAULT NULL,
  `concepto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ValorBeneficio` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TiempoBeneficio` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ValortotalBeneficio` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idotorga` int(11) DEFAULT NULL,
  `idantiguedad` int(11) DEFAULT NULL,
  `Acta` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id`, `idingreso`, `cantidadesbeneficio_id`, `idtiposolicitud`, `idprogramas`, `idparentesco`, `idviabilidadplaneacion`, `idseccional`, `idpoblacionbeneficia`, `idestadocivil`, `idzonaubicacion`, `idmotivodeuda`, `idcantidadesbeneficioinst`, `idsituacionvivienda`, `idpersonacargo`, `idunidad`, `SolicitudFecha`, `SolicitudCedulaSolicita`, `SolicitudNombreSolicita`, `SolicitudCedulaFuncionario`, `SolicitudDireccionFuncionario`, `SolicitudTelefonosFuncionario`, `SolicitudNombreFuncionario`, `SolicitudDescripcion`, `SolicitudConceptoPre`, `totalPuntaje`, `archivo`, `idConceptoVisita`, `idAfiliadoDibie`, `idGrado`, `concepto`, `ValorBeneficio`, `TiempoBeneficio`, `ValortotalBeneficio`, `idotorga`, `idantiguedad`, `Acta`) VALUES
(32, 1, 1, 1, 1, 1, 1, 2, 1, 1, 1, 1, NULL, 1, 1, 1, '2018-01-22', '10305424', 'ronald tique', '3654321564', '32432432', '5641354', 'RONALD STEVEN TIQUE', 'sdfsdfsdf', 'APROBADO', 60, '5b59cf36db8c59e3e61bea54399485a0.pdf', 1, 1, 1, '', '540000', '56', NULL, 1, 1, '105'),
(33, NULL, NULL, 2, 1, 1, 1, 2, 1, NULL, 2, NULL, 1, NULL, NULL, 1, '2018-01-22', '105456', 'lkajsdajsd', '103012515412151', 'CDSF45', 'asdasdasdasd', '-lkdsf{fds{ksfd', 'sdfsdfsdf', 'APROBADO', 70, 'b68ac233cb6a638a7fcc0ff02f92ff52.pdf', NULL, NULL, 1, '', '654987', '54', NULL, 1, 1, '654'),
(34, 2, NULL, 2, NULL, 2, NULL, 2, NULL, NULL, NULL, 2, 2, 2, 2, NULL, '2018-03-03', '103054', 'ronald tique', '1030546', 'cl 15 con 54', '321654987', 'ronald tique', 'agdsfkjaskdjfhkjasfd', 'gfddfhfd', 5498756, NULL, 1, 1, 2, NULL, '2342424', '234', NULL, 1, 1, '234234234'),
(35, NULL, NULL, 2, 1, 1, 1, 2, 1, NULL, 1, NULL, 1, NULL, NULL, 2, '2018-01-22', '21321321', 'ronald tique', '34234', 'CDSF45', '5641354', 'ronald steven', 'fdssdfsdfsdfsdf', 'APROBADO', 65, '3f4a773421c8aade63926d4bbcf87bc0.png', 2, NULL, 1, '', '987', '897', NULL, 1, 2, '+654'),
(36, 1, 1, 1, 1, 1, 1, 1, 2, 1, 2, 1, NULL, 1, 1, 1, '2018-01-23', '105456', 'ronald tique', '34234', 'CDSF45', 'asdasdasdasd', '-lkdsf{fds{ksfd', 'fdssdfsdfsdfsdf', 'APROBADO', 60, 'eca5424e2f82130f30eadd8322cea3e4.jpeg', 1, 1, 1, '', '321654', '21', NULL, 1, 1, '654'),
(37, 1, 1, 1, 1, 1, NULL, 2, NULL, 1, NULL, 1, NULL, 1, 2, 1, '2018-02-01', '10305424', 'ronald', '34234', '32432432', '5641354', '-lkdsf{fds{ksfd', 'prueba2', 'APROBADO', 65, '6144ef7a8f01fa14a6781d02b834fb61.pdf', 1, 1, 2, '', '350000', '12', NULL, 1, 1, '0125');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipossolicitud`
--

CREATE TABLE `tipossolicitud` (
  `id` int(11) NOT NULL,
  `TipoSolicitudNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipossolicitud`
--

INSERT INTO `tipossolicitud` (`id`, `TipoSolicitudNombre`) VALUES
(1, 'Familiar y personal'),
(2, 'Institucional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`id`, `nombre`) VALUES
(1, 'OFITE'),
(2, 'OFITE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viabilidadplaneacion`
--

CREATE TABLE `viabilidadplaneacion` (
  `id` int(11) NOT NULL,
  `ViabilidadPlaneacionConcepto` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `ViabilidadPlaneacionPuntaje` int(11) NOT NULL,
  `ViabilidadPlaneacionEstado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `viabilidadplaneacion`
--

INSERT INTO `viabilidadplaneacion` (`id`, `ViabilidadPlaneacionConcepto`, `ViabilidadPlaneacionPuntaje`, `ViabilidadPlaneacionEstado`) VALUES
(1, 'SI', 25, 1),
(2, 'NO', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonasubicacion`
--

CREATE TABLE `zonasubicacion` (
  `id` int(11) NOT NULL,
  `ZonasUbicacionNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ZonasUbicacionPuntaje` int(11) NOT NULL,
  `ZonasUbicacionEstado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `zonasubicacion`
--

INSERT INTO `zonasubicacion` (`id`, `ZonasUbicacionNombre`, `ZonasUbicacionPuntaje`, `ZonasUbicacionEstado`) VALUES
(1, 'URBANA', 10, 1),
(2, 'RURAL', 15, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acl_classes`
--
ALTER TABLE `acl_classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_69DD750638A36066` (`class_type`);

--
-- Indices de la tabla `acl_entries`
--
ALTER TABLE `acl_entries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4` (`class_id`,`object_identity_id`,`field_name`,`ace_order`),
  ADD KEY `IDX_46C8B806EA000B103D9AB4A6DF9183C9` (`class_id`,`object_identity_id`,`security_identity_id`),
  ADD KEY `IDX_46C8B806EA000B10` (`class_id`),
  ADD KEY `IDX_46C8B8063D9AB4A6` (`object_identity_id`),
  ADD KEY `IDX_46C8B806DF9183C9` (`security_identity_id`);

--
-- Indices de la tabla `acl_object_identities`
--
ALTER TABLE `acl_object_identities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9407E5494B12AD6EA000B10` (`object_identifier`,`class_id`),
  ADD KEY `IDX_9407E54977FA751A` (`parent_object_identity_id`);

--
-- Indices de la tabla `acl_object_identity_ancestors`
--
ALTER TABLE `acl_object_identity_ancestors`
  ADD PRIMARY KEY (`object_identity_id`,`ancestor_id`),
  ADD KEY `IDX_825DE2993D9AB4A6` (`object_identity_id`),
  ADD KEY `IDX_825DE299C671CEA1` (`ancestor_id`);

--
-- Indices de la tabla `acl_security_identities`
--
ALTER TABLE `acl_security_identities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8835EE78772E836AF85E0677` (`identifier`,`username`);

--
-- Indices de la tabla `afiliadodibie`
--
ALTER TABLE `afiliadodibie`
  ADD PRIMARY KEY (`idAfiliadoDibie`);

--
-- Indices de la tabla `antiguedad`
--
ALTER TABLE `antiguedad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cantidadesbeneficio`
--
ALTER TABLE `cantidadesbeneficio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cantidadesbeneficioinst`
--
ALTER TABLE `cantidadesbeneficioinst`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `conceptosjunta`
--
ALTER TABLE `conceptosjunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ConceptosJunta_Solicitudes1_idx` (`solicitud_id`);

--
-- Indices de la tabla `conceptosvisita`
--
ALTER TABLE `conceptosvisita`
  ADD PRIMARY KEY (`idConceptoVisita`);

--
-- Indices de la tabla `estadosciviles`
--
ALTER TABLE `estadosciviles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fos_user_group`
--
ALTER TABLE `fos_user_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_583D1F3E5E237E06` (`name`);

--
-- Indices de la tabla `fos_user_user`
--
ALTER TABLE `fos_user_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C560D76192FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_C560D761A0D96FBF` (`email_canonical`);

--
-- Indices de la tabla `fos_user_user_group`
--
ALTER TABLE `fos_user_user_group`
  ADD PRIMARY KEY (`user_id`,`group_id`),
  ADD KEY `IDX_B3C77447A76ED395` (`user_id`),
  ADD KEY `IDX_B3C77447FE54D947` (`group_id`);

--
-- Indices de la tabla `grados`
--
ALTER TABLE `grados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `motivosdeuda`
--
ALTER TABLE `motivosdeuda`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `otorga`
--
ALTER TABLE `otorga`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `parentescos`
--
ALTER TABLE `parentescos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personascargo`
--
ALTER TABLE `personascargo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `poblacionbeneficia`
--
ALTER TABLE `poblacionbeneficia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4CF2F0DA46963F6` (`idArea`),
  ADD KEY `fk_Presupuestos_Areas1_idx` (`id`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Programas_Areas_idx` (`idArea`);

--
-- Indices de la tabla `puntaje`
--
ALTER TABLE `puntaje`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seccionales`
--
ALTER TABLE `seccionales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `situacionesvivienda`
--
ALTER TABLE `situacionesvivienda`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_216D110975B7D83` (`idunidad`),
  ADD KEY `IDX_216D11013BA3729` (`cantidadesbeneficio_id`),
  ADD KEY `IDX_216D110BAA72B5A` (`idcantidadesbeneficioinst`),
  ADD KEY `IDX_216D1109E157E4C` (`idestadocivil`),
  ADD KEY `IDX_216D110AE4B0437` (`idGrado`),
  ADD KEY `IDX_216D110139F7671` (`idingreso`),
  ADD KEY `IDX_216D110B4FB73C` (`idmotivodeuda`),
  ADD KEY `IDX_216D11053B72D2C` (`idparentesco`),
  ADD KEY `IDX_216D110EF075161` (`idpersonacargo`),
  ADD KEY `IDX_216D11079D71D30` (`idpoblacionbeneficia`),
  ADD KEY `IDX_216D1101BA6EA57` (`idprogramas`),
  ADD KEY `IDX_216D11070C5A4CE` (`idseccional`),
  ADD KEY `IDX_216D110E9FCC173` (`idsituacionvivienda`),
  ADD KEY `IDX_216D110174D74B2` (`idtiposolicitud`),
  ADD KEY `IDX_216D11069A00F34` (`idviabilidadplaneacion`),
  ADD KEY `IDX_216D110AA18F2E4` (`idzonaubicacion`),
  ADD KEY `fk_Solicitudes_Seccionales1_idx` (`id`),
  ADD KEY `fk_Solicitudes_Parentescos1_idx` (`id`),
  ADD KEY `fk_Solicitudes_Grados1_idx` (`id`),
  ADD KEY `fk_Solicitudes_Programas1_idx` (`id`),
  ADD KEY `fk_Solicitudes_TiposSolicitud1_idx` (`id`),
  ADD KEY `fk_Solicitudes_EstadosCiviles1_idx` (`id`),
  ADD KEY `fk_Solicitudes_Ingresos1_idx` (`id`),
  ADD KEY `fk_Solicitudes_PersonasCargo1_idx` (`id`),
  ADD KEY `fk_Solicitudes_SituacionesVivienda1_idx` (`id`),
  ADD KEY `fk_Solicitudes_MotivosDeuda1_idx` (`id`),
  ADD KEY `fk_Solicitudes_CantidadesBeneficio1_idx` (`id`),
  ADD KEY `fk_Solicitudes_ConceptosVisita1_idx` (`idConceptoVisita`),
  ADD KEY `fk_Solicitudes_CantidadesBeneficioInst1_idx` (`id`),
  ADD KEY `fk_Solicitudes_ViabilidadPlaneacion1_idx` (`id`),
  ADD KEY `fk_Solicitudes_ZonasUbicacion1_idx` (`id`),
  ADD KEY `fk_Solicitudes_PoblacionBeneficia1_idx` (`id`),
  ADD KEY `fk_Solicitudes_AfiliadoDibie1_idx` (`idAfiliadoDibie`),
  ADD KEY `IDX_216D1104B6004A` (`idotorga`),
  ADD KEY `IDX_216D110E34F1D5F` (`idantiguedad`);

--
-- Indices de la tabla `tipossolicitud`
--
ALTER TABLE `tipossolicitud`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `viabilidadplaneacion`
--
ALTER TABLE `viabilidadplaneacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zonasubicacion`
--
ALTER TABLE `zonasubicacion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acl_classes`
--
ALTER TABLE `acl_classes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `acl_entries`
--
ALTER TABLE `acl_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `acl_object_identities`
--
ALTER TABLE `acl_object_identities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `acl_security_identities`
--
ALTER TABLE `acl_security_identities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `afiliadodibie`
--
ALTER TABLE `afiliadodibie`
  MODIFY `idAfiliadoDibie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `antiguedad`
--
ALTER TABLE `antiguedad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cantidadesbeneficio`
--
ALTER TABLE `cantidadesbeneficio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cantidadesbeneficioinst`
--
ALTER TABLE `cantidadesbeneficioinst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `conceptosjunta`
--
ALTER TABLE `conceptosjunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `conceptosvisita`
--
ALTER TABLE `conceptosvisita`
  MODIFY `idConceptoVisita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estadosciviles`
--
ALTER TABLE `estadosciviles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `fos_user_group`
--
ALTER TABLE `fos_user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fos_user_user`
--
ALTER TABLE `fos_user_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `grados`
--
ALTER TABLE `grados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `motivosdeuda`
--
ALTER TABLE `motivosdeuda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `otorga`
--
ALTER TABLE `otorga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `parentescos`
--
ALTER TABLE `parentescos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `personascargo`
--
ALTER TABLE `personascargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `poblacionbeneficia`
--
ALTER TABLE `poblacionbeneficia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `puntaje`
--
ALTER TABLE `puntaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seccionales`
--
ALTER TABLE `seccionales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `situacionesvivienda`
--
ALTER TABLE `situacionesvivienda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `tipossolicitud`
--
ALTER TABLE `tipossolicitud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `viabilidadplaneacion`
--
ALTER TABLE `viabilidadplaneacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `zonasubicacion`
--
ALTER TABLE `zonasubicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acl_entries`
--
ALTER TABLE `acl_entries`
  ADD CONSTRAINT `FK_46C8B8063D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_46C8B806DF9183C9` FOREIGN KEY (`security_identity_id`) REFERENCES `acl_security_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_46C8B806EA000B10` FOREIGN KEY (`class_id`) REFERENCES `acl_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `acl_object_identities`
--
ALTER TABLE `acl_object_identities`
  ADD CONSTRAINT `FK_9407E54977FA751A` FOREIGN KEY (`parent_object_identity_id`) REFERENCES `acl_object_identities` (`id`);

--
-- Filtros para la tabla `acl_object_identity_ancestors`
--
ALTER TABLE `acl_object_identity_ancestors`
  ADD CONSTRAINT `FK_825DE2993D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_825DE299C671CEA1` FOREIGN KEY (`ancestor_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `conceptosjunta`
--
ALTER TABLE `conceptosjunta`
  ADD CONSTRAINT `FK_A32277CD1CB9D6E4` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`);

--
-- Filtros para la tabla `fos_user_user_group`
--
ALTER TABLE `fos_user_user_group`
  ADD CONSTRAINT `FK_B3C77447A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B3C77447FE54D947` FOREIGN KEY (`group_id`) REFERENCES `fos_user_group` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD CONSTRAINT `FK_4CF2F0DA46963F6` FOREIGN KEY (`idArea`) REFERENCES `areas` (`id`);

--
-- Filtros para la tabla `programas`
--
ALTER TABLE `programas`
  ADD CONSTRAINT `FK_65BD43A2A46963F6` FOREIGN KEY (`idArea`) REFERENCES `areas` (`id`);

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `FK_216D110139F7671` FOREIGN KEY (`idingreso`) REFERENCES `ingresos` (`id`),
  ADD CONSTRAINT `FK_216D11013BA3729` FOREIGN KEY (`cantidadesbeneficio_id`) REFERENCES `cantidadesbeneficio` (`id`),
  ADD CONSTRAINT `FK_216D110174D74B2` FOREIGN KEY (`idtiposolicitud`) REFERENCES `tipossolicitud` (`id`),
  ADD CONSTRAINT `FK_216D1101BA6EA57` FOREIGN KEY (`idprogramas`) REFERENCES `programas` (`id`),
  ADD CONSTRAINT `FK_216D1104B6004A` FOREIGN KEY (`idotorga`) REFERENCES `otorga` (`id`),
  ADD CONSTRAINT `FK_216D1104FDB3952` FOREIGN KEY (`idConceptoVisita`) REFERENCES `conceptosvisita` (`idConceptoVisita`),
  ADD CONSTRAINT `FK_216D11053B72D2C` FOREIGN KEY (`idparentesco`) REFERENCES `parentescos` (`id`),
  ADD CONSTRAINT `FK_216D11069A00F34` FOREIGN KEY (`idviabilidadplaneacion`) REFERENCES `viabilidadplaneacion` (`id`),
  ADD CONSTRAINT `FK_216D11070C5A4CE` FOREIGN KEY (`idseccional`) REFERENCES `seccionales` (`id`),
  ADD CONSTRAINT `FK_216D11072EBC208` FOREIGN KEY (`idAfiliadoDibie`) REFERENCES `afiliadodibie` (`idAfiliadoDibie`),
  ADD CONSTRAINT `FK_216D11079D71D30` FOREIGN KEY (`idpoblacionbeneficia`) REFERENCES `poblacionbeneficia` (`id`),
  ADD CONSTRAINT `FK_216D110975B7D83` FOREIGN KEY (`idunidad`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `FK_216D1109E157E4C` FOREIGN KEY (`idestadocivil`) REFERENCES `estadosciviles` (`id`),
  ADD CONSTRAINT `FK_216D110AA18F2E4` FOREIGN KEY (`idzonaubicacion`) REFERENCES `zonasubicacion` (`id`),
  ADD CONSTRAINT `FK_216D110AE4B0437` FOREIGN KEY (`idGrado`) REFERENCES `grados` (`id`),
  ADD CONSTRAINT `FK_216D110B4FB73C` FOREIGN KEY (`idmotivodeuda`) REFERENCES `motivosdeuda` (`id`),
  ADD CONSTRAINT `FK_216D110BAA72B5A` FOREIGN KEY (`idcantidadesbeneficioinst`) REFERENCES `cantidadesbeneficioinst` (`id`),
  ADD CONSTRAINT `FK_216D110E34F1D5F` FOREIGN KEY (`idantiguedad`) REFERENCES `antiguedad` (`id`),
  ADD CONSTRAINT `FK_216D110E9FCC173` FOREIGN KEY (`idsituacionvivienda`) REFERENCES `situacionesvivienda` (`id`),
  ADD CONSTRAINT `FK_216D110EF075161` FOREIGN KEY (`idpersonacargo`) REFERENCES `personascargo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
