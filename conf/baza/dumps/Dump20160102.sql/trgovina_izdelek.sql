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
-- Table structure for table `izdelek`
--

DROP TABLE IF EXISTS `izdelek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `izdelek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `cena` double NOT NULL,
  `opis` varchar(250) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `aktiven` varchar(2) COLLATE utf8_slovenian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `izdelek`
--

LOCK TABLES `izdelek` WRITE;
/*!40000 ALTER TABLE `izdelek` DISABLE KEYS */;
INSERT INTO `izdelek` VALUES (1,'Računalnik',500.99,'Odličen Lenovo prenosnik za vsakogar.','da'),(2,'Samsung Galaxy s6',339.99,'Nora ponudba','da'),(3,'Poezije',59.99,'Prešeren','da'),(4,'Logitech komplet zvočnikov 2.1 Z623',169,'Izredno kakovosten komplet zvočnikov 2.1 s THX certifikatom. Omogočajo enostavno povezovanje z računalnikom, televizijo, igralnimi konzolami ali predvajalniki glasbe.','da'),(5,'Makita akumulatorski vibracijski vrtalni vija',149,'Akumulatorski vibracijski vrtalni vijačnik Makita HP330DX100 z 2-stopenjskim menjalnikom je opremljen z zmogljivim 10,8 V Li-ion akumulatorjem.','da'),(6,'DHS gorsko kolo 2625, 19&quot;',341,'Kolo, narejeno iz aluminija, ima dva menjalnika, in sicer SHIMANO ALTUS FDM-190, dual pull in SHIMANO ALTUS RDM-280, 8spd.','ne');
/*!40000 ALTER TABLE `izdelek` ENABLE KEYS */;
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
