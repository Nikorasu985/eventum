CREATE DATABASE  IF NOT EXISTS `eventumdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `eventumdb`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: eventumdb
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `configuraciones_usuario`
--

DROP TABLE IF EXISTS `configuraciones_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuraciones_usuario` (
  `id_configuracion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `tema` varchar(50) NOT NULL DEFAULT 'futurista',
  `modo_oscuro` varchar(10) NOT NULL DEFAULT 'auto',
  `colores_personalizados` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`colores_personalizados`)),
  `configuracion_dashboard` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`configuracion_dashboard`)),
  `notificaciones_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`notificaciones_config`)),
  `idioma` varchar(5) NOT NULL DEFAULT 'es',
  `zona_horaria` varchar(50) NOT NULL DEFAULT 'America/Mexico_City',
  `animaciones_habilitadas` tinyint(1) NOT NULL DEFAULT 1,
  `tamaño_fuente` int(11) NOT NULL DEFAULT 16,
  `tipo_fuente` varchar(50) NOT NULL DEFAULT 'Inter',
  `widgets_dashboard` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`widgets_dashboard`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_configuracion`),
  KEY `configuraciones_usuario_id_usuario_foreign` (`id_usuario`),
  CONSTRAINT `configuraciones_usuario_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuraciones_usuario`
--

LOCK TABLES `configuraciones_usuario` WRITE;
/*!40000 ALTER TABLE `configuraciones_usuario` DISABLE KEYS */;
INSERT INTO `configuraciones_usuario` VALUES (1,1,'futurista','dark',NULL,NULL,NULL,'es','America/Mexico_City',1,16,'Inter',NULL,'2025-09-25 10:32:18','2025-09-25 10:32:18'),(2,2,'futurista','dark',NULL,NULL,NULL,'es','America/Mexico_City',1,16,'Inter',NULL,'2025-09-25 10:32:18','2025-09-25 10:32:18'),(3,3,'futurista','dark',NULL,NULL,NULL,'es','America/Mexico_City',1,16,'Inter',NULL,'2025-09-25 10:32:18','2025-09-25 10:32:18');
/*!40000 ALTER TABLE `configuraciones_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cosas_por_llevar`
--

DROP TABLE IF EXISTS `cosas_por_llevar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cosas_por_llevar` (
  `id_cosa` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_evento` bigint(20) unsigned NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cantidad` varchar(50) DEFAULT NULL,
  `id_usuario` bigint(20) unsigned DEFAULT NULL,
  `estado` enum('pendiente','comprado','cancelado') NOT NULL DEFAULT 'pendiente',
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cosa`),
  KEY `cosas_por_llevar_id_evento_foreign` (`id_evento`),
  KEY `cosas_por_llevar_id_usuario_foreign` (`id_usuario`),
  CONSTRAINT `cosas_por_llevar_id_evento_foreign` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`),
  CONSTRAINT `cosas_por_llevar_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cosas_por_llevar`
--

LOCK TABLES `cosas_por_llevar` WRITE;
/*!40000 ALTER TABLE `cosas_por_llevar` DISABLE KEYS */;
/*!40000 ALTER TABLE `cosas_por_llevar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_participacion`
--

DROP TABLE IF EXISTS `estados_participacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_participacion` (
  `id_estado_participacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_estado` enum('confirmada','no asistió','cancelada') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_estado_participacion`),
  UNIQUE KEY `estados_participacion_nombre_estado_unique` (`nombre_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_participacion`
--

LOCK TABLES `estados_participacion` WRITE;
/*!40000 ALTER TABLE `estados_participacion` DISABLE KEYS */;
INSERT INTO `estados_participacion` VALUES (1,'confirmada','2025-09-25 10:32:18','2025-09-25 10:32:18'),(2,'no asistió','2025-09-25 10:32:18','2025-09-25 10:32:18'),(3,'cancelada','2025-09-25 10:32:18','2025-09-25 10:32:18');
/*!40000 ALTER TABLE `estados_participacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_solicitud`
--

DROP TABLE IF EXISTS `estados_solicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_solicitud` (
  `id_estado_solicitud` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_estado` enum('pendiente','aceptada','rechazada') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_estado_solicitud`),
  UNIQUE KEY `estados_solicitud_nombre_estado_unique` (`nombre_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_solicitud`
--

LOCK TABLES `estados_solicitud` WRITE;
/*!40000 ALTER TABLE `estados_solicitud` DISABLE KEYS */;
INSERT INTO `estados_solicitud` VALUES (1,'pendiente','2025-09-25 10:32:18','2025-09-25 10:32:18'),(2,'aceptada','2025-09-25 10:32:18','2025-09-25 10:32:18'),(3,'rechazada','2025-09-25 10:32:18','2025-09-25 10:32:18');
/*!40000 ALTER TABLE `estados_solicitud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id_evento` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_anfitrion` bigint(20) unsigned NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `lugar` varchar(150) DEFAULT NULL,
  `sitio` varchar(150) DEFAULT NULL,
  `id_tipo_presupuesto` bigint(20) unsigned NOT NULL DEFAULT 2,
  `presupuesto` decimal(10,2) DEFAULT NULL,
  `numero_integrantes` int(11) NOT NULL DEFAULT 0,
  `codigo_evento` varchar(20) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `fecha_limite_invitacion` date DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_evento`),
  UNIQUE KEY `eventos_codigo_evento_unique` (`codigo_evento`),
  KEY `eventos_id_anfitrion_foreign` (`id_anfitrion`),
  KEY `eventos_id_tipo_presupuesto_foreign` (`id_tipo_presupuesto`),
  CONSTRAINT `eventos_id_anfitrion_foreign` FOREIGN KEY (`id_anfitrion`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `eventos_id_tipo_presupuesto_foreign` FOREIGN KEY (`id_tipo_presupuesto`) REFERENCES `tipos_presupuesto` (`id_tipo_presupuesto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` VALUES (1,1,'Fiesta de Bienvenida Eventum','¡Bienvenido a Eventum! Únete a nuestra fiesta de presentación.','Sala de Conferencias Principal','https://meet.google.com/eventum-demo',2,500.00,0,'093A3D1A','2025-10-02','18:00:00','2025-10-02','22:00:00','2025-09-30','2025-09-25 05:32:18','2025-09-25 10:32:18','2025-09-25 10:32:18');
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2025_09_22_222356_create_roles_sistema_table',1),(6,'2025_09_22_222421_create_usuarios_table',1),(7,'2025_09_22_222429_create_tipos_presupuesto_table',1),(8,'2025_09_22_222437_create_eventos_table',1),(9,'2025_09_22_222444_create_roles_evento_table',1),(10,'2025_09_22_222457_create_usuarios_eventos_table',1),(11,'2025_09_22_222505_create_tipos_solicitud_table',1),(12,'2025_09_22_222515_create_estados_solicitud_table',1),(13,'2025_09_22_222525_create_solicitudes_invitacion_table',1),(14,'2025_09_22_222540_create_estados_participacion_table',1),(15,'2025_09_22_222553_create_participaciones_table',1),(16,'2025_09_22_222609_create_tipos_notificacion_table',1),(17,'2025_09_22_222617_create_notificaciones_table',1),(18,'2025_09_22_222626_create_reportes_evento_table',1),(19,'2025_09_22_222634_create_cosas_por_llevar_table',1),(20,'2025_09_22_222954_create_configuraciones_usuario_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificaciones` (
  `id_notificacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `id_evento` bigint(20) unsigned DEFAULT NULL,
  `id_tipo_notificacion` bigint(20) unsigned NOT NULL,
  `contenido` text NOT NULL,
  `leida` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_notificacion`),
  KEY `notificaciones_id_usuario_foreign` (`id_usuario`),
  KEY `notificaciones_id_evento_foreign` (`id_evento`),
  KEY `notificaciones_id_tipo_notificacion_foreign` (`id_tipo_notificacion`),
  CONSTRAINT `notificaciones_id_evento_foreign` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`),
  CONSTRAINT `notificaciones_id_tipo_notificacion_foreign` FOREIGN KEY (`id_tipo_notificacion`) REFERENCES `tipos_notificacion` (`id_tipo_notificacion`),
  CONSTRAINT `notificaciones_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (1,1,1,3,'usuario se ha unido a tu evento: Fiesta de Bienvenida Eventum',0,'2025-09-25 05:36:20','2025-09-25 10:36:20','2025-09-25 10:36:20');
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participaciones`
--

DROP TABLE IF EXISTS `participaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participaciones` (
  `id_participacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_evento` bigint(20) unsigned NOT NULL,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `fecha_confirmacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_estado_participacion` bigint(20) unsigned NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_participacion`),
  UNIQUE KEY `participaciones_id_evento_id_usuario_unique` (`id_evento`,`id_usuario`),
  KEY `participaciones_id_usuario_foreign` (`id_usuario`),
  KEY `participaciones_id_estado_participacion_foreign` (`id_estado_participacion`),
  CONSTRAINT `participaciones_id_estado_participacion_foreign` FOREIGN KEY (`id_estado_participacion`) REFERENCES `estados_participacion` (`id_estado_participacion`),
  CONSTRAINT `participaciones_id_evento_foreign` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`),
  CONSTRAINT `participaciones_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participaciones`
--

LOCK TABLES `participaciones` WRITE;
/*!40000 ALTER TABLE `participaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `participaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reportes_evento`
--

DROP TABLE IF EXISTS `reportes_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reportes_evento` (
  `id_reporte` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_evento` bigint(20) unsigned NOT NULL,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `motivo` text NOT NULL,
  `fecha_reporte` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','revisado','rechazado') NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_reporte`),
  KEY `reportes_evento_id_evento_foreign` (`id_evento`),
  KEY `reportes_evento_id_usuario_foreign` (`id_usuario`),
  CONSTRAINT `reportes_evento_id_evento_foreign` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`),
  CONSTRAINT `reportes_evento_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reportes_evento`
--

LOCK TABLES `reportes_evento` WRITE;
/*!40000 ALTER TABLE `reportes_evento` DISABLE KEYS */;
INSERT INTO `reportes_evento` VALUES (1,1,2,'Terrorismo','2025-09-25 05:44:33','pendiente','2025-09-25 10:44:33','2025-09-25 10:44:33');
/*!40000 ALTER TABLE `reportes_evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_evento`
--

DROP TABLE IF EXISTS `roles_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles_evento` (
  `id_rol_evento` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_rol_evento`),
  UNIQUE KEY `roles_evento_nombre_rol_unique` (`nombre_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_evento`
--

LOCK TABLES `roles_evento` WRITE;
/*!40000 ALTER TABLE `roles_evento` DISABLE KEYS */;
INSERT INTO `roles_evento` VALUES (1,'Anfitrión','Creador y organizador del evento','2025-09-25 10:32:18','2025-09-25 10:32:18'),(2,'Invitado','Usuario invitado al evento','2025-09-25 10:32:18','2025-09-25 10:32:18'),(3,'Participante','Usuario que participa en el evento','2025-09-25 10:32:18','2025-09-25 10:32:18');
/*!40000 ALTER TABLE `roles_evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_sistema`
--

DROP TABLE IF EXISTS `roles_sistema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles_sistema` (
  `id_rol_sistema` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_rol_sistema`),
  UNIQUE KEY `roles_sistema_nombre_rol_unique` (`nombre_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_sistema`
--

LOCK TABLES `roles_sistema` WRITE;
/*!40000 ALTER TABLE `roles_sistema` DISABLE KEYS */;
INSERT INTO `roles_sistema` VALUES (1,'Administrador','Rol con acceso completo al sistema','2025-09-25 10:32:18','2025-09-25 10:32:18'),(2,'Moderador','Rol con permisos de moderación','2025-09-25 10:32:18','2025-09-25 10:32:18'),(3,'Usuario','Rol básico de usuario','2025-09-25 10:32:18','2025-09-25 10:32:18');
/*!40000 ALTER TABLE `roles_sistema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitudes_invitacion`
--

DROP TABLE IF EXISTS `solicitudes_invitacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitudes_invitacion` (
  `id_solicitud` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_evento` bigint(20) unsigned NOT NULL,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `id_tipo_solicitud` bigint(20) unsigned NOT NULL,
  `id_estado_solicitud` bigint(20) unsigned NOT NULL DEFAULT 1,
  `mensaje` text DEFAULT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_solicitud`),
  UNIQUE KEY `solicitudes_invitacion_id_evento_id_usuario_unique` (`id_evento`,`id_usuario`),
  KEY `solicitudes_invitacion_id_usuario_foreign` (`id_usuario`),
  KEY `solicitudes_invitacion_id_tipo_solicitud_foreign` (`id_tipo_solicitud`),
  KEY `solicitudes_invitacion_id_estado_solicitud_foreign` (`id_estado_solicitud`),
  CONSTRAINT `solicitudes_invitacion_id_estado_solicitud_foreign` FOREIGN KEY (`id_estado_solicitud`) REFERENCES `estados_solicitud` (`id_estado_solicitud`),
  CONSTRAINT `solicitudes_invitacion_id_evento_foreign` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`),
  CONSTRAINT `solicitudes_invitacion_id_tipo_solicitud_foreign` FOREIGN KEY (`id_tipo_solicitud`) REFERENCES `tipos_solicitud` (`id_tipo_solicitud`),
  CONSTRAINT `solicitudes_invitacion_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitudes_invitacion`
--

LOCK TABLES `solicitudes_invitacion` WRITE;
/*!40000 ALTER TABLE `solicitudes_invitacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `solicitudes_invitacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_notificacion`
--

DROP TABLE IF EXISTS `tipos_notificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipos_notificacion` (
  `id_tipo_notificacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_tipo` enum('invitacion','solicitud','evento','recordatorio','aviso') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipo_notificacion`),
  UNIQUE KEY `tipos_notificacion_nombre_tipo_unique` (`nombre_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_notificacion`
--

LOCK TABLES `tipos_notificacion` WRITE;
/*!40000 ALTER TABLE `tipos_notificacion` DISABLE KEYS */;
INSERT INTO `tipos_notificacion` VALUES (1,'invitacion','2025-09-25 10:32:18','2025-09-25 10:32:18'),(2,'solicitud','2025-09-25 10:32:18','2025-09-25 10:32:18'),(3,'evento','2025-09-25 10:32:18','2025-09-25 10:32:18'),(4,'recordatorio','2025-09-25 10:32:18','2025-09-25 10:32:18'),(5,'aviso','2025-09-25 10:32:18','2025-09-25 10:32:18');
/*!40000 ALTER TABLE `tipos_notificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_presupuesto`
--

DROP TABLE IF EXISTS `tipos_presupuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipos_presupuesto` (
  `id_tipo_presupuesto` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_tipo` enum('fijo','sugerido') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipo_presupuesto`),
  UNIQUE KEY `tipos_presupuesto_nombre_tipo_unique` (`nombre_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_presupuesto`
--

LOCK TABLES `tipos_presupuesto` WRITE;
/*!40000 ALTER TABLE `tipos_presupuesto` DISABLE KEYS */;
INSERT INTO `tipos_presupuesto` VALUES (1,'fijo','2025-09-25 10:32:18','2025-09-25 10:32:18'),(2,'sugerido','2025-09-25 10:32:18','2025-09-25 10:32:18');
/*!40000 ALTER TABLE `tipos_presupuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_solicitud`
--

DROP TABLE IF EXISTS `tipos_solicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipos_solicitud` (
  `id_tipo_solicitud` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_tipo` enum('codigo','directa') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipo_solicitud`),
  UNIQUE KEY `tipos_solicitud_nombre_tipo_unique` (`nombre_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_solicitud`
--

LOCK TABLES `tipos_solicitud` WRITE;
/*!40000 ALTER TABLE `tipos_solicitud` DISABLE KEYS */;
INSERT INTO `tipos_solicitud` VALUES (1,'codigo','2025-09-25 10:32:18','2025-09-25 10:32:18'),(2,'directa','2025-09-25 10:32:18','2025-09-25 10:32:18');
/*!40000 ALTER TABLE `tipos_solicitud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `id_rol_sistema` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `usuarios_nombre_usuario_unique` (`nombre_usuario`),
  UNIQUE KEY `usuarios_correo_unique` (`correo`),
  KEY `usuarios_id_rol_sistema_foreign` (`id_rol_sistema`),
  CONSTRAINT `usuarios_id_rol_sistema_foreign` FOREIGN KEY (`id_rol_sistema`) REFERENCES `roles_sistema` (`id_rol_sistema`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin','admin@eventum.com','$2y$10$U57NcVozIa6gy7DirnyrfegSfEBZOiWaBjgiMcNUbOPB3VNQErrMG',1,'2025-09-25 10:32:18','2025-09-25 10:32:18'),(2,'usuario','usuario@eventum.com','$2y$10$pbqfjSNs3uPVCcUV4yI14.4ymjaIzhvgEpGbgi.nxAtHLr0np1ET2',3,'2025-09-25 10:32:18','2025-09-25 10:32:18'),(3,'moderador','moderador@eventum.com','$2y$10$lYS3vfA5Hy1skK/21xqoc.ugRv9vVgDh4x/XjqAic/MynnNLrLF5G',2,'2025-09-25 10:32:18','2025-09-25 10:32:18');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_eventos`
--

DROP TABLE IF EXISTS `usuarios_eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios_eventos` (
  `id_usuario_evento` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `id_evento` bigint(20) unsigned NOT NULL,
  `id_rol_evento` bigint(20) unsigned NOT NULL,
  `estado_invitacion` enum('pendiente','aceptado','rechazado') NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_usuario_evento`),
  UNIQUE KEY `usuarios_eventos_id_usuario_id_evento_unique` (`id_usuario`,`id_evento`),
  KEY `usuarios_eventos_id_evento_foreign` (`id_evento`),
  KEY `usuarios_eventos_id_rol_evento_foreign` (`id_rol_evento`),
  CONSTRAINT `usuarios_eventos_id_evento_foreign` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`),
  CONSTRAINT `usuarios_eventos_id_rol_evento_foreign` FOREIGN KEY (`id_rol_evento`) REFERENCES `roles_evento` (`id_rol_evento`),
  CONSTRAINT `usuarios_eventos_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_eventos`
--

LOCK TABLES `usuarios_eventos` WRITE;
/*!40000 ALTER TABLE `usuarios_eventos` DISABLE KEYS */;
INSERT INTO `usuarios_eventos` VALUES (1,2,1,2,'aceptado','2025-09-25 10:36:20','2025-09-25 10:36:20');
/*!40000 ALTER TABLE `usuarios_eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'eventumdb'
--

--
-- Dumping routines for database 'eventumdb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-25  1:12:31
