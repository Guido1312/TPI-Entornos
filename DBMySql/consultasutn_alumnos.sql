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
INSERT INTO `alumnos` VALUES (1,'Lautaro Canoo ','lcano@gmail.com',3),(2,'Guido Lorenzotti','guidolorenzotti@gmail.com',2),(3,'Franco zengarini','fzengarini@gmail.com',4),(4,'Ignacio Curone','icurone@gmail.com',5),(5,'Valentina Obiedo','vobiedo@hotmail.com',11),(6,'Natalia Fernandez','nfernadez@gmail.com',12),(7,'Nadia Alarcon','nalarcon@gmail.com',10);
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
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `ciclos_lectivos_AFTER_INSERT` AFTER INSERT ON `ciclos_lectivos` FOR EACH ROW BEGIN
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
  CONSTRAINT `fk_consultas_profesor_consulta` FOREIGN KEY (`id_profesor_consulta`) REFERENCES `profesor_consulta` (`id_profesor_consulta`) ON DELETE SET NULL,
  CONSTRAINT `fk_consultas_profesores` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=349 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultas`
--

LOCK TABLES `consultas` WRITE;
/*!40000 ALTER TABLE `consultas` DISABLE KEYS */;
INSERT INTO `consultas` VALUES (214,'20:00:00','2023-06-02',1,NULL,1,21,NULL),(215,'20:00:00','2023-06-09',1,NULL,1,21,NULL),(216,'20:00:00','2023-06-16',1,NULL,1,21,NULL),(217,'20:00:00','2023-06-23',1,NULL,1,21,NULL),(218,'20:00:00','2023-06-30',1,NULL,1,21,NULL),(219,'20:00:00','2023-07-07',1,NULL,1,21,NULL),(220,'20:00:00','2023-07-14',1,NULL,1,21,NULL),(221,'20:00:00','2023-07-21',1,NULL,1,21,NULL),(222,'20:00:00','2023-07-28',1,NULL,1,21,NULL),(223,'20:00:00','2023-08-04',1,NULL,1,21,NULL),(224,'20:00:00','2023-08-11',1,NULL,1,21,NULL),(225,'20:00:00','2023-08-18',1,NULL,1,21,NULL),(226,'20:00:00','2023-08-25',1,NULL,1,21,NULL),(227,'20:00:00','2023-09-01',1,NULL,1,21,NULL),(228,'20:00:00','2023-09-08',1,NULL,1,21,NULL),(229,'20:00:00','2023-09-15',1,NULL,1,21,NULL),(230,'20:00:00','2023-09-22',1,NULL,1,21,NULL),(231,'20:00:00','2023-09-29',1,NULL,1,21,NULL),(232,'20:00:00','2023-10-06',1,NULL,1,21,NULL),(233,'20:00:00','2023-10-20',1,NULL,1,21,NULL),(234,'20:00:00','2023-10-27',1,NULL,1,21,NULL),(235,'20:00:00','2023-11-03',1,NULL,1,21,NULL),(236,'20:00:00','2023-11-10',1,NULL,1,21,NULL),(237,'20:00:00','2023-11-17',1,NULL,1,21,NULL),(238,'20:00:00','2023-11-24',1,NULL,1,21,NULL),(239,'20:00:00','2023-12-01',1,NULL,1,21,NULL),(240,'20:00:00','2023-12-15',1,NULL,1,21,NULL),(241,'20:00:00','2024-02-09',1,NULL,1,21,NULL),(242,'20:00:00','2024-02-16',1,NULL,1,21,NULL),(243,'20:00:00','2024-02-23',1,NULL,1,21,NULL),(244,'20:00:00','2024-03-01',1,NULL,1,21,NULL),(245,'20:00:00','2024-03-08',1,NULL,1,21,NULL),(246,'22:33:00','2023-05-29',1,NULL,1,21,NULL),(247,'22:33:00','2023-06-05',1,NULL,1,21,NULL),(248,'22:33:00','2023-06-12',1,NULL,1,21,NULL),(249,'22:33:00','2023-06-26',1,NULL,1,21,NULL),(250,'22:33:00','2023-07-03',1,NULL,1,21,NULL),(251,'22:33:00','2023-07-10',1,NULL,1,21,NULL),(252,'22:33:00','2023-07-17',1,NULL,1,21,NULL),(253,'22:33:00','2023-07-24',1,NULL,1,21,NULL),(254,'22:33:00','2023-07-31',1,NULL,1,21,NULL),(255,'22:33:00','2023-08-07',1,NULL,1,21,NULL),(256,'22:33:00','2023-08-14',1,NULL,1,21,NULL),(257,'22:33:00','2023-08-28',1,NULL,1,21,NULL),(258,'22:33:00','2023-09-04',1,NULL,1,21,NULL),(259,'22:33:00','2023-09-11',1,NULL,1,21,NULL),(260,'22:33:00','2023-09-18',1,NULL,1,21,NULL),(261,'22:33:00','2023-09-25',1,NULL,1,21,NULL),(262,'22:33:00','2023-10-02',1,NULL,1,21,NULL),(263,'22:33:00','2023-10-09',1,NULL,1,21,NULL),(264,'22:33:00','2023-10-23',1,NULL,1,21,NULL),(265,'22:33:00','2023-10-30',1,NULL,1,21,NULL),(266,'22:33:00','2023-11-06',1,NULL,1,21,NULL),(267,'22:33:00','2023-11-13',1,NULL,1,21,NULL),(268,'22:33:00','2023-11-27',1,NULL,1,21,NULL),(269,'22:33:00','2023-12-04',1,NULL,1,21,NULL),(270,'22:33:00','2023-12-11',1,NULL,1,21,NULL),(271,'22:33:00','2023-12-18',1,NULL,1,21,NULL),(272,'22:33:00','2024-02-12',1,NULL,1,21,NULL),(273,'22:33:00','2024-02-19',1,NULL,1,21,NULL),(274,'22:33:00','2024-02-26',1,NULL,1,21,NULL),(275,'22:33:00','2024-03-04',1,NULL,1,21,NULL),(276,'22:33:00','2024-03-11',1,NULL,1,21,NULL),(277,'17:35:00','2023-05-24',1,NULL,1,23,NULL),(278,'17:35:00','2023-05-31',1,NULL,1,23,NULL),(279,'17:35:00','2023-06-07',1,NULL,1,23,NULL),(280,'17:35:00','2023-06-14',1,NULL,1,23,NULL),(281,'17:35:00','2023-06-21',1,NULL,1,23,NULL),(282,'17:35:00','2023-06-28',1,NULL,1,23,NULL),(283,'17:35:00','2023-07-05',1,NULL,1,23,NULL),(284,'17:35:00','2023-07-12',1,NULL,1,23,NULL),(285,'17:35:00','2023-07-19',1,NULL,1,23,NULL),(286,'17:35:00','2023-07-26',1,NULL,1,23,NULL),(287,'17:35:00','2023-08-02',1,NULL,1,23,NULL),(288,'17:35:00','2023-08-09',1,NULL,1,23,NULL),(289,'17:35:00','2023-08-16',1,NULL,1,23,NULL),(290,'17:35:00','2023-08-23',1,NULL,1,23,NULL),(291,'17:35:00','2023-08-30',1,NULL,1,23,NULL),(292,'17:35:00','2023-09-06',1,NULL,1,23,NULL),(293,'17:35:00','2023-09-13',1,NULL,1,23,NULL),(294,'17:35:00','2023-09-20',1,NULL,1,23,NULL),(295,'17:35:00','2023-09-27',1,NULL,1,23,NULL),(296,'17:35:00','2023-10-04',1,NULL,1,23,NULL),(297,'17:35:00','2023-10-11',1,NULL,1,23,NULL),(298,'17:35:00','2023-10-18',1,NULL,1,23,NULL),(299,'17:35:00','2023-10-25',1,NULL,1,23,NULL),(300,'17:35:00','2023-11-01',1,NULL,1,23,NULL),(301,'17:35:00','2023-11-08',1,NULL,1,23,NULL),(302,'17:35:00','2023-11-15',1,NULL,1,23,NULL),(303,'17:35:00','2023-11-22',1,NULL,1,23,NULL),(304,'17:35:00','2023-11-29',1,NULL,1,23,NULL),(305,'17:35:00','2023-12-06',1,NULL,1,23,NULL),(306,'17:35:00','2023-12-13',1,NULL,1,23,NULL),(307,'17:35:00','2024-02-07',1,NULL,1,23,NULL),(308,'17:35:00','2024-02-14',1,NULL,1,23,NULL),(309,'17:35:00','2024-02-21',1,NULL,1,23,NULL),(310,'17:35:00','2024-02-28',1,NULL,1,23,NULL),(311,'17:35:00','2024-03-06',1,NULL,1,23,NULL),(312,'17:35:00','2024-03-13',1,NULL,1,23,NULL),(313,'19:20:00','2023-05-24',1,NULL,1,22,NULL),(314,'19:20:00','2023-05-31',1,NULL,1,22,NULL),(315,'19:20:00','2023-06-07',1,NULL,1,22,NULL),(316,'19:20:00','2023-06-14',1,NULL,1,22,NULL),(317,'19:20:00','2023-06-21',1,NULL,1,22,NULL),(318,'19:20:00','2023-06-28',1,NULL,1,22,NULL),(319,'19:20:00','2023-07-05',1,NULL,1,22,NULL),(320,'19:20:00','2023-07-12',1,NULL,1,22,NULL),(321,'19:20:00','2023-07-19',1,NULL,1,22,NULL),(322,'19:20:00','2023-07-26',1,NULL,1,22,NULL),(323,'19:20:00','2023-08-02',1,NULL,1,22,NULL),(324,'19:20:00','2023-08-09',1,NULL,1,22,NULL),(325,'19:20:00','2023-08-16',1,NULL,1,22,NULL),(326,'19:20:00','2023-08-23',1,NULL,1,22,NULL),(327,'19:20:00','2023-08-30',1,NULL,1,22,NULL),(328,'19:20:00','2023-09-06',1,NULL,1,22,NULL),(329,'19:20:00','2023-09-13',1,NULL,1,22,NULL),(330,'19:20:00','2023-09-20',1,NULL,1,22,NULL),(331,'19:20:00','2023-09-27',1,NULL,1,22,NULL),(332,'19:20:00','2023-10-04',1,NULL,1,22,NULL),(333,'19:20:00','2023-10-11',1,NULL,1,22,NULL),(334,'19:20:00','2023-10-18',1,NULL,1,22,NULL),(335,'19:20:00','2023-10-25',1,NULL,1,22,NULL),(336,'19:20:00','2023-11-01',1,NULL,1,22,NULL),(337,'19:20:00','2023-11-08',1,NULL,1,22,NULL),(338,'19:20:00','2023-11-15',1,NULL,1,22,NULL),(339,'19:20:00','2023-11-22',1,NULL,1,22,NULL),(340,'19:20:00','2023-11-29',1,NULL,1,22,NULL),(341,'19:20:00','2023-12-06',1,NULL,1,22,NULL),(342,'19:20:00','2023-12-13',1,NULL,1,22,NULL),(343,'19:20:00','2024-02-07',1,NULL,1,22,NULL),(344,'19:20:00','2024-02-14',1,NULL,1,22,NULL),(345,'19:20:00','2024-02-21',1,NULL,1,22,NULL),(346,'19:20:00','2024-02-28',1,NULL,1,22,NULL),(347,'19:20:00','2024-03-06',1,NULL,1,22,NULL),(348,'19:20:00','2024-03-13',1,NULL,1,22,NULL);
/*!40000 ALTER TABLE `consultas` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `consultas_AFTER_UPDATE` AFTER UPDATE ON `consultas` FOR EACH ROW BEGIN
	DECLARE v_id_usuario INT;
    DECLARE v_texto VARCHAR(200);
    DECLARE cursor1 CURSOR FOR  select distinct id_usuario from inscripciones i
								inner join alumnos a on i.id_alumno = a.legajo
								where i.id_consulta = new.id_consulta;

	IF new.id_estado_consulta = 3 THEN
		SELECT concatenate(nombre_apellido,' ha cancelado la consulta del día '
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidades_alumnos`
--

LOCK TABLES `especialidades_alumnos` WRITE;
/*!40000 ALTER TABLE `especialidades_alumnos` DISABLE KEYS */;
INSERT INTO `especialidades_alumnos` VALUES (1,1,1),(2,2,1),(3,1,2),(4,1,3),(5,2,4),(6,2,5),(7,3,6),(8,3,7);
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
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
INSERT INTO `materias_profesor` VALUES (1,1),(2,1),(3,1),(1,2),(24,2),(12,3),(15,3),(18,3),(6,4),(21,4),(22,5),(23,5),(4,6),(11,6),(19,6),(5,7),(13,7),(14,7),(20,7),(8,8),(10,8),(17,9),(25,9),(9,10),(16,10);
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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesor_consulta`
--

LOCK TABLES `profesor_consulta` WRITE;
/*!40000 ALTER TABLE `profesor_consulta` DISABLE KEYS */;
INSERT INTO `profesor_consulta` VALUES (18,1,1,'19:00:00',1),(19,1,2,'16:30:00',2),(20,1,4,'17:45:00',3),(21,2,2,'15:00:00',24),(22,2,4,'17:00:00',1),(23,3,3,'19:00:00',12),(24,3,2,'15:30:00',15),(25,3,5,'18:00:00',18),(26,4,1,'18:30:00',6),(27,4,3,'15:00:00',21),(28,5,2,'14:30:00',22),(29,5,4,'16:00:00',23),(30,6,5,'13:00:00',4),(31,6,3,'16:00:00',11),(32,6,5,'17:30:00',19),(33,7,1,'13:00:00',5),(34,7,1,'14:30:00',13),(35,7,3,'19:00:00',14),(36,7,4,'13:00:00',20),(37,8,2,'17:00:00',8),(38,8,3,'13:00:00',10),(39,9,2,'16:30:00',17),(40,9,3,'20:00:00',25),(41,10,2,'20:30:00',9),(42,10,4,'20:00:00',9);
/*!40000 ALTER TABLE `profesor_consulta` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `profesor_consulta_AFTER_INSERT` AFTER INSERT ON `profesor_consulta` FOR EACH ROW BEGIN
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
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `profesor_consulta_BEFORE_DELETE` BEFORE DELETE ON `profesor_consulta` FOR EACH ROW BEGIN
	delete from consultasutn.consultas
    where id_profesor_consulta = old.id_profesor_consulta
    and id_estado_consulta = 1;
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
  PRIMARY KEY (`id_profesor`),
  KEY `fk_profesores_usuarios_idx` (`id_usuario`),
  CONSTRAINT `fk_profesores_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores`
--

LOCK TABLES `profesores` WRITE;
/*!40000 ALTER TABLE `profesores` DISABLE KEYS */;
INSERT INTO `profesores` VALUES (1,'Jorge Iwanow','jiwanow@gmail.com',7),(2,'Alvaro Hergenreder','aherg@hotmail.com',13),(3,'Maria Villamontee','mvilla@gmail.com',6),(4,'Jose Toscano','jtoscano@gmail.com',14),(5,'Ana Marinsaldi','amarinsaldi@outlook.com',15),(6,'Juan Pedraza','jpedraza@gmail.com',16),(7,'Micaela Montaldi','mmontaldi@gmail.com',17),(8,'Hernan Paez','hpaez@gail.com',18),(9,'Ivan Cerrudo','icerrudo@gmail.com',19),(10,'Claudia Rodriguez','crodriguez@gmail.com',20);
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,3,40111222,'admin','admin'),(2,1,41656727,'guidolorenzotti','guido1312'),(3,1,41662762,'lautarojuancano','mesa123'),(4,1,32847777,'francozengarini','letritas123'),(5,1,27632243,'ignacioncurone','compu111 '),(6,2,22736000,'mariavillamonte','montana288'),(7,2,36750093,'jorgeiwanow','asdqwe123'),(10,1,34546978,'nadiaalarcon','nuevo01'),(11,1,22222222,'valentinaobiedo','segundo01'),(12,1,12333212,'nataliafernandez','prueba'),(13,2,22455454,'alvarohergenreder','alvaro2023'),(14,2,21434589,'josetoscano','jose2023'),(15,2,18887654,'anamarinsaldi','ana2023'),(16,2,32695438,'juanpedraza','juan2023'),(17,2,31457996,'micaelamontaldi','micaela2023'),(18,2,22590304,'hernanpaez','hernan2023'),(19,2,19984483,'ivancerrudo','ivan2023'),(20,2,39226642,'claudiarodriguez','claudia2023');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'consultasutn'
--
/*!50003 DROP PROCEDURE IF EXISTS `agregar_vacaciones` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_vacaciones`(IN fecha_inicio DATE, IN fecha_fin DATE)
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
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarRegistros`(
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-06 19:10:56
