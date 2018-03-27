-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: proyecto_aos
-- ------------------------------------------------------
-- Server version	5.7.18-1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `acl_classes`
--

DROP TABLE IF EXISTS `acl_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_69DD750638A36066` (`class_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_classes`
--

LOCK TABLES `acl_classes` WRITE;
/*!40000 ALTER TABLE `acl_classes` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_entries`
--

DROP TABLE IF EXISTS `acl_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(10) unsigned NOT NULL,
  `object_identity_id` int(10) unsigned DEFAULT NULL,
  `security_identity_id` int(10) unsigned NOT NULL,
  `field_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ace_order` smallint(5) unsigned NOT NULL,
  `mask` int(11) NOT NULL,
  `granting` tinyint(1) NOT NULL,
  `granting_strategy` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `audit_success` tinyint(1) NOT NULL,
  `audit_failure` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4` (`class_id`,`object_identity_id`,`field_name`,`ace_order`),
  KEY `IDX_46C8B806EA000B103D9AB4A6DF9183C9` (`class_id`,`object_identity_id`,`security_identity_id`),
  KEY `IDX_46C8B806EA000B10` (`class_id`),
  KEY `IDX_46C8B8063D9AB4A6` (`object_identity_id`),
  KEY `IDX_46C8B806DF9183C9` (`security_identity_id`),
  CONSTRAINT `FK_46C8B8063D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_46C8B806DF9183C9` FOREIGN KEY (`security_identity_id`) REFERENCES `acl_security_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_46C8B806EA000B10` FOREIGN KEY (`class_id`) REFERENCES `acl_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_entries`
--

LOCK TABLES `acl_entries` WRITE;
/*!40000 ALTER TABLE `acl_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_object_identities`
--

DROP TABLE IF EXISTS `acl_object_identities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_object_identities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_object_identity_id` int(10) unsigned DEFAULT NULL,
  `class_id` int(10) unsigned NOT NULL,
  `object_identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `entries_inheriting` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9407E5494B12AD6EA000B10` (`object_identifier`,`class_id`),
  KEY `IDX_9407E54977FA751A` (`parent_object_identity_id`),
  CONSTRAINT `FK_9407E54977FA751A` FOREIGN KEY (`parent_object_identity_id`) REFERENCES `acl_object_identities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_object_identities`
--

LOCK TABLES `acl_object_identities` WRITE;
/*!40000 ALTER TABLE `acl_object_identities` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl_object_identities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_object_identity_ancestors`
--

DROP TABLE IF EXISTS `acl_object_identity_ancestors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_object_identity_ancestors` (
  `object_identity_id` int(10) unsigned NOT NULL,
  `ancestor_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`object_identity_id`,`ancestor_id`),
  KEY `IDX_825DE2993D9AB4A6` (`object_identity_id`),
  KEY `IDX_825DE299C671CEA1` (`ancestor_id`),
  CONSTRAINT `FK_825DE2993D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_825DE299C671CEA1` FOREIGN KEY (`ancestor_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_object_identity_ancestors`
--

LOCK TABLES `acl_object_identity_ancestors` WRITE;
/*!40000 ALTER TABLE `acl_object_identity_ancestors` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl_object_identity_ancestors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_security_identities`
--

DROP TABLE IF EXISTS `acl_security_identities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_security_identities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `username` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8835EE78772E836AF85E0677` (`identifier`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_security_identities`
--

LOCK TABLES `acl_security_identities` WRITE;
/*!40000 ALTER TABLE `acl_security_identities` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl_security_identities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `afiliadodibie`
--

DROP TABLE IF EXISTS `afiliadodibie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `afiliadodibie` (
  `idAfiliadoDibie` int(11) NOT NULL AUTO_INCREMENT,
  `AfiliadoDibieDesc` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `AfiliadoDibiePorcentaje` int(11) NOT NULL,
  `AfiliadoDibieEstado` tinyint(1) NOT NULL,
  PRIMARY KEY (`idAfiliadoDibie`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `afiliadodibie`
--

LOCK TABLES `afiliadodibie` WRITE;
/*!40000 ALTER TABLE `afiliadodibie` DISABLE KEYS */;
INSERT INTO `afiliadodibie` VALUES (1,'SI',10,1),(2,'NO',0,1);
/*!40000 ALTER TABLE `afiliadodibie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `antiguedad`
--

DROP TABLE IF EXISTS `antiguedad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `antiguedad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tiempo` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `antiguedad`
--

LOCK TABLES `antiguedad` WRITE;
/*!40000 ALTER TABLE `antiguedad` DISABLE KEYS */;
INSERT INTO `antiguedad` VALUES (1,'1'),(2,'2'),(3,'3'),(4,'4');
/*!40000 ALTER TABLE `antiguedad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `AreaNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES (2,'Educación'),(3,'Salud'),(4,'Bienestar');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cantidadesbeneficio`
--

DROP TABLE IF EXISTS `cantidadesbeneficio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cantidadesbeneficio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CantidadBeneficioNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `CantidadBeneficioPuntaje` int(11) NOT NULL,
  `CantidadesBeneficioEstado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cantidadesbeneficio`
--

LOCK TABLES `cantidadesbeneficio` WRITE;
/*!40000 ALTER TABLE `cantidadesbeneficio` DISABLE KEYS */;
INSERT INTO `cantidadesbeneficio` VALUES (2,'NINGUNO',20,1),(3,'1',15,1),(4,'2',10,1),(5,'3',5,1),(6,'4 o mas',0,1),(7,'2 o más SALUD',20,1);
/*!40000 ALTER TABLE `cantidadesbeneficio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cantidadesbeneficioinst`
--

DROP TABLE IF EXISTS `cantidadesbeneficioinst`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cantidadesbeneficioinst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CantidadesBeneficioDesc` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `CantidadesBeneficioInstPuntaje` int(11) NOT NULL,
  `CantidadesBeneficioInstEstado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cantidadesbeneficioinst`
--

LOCK TABLES `cantidadesbeneficioinst` WRITE;
/*!40000 ALTER TABLE `cantidadesbeneficioinst` DISABLE KEYS */;
INSERT INTO `cantidadesbeneficioinst` VALUES (1,'NINGUNO',20,1),(2,'1',15,1),(3,'2',10,1),(4,'3',5,1),(5,'4 o mas',0,1);
/*!40000 ALTER TABLE `cantidadesbeneficioinst` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `concepto`
--

DROP TABLE IF EXISTS `concepto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `concepto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `concepto`
--

LOCK TABLES `concepto` WRITE;
/*!40000 ALTER TABLE `concepto` DISABLE KEYS */;
/*!40000 ALTER TABLE `concepto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conceptosjunta`
--

DROP TABLE IF EXISTS `conceptosjunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conceptosjunta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `solicitud_id` int(11) DEFAULT NULL,
  `ConceptoJuntaValorB` decimal(12,2) DEFAULT NULL,
  `ConceptoJuntaTiempo` int(11) DEFAULT NULL,
  `ConceptoJuntaValorTotalB` decimal(12,2) DEFAULT NULL,
  `ConceptosJuntaDesc` varchar(3000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ConceptosJuntaOtorgada` tinyint(1) DEFAULT NULL,
  `ConceptosJuntaNumActa` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `aprobado` tinyint(1) DEFAULT NULL,
  `editado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ConceptosJunta_Solicitudes1_idx` (`solicitud_id`),
  CONSTRAINT `FK_A32277CD1CB9D6E4` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conceptosjunta`
--

LOCK TABLES `conceptosjunta` WRITE;
/*!40000 ALTER TABLE `conceptosjunta` DISABLE KEYS */;
INSERT INTO `conceptosjunta` VALUES (1,1,NULL,3,300000.00,'se aprueban 3 meses',NULL,'123123',1,1),(2,2,NULL,2,200000.00,'se aprueba esta joda',NULL,'123456',1,NULL);
/*!40000 ALTER TABLE `conceptosjunta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conceptosvisita`
--

DROP TABLE IF EXISTS `conceptosvisita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conceptosvisita` (
  `idConceptoVisita` int(11) NOT NULL AUTO_INCREMENT,
  `ConceptoVisitaNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ConceptosVisitaPuntaje` int(11) NOT NULL,
  `ConceptosVisitaEstado` tinyint(1) NOT NULL,
  PRIMARY KEY (`idConceptoVisita`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conceptosvisita`
--

LOCK TABLES `conceptosvisita` WRITE;
/*!40000 ALTER TABLE `conceptosvisita` DISABLE KEYS */;
INSERT INTO `conceptosvisita` VALUES (2,'Favorable',20,1),(3,'Desfavorable',10,1),(4,'No se pudo verificar',0,1);
/*!40000 ALTER TABLE `conceptosvisita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estadosciviles`
--

DROP TABLE IF EXISTS `estadosciviles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estadosciviles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `EstadoCivilNombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estadosciviles`
--

LOCK TABLES `estadosciviles` WRITE;
/*!40000 ALTER TABLE `estadosciviles` DISABLE KEYS */;
INSERT INTO `estadosciviles` VALUES (1,'Casado (a)'),(2,'Soltero (a)'),(3,'Unión libre'),(4,'Viudo (a)'),(5,'Separado (a)'),(6,'Nueva unión'),(7,'Madre o Padre Cabeza de hogar');
/*!40000 ALTER TABLE `estadosciviles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_user_group`
--

DROP TABLE IF EXISTS `fos_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fos_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_583D1F3E5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_user_group`
--

LOCK TABLES `fos_user_group` WRITE;
/*!40000 ALTER TABLE `fos_user_group` DISABLE KEYS */;
INSERT INTO `fos_user_group` VALUES (1,'Barranquilla','a:0:{}');
/*!40000 ALTER TABLE `fos_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_user_user`
--

DROP TABLE IF EXISTS `fos_user_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fos_user_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `two_step_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C560D76192FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_C560D761A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_user_user`
--

LOCK TABLES `fos_user_user` WRITE;
/*!40000 ALTER TABLE `fos_user_user` DISABLE KEYS */;
INSERT INTO `fos_user_user` VALUES (1,'admin','admin','admin@admin.com','admin@admin.com',1,'84uelsxl70w8k4go4ck04gsc0880oc4','sbtNIH/MG5PQ+BMs1nNA0RzS16l1dyqHGlB0abO7xqt0abd7gwrHrScRS4KyaVTxkFEBmJxG+gBa2Lb2epjVHQ==','2018-03-20 22:14:14',0,0,NULL,NULL,NULL,'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}',0,NULL,'2017-12-04 23:09:38','2018-03-20 22:14:14',NULL,NULL,NULL,NULL,NULL,'u',NULL,NULL,NULL,NULL,NULL,'null',NULL,NULL,'null',NULL,NULL,'null',NULL,NULL),(2,'Barranquilla','barranquilla','ronald.tique1688@correo.policia.gov.co','ronald.tique1688@correo.policia.gov.co',1,'3dzw09y0h1gk8csoscc4wwcgssggk0s','azRLb6SiDfwhIf7mCwIvOIZBlO1AGU035AQ7aG1cH+NMJz9bAKw+7lU4iQSUcCjDEqeBF9m7DKXsgfY09SLe6A==','2017-12-07 23:39:39',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,'2017-12-07 22:58:37','2017-12-07 23:39:39',NULL,NULL,NULL,NULL,NULL,'u',NULL,NULL,NULL,NULL,NULL,'null',NULL,NULL,'null',NULL,NULL,'null',NULL,NULL);
/*!40000 ALTER TABLE `fos_user_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_user_user_group`
--

DROP TABLE IF EXISTS `fos_user_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fos_user_user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `IDX_B3C77447A76ED395` (`user_id`),
  KEY `IDX_B3C77447FE54D947` (`group_id`),
  CONSTRAINT `FK_B3C77447A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_B3C77447FE54D947` FOREIGN KEY (`group_id`) REFERENCES `fos_user_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_user_user_group`
--

LOCK TABLES `fos_user_user_group` WRITE;
/*!40000 ALTER TABLE `fos_user_user_group` DISABLE KEYS */;
INSERT INTO `fos_user_user_group` VALUES (2,1);
/*!40000 ALTER TABLE `fos_user_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grados`
--

DROP TABLE IF EXISTS `grados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `GradoNombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grados`
--

LOCK TABLES `grados` WRITE;
/*!40000 ALTER TABLE `grados` DISABLE KEYS */;
INSERT INTO `grados` VALUES (3,'Coronel'),(4,'Teniente Coronel'),(5,'Mayor'),(6,'Capitán'),(7,'Teniente'),(8,'Subteniente'),(9,'Comisario'),(10,'Subcomisario'),(11,'Intendente Jefe'),(12,'Intendente'),(13,'Subintendente'),(14,'Patrullero'),(15,'No uniformado'),(20,'Auxuliar de Policía'),(21,'Estudiante'),(22,'Suboficial ® menos de 5 años'),(23,'Suboficial ® mas de 5 años'),(24,'Oficial ® menos de 5 años'),(25,'Oficial ® mas de 5 años'),(26,'Agente ® mas de 5 años'),(27,'Agente ® menos de 5 años'),(28,'No uniformado ® mas de 5 años'),(29,'No uniformado ® menos de 5 años'),(30,'Fallecido menos de 5 años'),(31,'Fallecido mas de 5 años');
/*!40000 ALTER TABLE `grados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingresos`
--

DROP TABLE IF EXISTS `ingresos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IngresoNombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `IngresoPuntaje` int(11) NOT NULL,
  `IngresosEstado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingresos`
--

LOCK TABLES `ingresos` WRITE;
/*!40000 ALTER TABLE `ingresos` DISABLE KEYS */;
INSERT INTO `ingresos` VALUES (1,'100% salario',5,1),(2,'65% y 99% salario',10,1),(3,'50% y 64% salario',15,1),(4,'Salario más Ingresos familiares',5,1),(5,'Menos del 50% del salario',10,1);
/*!40000 ALTER TABLE `ingresos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motivosdeuda`
--

DROP TABLE IF EXISTS `motivosdeuda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motivosdeuda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MotivoDeudaNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `MotivoDeudaPuntaje` int(11) NOT NULL,
  `MotivoDeudaEstado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motivosdeuda`
--

LOCK TABLES `motivosdeuda` WRITE;
/*!40000 ALTER TABLE `motivosdeuda` DISABLE KEYS */;
INSERT INTO `motivosdeuda` VALUES (1,'Préstamo de Estudio',15,1),(2,'Gastos Suntuosos',10,1),(3,'Préstamo Vivienda',15,1),(4,'Embargo por un prestamo',15,1),(5,'Embargo por servir de codeudor',15,1),(6,'Embargo por alimentos',15,1),(7,'Problemas médicos',15,1),(8,'Desastre Natural',15,1),(9,'Desastre Antrópico',15,1),(10,'Atentado terrorista',10,1),(11,'Cambio familiares no planificados',10,1),(12,'Mala planificación de las finanzas de hogar',10,1),(13,'Quiebra económica negocios particulares',10,1),(14,'Fue objeto de hurto',10,1);
/*!40000 ALTER TABLE `motivosdeuda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimiento`
--

DROP TABLE IF EXISTS `movimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `concepto_junta_id` int(11) DEFAULT NULL,
  `seccional_id` int(11) DEFAULT NULL,
  `presupuesto_id` int(11) DEFAULT NULL,
  `valor` int(11) NOT NULL,
  `tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C8FF107A2EED1FE2` (`concepto_junta_id`),
  KEY `IDX_C8FF107A9ABA4ED1` (`seccional_id`),
  KEY `IDX_C8FF107A90119F0F` (`presupuesto_id`),
  CONSTRAINT `FK_C8FF107A2EED1FE2` FOREIGN KEY (`concepto_junta_id`) REFERENCES `conceptosjunta` (`id`),
  CONSTRAINT `FK_C8FF107A90119F0F` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuestos` (`id`),
  CONSTRAINT `FK_C8FF107A9ABA4ED1` FOREIGN KEY (`seccional_id`) REFERENCES `seccionales` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimiento`
--

LOCK TABLES `movimiento` WRITE;
/*!40000 ALTER TABLE `movimiento` DISABLE KEYS */;
INSERT INTO `movimiento` VALUES (1,1,1,3,0,'Débito'),(2,1,1,3,0,'Débito'),(3,1,1,3,0,'Débito'),(4,1,1,1,0,'Débito'),(5,1,1,1,0,'Débito'),(6,1,1,3,60000,'Débito'),(7,1,1,3,60000,'Débito'),(8,1,1,3,60000,'Débito'),(9,1,1,1,60000,'Débito'),(10,1,1,1,60000,'Débito'),(11,2,2,4,40000,'Débito'),(12,2,2,4,40000,'Débito'),(13,2,2,5,40000,'Débito'),(14,2,2,5,40000,'Débito'),(15,2,2,5,40000,'Débito');
/*!40000 ALTER TABLE `movimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `otorga`
--

DROP TABLE IF EXISTS `otorga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `otorga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `otorga` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `otorga`
--

LOCK TABLES `otorga` WRITE;
/*!40000 ALTER TABLE `otorga` DISABLE KEYS */;
/*!40000 ALTER TABLE `otorga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parentescos`
--

DROP TABLE IF EXISTS `parentescos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parentescos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ParentescoNombre` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parentescos`
--

LOCK TABLES `parentescos` WRITE;
/*!40000 ALTER TABLE `parentescos` DISABLE KEYS */;
INSERT INTO `parentescos` VALUES (1,'PADRES'),(2,'HERMANO (A)'),(3,'CONYUGUE'),(4,'COMPAÑERO  (A) DE TRABAJO'),(5,'COMPAÑERO  (A) PERMANENTE'),(6,'NIETO  (A)'),(7,'OTRO'),(8,'COMANDANTE'),(9,'OTRO'),(10,'NO APLICA');
/*!40000 ALTER TABLE `parentescos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personascargo`
--

DROP TABLE IF EXISTS `personascargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personascargo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PersonaCargoNombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `PersonasCargoPuntaje` int(11) NOT NULL,
  `PersonasCargoEstado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personascargo`
--

LOCK TABLES `personascargo` WRITE;
/*!40000 ALTER TABLE `personascargo` DISABLE KEYS */;
INSERT INTO `personascargo` VALUES (1,'NINGUNA',5,1),(2,'1 o 2',10,1),(3,'3',15,1),(4,'4 o más',15,1);
/*!40000 ALTER TABLE `personascargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poblacionbeneficia`
--

DROP TABLE IF EXISTS `poblacionbeneficia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poblacionbeneficia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PoblacionBeneficiaDesc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `PoblacionBeneficiaPuntaje` int(11) NOT NULL,
  `PoblacionBeneficiaEstado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poblacionbeneficia`
--

LOCK TABLES `poblacionbeneficia` WRITE;
/*!40000 ALTER TABLE `poblacionbeneficia` DISABLE KEYS */;
INSERT INTO `poblacionbeneficia` VALUES (2,'0 a 300',10,1),(3,'301 a 600',15,1),(4,'601 a 1000',20,1),(5,'1001 a 2000',25,1);
/*!40000 ALTER TABLE `poblacionbeneficia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presupuestos`
--

DROP TABLE IF EXISTS `presupuestos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `presupuestos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PresupuestoMonto` bigint(20) NOT NULL,
  `idArea` int(11) DEFAULT NULL,
  `seccional_id` int(11) DEFAULT NULL,
  `saldo` bigint(20) NOT NULL,
  `desde` date DEFAULT NULL,
  `hasta` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4CF2F0DA46963F6` (`idArea`),
  KEY `fk_Presupuestos_Areas1_idx` (`id`),
  KEY `IDX_4CF2F0D9ABA4ED1` (`seccional_id`),
  CONSTRAINT `FK_4CF2F0D9ABA4ED1` FOREIGN KEY (`seccional_id`) REFERENCES `seccionales` (`id`),
  CONSTRAINT `FK_4CF2F0DA46963F6` FOREIGN KEY (`idArea`) REFERENCES `areas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presupuestos`
--

LOCK TABLES `presupuestos` WRITE;
/*!40000 ALTER TABLE `presupuestos` DISABLE KEYS */;
INSERT INTO `presupuestos` VALUES (1,5000000,2,1,4880000,'2018-01-01','2018-06-30'),(2,5000000,3,1,5000000,'2018-01-01','2018-06-30'),(3,5000000,4,1,4820000,'2018-01-01','2018-06-30'),(4,5000000,4,2,4920000,'2018-01-01','2018-03-31'),(5,5000000,2,2,4880000,'2018-01-01','2018-06-30');
/*!40000 ALTER TABLE `presupuestos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programa_concepto`
--

DROP TABLE IF EXISTS `programa_concepto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programa_concepto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `concepto_junta_id` int(11) DEFAULT NULL,
  `programa_id` int(11) DEFAULT NULL,
  `aprobado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6A4B8EE42EED1FE2` (`concepto_junta_id`),
  KEY `IDX_6A4B8EE4FD8A7328` (`programa_id`),
  CONSTRAINT `FK_6A4B8EE42EED1FE2` FOREIGN KEY (`concepto_junta_id`) REFERENCES `conceptosjunta` (`id`),
  CONSTRAINT `FK_6A4B8EE4FD8A7328` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programa_concepto`
--

LOCK TABLES `programa_concepto` WRITE;
/*!40000 ALTER TABLE `programa_concepto` DISABLE KEYS */;
INSERT INTO `programa_concepto` VALUES (1,1,24,0),(2,1,25,0),(3,1,23,0),(4,1,6,0),(5,1,10,0),(6,2,24,0),(7,2,25,0),(8,2,6,0),(9,2,10,0),(10,2,7,0);
/*!40000 ALTER TABLE `programa_concepto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programa_solicitud`
--

DROP TABLE IF EXISTS `programa_solicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programa_solicitud` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `programa_id` int(11) DEFAULT NULL,
  `solicitud_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B7684073FD8A7328` (`programa_id`),
  KEY `IDX_B76840731CB9D6E4` (`solicitud_id`),
  CONSTRAINT `FK_B76840731CB9D6E4` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`),
  CONSTRAINT `FK_B7684073FD8A7328` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programa_solicitud`
--

LOCK TABLES `programa_solicitud` WRITE;
/*!40000 ALTER TABLE `programa_solicitud` DISABLE KEYS */;
INSERT INTO `programa_solicitud` VALUES (1,24,1),(2,25,1),(3,23,1),(4,6,1),(5,10,1),(6,24,2),(7,25,2),(8,6,2),(9,10,2),(10,7,2);
/*!40000 ALTER TABLE `programa_solicitud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programas`
--

DROP TABLE IF EXISTS `programas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ProgramaNombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `idArea` int(11) DEFAULT NULL,
  `valor_mes` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Programas_Areas_idx` (`idArea`),
  CONSTRAINT `FK_65BD43A2A46963F6` FOREIGN KEY (`idArea`) REFERENCES `areas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programas`
--

LOCK TABLES `programas` WRITE;
/*!40000 ALTER TABLE `programas` DISABLE KEYS */;
INSERT INTO `programas` VALUES (1,'Plan padrino (Pensión) - Educación',2,20000),(2,'Plan padrino (Uniformes) - Educación',2,20000),(3,'Plan padrino (Bono Escolar) - Educación',2,20000),(4,'Plan padrino (Refrigerio) - Educación',2,20000),(5,'Plan padrino (Transporte) - Educación',2,20000),(6,'Valentina te sonrie (Pensión) - Educación',2,20000),(7,'Valentina te sonrie (Uniformes) - Educación',2,20000),(8,'Valentina te sonrie (Bono Escolar) - Educación',2,20000),(9,'Valentina te sonrie (Refrigerio) - Educación',2,20000),(10,'Valentina te sonrie (Transporte) - Educación',2,20000),(11,'Programa Capacitación - Educación',2,20000),(12,'Otro (Programa Educación)',2,20000),(13,'Mercado nutricional - Salud',3,20000),(14,'Pañales niños y adultos - Salud',3,20000),(15,'Leche (ensure o especial) 0  - 6 meses - Salud',3,20000),(16,'Leche (ensure o especial)  6 meses en adelante - Salud',3,20000),(17,'Pañitos y cremas (antiescaras) - Salud',3,20000),(18,'Otro (Programa Salud)',3,20000),(19,'Apoyo en mercado - Bienestar',4,20000),(20,'Apoyo pañales 0-6 meses - Bienestar',4,20000),(21,'Apoyo pañales 6-12 meses - Bienestar',4,20000),(22,'Apoyo pañales 1-2 años - Bienestar',4,20000),(23,'Apoyo leche maternizada - Bienestar',4,20000),(24,'Apoyo elementos de primera necesidad por calamidad o desastre natural - Bienestar',4,20000),(25,'Apoyo gastos funerarios - Bienestar',4,20000),(26,'Tiquetes aéreos o terrestres - Bienestar',4,20000),(27,'Apoyo pañitos humedos - Bienestar',4,20000),(28,'Otro (Programa Bienestar) - Bienestar',4,20000),(29,'Hogar de paso estadía - Salud',3,20000);
/*!40000 ALTER TABLE `programas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puntaje`
--

DROP TABLE IF EXISTS `puntaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `puntaje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puntaje`
--

LOCK TABLES `puntaje` WRITE;
/*!40000 ALTER TABLE `puntaje` DISABLE KEYS */;
/*!40000 ALTER TABLE `puntaje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seccionales`
--

DROP TABLE IF EXISTS `seccionales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seccionales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SeccionalNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `SeccionalPresupuesto` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seccionales`
--

LOCK TABLES `seccionales` WRITE;
/*!40000 ALTER TABLE `seccionales` DISABLE KEYS */;
INSERT INTO `seccionales` VALUES (1,'ANTIOQUIA',0),(2,'ATLANTICO',0),(3,'BOLÍVAR',0),(4,'BOYACA',0),(5,'CALDAS',0),(6,'CAQUETA',0),(7,'CASANARE',0),(8,'CAUCA',0),(9,'CESAR',0),(10,'COMITÉ BOGOTÁ',0),(11,'COMITÉ CHOCÓ',0),(12,'COMITÉ PUTUMAYO',0),(13,'COMITÉ URABA',0),(14,'CORDOBA',0),(15,'CUNDINAMARCA',0),(16,'GUAJIRA',0),(17,'HUILA',0),(18,'MAGDALENA',0),(19,'META',0),(20,'NARIÑO',0),(21,'NTE. SANTANDER',0),(22,'QUINDÍO',0),(23,'RISARALDA',0),(24,'SANTANDER',0),(25,'SUCRE',0),(26,'TOLIMA',0),(27,'VALLE',0),(29,'OFICINA PRINCIPAL',0);
/*!40000 ALTER TABLE `seccionales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `situacionesvivienda`
--

DROP TABLE IF EXISTS `situacionesvivienda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `situacionesvivienda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SituacionViviendaNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `SituacionesViviendaPuntaje` int(11) NOT NULL,
  `SituacionesViviendaEstado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `situacionesvivienda`
--

LOCK TABLES `situacionesvivienda` WRITE;
/*!40000 ALTER TABLE `situacionesvivienda` DISABLE KEYS */;
INSERT INTO `situacionesvivienda` VALUES (1,'Propia (sin deuda)',15,1),(2,'Propia (Hipoteca)',20,1),(3,'Arriendo',20,1),(4,'Familiar',15,1);
/*!40000 ALTER TABLE `situacionesvivienda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitudes`
--

DROP TABLE IF EXISTS `solicitudes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idingreso` int(11) DEFAULT NULL,
  `cantidadesbeneficio_id` int(11) DEFAULT NULL,
  `idtiposolicitud` int(11) DEFAULT NULL,
  `idotorga` int(11) DEFAULT NULL,
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
  `SolicitudFecha` date NOT NULL,
  `SolicitudCedulaSolicita` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `SolicitudNombreSolicita` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SolicitudCedulaFuncionario` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `SolicitudDireccionFuncionario` varchar(350) COLLATE utf8_unicode_ci NOT NULL,
  `SolicitudTelefonosFuncionario` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `SolicitudNombreFuncionario` varchar(450) COLLATE utf8_unicode_ci NOT NULL,
  `SolicitudDescripcion` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `documentoBeneficiarioFinal` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idConceptoVisita` int(11) DEFAULT NULL,
  `idAfiliadoDibie` int(11) DEFAULT NULL,
  `idGrado` int(11) DEFAULT NULL,
  `idunidad` int(11) DEFAULT NULL,
  `totalPuntaje` int(11) DEFAULT NULL,
  `archivo` varchar(3000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idantiguedad` int(11) DEFAULT NULL,
  `concepto_id` int(11) DEFAULT NULL,
  `emailSolicitante` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `nombreBeneficiarioFinal` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(3000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ValorBeneficio` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TiempoBeneficio` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ValortotalBeneficio` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Acta` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_216D11013BA3729` (`cantidadesbeneficio_id`),
  KEY `IDX_216D110BAA72B5A` (`idcantidadesbeneficioinst`),
  KEY `IDX_216D1109E157E4C` (`idestadocivil`),
  KEY `IDX_216D110AE4B0437` (`idGrado`),
  KEY `IDX_216D110139F7671` (`idingreso`),
  KEY `IDX_216D110B4FB73C` (`idmotivodeuda`),
  KEY `IDX_216D11053B72D2C` (`idparentesco`),
  KEY `IDX_216D110EF075161` (`idpersonacargo`),
  KEY `IDX_216D11079D71D30` (`idpoblacionbeneficia`),
  KEY `IDX_216D11070C5A4CE` (`idseccional`),
  KEY `IDX_216D110E9FCC173` (`idsituacionvivienda`),
  KEY `IDX_216D110174D74B2` (`idtiposolicitud`),
  KEY `IDX_216D11069A00F34` (`idviabilidadplaneacion`),
  KEY `IDX_216D110AA18F2E4` (`idzonaubicacion`),
  KEY `fk_Solicitudes_Seccionales1_idx` (`id`),
  KEY `fk_Solicitudes_Parentescos1_idx` (`id`),
  KEY `fk_Solicitudes_Grados1_idx` (`id`),
  KEY `fk_Solicitudes_Programas1_idx` (`id`),
  KEY `fk_Solicitudes_TiposSolicitud1_idx` (`id`),
  KEY `fk_Solicitudes_EstadosCiviles1_idx` (`id`),
  KEY `fk_Solicitudes_Ingresos1_idx` (`id`),
  KEY `fk_Solicitudes_PersonasCargo1_idx` (`id`),
  KEY `fk_Solicitudes_SituacionesVivienda1_idx` (`id`),
  KEY `fk_Solicitudes_MotivosDeuda1_idx` (`id`),
  KEY `fk_Solicitudes_CantidadesBeneficio1_idx` (`id`),
  KEY `fk_Solicitudes_ConceptosVisita1_idx` (`idConceptoVisita`),
  KEY `fk_Solicitudes_CantidadesBeneficioInst1_idx` (`id`),
  KEY `fk_Solicitudes_ViabilidadPlaneacion1_idx` (`id`),
  KEY `fk_Solicitudes_ZonasUbicacion1_idx` (`id`),
  KEY `fk_Solicitudes_PoblacionBeneficia1_idx` (`id`),
  KEY `fk_Solicitudes_AfiliadoDibie1_idx` (`idAfiliadoDibie`),
  KEY `IDX_216D110975B7D83` (`idunidad`),
  KEY `IDX_216D1104B6004A` (`idotorga`),
  KEY `IDX_216D110E34F1D5F` (`idantiguedad`),
  KEY `IDX_216D1106C2330BD` (`concepto_id`),
  CONSTRAINT `FK_216D110139F7671` FOREIGN KEY (`idingreso`) REFERENCES `ingresos` (`id`),
  CONSTRAINT `FK_216D11013BA3729` FOREIGN KEY (`cantidadesbeneficio_id`) REFERENCES `cantidadesbeneficio` (`id`),
  CONSTRAINT `FK_216D110174D74B2` FOREIGN KEY (`idtiposolicitud`) REFERENCES `tipossolicitud` (`id`),
  CONSTRAINT `FK_216D1104B6004A` FOREIGN KEY (`idotorga`) REFERENCES `otorga` (`id`),
  CONSTRAINT `FK_216D1104FDB3952` FOREIGN KEY (`idConceptoVisita`) REFERENCES `conceptosvisita` (`idConceptoVisita`),
  CONSTRAINT `FK_216D11053B72D2C` FOREIGN KEY (`idparentesco`) REFERENCES `parentescos` (`id`),
  CONSTRAINT `FK_216D11069A00F34` FOREIGN KEY (`idviabilidadplaneacion`) REFERENCES `viabilidadplaneacion` (`id`),
  CONSTRAINT `FK_216D1106C2330BD` FOREIGN KEY (`concepto_id`) REFERENCES `concepto` (`id`),
  CONSTRAINT `FK_216D11070C5A4CE` FOREIGN KEY (`idseccional`) REFERENCES `seccionales` (`id`),
  CONSTRAINT `FK_216D11072EBC208` FOREIGN KEY (`idAfiliadoDibie`) REFERENCES `afiliadodibie` (`idAfiliadoDibie`),
  CONSTRAINT `FK_216D11079D71D30` FOREIGN KEY (`idpoblacionbeneficia`) REFERENCES `poblacionbeneficia` (`id`),
  CONSTRAINT `FK_216D110975B7D83` FOREIGN KEY (`idunidad`) REFERENCES `unidad` (`id`),
  CONSTRAINT `FK_216D1109E157E4C` FOREIGN KEY (`idestadocivil`) REFERENCES `estadosciviles` (`id`),
  CONSTRAINT `FK_216D110AA18F2E4` FOREIGN KEY (`idzonaubicacion`) REFERENCES `zonasubicacion` (`id`),
  CONSTRAINT `FK_216D110AE4B0437` FOREIGN KEY (`idGrado`) REFERENCES `grados` (`id`),
  CONSTRAINT `FK_216D110B4FB73C` FOREIGN KEY (`idmotivodeuda`) REFERENCES `motivosdeuda` (`id`),
  CONSTRAINT `FK_216D110BAA72B5A` FOREIGN KEY (`idcantidadesbeneficioinst`) REFERENCES `cantidadesbeneficioinst` (`id`),
  CONSTRAINT `FK_216D110E34F1D5F` FOREIGN KEY (`idantiguedad`) REFERENCES `antiguedad` (`id`),
  CONSTRAINT `FK_216D110E9FCC173` FOREIGN KEY (`idsituacionvivienda`) REFERENCES `situacionesvivienda` (`id`),
  CONSTRAINT `FK_216D110EF075161` FOREIGN KEY (`idpersonacargo`) REFERENCES `personascargo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitudes`
--

LOCK TABLES `solicitudes` WRITE;
/*!40000 ALTER TABLE `solicitudes` DISABLE KEYS */;
INSERT INTO `solicitudes` VALUES (1,NULL,NULL,2,NULL,9,1,1,3,NULL,2,NULL,3,NULL,NULL,'2018-03-19','123123123','123123123','123456123','123','123123123','123345','sadasdasdasdsad',NULL,NULL,NULL,12,12,65,NULL,3,NULL,'asd@asd.com',NULL,NULL,NULL,NULL,NULL,NULL),(2,2,5,1,NULL,6,NULL,2,NULL,1,NULL,7,NULL,1,2,'2018-03-20','123123123','123123123','4424234','asd asd asd','123123123','sd asd ad','sadasdasdasdsad','123123123123',3,1,4,3,70,NULL,2,NULL,'asd@asd.com','asdasdasdsa',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `solicitudes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipossolicitud`
--

DROP TABLE IF EXISTS `tipossolicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipossolicitud` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TipoSolicitudNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipossolicitud`
--

LOCK TABLES `tipossolicitud` WRITE;
/*!40000 ALTER TABLE `tipossolicitud` DISABLE KEYS */;
INSERT INTO `tipossolicitud` VALUES (1,'Familiar y personal'),(2,'Institucional');
/*!40000 ALTER TABLE `tipossolicitud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidad`
--

DROP TABLE IF EXISTS `unidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidad`
--

LOCK TABLES `unidad` WRITE;
/*!40000 ALTER TABLE `unidad` DISABLE KEYS */;
INSERT INTO `unidad` VALUES (2,'AGREGADURIAS'),(3,'AMERIPOL'),(4,'ARCOI'),(5,'CASUR'),(6,'CENOP'),(7,'CENTROS INSTRUCCIÓN'),(8,'CESEP 2016'),(9,'CESEP 2017'),(10,'COEST'),(11,'DEAMA'),(12,'DEANT'),(13,'DEARA'),(14,'DEATA'),(15,'DEBOL'),(16,'DEBOY'),(17,'DECAL'),(18,'DECAQ'),(19,'DECAS'),(20,'DECAU'),(21,'DECES'),(22,'DECHO'),(23,'DECOR'),(24,'DECUN'),(25,'DEGUA'),(26,'DEGUN'),(27,'DEGUV'),(28,'DEMAG'),(29,'DEMAM'),(30,'DEMET'),(31,'DENAR'),(32,'DENOR'),(33,'DEPUY'),(34,'DEQUI'),(35,'DERIS'),(36,'DESAN'),(37,'DESAP'),(38,'DESUC'),(39,'DETOL'),(40,'DEUIL'),(41,'DEURA'),(42,'DEVAL'),(43,'DEVAU'),(44,'DEVIC'),(45,'DIASE'),(46,'DIBIE'),(47,'DICAR'),(48,'DIJIN'),(49,'DINAE'),(50,'DINCO'),(51,'DIPOL'),(52,'DIPON'),(53,'DIPRO'),(54,'DIRAF'),(55,'DIRAN'),(56,'DISAN'),(57,'DISEC'),(58,'DITAH'),(59,'DITRA'),(60,'ECSAN'),(61,'ESAGU'),(62,'ESANA'),(63,'ESANT'),(64,'ESAVI'),(65,'ESBOL'),(66,'ESCAR'),(67,'ESCEQ'),(68,'ESCER'),(69,'ESCIC'),(70,'ESCOL'),(71,'ESECU'),(72,'ESEVI'),(73,'ESGAC'),(74,'ESGON'),(75,'ESINC'),(76,'ESJIM'),(77,'ESMAC'),(78,'ESMEB'),(79,'ESPOL'),(80,'ESPRO'),(81,'ESRAN'),(82,'ESREY'),(83,'ESSUM'),(84,'ESTIC'),(85,'ESVEL'),(86,'FORPO'),(87,'INPEC'),(88,'INSGE'),(89,'MEBAR'),(90,'MEBOG'),(91,'MEBUC'),(92,'MECAL'),(93,'MECAL'),(94,'MECAR'),(95,'MECUC'),(96,'MEMAZ'),(97,'MEMOT'),(98,'MENEV'),(99,'MEPAS'),(100,'MEPER'),(101,'MEPOY'),(102,'MESAN'),(103,'METIB'),(104,'METUN'),(105,'MEVAL'),(106,'MEVIL'),(107,'MINDEFENSA'),(108,'OFITE'),(109,'OFPLA'),(110,'POLFA'),(111,'SEGEN'),(112,'SUDIR');
/*!40000 ALTER TABLE `unidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `viabilidadplaneacion`
--

DROP TABLE IF EXISTS `viabilidadplaneacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `viabilidadplaneacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ViabilidadPlaneacionConcepto` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `ViabilidadPlaneacionPuntaje` int(11) NOT NULL,
  `ViabilidadPlaneacionEstado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `viabilidadplaneacion`
--

LOCK TABLES `viabilidadplaneacion` WRITE;
/*!40000 ALTER TABLE `viabilidadplaneacion` DISABLE KEYS */;
INSERT INTO `viabilidadplaneacion` VALUES (1,'SI',25,1),(2,'NO',0,1);
/*!40000 ALTER TABLE `viabilidadplaneacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zonasubicacion`
--

DROP TABLE IF EXISTS `zonasubicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zonasubicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ZonasUbicacionNombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ZonasUbicacionPuntaje` int(11) NOT NULL,
  `ZonasUbicacionEstado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zonasubicacion`
--

LOCK TABLES `zonasubicacion` WRITE;
/*!40000 ALTER TABLE `zonasubicacion` DISABLE KEYS */;
INSERT INTO `zonasubicacion` VALUES (1,'URBANA',10,1),(2,'RURAL',15,1),(3,'URBANA ORDEN PÚBLICO',20,1),(4,'RURAL ORDEN PÚBLICO',25,1);
/*!40000 ALTER TABLE `zonasubicacion` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-20 23:44:59
