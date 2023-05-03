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
INSERT INTO `alumnos` VALUES (1,'Lautaro Canoo ','lcano@gmail.com',3),(2,'Guido Lorenzotti','guidolorenzotti@gmail.com',2),(3,'Franco Teclado','fteclado@gmail.com',4),(1222,'nuevoooa  ','pruba@gmail.com',11);
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
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
  PRIMARY KEY (`id_consulta`),
  KEY `fk_consultas_estado_consulta_idx` (`id_estado_consulta`),
  KEY `fk_consultas_profesores_idx` (`id_profesor`),
  KEY `fk_consultas_materias_idx` (`id_materia`),
  CONSTRAINT `fk_consultas_estado_consulta` FOREIGN KEY (`id_estado_consulta`) REFERENCES `estados_consulta` (`id_estado_consulta`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_consultas_materias` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_consultas_profesores` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultas`
--

LOCK TABLES `consultas` WRITE;
/*!40000 ALTER TABLE `consultas` DISABLE KEYS */;
INSERT INTO `consultas` VALUES (1,'10:00:00','2022-06-29',1,NULL,1,1),(2,'12:30:00','2022-06-27',1,NULL,1,2),(3,'10:00:00','2022-06-26',1,NULL,2,2),(4,'11:00:00','2023-04-12',3,'asdasd',2,2);
/*!40000 ALTER TABLE `consultas` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dias_sin_consulta`
--

LOCK TABLES `dias_sin_consulta` WRITE;
/*!40000 ALTER TABLE `dias_sin_consulta` DISABLE KEYS */;
INSERT INTO `dias_sin_consulta` VALUES (1,'2022-05-25','Dia de la patria'),(2,'2022-06-17','Dia de la libertad');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripciones`
--

LOCK TABLES `inscripciones` WRITE;
/*!40000 ALTER TABLE `inscripciones` DISABLE KEYS */;
INSERT INTO `inscripciones` VALUES (1,'2022-06-20',1,1,1),(2,'2022-06-21',4,2,2),(4,'2022-06-13',1,2,1),(5,'2022-06-13',1,3,1),(6,'2023-03-08',1,1,2);
/*!40000 ALTER TABLE `inscripciones` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores`
--

LOCK TABLES `profesores` WRITE;
/*!40000 ALTER TABLE `profesores` DISABLE KEYS */;
INSERT INTO `profesores` VALUES (1,'Iwanow','lavarropas@gmail.com',6),(2,'Hergenreder','aherg@hotmail.com',5),(3,'Villamontee ','mvilla@gmail.com',10),(4,'Toscano','jtoscano@gmail.com',NULL),(5,'Marinsaldi','marinsaldi@outlook.com',NULL),(6,'Pedraza','jaunpedr@gmail.com',NULL),(7,'Montaldi','mmonti@gmail.com',NULL),(8,'Garnacho','garnacho79@gmail.com',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,3,40111222,'admin','admin'),(2,1,41656727,'guidolorenzotti','guido1312'),(3,1,41662762,'lautarojuancano','mesa123'),(4,1,32847777,'francotecla','letritas123'),(5,1,27632243,'alvaherge  ','compu111 '),(6,2,22736000,'iwanow','montana288'),(7,2,36750093,'mariatoscano','asdqwe123'),(10,1,34546978,'elnuevo','nuevo01'),(11,1,22222222,'elsegundo','segundo01'),(12,1,12333212,'prueba','prueba');
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

-- Dump completed on 2023-05-03 20:38:58
