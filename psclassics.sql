-- MySQL dump 10.13  Distrib 8.0.21, for Win64 (x86_64)
--
-- Host: localhost    Database: psclassics
-- ------------------------------------------------------
-- Server version	8.0.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) NOT NULL DEFAULT '',
  `item_id` int NOT NULL DEFAULT '0',
  `comment_by` varchar(100) NOT NULL DEFAULT '',
  `comment_date` varchar(35) NOT NULL DEFAULT '',
  `comment_id` int NOT NULL DEFAULT '0',
  `comment_likes` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `games` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `platform` varchar(10) NOT NULL DEFAULT '',
  `cover` varchar(100) NOT NULL DEFAULT '',
  `uploader` varchar(100) NOT NULL DEFAULT '',
  `likes` int NOT NULL DEFAULT '0',
  `favourited` int NOT NULL DEFAULT '0',
  `comments` int NOT NULL DEFAULT '0',
  `views` int NOT NULL DEFAULT '0',
  `link` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'Midnight Club 3 Dub Edition Remix','ps2','71OruZvHa4L._SL1415_.jpg','RobertoRicardo2000',0,0,0,0,''),(2,'Midnight Club 2','ps2','Midnight_Club_2_PAL(de)-Front.jpg','RobertoRicardo2000',0,0,0,0,''),(3,'Juiced 2 Hot Import Nights','ps2','51zETZEerpL._SY445_.jpg','RobertoRicardo2000',0,0,0,0,''),(4,'Grand Theft Auto San Andreas','ps2','51SV62HXM1L._AC_.jpg','RobertoRicardo2000',0,0,0,0,''),(5,'Grand Theft Auto Vice City','ps2','61F2X96DR9L._AC_.jpg','RobertoRicardo2000',0,0,0,0,''),(6,'Batman Begins 2005','ps2','51QVCS4XCVL._AC_.jpg','RobertoRicardo2000',0,0,0,0,''),(7,'Need For Speed Carbon','ps2','AC_sneufesefse.jpg','RobertoRicardo2000',1,5,0,0,'https://cdromance.com/ps2-iso/need-for-speed-carbon-usa/'),(8,'Need For Speed Most Wanted','ps2','AC_NFSMW_swedsne.jpg','RobertoRicardo2000',0,0,0,0,''),(9,'Tomb Raider Legend','ps2','51DG31T4PDL._SY445_.jpg','RobertoRicardo2000',0,0,0,0,''),(10,'Tomb Raider Anniversary','ps2','51GCi6BnCXL._AC_.jpg','RobertoRicardo2000',0,0,0,0,''),(11,'Without Warning','ps2','51Y6VCAVHPL._AC_.jpg','RobertoRicardo2000',0,0,0,0,'');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rated_comments`
--

DROP TABLE IF EXISTS `rated_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rated_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comment_id` int NOT NULL DEFAULT '0',
  `liked_by_user_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rated_comments`
--

LOCK TABLES `rated_comments` WRITE;
/*!40000 ALTER TABLE `rated_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `rated_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rated_games`
--

DROP TABLE IF EXISTS `rated_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rated_games` (
  `id` int NOT NULL AUTO_INCREMENT,
  `game_id` int NOT NULL DEFAULT '0',
  `liked_by_user_id` int NOT NULL DEFAULT '0',
  `favourited_by_user_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rated_games`
--

LOCK TABLES `rated_games` WRITE;
/*!40000 ALTER TABLE `rated_games` DISABLE KEYS */;
INSERT INTO `rated_games` VALUES (3,7,1,0);
/*!40000 ALTER TABLE `rated_games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(200) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(100) NOT NULL DEFAULT '',
  `display_name` varchar(100) NOT NULL DEFAULT '',
  `followers` int NOT NULL DEFAULT '0',
  `following` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'z','z','$2y$10$j8eYPFiMYdYtiUeJCWbNleXI7RB1jM3l7Y1KwUXzPXDR7jNXhGdaO','','',0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-12 10:56:47
