-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: txt
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.8-MariaDB

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
-- Table structure for table `descargas`
--

DROP TABLE IF EXISTS `descargas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `descargas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombreUser` varchar(70) DEFAULT NULL,
  `emailUser` varchar(50) DEFAULT NULL,
  `name_file_xlsx` varchar(50) DEFAULT NULL,
  `id_import_zip` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_descargas_import_zip_id` (`id_import_zip`),
  CONSTRAINT `FK_descargas_import_zip_id` FOREIGN KEY (`id_import_zip`) REFERENCES `import_zip` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `descargas`
--

LOCK TABLES `descargas` WRITE;
/*!40000 ALTER TABLE `descargas` DISABLE KEYS */;
/*!40000 ALTER TABLE `descargas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `import_txt`
--

DROP TABLE IF EXISTS `import_txt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `import_txt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_file` varchar(40) DEFAULT 'NULL',
  `id_import_zip` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_import_txt_import_zip_id` (`id_import_zip`),
  CONSTRAINT `FK_import_txt_import_zip_id` FOREIGN KEY (`id_import_zip`) REFERENCES `import_zip` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `import_txt`
--

LOCK TABLES `import_txt` WRITE;
/*!40000 ALTER TABLE `import_txt` DISABLE KEYS */;
/*!40000 ALTER TABLE `import_txt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `import_zip`
--

DROP TABLE IF EXISTS `import_zip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `import_zip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_file` varchar(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4 AVG_ROW_LENGTH=2340;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `import_zip`
--

LOCK TABLES `import_zip` WRITE;
/*!40000 ALTER TABLE `import_zip` DISABLE KEYS */;
/*!40000 ALTER TABLE `import_zip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sample`
--

DROP TABLE IF EXISTS `tbl_sample`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sample` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sample`
--

LOCK TABLES `tbl_sample` WRITE;
/*!40000 ALTER TABLE `tbl_sample` DISABLE KEYS */;
INSERT INTO `tbl_sample` VALUES (1,'James','Butt'),(2,'Josephine','Darakjy'),(3,'Art','Venere'),(4,'Lenna','Paprocki'),(5,'Donette','Foller'),(6,'Simona','Morasca'),(7,'Mitsue','Tollner'),(8,'Leota','Dilliard'),(9,'Sage','Wieser'),(10,'Kris','Marrier'),(11,'Minna','Amigon'),(12,'Abel','Maclead'),(13,'Kiley','Caldarera'),(14,'Graciela','Ruta'),(15,'Cammy','Albares'),(16,'Mattie','Poquette'),(17,'Meaghan','Garufi'),(18,'Gladys','Rim'),(19,'Yuki','Whobrey'),(20,'Fletcher','Flosi'),(21,'Bette','Nicka'),(22,'Veronika','Inouye'),(23,'Willard','Kolmetz'),(24,'Maryann','Royster'),(25,'John','Smith'),(26,'James','Butt'),(27,'Josephine','Darakjy'),(28,'Art','Venere'),(29,'Lenna','Paprocki'),(30,'Donette','Foller'),(31,'Simona','Morasca'),(32,'Mitsue','Tollner'),(33,'Leota','Dilliard'),(34,'Sage','Wieser'),(35,'Kris','Marrier'),(36,'Minna','Amigon'),(37,'Abel','Maclead'),(38,'Kiley','Caldarera'),(39,'Graciela','Ruta'),(40,'Cammy','Albares'),(41,'Mattie','Poquette'),(42,'Meaghan','Garufi'),(43,'Gladys','Rim'),(44,'Yuki','Whobrey'),(45,'Fletcher','Flosi'),(46,'Bette','Nicka'),(47,'Veronika','Inouye'),(48,'Willard','Kolmetz'),(49,'Maryann','Royster'),(50,'John','Smith');
/*!40000 ALTER TABLE `tbl_sample` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'txt'
--

--
-- Dumping routines for database 'txt'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-23 10:28:53
