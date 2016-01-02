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
-- Table structure for table `uporabnik`
--

DROP TABLE IF EXISTS `uporabnik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uporabnik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `priimek` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `mail` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `uporabnisko_ime` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `geslo` varchar(65) COLLATE utf8_slovenian_ci NOT NULL,
  `aktiven` varchar(2) COLLATE utf8_slovenian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uporabnik`
--

LOCK TABLES `uporabnik` WRITE;
/*!40000 ALTER TABLE `uporabnik` DISABLE KEYS */;
INSERT INTO `uporabnik` VALUES (1,'Admin','Admin','admin@admin.com','admin','$2y$10$IIZmfVmMQ3vq6TbfjrAThe3b0Hfvtp0he9NwBhm.BxdRPt79qFA9O','da'),(2,'Beni','Novak','bn5567@student.uni-lj.si','beni','$2y$10$eIHzzecc0N9UJ8myjCprweLJORwC/2UPu7I3Fr3AhYGQNDpcrnTz.','da'),(3,'Naum','Gj','ng3454@student.uni-lj.si','naum','$2y$10$pco2dumkdiVpfqJCAIU29O60Mk6eM/oJAupt82a11iw7ayv2fBTGW','da'),(5,'Benjamin','Novak','benjamin@gmail.com','Benjamin','$2y$10$zIBJPMK0jTSNpEw0mWNcveARnBHdBF5WF5cpua.dBFmXgta3bl/JO','da'),(6,'Benjamin','Novak','benjaminovak@gmail.com','benjaminovak','$2y$10$nfDih8oCvLlA/La6aSAGReWaEuWtk8TP9n4CoJgQB5txiIvVV6RRC','ne'),(7,'Lionel','Messi','messi@gmail.com','Lionel','$2y$10$8GIsNoqNYC5De1RH7vWoeu9EfGKcj4o4ttvolDqh91qI6q.5IGCZa','da'),(8,'Visimir','Kravanja','kravanja.v@gmail.com','kravanja','$2y$10$aLfv0Mmle12YDxF42U9JLeNG11oLX9RiwwO4pQls4HqEctVE4QR2S','da');
/*!40000 ALTER TABLE `uporabnik` ENABLE KEYS */;
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
