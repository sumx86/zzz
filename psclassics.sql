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
-- Table structure for table `blocked_users`
--

DROP TABLE IF EXISTS `blocked_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blocked_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `blocked_user_id` int NOT NULL DEFAULT '0',
  `blocked_by_user_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocked_users`
--

LOCK TABLES `blocked_users` WRITE;
/*!40000 ALTER TABLE `blocked_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `blocked_users` ENABLE KEYS */;
UNLOCK TABLES;

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
  `comment_by_id` int NOT NULL DEFAULT '0',
  `comment_date` varchar(35) NOT NULL DEFAULT '',
  `comment_id` int NOT NULL DEFAULT '0',
  `comment_likes` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (60,'cmoun[quot1] Ð±ÑÑ ð½',7,'anto98',2,'08/30/2022',37,1),(61,'nice',7,'anto98',2,'08/31/2022',38,1),(26,'Tomb Raider => The BEST GAME SERIES EVAAAAH!!!!',10,'Motha[quot1]Fucka',4,'08/07/2022',32,1),(23,'I love this game!!!',9,'devArt98',3,'08/07/2022',29,3),(27,'Fuck yeaaah!!!!',16,'Motha[quot1]Fucka',4,'08/07/2022',33,2),(28,'This game is freaking AWESOME!!![quot1]',15,'Motha[quot1]Fucka',4,'08/10/2022',34,1),(29,'Brat I grew up with this game <3',17,'Motha[quot1]Fucka',4,'08/10/2022',35,2),(30,'Yeah, I love horror games [That[quot1]s what she said [colon])]',15,'Motha[quot1]Fucka',4,'08/20/2022',36,1);
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
  `genres` varchar(255) NOT NULL DEFAULT '',
  `developers` varchar(255) NOT NULL DEFAULT '',
  `publishers` varchar(255) NOT NULL DEFAULT '',
  `release_dates` varchar(255) NOT NULL DEFAULT '',
  `platforms` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'Midnight Club 3 Dub Edition Remix','ps2','71OruZvHa4L._SL1415_.jpg','RobertoRicardo2000',3,2,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(2,'Midnight Club 2','ps2','Midnight_Club_2_PAL(de)-Front.jpg','RobertoRicardo2000',1,1,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(3,'Juiced 2 Hot Import Nights','ps2','51zETZEerpL._SY445_.jpg','RobertoRicardo2000',1,0,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(4,'Grand Theft Auto San Andreas','ps2','51SV62HXM1L._AC_.jpg','RobertoRicardo2000',1,1,0,4,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(5,'Grand Theft Auto Vice City','ps2','61F2X96DR9L._AC_.jpg','RobertoRicardo2000',1,1,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(6,'Batman Begins 2005','ps2','51QVCS4XCVL._AC_.jpg','RobertoRicardo2000',2,1,0,4,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(7,'Need For Speed Carbon','ps2','AC_sneufesefse.jpg','anto98',4,4,2,4,'https://cdromance.com/ps2-iso/need-for-speed-carbon-usa/','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(8,'Need For Speed Most Wanted','ps2','AC_NFSMW_swedsne.jpg','RobertoRicardo2000',3,2,0,4,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(9,'Tomb Raider Legend','ps2','51DG31T4PDL._SY445_.jpg','RobertoRicardo2000',4,4,1,4,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(10,'Tomb Raider Anniversary','ps2','51GCi6BnCXL._AC_.jpg','RobertoRicardo2000',3,4,1,4,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(11,'Without Warning','ps2','51Y6VCAVHPL._AC_.jpg','RobertoRicardo2000',1,1,0,4,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(12,'Kuon 2004','ps2','Kuon_NA_cover.jpg','anto98',2,2,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(14,'Clock Tower 3','ps2','51M2AH7S15L._SY445_.jpg','anto98',3,3,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(15,'Forbidden Siren 2','ps2','R_cover.jpg','devArt98',3,2,2,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(16,'Tomb Raider Underworld','ps2','81gIhTH5BkL._SL1500_.jpg','anto98',2,2,1,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE'),(17,'WWE SmackDown vs. Raw 2009','ps2','51hSE75DQ+L._SY445_.jpg','anto98',1,1,1,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE');
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
) ENGINE=MyISAM AUTO_INCREMENT=364 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rated_comments`
--

LOCK TABLES `rated_comments` WRITE;
/*!40000 ALTER TABLE `rated_comments` DISABLE KEYS */;
INSERT INTO `rated_comments` VALUES (363,38,2),(352,33,2),(177,27,2),(179,28,2),(213,26,3),(204,28,3),(212,29,3),(226,29,2),(358,37,2),(250,29,4),(238,32,4),(249,33,4),(256,35,4),(257,36,4),(258,34,4),(273,35,2);
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
) ENGINE=MyISAM AUTO_INCREMENT=435 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rated_games`
--

LOCK TABLES `rated_games` WRITE;
/*!40000 ALTER TABLE `rated_games` DISABLE KEYS */;
INSERT INTO `rated_games` VALUES (138,10,0,1),(99,5,0,1),(93,8,1,0),(108,10,1,0),(32,5,1,0),(88,8,0,1),(144,7,1,0),(143,7,0,1),(139,9,0,1),(137,9,1,0),(434,7,0,2),(432,7,2,0),(253,8,2,0),(301,6,2,0),(309,9,0,2),(156,9,2,0),(166,10,2,0),(162,1,2,0),(167,10,0,2),(259,14,2,0),(260,14,0,2),(230,12,0,2),(231,12,2,0),(305,7,3,0),(306,7,0,3),(247,14,3,0),(246,14,0,3),(241,10,0,3),(279,9,0,3),(244,9,3,0),(261,3,3,0),(281,15,0,3),(280,15,3,0),(284,1,0,3),(283,1,3,0),(288,15,2,0),(398,16,0,2),(399,16,2,0),(394,7,0,4),(364,9,0,4),(315,9,4,0),(395,7,4,0),(385,10,4,0),(386,10,0,4),(346,16,4,0),(345,16,0,4),(375,12,4,0),(334,1,0,4),(335,1,4,0),(338,2,0,4),(339,2,4,0),(340,4,4,0),(341,4,0,4),(347,6,4,0),(348,6,0,4),(352,11,4,0),(351,11,0,4),(383,17,4,0),(381,17,0,4),(390,14,0,4),(374,12,0,4),(391,14,4,0),(388,8,4,0),(389,8,0,4),(392,15,0,4),(393,15,4,0);
/*!40000 ALTER TABLE `rated_games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `release_dates`
--

DROP TABLE IF EXISTS `release_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `release_dates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `release_dates`
--

LOCK TABLES `release_dates` WRITE;
/*!40000 ALTER TABLE `release_dates` DISABLE KEYS */;
/*!40000 ALTER TABLE `release_dates` ENABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'z','z','$2y$10$j8eYPFiMYdYtiUeJCWbNleXI7RB1jM3l7Y1KwUXzPXDR7jNXhGdaO','','',0,0),(2,'anto98','abv@abv.bg','$2y$10$gcj9ZgFxGzMly5d4YIYB5elxW9reLNMXGg3DVdsAYNRyTufKY4mLi','','',0,0),(3,'devArt98','zzz@abv.bg','$2y$10$Hs.UbQN53GFxYYW6WeDdQOFvlle94n1wrWNxNog8EphqvqHUJyq7a','','',0,0),(4,'Motha[quot1]Fucka','az[quot1]@email.bg','$2y$10$kW3POFjNYpUCL1i3YIvPnO8hlRS0rN2QVPIwwVKOlHeZ7T9vyeod6','','',0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `viewed_games`
--

DROP TABLE IF EXISTS `viewed_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `viewed_games` (
  `id` int NOT NULL AUTO_INCREMENT,
  `game_id` int NOT NULL DEFAULT '0',
  `viewed_by_user_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `viewed_games`
--

LOCK TABLES `viewed_games` WRITE;
/*!40000 ALTER TABLE `viewed_games` DISABLE KEYS */;
INSERT INTO `viewed_games` VALUES (1,7,1),(2,8,1),(3,9,1),(4,10,1),(5,11,1),(6,4,1),(7,7,2),(8,6,1),(9,4,2),(10,1,2),(11,9,2),(12,8,2),(13,6,2),(14,3,2),(15,11,2),(16,10,2),(17,2,2),(18,14,2),(19,12,2),(20,14,3),(21,12,3),(22,7,3),(23,5,3),(24,11,3),(25,10,3),(26,9,3),(27,6,3),(28,4,3),(29,2,3),(30,1,3),(31,3,3),(32,15,3),(33,15,2),(34,16,2),(35,8,3),(36,16,3),(37,7,4),(38,9,4),(39,10,4),(40,8,4),(41,16,4),(42,12,4),(43,15,4),(44,2,4),(45,1,4),(46,4,4),(47,5,4),(48,6,4),(49,11,4),(50,3,4),(51,14,4),(52,17,4),(53,17,2),(54,5,2),(55,17,3);
/*!40000 ALTER TABLE `viewed_games` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-31  1:08:41
