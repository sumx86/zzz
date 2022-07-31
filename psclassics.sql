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
  `comment_date` varchar(35) NOT NULL DEFAULT '',
  `comment_id` int NOT NULL DEFAULT '0',
  `comment_likes` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'They didnt know what was going on in that room hehehe',7,'_SomeUser98','7/16/2022',23,3),(2,'Or maybe they did but just',7,'_SomeUser98','7/16/2022',24,3),(3,'pretended lol haha xD',7,'_SomeUser98','7/16/2022',24,3);
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'Midnight Club 3 Dub Edition Remix','ps2','71OruZvHa4L._SL1415_.jpg','RobertoRicardo2000',1,0,0,2,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(2,'Midnight Club 2','ps2','Midnight_Club_2_PAL(de)-Front.jpg','RobertoRicardo2000',0,0,0,2,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(3,'Juiced 2 Hot Import Nights','ps2','51zETZEerpL._SY445_.jpg','RobertoRicardo2000',1,0,0,2,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(4,'Grand Theft Auto San Andreas','ps2','51SV62HXM1L._AC_.jpg','RobertoRicardo2000',0,0,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(5,'Grand Theft Auto Vice City','ps2','61F2X96DR9L._AC_.jpg','RobertoRicardo2000',1,1,0,1,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(6,'Batman Begins 2005','ps2','51QVCS4XCVL._AC_.jpg','RobertoRicardo2000',1,0,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(7,'Need For Speed Carbon','ps2','AC_sneufesefse.jpg','anto98',3,3,0,3,'https://cdromance.com/ps2-iso/need-for-speed-carbon-usa/','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(8,'Need For Speed Most Wanted','ps2','AC_NFSMW_swedsne.jpg','RobertoRicardo2000',2,1,0,2,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(9,'Tomb Raider Legend','ps2','51DG31T4PDL._SY445_.jpg','RobertoRicardo2000',3,3,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(10,'Tomb Raider Anniversary','ps2','51GCi6BnCXL._AC_.jpg','RobertoRicardo2000',2,3,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(11,'Without Warning','ps2','51Y6VCAVHPL._AC_.jpg','RobertoRicardo2000',0,0,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(12,'Kuon 2004','ps2','Kuon_NA_cover.jpg','anto98',1,1,0,2,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(14,'Clock Tower 3','ps2','51M2AH7S15L._SY445_.jpg','anto98',2,2,0,2,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(15,'Forbidden Siren 2','ps2','R_cover.jpg','devArt98',1,1,0,1,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998'),(16,'Tomb Raider Underworld','ps2','81gIhTH5BkL._SL1500_.jpg','anto98',0,0,0,0,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998');
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
) ENGINE=MyISAM AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rated_comments`
--

LOCK TABLES `rated_comments` WRITE;
/*!40000 ALTER TABLE `rated_comments` DISABLE KEYS */;
INSERT INTO `rated_comments` VALUES (109,23,1),(89,24,1),(141,23,2),(134,24,2),(145,23,3),(144,24,3);
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
) ENGINE=MyISAM AUTO_INCREMENT=273 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rated_games`
--

LOCK TABLES `rated_games` WRITE;
/*!40000 ALTER TABLE `rated_games` DISABLE KEYS */;
INSERT INTO `rated_games` VALUES (138,10,0,1),(99,5,0,1),(93,8,1,0),(108,10,1,0),(32,5,1,0),(88,8,0,1),(144,7,1,0),(143,7,0,1),(139,9,0,1),(137,9,1,0),(178,7,0,2),(203,7,2,0),(253,8,2,0),(154,6,2,0),(165,9,0,2),(156,9,2,0),(166,10,2,0),(162,1,2,0),(167,10,0,2),(259,14,2,0),(260,14,0,2),(230,12,0,2),(231,12,2,0),(235,7,3,0),(272,7,0,3),(247,14,3,0),(246,14,0,3),(241,10,0,3),(242,9,0,3),(244,9,3,0),(261,3,3,0),(270,15,0,3),(271,15,3,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'z','z','$2y$10$j8eYPFiMYdYtiUeJCWbNleXI7RB1jM3l7Y1KwUXzPXDR7jNXhGdaO','','',0,0),(2,'anto98','abv@abv.bg','$2y$10$gcj9ZgFxGzMly5d4YIYB5elxW9reLNMXGg3DVdsAYNRyTufKY4mLi','','',0,0),(3,'devArt98','zzz@abv.bg','$2y$10$Hs.UbQN53GFxYYW6WeDdQOFvlle94n1wrWNxNog8EphqvqHUJyq7a','','',0,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `viewed_games`
--

LOCK TABLES `viewed_games` WRITE;
/*!40000 ALTER TABLE `viewed_games` DISABLE KEYS */;
INSERT INTO `viewed_games` VALUES (1,7,1),(2,8,1),(3,9,1),(4,10,1),(5,11,1),(6,4,1),(7,7,2),(8,6,1),(9,4,2),(10,1,2),(11,9,2),(12,8,2),(13,6,2),(14,3,2),(15,11,2),(16,10,2),(17,2,2),(18,14,2),(19,12,2),(20,14,3),(21,12,3),(22,7,3),(23,5,3),(24,11,3),(25,10,3),(26,9,3),(27,6,3),(28,4,3),(29,2,3),(30,1,3),(31,3,3),(32,15,3);
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

-- Dump completed on 2022-07-31  5:37:03
