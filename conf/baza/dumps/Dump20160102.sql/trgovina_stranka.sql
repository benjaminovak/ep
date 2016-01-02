CREATE DATABASE  IF NOT EXISTS `trgovina` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_slovenian_ci */;
USE `trgovina`;
-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (i686)
--
-- Host: 127.0.0.1    Database: trgovina
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.04.1

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
-- Table structure for table `stranka`
--

DROP TABLE IF EXISTS `stranka`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stranka` (
  `uporabnik_id` int(11) NOT NULL,
  `telefon` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `ulica` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `stevilka` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `posta_id` int(11) NOT NULL,
  PRIMARY KEY (`uporabnik_id`),
  KEY `fk_Stranka_Uporabnik1_idx` (`uporabnik_id`),
  KEY `fk_stranka_posta1_idx` (`posta_id`),
  CONSTRAINT `fk_stranka_posta1` FOREIGN KEY (`posta_id`) REFERENCES `posta` (`posta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Stranka_Uporabnik1` FOREIGN KEY (`uporabnik_id`) REFERENCES `uporabnik` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stranka`
--

LOCK TABLES `stranka` WRITE;
/*!40000 ALTER TABLE `stranka` DISABLE KEYS */;
/*!40000 ALTER TABLE `stranka` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-02 20:36:04