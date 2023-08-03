-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Host: tvcpw8tpu4jvgnnq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com    Database: c1lglv9dmosspu2q
-- ------------------------------------------------------
-- Server version	8.0.28

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '';

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
  `dni` int NOT NULL,
  PRIMARY KEY (`legajo`),
  UNIQUE KEY `dni_UNIQUE` (`dni`),
  KEY `fk_alumnos_usuarios_idx` (`id_usuario`),
  CONSTRAINT `fk_alumnos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41234433 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` VALUES (1,'Lautaro Cano','lautarojuancano@gmail.com',3,41662762),(2,'Guido Lorenzotti','guidolorenzotti@gmail.com',2,41656727),(3,'Franco zengarini','fzengarini@gmail.com',4,32847777),(4,'Ignacio Curone','icurone@gmail.com',5,27632243),(5,'Valentina Obiedo','vobiedo@hotmail.com',11,22222222),(6,'Natalia Fernandez','nfernadez@gmail.com',12,12333212),(7,'Jorgelina Rogel','jrogel@gmail.com',10,34546978);
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
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`omzwmyajx1pnuzc1`@`%`*/ /*!50003 TRIGGER `ciclos_lectivos_AFTER_INSERT` AFTER INSERT ON `ciclos_lectivos` FOR EACH ROW BEGIN
	CALL `consultasutn`.`agregar_vacaciones`(new.fecha_inicio_vacaciones, new.fecha_fin_vacaciones);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  CONSTRAINT `fk_consultas_profesor_consulta` FOREIGN KEY (`id_profesor_consulta`) REFERENCES `profesor_consulta` (`id_profesor_consulta`) ON DELETE CASCADE,
  CONSTRAINT `fk_consultas_profesores` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=714 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultas`
--

LOCK TABLES `consultas` WRITE;
/*!40000 ALTER TABLE `consultas` DISABLE KEYS */;
INSERT INTO `consultas` VALUES (491,'17:30:00','2023-08-01',1,NULL,1,1,48),(492,'17:30:00','2023-08-08',3,'MOTIVOS PERSONALES',1,1,48),(493,'17:30:00','2023-08-15',1,NULL,1,1,48),(494,'17:30:00','2023-08-22',1,NULL,1,1,48),(495,'17:30:00','2023-08-29',1,NULL,1,1,48),(496,'17:30:00','2023-09-05',1,NULL,1,1,48),(497,'17:30:00','2023-09-12',1,NULL,1,1,48),(498,'17:30:00','2023-09-19',1,NULL,1,1,48),(499,'17:30:00','2023-09-26',1,NULL,1,1,48),(500,'17:30:00','2023-10-03',1,NULL,1,1,48),(501,'17:30:00','2023-10-10',1,NULL,1,1,48),(502,'17:30:00','2023-10-17',1,NULL,1,1,48),(503,'17:30:00','2023-10-24',1,NULL,1,1,48),(504,'17:30:00','2023-10-31',1,NULL,1,1,48),(505,'17:30:00','2023-11-07',1,NULL,1,1,48),(506,'17:30:00','2023-11-14',1,NULL,1,1,48),(507,'17:30:00','2023-11-21',1,NULL,1,1,48),(508,'17:30:00','2023-11-28',1,NULL,1,1,48),(509,'17:30:00','2023-12-05',1,NULL,1,1,48),(510,'17:30:00','2023-12-12',1,NULL,1,1,48),(511,'17:30:00','2024-02-06',1,NULL,1,1,48),(512,'17:30:00','2024-02-13',1,NULL,1,1,48),(513,'17:30:00','2024-02-20',1,NULL,1,1,48),(514,'17:30:00','2024-02-27',1,NULL,1,1,48),(515,'17:30:00','2024-03-05',1,NULL,1,1,48),(516,'17:30:00','2024-03-12',1,NULL,1,1,48),(517,'14:00:00','2023-07-27',2,NULL,1,2,49),(518,'14:00:00','2023-08-03',1,NULL,1,2,49),(519,'14:00:00','2023-08-10',1,NULL,1,2,49),(520,'14:00:00','2023-08-17',1,NULL,1,2,49),(521,'14:00:00','2023-08-24',1,NULL,1,2,49),(522,'14:00:00','2023-08-31',1,NULL,1,2,49),(523,'14:00:00','2023-09-07',1,NULL,1,2,49),(524,'14:00:00','2023-09-14',1,NULL,1,2,49),(525,'14:00:00','2023-09-28',1,NULL,1,2,49),(526,'14:00:00','2023-10-05',1,NULL,1,2,49),(527,'14:00:00','2023-10-12',1,NULL,1,2,49),(528,'14:00:00','2023-10-19',1,NULL,1,2,49),(529,'14:00:00','2023-10-26',1,NULL,1,2,49),(530,'14:00:00','2023-11-02',1,NULL,1,2,49),(531,'14:00:00','2023-11-09',1,NULL,1,2,49),(532,'14:00:00','2023-11-16',1,NULL,1,2,49),(533,'14:00:00','2023-11-23',1,NULL,1,2,49),(534,'14:00:00','2023-11-30',1,NULL,1,2,49),(535,'14:00:00','2023-12-07',1,NULL,1,2,49),(536,'14:00:00','2023-12-14',1,NULL,1,2,49),(537,'14:00:00','2024-02-08',1,NULL,1,2,49),(538,'14:00:00','2024-02-15',1,NULL,1,2,49),(539,'14:00:00','2024-02-22',1,NULL,1,2,49),(540,'14:00:00','2024-02-29',1,NULL,1,2,49),(541,'14:00:00','2024-03-07',1,NULL,1,2,49),(542,'14:00:00','2024-03-14',1,NULL,1,2,49),(543,'17:00:00','2023-07-26',1,NULL,2,24,50),(544,'17:00:00','2023-08-02',1,NULL,2,24,50),(545,'17:00:00','2023-08-09',1,NULL,2,24,50),(546,'17:00:00','2023-08-16',1,NULL,2,24,50),(547,'17:00:00','2023-08-23',1,NULL,2,24,50),(548,'17:00:00','2023-08-30',1,NULL,2,24,50),(549,'17:00:00','2023-09-06',1,NULL,2,24,50),(550,'17:00:00','2023-09-13',1,NULL,2,24,50),(551,'17:00:00','2023-09-20',1,NULL,2,24,50),(552,'17:00:00','2023-09-27',1,NULL,2,24,50),(553,'17:00:00','2023-10-04',1,NULL,2,24,50),(554,'17:00:00','2023-10-11',1,NULL,2,24,50),(555,'17:00:00','2023-10-18',1,NULL,2,24,50),(556,'17:00:00','2023-10-25',1,NULL,2,24,50),(557,'17:00:00','2023-11-01',1,NULL,2,24,50),(558,'17:00:00','2023-11-08',1,NULL,2,24,50),(559,'17:00:00','2023-11-15',1,NULL,2,24,50),(560,'17:00:00','2023-11-22',1,NULL,2,24,50),(561,'17:00:00','2023-11-29',1,NULL,2,24,50),(562,'17:00:00','2023-12-06',1,NULL,2,24,50),(563,'17:00:00','2023-12-13',1,NULL,2,24,50),(564,'17:00:00','2024-02-07',1,NULL,2,24,50),(565,'17:00:00','2024-02-14',1,NULL,2,24,50),(566,'17:00:00','2024-02-21',1,NULL,2,24,50),(567,'17:00:00','2024-02-28',1,NULL,2,24,50),(568,'17:00:00','2024-03-06',1,NULL,2,24,50),(569,'17:00:00','2024-03-13',1,NULL,2,24,50),(570,'16:30:00','2023-07-31',1,NULL,3,15,51),(571,'16:30:00','2023-08-07',1,NULL,3,15,51),(572,'16:30:00','2023-08-14',1,NULL,3,15,51),(573,'16:30:00','2023-08-28',1,NULL,3,15,51),(574,'16:30:00','2023-09-04',1,NULL,3,15,51),(575,'16:30:00','2023-09-11',1,NULL,3,15,51),(576,'16:30:00','2023-09-18',1,NULL,3,15,51),(577,'16:30:00','2023-09-25',1,NULL,3,15,51),(578,'16:30:00','2023-10-02',1,NULL,3,15,51),(579,'16:30:00','2023-10-09',1,NULL,3,15,51),(580,'16:30:00','2023-10-23',1,NULL,3,15,51),(581,'16:30:00','2023-10-30',1,NULL,3,15,51),(582,'16:30:00','2023-11-06',1,NULL,3,15,51),(583,'16:30:00','2023-11-13',1,NULL,3,15,51),(584,'16:30:00','2023-11-27',1,NULL,3,15,51),(585,'16:30:00','2023-12-04',1,NULL,3,15,51),(586,'16:30:00','2023-12-11',1,NULL,3,15,51),(587,'16:30:00','2023-12-18',1,NULL,3,15,51),(588,'16:30:00','2024-02-12',1,NULL,3,15,51),(589,'16:30:00','2024-02-19',1,NULL,3,15,51),(590,'16:30:00','2024-02-26',1,NULL,3,15,51),(591,'16:30:00','2024-03-04',1,NULL,3,15,51),(592,'16:30:00','2024-03-11',1,NULL,3,15,51),(593,'19:30:00','2023-07-28',1,NULL,4,6,52),(594,'19:30:00','2023-08-04',1,NULL,4,6,52),(595,'19:30:00','2023-08-11',1,NULL,4,6,52),(596,'19:30:00','2023-08-18',1,NULL,4,6,52),(597,'19:30:00','2023-08-25',1,NULL,4,6,52),(598,'19:30:00','2023-09-01',1,NULL,4,6,52),(599,'19:30:00','2023-09-08',1,NULL,4,6,52),(600,'19:30:00','2023-09-15',1,NULL,4,6,52),(601,'19:30:00','2023-09-22',1,NULL,4,6,52),(602,'19:30:00','2023-09-29',1,NULL,4,6,52),(603,'19:30:00','2023-10-06',1,NULL,4,6,52),(604,'19:30:00','2023-10-20',1,NULL,4,6,52),(605,'19:30:00','2023-10-27',1,NULL,4,6,52),(606,'19:30:00','2023-11-03',1,NULL,4,6,52),(607,'19:30:00','2023-11-10',1,NULL,4,6,52),(608,'19:30:00','2023-11-17',1,NULL,4,6,52),(609,'19:30:00','2023-11-24',1,NULL,4,6,52),(610,'19:30:00','2023-12-01',1,NULL,4,6,52),(611,'19:30:00','2023-12-15',1,NULL,4,6,52),(612,'19:30:00','2024-02-09',1,NULL,4,6,52),(613,'19:30:00','2024-02-16',1,NULL,4,6,52),(614,'19:30:00','2024-02-23',1,NULL,4,6,52),(615,'19:30:00','2024-03-01',1,NULL,4,6,52),(616,'19:30:00','2024-03-08',1,NULL,4,6,52),(617,'15:00:00','2023-07-31',3,'No podré asistir.',5,22,53),(618,'15:00:00','2023-08-07',1,NULL,5,22,53),(619,'15:00:00','2023-08-14',1,NULL,5,22,53),(620,'15:00:00','2023-08-28',1,NULL,5,22,53),(621,'15:00:00','2023-09-04',1,NULL,5,22,53),(622,'15:00:00','2023-09-11',1,NULL,5,22,53),(623,'15:00:00','2023-09-18',1,NULL,5,22,53),(624,'15:00:00','2023-09-25',1,NULL,5,22,53),(625,'15:00:00','2023-10-02',1,NULL,5,22,53),(626,'15:00:00','2023-10-09',1,NULL,5,22,53),(627,'15:00:00','2023-10-23',1,NULL,5,22,53),(628,'15:00:00','2023-10-30',1,NULL,5,22,53),(629,'15:00:00','2023-11-06',1,NULL,5,22,53),(630,'15:00:00','2023-11-13',1,NULL,5,22,53),(631,'15:00:00','2023-11-27',1,NULL,5,22,53),(632,'15:00:00','2023-12-04',1,NULL,5,22,53),(633,'15:00:00','2023-12-11',1,NULL,5,22,53),(634,'15:00:00','2023-12-18',1,NULL,5,22,53),(635,'15:00:00','2024-02-12',1,NULL,5,22,53),(636,'15:00:00','2024-02-19',1,NULL,5,22,53),(637,'15:00:00','2024-02-26',1,NULL,5,22,53),(638,'15:00:00','2024-03-04',1,NULL,5,22,53),(639,'15:00:00','2024-03-11',1,NULL,5,22,53),(640,'18:30:00','2023-07-26',1,NULL,5,23,54),(641,'18:30:00','2023-08-02',1,NULL,5,23,54),(642,'18:30:00','2023-08-09',1,NULL,5,23,54),(643,'18:30:00','2023-08-16',1,NULL,5,23,54),(644,'18:30:00','2023-08-23',1,NULL,5,23,54),(645,'18:30:00','2023-08-30',1,NULL,5,23,54),(646,'18:30:00','2023-09-06',1,NULL,5,23,54),(647,'18:30:00','2023-09-13',1,NULL,5,23,54),(648,'18:30:00','2023-09-20',1,NULL,5,23,54),(649,'18:30:00','2023-09-27',1,NULL,5,23,54),(650,'18:30:00','2023-10-04',1,NULL,5,23,54),(651,'18:30:00','2023-10-11',1,NULL,5,23,54),(652,'18:30:00','2023-10-18',1,NULL,5,23,54),(653,'18:30:00','2023-10-25',1,NULL,5,23,54),(654,'18:30:00','2023-11-01',1,NULL,5,23,54),(655,'18:30:00','2023-11-08',1,NULL,5,23,54),(656,'18:30:00','2023-11-15',1,NULL,5,23,54),(657,'18:30:00','2023-11-22',1,NULL,5,23,54),(658,'18:30:00','2023-11-29',1,NULL,5,23,54),(659,'18:30:00','2023-12-06',1,NULL,5,23,54),(660,'18:30:00','2023-12-13',1,NULL,5,23,54),(661,'18:30:00','2024-02-07',1,NULL,5,23,54),(662,'18:30:00','2024-02-14',1,NULL,5,23,54),(663,'18:30:00','2024-02-21',1,NULL,5,23,54),(664,'18:30:00','2024-02-28',1,NULL,5,23,54),(665,'18:30:00','2024-03-06',1,NULL,5,23,54),(666,'18:30:00','2024-03-13',1,NULL,5,23,54),(667,'19:30:00','2023-07-31',1,NULL,5,22,NULL),(668,'17:22:00','2023-08-01',1,NULL,5,22,NULL),(669,'14:00:00','2023-08-07',1,NULL,17,1,55),(670,'14:00:00','2023-08-14',1,NULL,17,1,55),(671,'14:00:00','2023-08-28',1,NULL,17,1,55),(672,'14:00:00','2023-09-04',1,NULL,17,1,55),(673,'14:00:00','2023-09-11',1,NULL,17,1,55),(674,'14:00:00','2023-09-18',1,NULL,17,1,55),(675,'14:00:00','2023-09-25',1,NULL,17,1,55),(676,'14:00:00','2023-10-02',1,NULL,17,1,55),(677,'14:00:00','2023-10-09',1,NULL,17,1,55),(678,'14:00:00','2023-10-23',1,NULL,17,1,55),(679,'14:00:00','2023-10-30',1,NULL,17,1,55),(680,'14:00:00','2023-11-06',1,NULL,17,1,55),(681,'14:00:00','2023-11-13',1,NULL,17,1,55),(682,'14:00:00','2023-11-27',1,NULL,17,1,55),(683,'14:00:00','2023-12-04',1,NULL,17,1,55),(684,'14:00:00','2023-12-11',1,NULL,17,1,55),(685,'14:00:00','2023-12-18',1,NULL,17,1,55),(686,'14:00:00','2024-02-12',1,NULL,17,1,55),(687,'14:00:00','2024-02-19',1,NULL,17,1,55),(688,'14:00:00','2024-02-26',1,NULL,17,1,55),(689,'14:00:00','2024-03-04',1,NULL,17,1,55),(690,'14:00:00','2024-03-11',1,NULL,17,1,55),(691,'13:00:00','2023-08-07',1,NULL,17,2,56),(692,'13:00:00','2023-08-14',1,NULL,17,2,56),(693,'13:00:00','2023-08-28',1,NULL,17,2,56),(694,'13:00:00','2023-09-04',1,NULL,17,2,56),(695,'13:00:00','2023-09-11',1,NULL,17,2,56),(696,'13:00:00','2023-09-18',1,NULL,17,2,56),(697,'13:00:00','2023-09-25',1,NULL,17,2,56),(698,'13:00:00','2023-10-02',1,NULL,17,2,56),(699,'13:00:00','2023-10-09',1,NULL,17,2,56),(700,'13:00:00','2023-10-23',1,NULL,17,2,56),(701,'13:00:00','2023-10-30',1,NULL,17,2,56),(702,'13:00:00','2023-11-06',1,NULL,17,2,56),(703,'13:00:00','2023-11-13',1,NULL,17,2,56),(704,'13:00:00','2023-11-27',1,NULL,17,2,56),(705,'13:00:00','2023-12-04',1,NULL,17,2,56),(706,'13:00:00','2023-12-11',1,NULL,17,2,56),(707,'13:00:00','2023-12-18',1,NULL,17,2,56),(708,'13:00:00','2024-02-12',1,NULL,17,2,56),(709,'13:00:00','2024-02-19',1,NULL,17,2,56),(710,'13:00:00','2024-02-26',1,NULL,17,2,56),(711,'13:00:00','2024-03-04',1,NULL,17,2,56),(712,'13:00:00','2024-03-11',1,NULL,17,2,56),(713,'17:29:00','2023-08-09',1,NULL,1,1,NULL);
/*!40000 ALTER TABLE `consultas` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`omzwmyajx1pnuzc1`@`%`*/ /*!50003 TRIGGER `consultas_AFTER_UPDATE` AFTER UPDATE ON `consultas` FOR EACH ROW BEGIN
	DECLARE v_id_usuario INT;
    DECLARE v_texto VARCHAR(200);
    DECLARE contador INT DEFAULT 0;
    DECLARE cursor1 CURSOR FOR  select distinct id_usuario from inscripciones i
								inner join alumnos a on i.id_alumno = a.legajo
								where i.id_consulta = new.id_consulta;
    DECLARE EXIT HANDLER FOR NOT FOUND SET contador = 0;                             

	IF new.id_estado_consulta = 3 THEN
		SELECT concat(nombre_apellido,' ha cancelado la consulta del día '
				,new.fecha_consulta,' por: ',new.motivo_cancelacion)
        INTO v_texto
        FROM profesores p
        WHERE p.id_profesor = new.id_profesor;
        
		OPEN cursor1;
		bucle: LOOP
		FETCH cursor1 INTO v_id_usuario;

			insert into notificaciones(id_usuario, titulo,texto,leida,fecha)
			values (v_id_usuario, 'Consulta bloqueada', v_texto, 0, current_date());
            
		END LOOP;
    END IF;
    
    IF new.id_estado_consulta = 2 THEN 
		update inscripciones set estado_inscripcion = 2 where id_consulta = new.id_consulta;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
  CONSTRAINT `fk_especialidades_alumnos_alumnos` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`legajo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_especialidades_alumnos_especialidades` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidades` (`id_especialidad`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidades_alumnos`
--

LOCK TABLES `especialidades_alumnos` WRITE;
/*!40000 ALTER TABLE `especialidades_alumnos` DISABLE KEYS */;
INSERT INTO `especialidades_alumnos` VALUES (1,1,1),(3,1,2),(4,1,3),(5,2,4),(6,2,5),(7,3,6),(22,3,7),(33,3,1);
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
INSERT INTO `estados_consulta` VALUES (1,'Pendiente'),(2,'Realizada'),(3,'Bloqueada'),(4,'Cancelada');
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripciones`
--

LOCK TABLES `inscripciones` WRITE;
/*!40000 ALTER TABLE `inscripciones` DISABLE KEYS */;
INSERT INTO `inscripciones` VALUES (12,'2023-07-26',1,640,1),(13,'2023-07-26',4,593,1),(14,'2023-07-26',1,617,1),(16,'2023-08-01',1,491,2),(17,'2023-08-01',1,492,2),(18,'2023-08-01',1,499,2);
/*!40000 ALTER TABLE `inscripciones` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`omzwmyajx1pnuzc1`@`%`*/ /*!50003 TRIGGER `inscripciones_AFTER_INSERT` AFTER INSERT ON `inscripciones` FOR EACH ROW BEGIN
	DECLARE v_id_usuario INT;
    DECLARE v_texto VARCHAR(200);
    DECLARE v_materia VARCHAR(45);
    DECLARE v_fecha DATE;
                                
	select id_usuario, nombre_materia, fecha_consulta
	into v_id_usuario, v_materia, v_fecha
	from consultas c
	inner join profesores p on c.id_profesor = p.id_profesor
	inner join materias m on m.id_materia = c.id_materia
	where c.id_consulta = new.id_consulta;                     

	SELECT concat(nombre_apellido,' se ha inscripto a la consulta de ', v_materia,
	' del día ',DATE_FORMAT(v_fecha, '%d %m %Y'),'.')
	INTO v_texto
	FROM alumnos a
	WHERE a.legajo = new.id_alumno;

	insert into notificaciones(id_usuario, titulo,texto,leida,fecha)
	values (v_id_usuario, 'Nueva inscripción', v_texto, 0, current_date());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`omzwmyajx1pnuzc1`@`%`*/ /*!50003 TRIGGER `inscripciones_AFTER_UPDATE` AFTER UPDATE ON `inscripciones` FOR EACH ROW BEGIN
	DECLARE v_id_usuario INT;
    DECLARE v_texto VARCHAR(200);
    DECLARE v_materia VARCHAR(45);
    DECLARE v_fecha DATE;
	IF new.estado_inscripcion = 4 THEN                        
		select id_usuario, nombre_materia, fecha_consulta
		into v_id_usuario, v_materia, v_fecha
		from consultas c
		inner join profesores p on c.id_profesor = p.id_profesor
		inner join materias m on m.id_materia = c.id_materia
		where c.id_consulta = new.id_consulta;                     

		SELECT concat(nombre_apellido,' ha cancelado su inscripción a la consulta de ', v_materia,
		' del día ',DATE_FORMAT(v_fecha, '%d %m %Y'),'.')
		INTO v_texto
		FROM alumnos a
		WHERE a.legajo = new.id_alumno;

		insert into notificaciones(id_usuario, titulo,texto,leida,fecha)
		values (v_id_usuario, 'Inscripción cancelada', v_texto, 0, current_date());
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
INSERT INTO `mapa_sitio` VALUES (1,3,'Alumnos','abmAlumnos.php'),(2,3,'Profesores','abmProfesores.php'),(3,3,'Especialidades','abmEspecialidades.php'),(4,3,'Materias','abmMaterias.php'),(5,3,'Usuarios','abmUsuarios.php'),(6,3,'Consultas','abmConsultas.php'),(7,3,'Planilla Consultas','listadocentesdia.php'),(8,2,'Administrar Consultas','consultasProfesor.php'),(9,2,'Ver Inscriptos','listaInscriptos.php'),(10,2,'Perfil','perfil.php'),(11,1,'Perfil','perfil.php'),(12,1,'Inscripción a consultas','inscribir.php'),(13,1,'Mis Inscripciones','misinscripciones.php'),(14,3,'Materias','abmMateriasProfesor.php');
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
INSERT INTO `mapa_sitio_previos` VALUES (6,2,1),(9,8,1),(14,2,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materias`
--

LOCK TABLES `materias` WRITE;
/*!40000 ALTER TABLE `materias` DISABLE KEYS */;
INSERT INTO `materias` VALUES (1,'Analisis de Sistemas',1),(2,'Sintaxis y Semantica de los Lenguajes',1),(3,'Paradigmas de Programacion',1),(4,'Analisis Matematico II',3),(5,'Fisica II',3),(6,'Ingenieria Ambiental y Seguridad Industrial',3),(8,'Ingenieria Mecanica II',3),(9,'Ingles I',3),(10,'Integracion II',2),(11,'Probabilidad y Estadistica',2),(12,'Quimica Inorganica',2),(13,'Fisica I',2),(14,'Fisica II',2),(15,'Quimica Organica',2),(16,'Ingles I',2),(17,'Matematica Superior Aplicada',2),(18,'Quimica',1),(19,'Analisis Matematico II',1),(20,'Fisica II',1),(21,'Quimica Aplicada',3),(22,'Estabilidad I',3),(23,'Materiales Metalicos',3),(24,'Sistemas Operativos',1),(25,'Sistemas de Representacion',1);
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
INSERT INTO `materias_profesor` VALUES (1,1),(2,1),(3,1),(1,2),(24,2),(12,3),(15,3),(18,3),(6,4),(21,4),(22,5),(23,5),(4,6),(11,6),(19,6),(5,7),(13,7),(14,7),(20,7),(8,8),(10,8),(17,9),(25,9),(9,10),(16,10),(1,17),(2,17);
/*!40000 ALTER TABLE `materias_profesor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificaciones` (
  `id_notificacion` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `texto` varchar(300) NOT NULL,
  `leida` tinyint NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_notificacion`),
  KEY `fk_notificaciones_usuarios_idx` (`id_usuario`),
  CONSTRAINT `fk_notificaciones_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (18,15,'Nueva inscripción','Lautaro Cano se ha inscripto a la consulta de Materiales Metalicos del día 26 07 2023.',0,'2023-07-26'),(19,14,'Nueva inscripción','Lautaro Cano se ha inscripto a la consulta de Ingenieria Ambiental y Seguridad Industrial del día 28 07 2023.',0,'2023-07-26'),(20,15,'Nueva inscripción','Lautaro Cano se ha inscripto a la consulta de Estabilidad I del día 31 07 2023.',0,'2023-07-26'),(21,14,'Inscripción cancelada','Lautaro Cano ha cancelado su inscripción a la consulta de Ingenieria Ambiental y Seguridad Industrial del día 28 07 2023.',0,'2023-07-26'),(22,3,'Consulta bloqueada','Ana Marinsaldi ha cancelado la consulta del día 2023-07-31 por: No podré asistir.',1,'2023-07-26'),(23,3,'Consulta bloqueada','Ana Marinsaldi ha cancelado la consulta del día 2023-07-31 por: No podré asistir.',0,'2023-07-26'),(24,7,'Nueva inscripción','Guido Lorenzotti se ha inscripto a la consulta de Analisis de Sistemas del día 01 08 2023.',0,'2023-08-01'),(25,7,'Nueva inscripción','Guido Lorenzotti se ha inscripto a la consulta de Analisis de Sistemas del día 08 08 2023.',0,'2023-08-01'),(26,7,'Nueva inscripción','Guido Lorenzotti se ha inscripto a la consulta de Analisis de Sistemas del día 26 09 2023.',0,'2023-08-01'),(27,2,'Consulta bloqueada','Jorge Iwanow ha cancelado la consulta del día 2023-08-08 por: MOTIVOS PERSONALES',0,'2023-08-01');
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preguntas_frecuentes`
--

DROP TABLE IF EXISTS `preguntas_frecuentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preguntas_frecuentes` (
  `id_pregunta_frecuente` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  `id_rol_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_pregunta_frecuente`),
  KEY `fk_preguntas_rol_idx` (`id_rol_usuario`),
  CONSTRAINT `fk_preguntas_rol` FOREIGN KEY (`id_rol_usuario`) REFERENCES `roles_usuario` (`id_rol_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preguntas_frecuentes`
--

LOCK TABLES `preguntas_frecuentes` WRITE;
/*!40000 ALTER TABLE `preguntas_frecuentes` DISABLE KEYS */;
INSERT INTO `preguntas_frecuentes` VALUES (1,'¿Cómo inscribirse a una consulta?','Ingresar a \"Inscribirse a consultas\" desde el home, o la barra desplegable. A continuacion deberá buscar la consulta deseada y presionar el botón \"Inscribirse\".',1),(2,'¿Qué pasa si el profesor cancela la consulta?','En este caso recibirás una notificacion en la seccion corresponidente donde se detalla la consulta y el motivo de cancelación.',1),(3,'¿Cómo cancelo una inscripción?','Ingrese en \"Mis inscripciones\". Allí se listarán todas las consultas pendientes. Al cancelar la inscripción se le enviará una notificación a su profesor.',1),(4,'¿Cómo veo que alumnos están inscriptos a una consulta?','En la sección \"Administrar consultas\" encontrará un botón que permite listar e imprimir un detalle de los alumnos inscriptos.',2),(5,'¿Cómo bloqueo una consulta?','En la sección \"Administrar consultas\" encontrará un botón que permite bloquear la consulta deseada. Deberá incluir el motivo de bloqueo.',2),(6,'¿Puedo bloquear una consulta en cualquier momento?','Esto solo podrá hacerlo hasta 2 horas antes del horario planificado de la consulta. Se le avisará al alumno de esta situacion detallando el motivo.',2);
/*!40000 ALTER TABLE `preguntas_frecuentes` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesor_consulta`
--

LOCK TABLES `profesor_consulta` WRITE;
/*!40000 ALTER TABLE `profesor_consulta` DISABLE KEYS */;
INSERT INTO `profesor_consulta` VALUES (48,1,2,'17:30:00',1),(49,1,4,'14:00:00',2),(50,2,3,'17:00:00',24),(51,3,1,'16:30:00',15),(52,4,5,'19:30:00',6),(53,5,1,'15:00:00',22),(54,5,3,'18:30:00',23),(55,17,1,'14:00:00',1),(56,17,1,'13:00:00',2);
/*!40000 ALTER TABLE `profesor_consulta` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`omzwmyajx1pnuzc1`@`%`*/ /*!50003 TRIGGER `profesor_consulta_AFTER_INSERT` AFTER INSERT ON `profesor_consulta` FOR EACH ROW BEGIN
	CALL InsertarRegistros(
    NEW.id_profesor_consulta,
	NEW.id_profesor,
    NEW.id_materia,
    NEW.id_dia_consulta,
    NEW.hora
	);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `dni` int NOT NULL,
  PRIMARY KEY (`id_profesor`),
  UNIQUE KEY `dni_UNIQUE` (`dni`),
  KEY `fk_profesores_usuarios_idx` (`id_usuario`),
  CONSTRAINT `fk_profesores_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores`
--

LOCK TABLES `profesores` WRITE;
/*!40000 ALTER TABLE `profesores` DISABLE KEYS */;
INSERT INTO `profesores` VALUES (1,'Jorge Iwanow','guidolorenzotti@hotmail.com',7,36750093),(2,'Alvaro Hergenreder','guidolorenzotti@hotmail.com',13,22455454),(3,'Maria Villamonte','guidolorenzotti@hotmail.com',6,22736000),(4,'Jose Toscano','lautarojuancano@gmail.com',14,21434589),(5,'Ana Marinsaldi','lautarojuancano@gmail.com',15,18887654),(6,'Juan Pedraza','lautarojuancano@gmail.com',16,32695438),(7,'Micaela Montaldi','lautarojuancano@gmail.com',17,31457996),(8,'Hernan Paez','guidolorenzotti@hotmail.com',18,22590304),(9,'Ivan Cerrudo','guidolorenzotti@hotmail.com',19,19984483),(10,'Claudia Rodriguez','guidolorenzotti@hotmail.com',20,39226642),(17,'Daniela Díaz','danielisabet@yahoo.com',NULL,12345678);
/*!40000 ALTER TABLE `profesores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_usuarios`
--

DROP TABLE IF EXISTS `registro_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro_usuarios` (
  `id_registro_usuario` int NOT NULL AUTO_INCREMENT,
  `id_rol_usuario` int NOT NULL,
  `dni` int NOT NULL,
  `nombre_usuario` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `validado` tinyint NOT NULL,
  `fecha` timestamp NOT NULL,
  PRIMARY KEY (`id_registro_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_usuarios`
--

LOCK TABLES `registro_usuarios` WRITE;
/*!40000 ALTER TABLE `registro_usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro_usuarios` ENABLE KEYS */;
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
  `nombre_usuario` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `nombre_usuario_UNIQUE` (`nombre_usuario`),
  KEY `fk_usuarios_roles_usuario_idx` (`rol`),
  CONSTRAINT `fk_usuarios_roles_usuario` FOREIGN KEY (`rol`) REFERENCES `roles_usuario` (`id_rol_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,3,'admin','admin'),(2,1,'guidolorenzotti','guido2023'),(3,1,'lautarojuancano','lautaro2023'),(4,1,'francozengarini','letritas123'),(5,1,'ignacioncurone','compu111 '),(6,2,'mariavillamonte','montana288'),(7,2,'jorgeiwanow','jorge2023'),(10,1,'jorgelinarogel','nuevo01'),(11,1,'valentinaobiedo','segundo01'),(12,1,'nataliafernandez','prueba'),(13,2,'alvarohergenreder','alvaro2023'),(14,2,'josetoscano','jose2023'),(15,2,'anamarinsaldi','ana2023'),(16,2,'juanpedraza','juan2023'),(17,2,'micaelamontaldi','micaela2023'),(18,2,'hernanpaez','hernan2023'),(19,2,'ivancerrudo','ivan2023'),(20,2,'claudiarodriguez','claudia2023');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'c1lglv9dmosspu2q'
--
/*!50003 DROP FUNCTION IF EXISTS `validar_registro` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`omzwmyajx1pnuzc1`@`%` FUNCTION `validar_registro`(p_code VARCHAR(20)) RETURNS varchar(100) CHARSET utf8mb4
BEGIN
	DECLARE v_count INT;
    DECLARE v_respuesta VARCHAR(100);
    DECLARE v_id_rol INT;
    DECLARE v_dni INT;
    DECLARE v_nombre_usuario VARCHAR(45);
    DECLARE v_password VARCHAR(45);
    DECLARE v_id_usuario INT;
    
	select count(*) into v_count from registro_usuarios where codigo=p_code 
    and validado = 0
    and fecha>=DATE_ADD(NOW(), INTERVAL -2 HOUR);
    if v_count = 1 then
		select id_rol_usuario, dni, nombre_usuario, password
        into v_id_rol, v_dni, v_nombre_usuario, v_password
        from registro_usuarios 
        where codigo=p_code and validado = 0 and fecha>=DATE_ADD(NOW(), INTERVAL -2 HOUR);
        
        update registro_usuarios set validado = 1
        where codigo=p_code and validado = 0 and fecha>=DATE_ADD(NOW(), INTERVAL -2 HOUR);
        
		insert into usuarios(rol,nombre_usuario,password) values(v_id_rol,v_nombre_usuario, v_password);
        SELECT LAST_INSERT_ID() into v_id_usuario;
        if v_id_rol=1 then
			update alumnos set id_usuario =  v_id_usuario where dni = v_dni;
        else
			if v_id_rol=2 then
				update profesores set id_usuario =  v_id_usuario where dni = v_dni;
			end if;
        end if;
        
        select "Usuario registrado" into v_respuesta;
	else
		select "No se encontró usuario para el código de validación" into v_respuesta;
    end if;
RETURN v_respuesta;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `agregar_vacaciones` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`omzwmyajx1pnuzc1`@`%` PROCEDURE `agregar_vacaciones`(IN fecha_inicio DATE, IN fecha_fin DATE)
BEGIN
    DECLARE v_fecha_actual DATE;    
    SET v_fecha_actual = fecha_inicio;
    
    WHILE v_fecha_actual <= fecha_fin DO
		INSERT INTO dias_sin_consulta (fecha, descripcion)
		VALUES (v_fecha_actual,'Vacaciones');
        
        SET v_fecha_actual = v_fecha_actual + INTERVAL 1 DAY; -- Avanzar al siguiente día
    END WHILE;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `InsertarRegistros` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`omzwmyajx1pnuzc1`@`%` PROCEDURE `InsertarRegistros`(
	IN p_id_profesor_consulta INT,
    IN p_id_profesor INT,
    IN p_id_materia INT,
    IN p_id_dia_consulta INT,
    IN p_hora TIME
)
BEGIN
    DECLARE v_fecha_inicio DATE;
    DECLARE v_fecha_fin DATE;
    DECLARE v_fecha_actual DATE;
    DECLARE v_day_name varchar(15);
    DECLARE v_feriado varchar(1);
    
    SELECT fecha_inicio, fecha_fin
    INTO v_fecha_inicio, v_fecha_fin
    FROM ciclos_lectivos
    WHERE activo = 1;
    
    IF current_date() > v_fecha_inicio THEN
		SET v_fecha_actual = current_date();
    ELSE
		SET v_fecha_actual = fecha_inicio;
    END IF;
    
    WHILE v_fecha_actual <= v_fecha_fin DO
		SET v_feriado = 'F';
        
		SELECT dia_mysql
        INTO v_day_name
        FROM dias_consulta
        WHERE id_dia_consulta = p_id_dia_consulta;
        
        select 'V' into v_feriado from dias_sin_consulta d where d.fecha = v_fecha_actual;
        
        IF DAYNAME(v_fecha_actual) = v_day_name and v_feriado != 'V' THEN
            INSERT INTO consultas (id_profesor_consulta, fecha_consulta, hora_consulta,id_profesor,id_materia,id_estado_consulta)
            VALUES (p_id_profesor_consulta, v_fecha_actual, p_hora, p_id_profesor, p_id_materia, 1);
        END IF;
        
        SET v_fecha_actual = v_fecha_actual + INTERVAL 1 DAY; -- Avanzar al siguiente día
    END WHILE;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insertar_alumno` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`omzwmyajx1pnuzc1`@`%` PROCEDURE `insertar_alumno`(IN p_legajo INT, IN p_nombre_apellido VARCHAR(45), IN p_mail VARCHAR(45), IN p_dni INT, IN p_id_usuario VARCHAR(45), IN p_especialidades VARCHAR(255))
BEGIN
	if p_id_usuario != '' THEN
		INSERT INTO alumnos (legajo, nombre_apellido, mail, id_usuario, dni)
		Values (p_legajo,p_nombre_apellido, p_mail, p_id_usuario, p_dni);
    ELSE
		INSERT INTO alumnos (legajo, nombre_apellido, mail, dni)
		Values (p_legajo,p_nombre_apellido, p_mail, p_dni);
    END IF;
    insert into especialidades_alumnos(id_especialidad, id_alumno)
		SELECT id_especialidad, p_legajo FROM especialidades WHERE instr(p_especialidades,concat(";",id_especialidad,";"))!=0;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `modificar_alumno` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`omzwmyajx1pnuzc1`@`%` PROCEDURE `modificar_alumno`(IN p_legajo INT, IN p_nombre_apellido VARCHAR(45), IN p_mail VARCHAR(45),IN p_dni INT, IN p_id_usuario VARCHAR(45), IN p_especialidades VARCHAR(255))
BEGIN
	if p_id_usuario != '' THEN
		UPDATE alumnos SET legajo = p_legajo, nombre_apellido = p_nombre_apellido, mail = p_mail, id_usuario = p_id_usuario, dni = p_dni
                        WHERE legajo = p_legajo;
    ELSE
		UPDATE alumnos SET legajo = p_legajo, nombre_apellido = p_nombre_apellido, mail = p_mail, dni= p_dni, id_usuario = null
                        WHERE legajo = p_legajo;
    END IF;
	
    delete from especialidades_alumnos where id_alumno =  p_legajo;   
    insert into especialidades_alumnos(id_especialidad, id_alumno)
		SELECT id_especialidad, p_legajo FROM especialidades WHERE instr(p_especialidades,concat(';',id_especialidad,';'))!=0;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-02 23:24:14
