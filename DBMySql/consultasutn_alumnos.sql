CREATE DATABASE  IF NOT EXISTS `consultasutn` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `consultasutn`;
-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Host: localhost    Database: consultasutn
-- ------------------------------------------------------
-- Server version	8.0.29

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
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos` (
  `legajo` int NOT NULL AUTO_INCREMENT,
  `nombre_apellido` varchar(45) NOT NULL,
  `mail` varchar(45) NOT NULL,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`legajo`),
  KEY `fk_alumnos_usuarios_idx` (`id_usuario`),
  CONSTRAINT `fk_alumnos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41234433 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` VALUES (1,'Lautaro Canoo ','lcano@gmail.com',3),(2,'Guido Lorenzotti','guidolorenzotti@gmail.com',2),(3,'Franco Teclado','fteclado@gmail.com',4),(4,'prueba edicion','pruba@gmail.com',1),(112232,'prueba aalta','preubalata@hotmail.com',NULL);
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciclos_lectivos`
--

DROP TABLE IF EXISTS `ciclos_lectivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ciclos_lectivos` (
  `id_ciclo_lectivo` int NOT NULL AUTO_INCREMENT,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `activo` tinyint NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `fecha_inicio_vacaciones` date NOT NULL,
  `fecha_fin_vacaciones` date NOT NULL,
  PRIMARY KEY (`id_ciclo_lectivo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciclos_lectivos`
--

LOCK TABLES `ciclos_lectivos` WRITE;
/*!40000 ALTER TABLE `ciclos_lectivos` DISABLE KEYS */;
INSERT INTO `ciclos_lectivos` VALUES (1,'2023-03-15','2024-03-14',1,'2023','0000-00-00','0000-00-00'),(2,'2024-03-15','2025-03-14',0,'2024','0000-00-00','0000-00-00'),(3,'2025-03-15','2026-03-14',0,'2025','2025-12-14','2026-02-14');
/*!40000 ALTER TABLE `ciclos_lectivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultas`
--

DROP TABLE IF EXISTS `consultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consultas` (
  `id_consulta` int NOT NULL AUTO_INCREMENT,
  `hora_consulta` time NOT NULL,
  `fecha_consulta` date NOT NULL,
  `id_estado_consulta` int NOT NULL,
  `motivo_cancelacion` varchar(100) DEFAULT NULL,
  `id_profesor` int NOT NULL,
  `id_materia` int NOT NULL,
  `id_profesor_consulta` int DEFAULT NULL,
  PRIMARY KEY (`id_consulta`),
  KEY `fk_consultas_estado_consulta_idx` (`id_estado_consulta`),
  KEY `fk_consultas_profesores_idx` (`id_profesor`),
  KEY `fk_consultas_materias_idx` (`id_materia`),
  KEY `fk_consultas_profesor_consulta_idx` (`id_profesor_consulta`),
  CONSTRAINT `fk_consultas_estado_consulta` FOREIGN KEY (`id_estado_consulta`) REFERENCES `estados_consulta` (`id_estado_consulta`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_consultas_materias` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_consultas_profesor_consulta` FOREIGN KEY (`id_profesor_consulta`) REFERENCES `profesor_consulta` (`id_profesor_consulta`) ON DELETE SET NULL,
  CONSTRAINT `fk_consultas_profesores` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=349 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultas`
--

LOCK TABLES `consultas` WRITE;
/*!40000 ALTER TABLE `consultas` DISABLE KEYS */;
INSERT INTO `consultas` VALUES (214,'20:00:00','2023-06-02',1,NULL,1,1,14),(215,'20:00:00','2023-06-09',1,NULL,1,1,14),(216,'20:00:00','2023-06-16',1,NULL,1,1,14),(217,'20:00:00','2023-06-23',1,NULL,1,1,14),(218,'20:00:00','2023-06-30',1,NULL,1,1,14),(219,'20:00:00','2023-07-07',1,NULL,1,1,14),(220,'20:00:00','2023-07-14',1,NULL,1,1,14),(221,'20:00:00','2023-07-21',1,NULL,1,1,14),(222,'20:00:00','2023-07-28',1,NULL,1,1,14),(223,'20:00:00','2023-08-04',1,NULL,1,1,14),(224,'20:00:00','2023-08-11',1,NULL,1,1,14),(225,'20:00:00','2023-08-18',1,NULL,1,1,14),(226,'20:00:00','2023-08-25',1,NULL,1,1,14),(227,'20:00:00','2023-09-01',1,NULL,1,1,14),(228,'20:00:00','2023-09-08',1,NULL,1,1,14),(229,'20:00:00','2023-09-15',1,NULL,1,1,14),(230,'20:00:00','2023-09-22',1,NULL,1,1,14),(231,'20:00:00','2023-09-29',1,NULL,1,1,14),(232,'20:00:00','2023-10-06',1,NULL,1,1,14),(233,'20:00:00','2023-10-20',1,NULL,1,1,14),(234,'20:00:00','2023-10-27',1,NULL,1,1,14),(235,'20:00:00','2023-11-03',1,NULL,1,1,14),(236,'20:00:00','2023-11-10',1,NULL,1,1,14),(237,'20:00:00','2023-11-17',1,NULL,1,1,14),(238,'20:00:00','2023-11-24',1,NULL,1,1,14),(239,'20:00:00','2023-12-01',1,NULL,1,1,14),(240,'20:00:00','2023-12-15',1,NULL,1,1,14),(241,'20:00:00','2024-02-09',1,NULL,1,1,14),(242,'20:00:00','2024-02-16',1,NULL,1,1,14),(243,'20:00:00','2024-02-23',1,NULL,1,1,14),(244,'20:00:00','2024-03-01',1,NULL,1,1,14),(245,'20:00:00','2024-03-08',1,NULL,1,1,14),(246,'22:33:00','2023-05-29',1,NULL,1,1,15),(247,'22:33:00','2023-06-05',1,NULL,1,1,15),(248,'22:33:00','2023-06-12',1,NULL,1,1,15),(249,'22:33:00','2023-06-26',1,NULL,1,1,15),(250,'22:33:00','2023-07-03',1,NULL,1,1,15),(251,'22:33:00','2023-07-10',1,NULL,1,1,15),(252,'22:33:00','2023-07-17',1,NULL,1,1,15),(253,'22:33:00','2023-07-24',1,NULL,1,1,15),(254,'22:33:00','2023-07-31',1,NULL,1,1,15),(255,'22:33:00','2023-08-07',1,NULL,1,1,15),(256,'22:33:00','2023-08-14',1,NULL,1,1,15),(257,'22:33:00','2023-08-28',1,NULL,1,1,15),(258,'22:33:00','2023-09-04',1,NULL,1,1,15),(259,'22:33:00','2023-09-11',1,NULL,1,1,15),(260,'22:33:00','2023-09-18',1,NULL,1,1,15),(261,'22:33:00','2023-09-25',1,NULL,1,1,15),(262,'22:33:00','2023-10-02',1,NULL,1,1,15),(263,'22:33:00','2023-10-09',1,NULL,1,1,15),(264,'22:33:00','2023-10-23',1,NULL,1,1,15),(265,'22:33:00','2023-10-30',1,NULL,1,1,15),(266,'22:33:00','2023-11-06',1,NULL,1,1,15),(267,'22:33:00','2023-11-13',1,NULL,1,1,15),(268,'22:33:00','2023-11-27',1,NULL,1,1,15),(269,'22:33:00','2023-12-04',1,NULL,1,1,15),(270,'22:33:00','2023-12-11',1,NULL,1,1,15),(271,'22:33:00','2023-12-18',1,NULL,1,1,15),(272,'22:33:00','2024-02-12',1,NULL,1,1,15),(273,'22:33:00','2024-02-19',1,NULL,1,1,15),(274,'22:33:00','2024-02-26',1,NULL,1,1,15),(275,'22:33:00','2024-03-04',1,NULL,1,1,15),(276,'22:33:00','2024-03-11',1,NULL,1,1,15),(277,'17:35:00','2023-05-24',1,NULL,1,3,16),(278,'17:35:00','2023-05-31',1,NULL,1,3,16),(279,'17:35:00','2023-06-07',1,NULL,1,3,16),(280,'17:35:00','2023-06-14',1,NULL,1,3,16),(281,'17:35:00','2023-06-21',1,NULL,1,3,16),(282,'17:35:00','2023-06-28',1,NULL,1,3,16),(283,'17:35:00','2023-07-05',1,NULL,1,3,16),(284,'17:35:00','2023-07-12',1,NULL,1,3,16),(285,'17:35:00','2023-07-19',1,NULL,1,3,16),(286,'17:35:00','2023-07-26',1,NULL,1,3,16),(287,'17:35:00','2023-08-02',1,NULL,1,3,16),(288,'17:35:00','2023-08-09',1,NULL,1,3,16),(289,'17:35:00','2023-08-16',1,NULL,1,3,16),(290,'17:35:00','2023-08-23',1,NULL,1,3,16),(291,'17:35:00','2023-08-30',1,NULL,1,3,16),(292,'17:35:00','2023-09-06',1,NULL,1,3,16),(293,'17:35:00','2023-09-13',1,NULL,1,3,16),(294,'17:35:00','2023-09-20',1,NULL,1,3,16),(295,'17:35:00','2023-09-27',1,NULL,1,3,16),(296,'17:35:00','2023-10-04',1,NULL,1,3,16),(297,'17:35:00','2023-10-11',1,NULL,1,3,16),(298,'17:35:00','2023-10-18',1,NULL,1,3,16),(299,'17:35:00','2023-10-25',1,NULL,1,3,16),(300,'17:35:00','2023-11-01',1,NULL,1,3,16),(301,'17:35:00','2023-11-08',1,NULL,1,3,16),(302,'17:35:00','2023-11-15',1,NULL,1,3,16),(303,'17:35:00','2023-11-22',1,NULL,1,3,16),(304,'17:35:00','2023-11-29',1,NULL,1,3,16),(305,'17:35:00','2023-12-06',1,NULL,1,3,16),(306,'17:35:00','2023-12-13',1,NULL,1,3,16),(307,'17:35:00','2024-02-07',1,NULL,1,3,16),(308,'17:35:00','2024-02-14',1,NULL,1,3,16),(309,'17:35:00','2024-02-21',1,NULL,1,3,16),(310,'17:35:00','2024-02-28',1,NULL,1,3,16),(311,'17:35:00','2024-03-06',1,NULL,1,3,16),(312,'17:35:00','2024-03-13',1,NULL,1,3,16),(313,'19:20:00','2023-05-24',1,NULL,1,2,17),(314,'19:20:00','2023-05-31',1,NULL,1,2,17),(315,'19:20:00','2023-06-07',1,NULL,1,2,17),(316,'19:20:00','2023-06-14',1,NULL,1,2,17),(317,'19:20:00','2023-06-21',1,NULL,1,2,17),(318,'19:20:00','2023-06-28',1,NULL,1,2,17),(319,'19:20:00','2023-07-05',1,NULL,1,2,17),(320,'19:20:00','2023-07-12',1,NULL,1,2,17),(321,'19:20:00','2023-07-19',1,NULL,1,2,17),(322,'19:20:00','2023-07-26',1,NULL,1,2,17),(323,'19:20:00','2023-08-02',1,NULL,1,2,17),(324,'19:20:00','2023-08-09',1,NULL,1,2,17),(325,'19:20:00','2023-08-16',1,NULL,1,2,17),(326,'19:20:00','2023-08-23',1,NULL,1,2,17),(327,'19:20:00','2023-08-30',1,NULL,1,2,17),(328,'19:20:00','2023-09-06',1,NULL,1,2,17),(329,'19:20:00','2023-09-13',1,NULL,1,2,17),(330,'19:20:00','2023-09-20',1,NULL,1,2,17),(331,'19:20:00','2023-09-27',1,NULL,1,2,17),(332,'19:20:00','2023-10-04',1,NULL,1,2,17),(333,'19:20:00','2023-10-11',1,NULL,1,2,17),(334,'19:20:00','2023-10-18',1,NULL,1,2,17),(335,'19:20:00','2023-10-25',1,NULL,1,2,17),(336,'19:20:00','2023-11-01',1,NULL,1,2,17),(337,'19:20:00','2023-11-08',1,NULL,1,2,17),(338,'19:20:00','2023-11-15',1,NULL,1,2,17),(339,'19:20:00','2023-11-22',1,NULL,1,2,17),(340,'19:20:00','2023-11-29',1,NULL,1,2,17),(341,'19:20:00','2023-12-06',1,NULL,1,2,17),(342,'19:20:00','2023-12-13',1,NULL,1,2,17),(343,'19:20:00','2024-02-07',1,NULL,1,2,17),(344,'19:20:00','2024-02-14',1,NULL,1,2,17),(345,'19:20:00','2024-02-21',1,NULL,1,2,17),(346,'19:20:00','2024-02-28',1,NULL,1,2,17),(347,'19:20:00','2024-03-06',1,NULL,1,2,17),(348,'19:20:00','2024-03-13',1,NULL,1,2,17);
/*!40000 ALTER TABLE `consultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dias_consulta`
--

DROP TABLE IF EXISTS `dias_consulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dias_consulta` (
  `id_dia_consulta` int NOT NULL,
  `dia` varchar(45) NOT NULL,
  `dia_mysql` varchar(45) NOT NULL,
  PRIMARY KEY (`id_dia_consulta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dias_consulta`
--

LOCK TABLES `dias_consulta` WRITE;
/*!40000 ALTER TABLE `dias_consulta` DISABLE KEYS */;
INSERT INTO `dias_consulta` VALUES (1,'Lunes','Monday'),(2,'Martes','Tuesday'),(3,'Miércoles','Wednesday'),(4,'Jueves','Thursday'),(5,'Viernes','Friday');
/*!40000 ALTER TABLE `dias_consulta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dias_sin_consulta`
--

DROP TABLE IF EXISTS `dias_sin_consulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dias_sin_consulta` (
  `id_dia_s_c` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_dia_s_c`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dias_sin_consulta`
--

LOCK TABLES `dias_sin_consulta` WRITE;
/*!40000 ALTER TABLE `dias_sin_consulta` DISABLE KEYS */;
INSERT INTO `dias_sin_consulta` VALUES (1,'2023-05-25','25 de mayo'),(2,'2023-05-26','Puente'),(3,'2023-03-24','24 de marzo'),(4,'2023-04-06','Jueves santo'),(5,'2023-04-07','Viernes santo'),(6,'2023-05-01','Dìa del trabajador'),(7,'2023-06-19','Puente'),(8,'2023-06-20','Dìa de la bandera'),(9,'2023-08-21','Sanma'),(10,'2023-09-21','Dìa del estudiante'),(11,'2023-10-13','Puente'),(12,'2023-10-16','Dìa del resp a la diver'),(13,'2023-11-20','Día de la soberanía'),(14,'2023-12-08','Día de la virgen'),(15,'2023-12-19','Vacaciones'),(16,'2023-12-20','Vacaciones'),(17,'2023-12-21','Vacaciones'),(18,'2023-12-22','Vacaciones'),(19,'2023-12-23','Vacaciones'),(20,'2023-12-24','Vacaciones'),(21,'2023-12-25','Vacaciones'),(22,'2023-12-26','Vacaciones'),(23,'2023-12-27','Vacaciones'),(24,'2023-12-28','Vacaciones'),(25,'2023-12-29','Vacaciones'),(26,'2023-12-30','Vacaciones'),(27,'2023-12-31','Vacaciones'),(28,'2024-01-01','Vacaciones'),(29,'2024-01-02','Vacaciones'),(30,'2024-01-03','Vacaciones'),(31,'2024-01-04','Vacaciones'),(32,'2024-01-05','Vacaciones'),(33,'2024-01-06','Vacaciones'),(34,'2024-01-07','Vacaciones'),(35,'2024-01-08','Vacaciones'),(36,'2024-01-09','Vacaciones'),(37,'2024-01-10','Vacaciones'),(38,'2024-01-11','Vacaciones'),(39,'2024-01-12','Vacaciones'),(40,'2024-01-13','Vacaciones'),(41,'2024-01-14','Vacaciones'),(42,'2024-01-15','Vacaciones'),(43,'2024-01-16','Vacaciones'),(44,'2024-01-17','Vacaciones'),(45,'2024-01-18','Vacaciones'),(46,'2024-01-19','Vacaciones'),(47,'2024-01-20','Vacaciones'),(48,'2024-01-21','Vacaciones'),(49,'2024-01-22','Vacaciones'),(50,'2024-01-23','Vacaciones'),(51,'2024-01-24','Vacaciones'),(52,'2024-01-25','Vacaciones'),(53,'2024-01-26','Vacaciones'),(54,'2024-01-27','Vacaciones'),(55,'2024-01-28','Vacaciones'),(56,'2024-01-29','Vacaciones'),(57,'2024-01-30','Vacaciones'),(58,'2024-01-31','Vacaciones'),(59,'2024-02-01','Vacaciones'),(60,'2024-02-02','Vacaciones'),(61,'2024-02-03','Vacaciones'),(62,'2024-02-04','Vacaciones'),(63,'2024-02-05','Vacaciones'),(64,'2025-12-14','Vacaciones'),(65,'2025-12-15','Vacaciones'),(66,'2025-12-16','Vacaciones'),(67,'2025-12-17','Vacaciones'),(68,'2025-12-18','Vacaciones'),(69,'2025-12-19','Vacaciones'),(70,'2025-12-20','Vacaciones'),(71,'2025-12-21','Vacaciones'),(72,'2025-12-22','Vacaciones'),(73,'2025-12-23','Vacaciones'),(74,'2025-12-24','Vacaciones'),(75,'2025-12-25','Vacaciones'),(76,'2025-12-26','Vacaciones'),(77,'2025-12-27','Vacaciones'),(78,'2025-12-28','Vacaciones'),(79,'2025-12-29','Vacaciones'),(80,'2025-12-30','Vacaciones'),(81,'2025-12-31','Vacaciones'),(82,'2026-01-01','Vacaciones'),(83,'2026-01-02','Vacaciones'),(84,'2026-01-03','Vacaciones'),(85,'2026-01-04','Vacaciones'),(86,'2026-01-05','Vacaciones'),(87,'2026-01-06','Vacaciones'),(88,'2026-01-07','Vacaciones'),(89,'2026-01-08','Vacaciones'),(90,'2026-01-09','Vacaciones'),(91,'2026-01-10','Vacaciones'),(92,'2026-01-11','Vacaciones'),(93,'2026-01-12','Vacaciones'),(94,'2026-01-13','Vacaciones'),(95,'2026-01-14','Vacaciones'),(96,'2026-01-15','Vacaciones'),(97,'2026-01-16','Vacaciones'),(98,'2026-01-17','Vacaciones'),(99,'2026-01-18','Vacaciones'),(100,'2026-01-19','Vacaciones'),(101,'2026-01-20','Vacaciones'),(102,'2026-01-21','Vacaciones'),(103,'2026-01-22','Vacaciones'),(104,'2026-01-23','Vacaciones'),(105,'2026-01-24','Vacaciones'),(106,'2026-01-25','Vacaciones'),(107,'2026-01-26','Vacaciones'),(108,'2026-01-27','Vacaciones'),(109,'2026-01-28','Vacaciones'),(110,'2026-01-29','Vacaciones'),(111,'2026-01-30','Vacaciones'),(112,'2026-01-31','Vacaciones'),(113,'2026-02-01','Vacaciones'),(114,'2026-02-02','Vacaciones'),(115,'2026-02-03','Vacaciones'),(116,'2026-02-04','Vacaciones'),(117,'2026-02-05','Vacaciones'),(118,'2026-02-06','Vacaciones'),(119,'2026-02-07','Vacaciones'),(120,'2026-02-08','Vacaciones'),(121,'2026-02-09','Vacaciones'),(122,'2026-02-10','Vacaciones'),(123,'2026-02-11','Vacaciones'),(124,'2026-02-12','Vacaciones'),(125,'2026-02-13','Vacaciones'),(126,'2026-02-14','Vacaciones');
/*!40000 ALTER TABLE `dias_sin_consulta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especialidades`
--

DROP TABLE IF EXISTS `especialidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `especialidades` (
  `id_especialidad` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_especialidad`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidades`
--

LOCK TABLES `especialidades` WRITE;
/*!40000 ALTER TABLE `especialidades` DISABLE KEYS */;
INSERT INTO `especialidades` VALUES (1,'Ingenieria en sistemas'),(2,'Ingenieria Quimica'),(3,'Ingenieria Mecanica');
/*!40000 ALTER TABLE `especialidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especialidades_alumnos`
--

DROP TABLE IF EXISTS `especialidades_alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `especialidades_alumnos` (
  `id_especialidad_alumno` int NOT NULL AUTO_INCREMENT,
  `id_especialidad` int NOT NULL,
  `id_alumno` int NOT NULL,
  PRIMARY KEY (`id_especialidad_alumno`),
  KEY `fk_especialidades_alumnos_alumnos_idx` (`id_alumno`),
  KEY `fk_especialidades_alumnos_especialidades_idx` (`id_especialidad`),
  CONSTRAINT `fk_especialidades_alumnos_alumnos` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`legajo`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_especialidades_alumnos_especialidades` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidades` (`id_especialidad`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidades_alumnos`
--

LOCK TABLES `especialidades_alumnos` WRITE;
/*!40000 ALTER TABLE `especialidades_alumnos` DISABLE KEYS */;
INSERT INTO `especialidades_alumnos` VALUES (1,1,1),(2,2,1),(3,1,2);
/*!40000 ALTER TABLE `especialidades_alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_consulta`
--

DROP TABLE IF EXISTS `estados_consulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_consulta` (
  `id_estado_consulta` int NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(45) NOT NULL,
  PRIMARY KEY (`id_estado_consulta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_consulta`
--

LOCK TABLES `estados_consulta` WRITE;
/*!40000 ALTER TABLE `estados_consulta` DISABLE KEYS */;
INSERT INTO `estados_consulta` VALUES (1,'Pendiente'),(2,'Confirmada'),(3,'Bloqueada'),(4,'Cancelada');
/*!40000 ALTER TABLE `estados_consulta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_inscripcion`
--

DROP TABLE IF EXISTS `estados_inscripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_inscripcion` (
  `id_estado_inscripcion` int NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(45) NOT NULL,
  PRIMARY KEY (`id_estado_inscripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_inscripcion`
--

LOCK TABLES `estados_inscripcion` WRITE;
/*!40000 ALTER TABLE `estados_inscripcion` DISABLE KEYS */;
INSERT INTO `estados_inscripcion` VALUES (1,'Activo'),(2,'Asistido'),(3,'No asistido'),(4,'Cancelado');
/*!40000 ALTER TABLE `estados_inscripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripciones`
--

DROP TABLE IF EXISTS `inscripciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscripciones` (
  `id_inscripcion` int NOT NULL AUTO_INCREMENT,
  `fecha_inscripcion` date NOT NULL,
  `estado_inscripcion` int NOT NULL,
  `id_consulta` int NOT NULL,
  `id_alumno` int NOT NULL,
  PRIMARY KEY (`id_inscripcion`),
  KEY `id_consulta_idx` (`id_consulta`),
  KEY `fk_inscripciones_alumno_idx` (`id_alumno`),
  CONSTRAINT `fk_inscripciones_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`legajo`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_inscripciones_consultas` FOREIGN KEY (`id_consulta`) REFERENCES `consultas` (`id_consulta`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripciones`
--

LOCK TABLES `inscripciones` WRITE;
/*!40000 ALTER TABLE `inscripciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscripciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mapa_sitio`
--

DROP TABLE IF EXISTS `mapa_sitio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mapa_sitio` (
  `idmapa_sitio` int NOT NULL,
  `id_rol_usuario` int NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `path` varchar(100) NOT NULL,
  PRIMARY KEY (`idmapa_sitio`),
  KEY `fk_mapa_sitio_roles_usuario_idx` (`id_rol_usuario`),
  CONSTRAINT `fk_mapa_sitio_roles_usuario` FOREIGN KEY (`id_rol_usuario`) REFERENCES `roles_usuario` (`id_rol_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mapa_sitio`
--

LOCK TABLES `mapa_sitio` WRITE;
/*!40000 ALTER TABLE `mapa_sitio` DISABLE KEYS */;
INSERT INTO `mapa_sitio` VALUES (1,3,'Alumnos','abmAlumnos.php'),(2,3,'Profesores','abmProfesores.php'),(3,3,'Especialidades','abmEspecialidades.php'),(4,3,'Materias','abmMaterias.php'),(5,3,'Usuarios','abmUsuarios.php'),(6,3,'Consultas','abmConsultas.php'),(7,3,'Planilla Consultas','listadocentesdia.php'),(8,2,'Administrar Consultas','consultasProfesor.php'),(9,2,'Ver Inscriptos','listaInscriptos.php'),(10,2,'Perfil','perfil.php'),(11,1,'Perfil','perfil.php'),(12,1,'Inscripción a consultas','inscribir.php'),(13,1,'Mis Inscripciones','misinscripciones.php');
/*!40000 ALTER TABLE `mapa_sitio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mapa_sitio_previos`
--

DROP TABLE IF EXISTS `mapa_sitio_previos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mapa_sitio_previos` (
  `idmapa_sitio` int NOT NULL,
  `idmapa_sitio_anterior` int NOT NULL,
  `orden` int NOT NULL,
  PRIMARY KEY (`idmapa_sitio`,`idmapa_sitio_anterior`),
  KEY `fk_mp_previos_actual_idx` (`idmapa_sitio`),
  KEY `fk_mp_previos_anterior_idx` (`idmapa_sitio_anterior`),
  CONSTRAINT `fk_mp_previos_actual` FOREIGN KEY (`idmapa_sitio`) REFERENCES `mapa_sitio` (`idmapa_sitio`),
  CONSTRAINT `fk_mp_previos_anterior` FOREIGN KEY (`idmapa_sitio_anterior`) REFERENCES `mapa_sitio` (`idmapa_sitio`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mapa_sitio_previos`
--

LOCK TABLES `mapa_sitio_previos` WRITE;
/*!40000 ALTER TABLE `mapa_sitio_previos` DISABLE KEYS */;
INSERT INTO `mapa_sitio_previos` VALUES (6,2,1),(9,8,1);
/*!40000 ALTER TABLE `mapa_sitio_previos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materias`
--

DROP TABLE IF EXISTS `materias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materias` (
  `id_materia` int NOT NULL AUTO_INCREMENT,
  `nombre_materia` varchar(45) NOT NULL,
  `id_especialidad` int NOT NULL,
  PRIMARY KEY (`id_materia`),
  KEY `fk_materias_especialidad_idx` (`id_especialidad`),
  CONSTRAINT `fk_materias_especialidad` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidades` (`id_especialidad`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materias`
--

LOCK TABLES `materias` WRITE;
/*!40000 ALTER TABLE `materias` DISABLE KEYS */;
INSERT INTO `materias` VALUES (1,'Paradigmas de la programacion    ',1),(2,'Sistemas y organizaciones',1),(3,'Quimica organica',2),(4,'Termodinamica',3),(5,'Estabildiad',3),(6,'Quimica inorganica',2),(8,'Gestion de datos',1);
/*!40000 ALTER TABLE `materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materias_profesor`
--

DROP TABLE IF EXISTS `materias_profesor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materias_profesor` (
  `id_materia` int NOT NULL,
  `id_profesor` int NOT NULL,
  PRIMARY KEY (`id_materia`,`id_profesor`),
  KEY `fk_materias_profesor_profesor_idx` (`id_profesor`),
  CONSTRAINT `fk_materias_profesor_materia` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON UPDATE CASCADE,
  CONSTRAINT `fk_materias_profesor_profesor` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materias_profesor`
--

LOCK TABLES `materias_profesor` WRITE;
/*!40000 ALTER TABLE `materias_profesor` DISABLE KEYS */;
INSERT INTO `materias_profesor` VALUES (1,1),(2,1),(3,1);
/*!40000 ALTER TABLE `materias_profesor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificaciones` (
  `id_notificacion` int NOT NULL,
  `id_usuario` int NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `texto` varchar(300) NOT NULL,
  `leida` tinyint NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_notificacion`),
  KEY `fk_notificaciones_usuarios_idx` (`id_usuario`),
  CONSTRAINT `fk_notificaciones_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (1,2,'Prueba','Texto de prueba para una notificación',0,'2023-05-23');
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesor_consulta`
--

DROP TABLE IF EXISTS `profesor_consulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profesor_consulta` (
  `id_profesor_consulta` int NOT NULL AUTO_INCREMENT,
  `id_profesor` int NOT NULL,
  `id_dia_consulta` int NOT NULL,
  `hora` time NOT NULL,
  `id_materia` int NOT NULL,
  PRIMARY KEY (`id_profesor_consulta`),
  KEY `fk_profesor_consulta_profesor_idx` (`id_profesor`),
  KEY `fk_profesor_consulta_materia_idx` (`id_materia`),
  KEY `fk_profesor_consulta_dia_idx` (`id_dia_consulta`),
  CONSTRAINT `fk_profesor_consulta_dia` FOREIGN KEY (`id_dia_consulta`) REFERENCES `dias_consulta` (`id_dia_consulta`) ON UPDATE CASCADE,
  CONSTRAINT `fk_profesor_consulta_materia` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON UPDATE CASCADE,
  CONSTRAINT `fk_profesor_consulta_profesor` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesor_consulta`
--

LOCK TABLES `profesor_consulta` WRITE;
/*!40000 ALTER TABLE `profesor_consulta` DISABLE KEYS */;
INSERT INTO `profesor_consulta` VALUES (14,1,5,'20:00:00',1),(15,1,1,'22:33:00',1),(16,1,3,'17:35:00',3),(17,1,3,'19:20:00',2);
/*!40000 ALTER TABLE `profesor_consulta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesores`
--

DROP TABLE IF EXISTS `profesores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profesores` (
  `id_profesor` int NOT NULL AUTO_INCREMENT,
  `nombre_apellido` varchar(45) NOT NULL,
  `mail` varchar(45) NOT NULL,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_profesor`),
  KEY `fk_profesores_usuarios_idx` (`id_usuario`),
  CONSTRAINT `fk_profesores_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores`
--

LOCK TABLES `profesores` WRITE;
/*!40000 ALTER TABLE `profesores` DISABLE KEYS */;
INSERT INTO `profesores` VALUES (1,'Iwanow','lavarropas@gmail.com',6),(2,'Hergenreder','aherg@hotmail.com',5),(3,'Villamontee ','mvilla@gmail.com',10),(4,'Toscano','jtoscano@gmail.com',NULL),(5,'Marinsaldi','marinsaldi@outlook.com',NULL),(6,'Pedraza','jaunpedr@gmail.com',NULL),(7,'Montaldi','mmonti@gmail.com',NULL),(8,'Garnacho','garnacho79@gail.com',NULL),(12,'diana claudia','ass@gmail.com',12);
/*!40000 ALTER TABLE `profesores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_usuario`
--

DROP TABLE IF EXISTS `roles_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles_usuario` (
  `id_rol_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(45) NOT NULL,
  PRIMARY KEY (`id_rol_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_usuario`
--

LOCK TABLES `roles_usuario` WRITE;
/*!40000 ALTER TABLE `roles_usuario` DISABLE KEYS */;
INSERT INTO `roles_usuario` VALUES (1,'Alumno'),(2,'Profesor'),(3,'Administrador');
/*!40000 ALTER TABLE `roles_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `rol` int NOT NULL,
  `dni` int NOT NULL,
  `nombre_usuario` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `nombre_usuario_UNIQUE` (`nombre_usuario`),
  KEY `fk_usuarios_roles_usuario_idx` (`rol`),
  CONSTRAINT `fk_usuarios_roles_usuario` FOREIGN KEY (`rol`) REFERENCES `roles_usuario` (`id_rol_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,3,40111222,'admin','admin'),(2,1,41656727,'guidolorenzotti','guido1312'),(3,1,41662762,'lautarojuancano','mesa123'),(4,1,32847777,'francotecla','letritas123'),(5,1,27632243,'alvaherge  ','compu111 '),(6,2,22736000,'iwanow','montana288'),(7,2,36750093,'mariatoscanoo','asdqwe123'),(10,1,34546978,'elnuevo','nuevo01'),(11,1,22222222,'elsegundo','segundo01'),(12,1,12333212,'prueba','prueba');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-23 22:40:43
