-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: quiz
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
-- Table structure for table `odgovori`
--

DROP TABLE IF EXISTS `odgovori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `odgovori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pitanje_id` int(11) NOT NULL,
  `odgovor` varchar(255) NOT NULL,
  `tacan` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `pitanje_id` (`pitanje_id`),
  CONSTRAINT `odgovori_ibfk_1` FOREIGN KEY (`pitanje_id`) REFERENCES `pitanja` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `odgovori`
--

LOCK TABLES `odgovori` WRITE;
/*!40000 ALTER TABLE `odgovori` DISABLE KEYS */;
INSERT INTO `odgovori` VALUES (41,11,'var xhttp = new XMLHttpRequest();',1),(42,11,'var ajax = new HttpRequest();',0),(43,11,'new AjaxRequest();',0),(44,11,'create XMLHttpRequest();',0),(45,12,'Da se podaci učitavaju u pozadini bez ponovnog učitavanja stranice',1),(46,12,'Da se automatski osveži stranica',0),(47,12,'Da se izbriše HTML kod',0),(48,12,'Da se pokrene novi prozor',0),(49,13,'xhttp.send();',1),(50,13,'xhttp.submit();',0),(51,13,'xhttp.post();',0),(52,13,'xhttp.transfer();',0),(53,14,'onreadystatechange',1),(54,14,'onloadstate',0),(55,14,'onchange',0),(56,14,'onprogresschange',0),(57,15,'4',1),(58,15,'0',0),(59,15,'1',0),(60,15,'2',0),(61,16,'200',1),(62,16,'404',0),(63,16,'500',0),(64,16,'301',0),(65,17,'xhttp.open(\"GET\", \"data.txt\", true);',1),(66,17,'xhttp.load(\"data.txt\");',0),(67,17,'xhttp.fetch(\"data.txt\");',0),(68,17,'xhttp.connect(\"data.txt\");',0),(69,18,'xhttp.responseText',1),(70,18,'xhttp.responseData',0),(71,18,'xhttp.dataResponse',0),(72,18,'xhttp.result',0),(73,19,'jQuery',1),(74,19,'Bootstrap',0),(75,19,'React',0),(76,19,'Vue',0),(77,20,'$.get(\"podaci.txt\", function(data) { });',1),(78,20,'ajax.get(\"podaci.txt\");',0),(79,20,'fetch(\"podaci.txt\", \"GET\");',0),(80,20,'getRequest(\"podaci.txt\");',0);
/*!40000 ALTER TABLE `odgovori` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-25 12:49:47
