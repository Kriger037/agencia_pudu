CREATE DATABASE  IF NOT EXISTS `agencia_pudu` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `agencia_pudu`;
-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: agencia_pudu
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
-- Table structure for table `hotel`
--

DROP TABLE IF EXISTS `hotel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hotel` (
  `hotel_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  `ubicacion` varchar(60) DEFAULT NULL,
  `habitaciones_disponibles` int(11) DEFAULT NULL,
  `tarifa_noche` int(11) DEFAULT NULL,
  PRIMARY KEY (`hotel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotel`
--

LOCK TABLES `hotel` WRITE;
/*!40000 ALTER TABLE `hotel` DISABLE KEYS */;
INSERT INTO `hotel` VALUES (1,'Tokyo Inn','Tokio-Japon',16,97000),(2,'Hotel Paris Center','Paris-Francia',10,81000),(3,'Madison Hotel','Roma-Italia',3,149000);
/*!40000 ALTER TABLE `hotel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva`
--

DROP TABLE IF EXISTS `reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reserva` (
  `reserva_id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) DEFAULT NULL,
  `fecha_reserva` date DEFAULT NULL,
  `vuelo_id` int(11) DEFAULT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`reserva_id`),
  KEY `vuelo` (`vuelo_id`),
  KEY `fk_reserva_hotel` (`hotel_id`),
  CONSTRAINT `fk_reserva_hotel` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`hotel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `hotel` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`hotel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `vuelo` FOREIGN KEY (`vuelo_id`) REFERENCES `vuelo` (`vuelo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva`
--

LOCK TABLES `reserva` WRITE;
/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
INSERT INTO `reserva` VALUES (1,2811,'2025-08-10',2,1),(2,5928,'2025-08-10',2,1),(3,1159,'2025-08-10',2,1),(4,592811,'2025-08-10',2,1),(5,6498,'2025-07-25',1,2),(6,9852,'2025-07-25',1,2),(7,25184,'2025-08-10',2,1),(8,8156,'2025-07-25',1,2),(9,51916161,'2025-07-25',1,2),(10,841266,'2025-07-22',3,3);
/*!40000 ALTER TABLE `reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vuelo`
--

DROP TABLE IF EXISTS `vuelo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vuelo` (
  `vuelo_id` int(11) NOT NULL AUTO_INCREMENT,
  `origen` varchar(60) DEFAULT NULL,
  `destino` varchar(60) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `plazas_disponibles` int(11) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  PRIMARY KEY (`vuelo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vuelo`
--

LOCK TABLES `vuelo` WRITE;
/*!40000 ALTER TABLE `vuelo` DISABLE KEYS */;
INSERT INTO `vuelo` VALUES (1,'Santiago-Chile','Paris-Francia','2025-07-25',10,811000),(2,'Santiago-Chile','Tokio-Japon','2025-08-10',15,1500000),(3,'Santiago-Chile','Roma-Italia','2025-07-22',14,905000);
/*!40000 ALTER TABLE `vuelo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'agencia_pudu'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-21 18:29:51
