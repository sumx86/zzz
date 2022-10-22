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
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (67,'Ð·Ð¶Ð¶ ð½',7,'anto98',2,'09/21/2022',43,1),(63,'ÐÑÐºÐ°ÐºÑÐ² ÐºÐ¾Ð¼ÐµÐ½ÑÐ°Ñ ÑÑÐºÐ°[quot1] ð',7,'devArt98',3,'09/03/2022',40,3),(26,'Tomb Raider => The BEST GAME SERIES EVAAAAH!!!!',10,'Motha[quot1]Fucka',4,'08/07/2022',32,2),(23,'I love this game!!!',9,'devArt98',3,'08/07/2022',29,3),(27,'Fuck yeaaah!!!!',16,'Motha[quot1]Fucka',4,'08/07/2022',33,2),(28,'This game is freaking AWESOME!!![quot1]',15,'Motha[quot1]Fucka',4,'08/10/2022',34,1),(29,'Brat I grew up with this game <3',17,'Motha[quot1]Fucka',4,'08/10/2022',35,2),(30,'Yeah, I love horror games [That[quot1]s what she said [colon])]',15,'Motha[quot1]Fucka',4,'08/20/2022',36,2),(66,'Ð¥ÐµÐ»ÑÐ¸Ð½ Ð¸Ð´Ð²Ð°Ð°Ð°Ð°Ð° ðð½',15,'Брадва123',5,'09/05/2022',42,1),(68,'Ð¿ÑÑÑ ð',18,'нещо98',6,'09/24/2022',44,2),(69,'ÐµÐ¹ ÑÐ¸ Ð»Ð¸Ð½Ðº -> [link]http://xvideos.com/history[/link] ð[quot1]',8,'anto98',2,'09/25/2022',45,1),(70,'ð',8,'anto98',2,'09/27/2022',46,0),(71,'Japanese horror is da best ð½',20,'devArt98',3,'10/04/2022',47,1),(72,'One of the best !!!!ð',29,'devArt98',3,'10/09/2022',48,1);
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
  `uploader_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'Midnight Club 3 Dub Edition Remix','ps2','71OruZvHa4L._SL1415_.jpg','devArt98',3,2,0,4,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',3),(2,'Midnight Club 2','ps2','Midnight_Club_2_PAL(de)-Front.jpg','devArt98',1,1,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',3),(3,'Juiced 2 Hot Import Nights','ps2','51zETZEerpL._SY445_.jpg','devArt98',1,0,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',3),(4,'Grand Theft Auto San Andreas','ps2','51SV62HXM1L._AC_.jpg','devArt98',1,1,0,4,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',3),(5,'Grand Theft Auto Vice City','ps2','61F2X96DR9L._AC_.jpg','devArt98',1,1,0,4,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',3),(6,'Batman Begins 2005','ps2','51QVCS4XCVL._AC_.jpg','devArt98',2,2,0,4,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',3),(7,'Need For Speed Carbon','ps2','AC_sneufesefse.jpg','anto98',4,5,1,6,'https://cdromance.com/ps2-iso/need-for-speed-carbon-usa/','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',2),(8,'Need For Speed Most Wanted','ps2','AC_NFSMW_swedsne.jpg','devArt98',3,3,2,4,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',3),(9,'Tomb Raider Legend','ps2','51DG31T4PDL._SY445_.jpg','devArt98',4,5,1,6,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',3),(10,'Tomb Raider Anniversary','ps2','51GCi6BnCXL._AC_.jpg','devArt98',3,5,2,5,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',3),(11,'Without Warning','ps2','51Y6VCAVHPL._AC_.jpg','devArt98',1,1,0,4,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',3),(12,'Kuon 2004','ps2','Kuon_NA_cover.jpg','anto98',2,2,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',2),(14,'Clock Tower 3','ps2','51M2AH7S15L._SY445_.jpg','anto98',3,3,0,3,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',2),(15,'Forbidden Siren 2','ps2','R_cover.jpg','devArt98',4,4,3,5,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',3),(16,'Tomb Raider Underworld','ps2','81gIhTH5BkL._SL1500_.jpg','anto98',2,3,1,4,'','Action, Racing, Adventures','EA Black Box, EA Vancouver, Global VR, MORE','Electronic Arts, Warner Bros. Interactive Entertainment','October 31 1998','PlayStation 2, macOS, Microsoft Windows, PlayStation 3, MORE',2),(18,'Leisure Suit Larry','ps2','ZDZiOGUzNjk1MmRkNDRlNDVmZmQzYzkzY2NlZjZiZjc=.jpg','anto98',2,1,1,3,'None','Graphic adventure',' Sierra Entertainment, Assemble Entertainment, CrazyBunch, N-Fusion Interactive, BlueSky Software',' Sierra Entertainment, Assemble Entertainment, MORE','October 5, 2004','Microsoft Windows, PlayStation 2, Xbox',2),(19,'Van Helsing','ps2','MV5BMTU1ODA4MDkwM15BMl5.jpg','anto98',1,0,0,2,'','Third-person shooter, Action-adventure game, Hack and slash','Saffire','Vivendi Games','April 27, 2004','PlayStation 2, Game Boy Advance, Xbox',2),(20,'Fatal Frame II','ps2','51F8MKPQF8L.jpg','anto98',1,0,1,2,'none','Survival horror, Action-adventure game, Photography game','Tecmo','Tecmo, Nintendo, Ubisoft, Xbox Game Studios, Sony Interactive Entertainment','November 27, 2003','PlayStation 3, PlayStation 2, Xbox',2),(21,'Metal Gear Solid 3 (Snake Eater)','ps2','1278-metal-gear-solid-3-snake-eater.jpg','anto98',0,0,0,0,'None','Stealth Game','Konami Computer Entertainment Japan, Kojima Productions, HexaDrive, Armature Games','Konami','November 17, 2004','PlayStation 2, Nintendo 3DS',2),(22,'Red Ninja: End of Honor','ps2','41FKXyVYawL.jpg','anto98',0,0,0,0,'None','Action game, Stealth game','Tranji','Vivendi Games, Vivendi','March 3, 2005','PlayStation 2, Xbox',2),(27,'The Darkness II','ps3','MjgzNmNhMDFkNjE0YmNhZTQzOWU3Nzc1MDFmNTU2ZWE=.png','devArt98',1,2,0,2,'None','First-person shooter','Digital Extremes','2K Games','February 7, 2012','PlayStation 3, Microsoft Windows, Xbox 360, macOS, Classic Mac OS',3),(24,'Primal','ps2','33746-prima.jpg','anto98',1,0,0,2,'None','Action-adventure game, Role-playing Video Game','Guerrilla Cambridge','Sony Interactive Entertainment Europe, Sony Interactive Entertainment','March 25, 2003','PlayStation 2, PlayStation 4, PlayStation 3, Amiga',2),(25,'The Fear','ps2','84693-the-fear.jpg','anto98',2,1,0,2,'None','Adventure game','Enix, tri-Crescendo','Enix','July 26, 2001','PlayStation 2',2),(28,'Saw ','ps3','YzlhOWIzZDhhYzYzMzVmYjg0NzZlNTEyMzlkZmQzM2Y=.jpg','devArt98',1,2,0,2,'None','Puzzle Video Game, Survival horror, Action-adventure game','Zombie Studios','Konami, Brash Entertainment','October 6, 2009','PlayStation 3, Xbox 360, Microsoft Windows',3),(29,'Alice: Madness Returns','ps3','NDJjNWNjNmM5OGU4Y2ZlNGY1NzE1MDlkNzczYjZhZjY=.jpg','devArt98',1,2,1,2,'None','Platform game, Action-adventure game, Hack and slash, Adventure','Spicy Horse','Electronic Arts','June 14, 2011','PlayStation 3, Xbox 360, Microsoft Windows',3),(30,'The Rumble Fish','ps2','YWE1MjU0MzNjZWZmYzAwZjZmOGU1YzllY2E0NjNhNGI=.jpg','devArt98',2,1,0,2,'None','Fighting game','Dimps','Sega, Sammy Corporation, Sega Sammy Holdings','March 17, 2005','PlayStation 2, Arcade game',3),(31,'.hack//OUTBREAK','ps2','N2EzMjllMDU5MGNlMTI5NzBkZTEyMWI0MDJkYjIzNTI=.jpg','devArt98',2,0,0,2,'None','Massively multiplayer online role-playing game, Action game','CyberConnect2','Bandai','December 12, 2002','PlayStation 2',3),(32,'Prince of Persia: The Two Thrones','ps2','ZjE2MmE5MDY2MWQ3YTljNmEyNjc4NzczODZmOTVkNGI=.jpg','devArt98',2,0,0,2,'None','Platform game, Action-adventure game, Hack and slash, Adventure','Ubisoft Montreal, Ubisoft, Gameloft, Ubisoft Casablanca','Ubisoft','June 15, 2005','Microsoft Windows, macOS, PlayStation Portable, MORE',3),(33,'Dark Angel: Vampire Apocalypse','ps2','MGFjY2VhZjYwZGY5MWJlMzVkM2MyNWUyMTI2NTIzZTg=.jpg','devArt98',2,1,0,2,'None','Action role-playing game','Metro3D, Metropolis Digital','Metro3D','July 8, 2001','PlayStation 2',3),(34,'Gungrave: Overdose','ps2','MGMyOWQzMGNkYTgyYmI5MGRkMGMxNjZhZjUzNzlmMmI=.jpg','anto98',2,1,0,2,'None','Third-person shooter','Red Entertainment, Ikusabune Co., Ltd., Ikusabune Inc.','Red Entertainment, Mastiff','March 4, 2004','PlayStation 2',2),(35,'Cold Fear','ps2','MWFkNjM1ODAyNTQ3ZWYzZGZhMzcyZDZiZTFmZTNhMTM=.jpg','anto98',1,0,0,2,'None','Survival horror, Third-person shooter, Action-adventure game','Darkworks','Ubisoft','March 15, 2005','PlayStation 2, Microsoft Windows, Xbox',2),(36,'Folklore','ps3','YWFkMjUwZjFkZTQyMDZhOWEzMzcyMWY4NDJkMjc3MDk=.jpg','anto98',1,1,0,1,'None','Action-adventure game, Action role-playing game','Game Republic, Shirogumi, Gaia','Sony Interactive Entertainment','June 21, 2007','PlayStation 3',2),(38,'Aeon Flux','ps2','YjU5OGUwYTAxMDM4MzcyMDAyNWIyZjY1OThlMGE0Njk=.jpg','anto98',0,0,0,2,'None','Action-adventure game, Shooter Video Game, Puzzle Video Game','Terminal Reality','Majesco Entertainment','November 15, 2005','PlayStation 2, Xbox',2),(39,'Dead or Alive 2','ps2','YWE0Y2NkMGE0NDAyOGUzNmQ0ZWZkZThiYzEzMjIwNTg=.jpg','anto98',1,1,0,2,'None','Fighting game, Action game','Tecmo, Team Ninja','Tecmo, Koei Tecmo, Acclaim Entertainment, Sony Interactive Entertainment','October 16, 1999','Dreamcast, PlayStation 2, Nintendo 64, Arcade game',2),(43,'Kimi ga Nozomu Eien','ps2','Y2JlODA1OGM3NmQyMDZiMzIzYWU1ODhmNDQ4YWM3MGM=.jpg','anto98',1,1,0,2,'None','Eroge, Visual novel','Age','Acid, Alchemist, Princess Soft','August 3, 2001','Windows, Dreamcast, PlayStation 2',2),(42,'Blood Will Tell: Tezuka Osamu[quot1]s Dororo','ps2','NWU2N2E3Mzg4MDg1NjNiMDA5NzhmMThiYzE2Y2Q1OTM=.jpg','anto98',2,1,0,3,'None','Action-adventure game, Fighting game, Role-playing Video Game','Sega AM1, Red Entertainment, Sega, Paon Corporation','Sega, Tezuka Productions','September 9, 2004','PlayStation 2',2),(44,'Afro Samurai','ps3','ZWRkYTNhN2IzNzJjY2QxNmFkODA0ODk1YmY5OTY3MmQ=.jpg','anto98',0,0,0,1,'None','Beat [quot1]em up, Fighting game, Hack and slash, Action-adventure game','BNE Entertainment, Bandai Namco Holdings','BNE Entertainment, Surge','January 27, 2009','PlayStation 3, Xbox 360',2),(45,'Shikigami no Shiro','ps2','OTk4OGZjOGQ3ODliZTBlNTlhM2U1OWExN2E1MjkyMTM=.jpg','anto98',2,1,0,2,'None','Shoot [quot1]em up','Alfa System, Cosmo Machia','XS Games, Media Quest, Taito, SourceNext, Komodo','2001','PlayStation 2, Microsoft Windows, Xbox, Arcade game',2),(46,'Resident Evil 4','ps2','NGYyYWQzOGFhMDY1NmFhYWZkN2E2OWJiZWU0M2E4NTc=.jpg','devArt98',2,1,0,2,'None','Puzzle Video Game, Survival horror, Third-person shooter, Action-adventure game','Capcom, Capcom Production Studio 4','Capcom','January 11, 2005','PlayStation 2, Android, PlayStation 4, GameCube, MORE',3),(47,'Payday 2','ps3','ODllODBlMjA1Y2QzZmI4Zjk5NDIxYTE4MWQ1ZDA1NGY=.jpg','anto98',1,1,0,1,'None','Cooperative First-Person Shooter','Overkill Software, Starbreeze Studios, OVERKILL - a Starbreeze Studio., Sumo Digital','Starbreeze Studios, 505 Games','August 13, 2013','PlayStation 4, Xbox One, Nintendo Switch, PlayStation 3, Microsoft Windows, Xbox 360, Linux',2),(48,'Guitar Hero Smash Hits','ps2','NmM5NDQ2MGZlYTE3OTYxOTdlOWRlN2Q0N2YxMTg1MDA=.jpg','нещо98',1,0,0,1,'None','Rhythm game, Action game','Beenox','RedOctane, Activision, Activision Blizzard','June 16, 2009','PlayStation 3, Xbox 360, PlayStation 2, Wii',6),(49,'Okami','ps2','ZjQwZjc0ZjM3NDRjNWQyZWZiNTE5Njg5NGRhYzI1Mzc=.jpg','anto98',0,0,0,1,'None','Role-playing Video Game, Action-adventure game','Capcom, Clover Studio, Ready at Dawn','Capcom','April 20, 2006','Nintendo Switch, PlayStation 2, Wii, PlayStation 3, Xbox One, Microsoft Windows',2),(50,'Grandia III','ps2','YmIyN2VjZTZhMzhjMDc5ZmQwZTYwZjY2MDM4ZjEyZmU=.jpg','anto98',0,0,0,1,'https://cdromance.com/ps2-iso/grandia-iii-usaundub/','Japanese role-playing game, Adventure game','Game Arts','Square Enix','August 4, 2005','PlayStation 2',2),(51,'Tokyo Xtreme Racer: Drift 2','ps2','NGNjM2VhZTU4ZWI4Yzk0ZDJiYjI0ZmQwM2E5ZThkMDE=.jpg','anto98',0,0,0,1,'https://romspure.cc/roms/sony-playstation-2/tokyo-xtreme-racer-drift-2/#google_vignette','Racing Video Game','Genki','Genki, Crave Entertainment, Konami','July 28, 2005','PlayStation 2',2);
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inbox`
--

DROP TABLE IF EXISTS `inbox`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inbox` (
  `id` int NOT NULL AUTO_INCREMENT,
  `from_user` varchar(100) NOT NULL DEFAULT '',
  `from_user_id` int NOT NULL DEFAULT '0',
  `message` varchar(100) NOT NULL DEFAULT '',
  `to_user` varchar(100) NOT NULL DEFAULT '',
  `to_user_id` int NOT NULL DEFAULT '0',
  `date` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inbox`
--

LOCK TABLES `inbox` WRITE;
/*!40000 ALTER TABLE `inbox` DISABLE KEYS */;
/*!40000 ALTER TABLE `inbox` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `from_user_id` int NOT NULL DEFAULT '0',
  `to_user_id` int NOT NULL DEFAULT '0',
  `message` varchar(150) NOT NULL DEFAULT '',
  `date` varchar(35) NOT NULL DEFAULT '',
  `seen` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pending_uploads`
--

DROP TABLE IF EXISTS `pending_uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pending_uploads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `platform` varchar(10) NOT NULL DEFAULT '',
  `cover` varchar(100) NOT NULL DEFAULT '',
  `uploader` varchar(100) NOT NULL DEFAULT '',
  `uploader_id` int NOT NULL DEFAULT '0',
  `link` varchar(255) NOT NULL DEFAULT '',
  `genres` varchar(255) NOT NULL DEFAULT '',
  `developers` varchar(255) NOT NULL DEFAULT '',
  `publishers` varchar(255) NOT NULL DEFAULT '',
  `release_dates` varchar(255) NOT NULL DEFAULT '',
  `platforms` varchar(255) NOT NULL DEFAULT '',
  `date` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pending_uploads`
--

LOCK TABLES `pending_uploads` WRITE;
/*!40000 ALTER TABLE `pending_uploads` DISABLE KEYS */;
INSERT INTO `pending_uploads` VALUES (40,'a','ps3','ZmUzYTI5ODFkNGRjYmY1M2I2M2E4NWMzMmY4MzIwYTE=.jpg','anto98',0,'a','a','a','a','a','a','09/26/2022 11:17:14'),(41,'The Darkness II','ps3','MjgzNmNhMDFkNjE0YmNhZTQzOWU3Nzc1MDFmNTU2ZWE=.png','devArt98',0,'None','First-person shooter','Digital Extremes','2K Games','February 7, 2012','PlayStation 3, Microsoft Windows, Xbox 360, macOS, Classic Mac OS','10/09/2022 16:27:55'),(42,'Saw ','ps3','YzlhOWIzZDhhYzYzMzVmYjg0NzZlNTEyMzlkZmQzM2Y=.jpg','devArt98',0,'None','Puzzle Video Game, Survival horror, Action-adventure game','Zombie Studios','Konami, Brash Entertainment','October 6, 2009','PlayStation 3, Xbox 360, Microsoft Windows','10/09/2022 21:16:43'),(43,'Alice: Madness Returns','ps3','NDJjNWNjNmM5OGU4Y2ZlNGY1NzE1MDlkNzczYjZhZjY=.jpg','devArt98',0,'None','Platform game, Action-adventure game, Hack and slash, Adventure','Spicy Horse','Electronic Arts','June 14, 2011','PlayStation 3, Xbox 360, Microsoft Windows','10/09/2022 21:24:56'),(44,'The Rumble Fish','ps2','YWE1MjU0MzNjZWZmYzAwZjZmOGU1YzllY2E0NjNhNGI=.jpg','devArt98',0,'None','Fighting game','Dimps','Sega, Sammy Corporation, Sega Sammy Holdings','March 17, 2005','PlayStation 2, Arcade game','10/11/2022 11:33:37'),(45,'.hack//OUTBREAK','ps2','N2EzMjllMDU5MGNlMTI5NzBkZTEyMWI0MDJkYjIzNTI=.jpg','devArt98',0,'None','Massively multiplayer online role-playing game, Action game','CyberConnect2','Bandai','December 12, 2002','PlayStation 2','10/11/2022 12:00:19'),(46,'Prince of Persia: The Two Thrones','ps2','ZjE2MmE5MDY2MWQ3YTljNmEyNjc4NzczODZmOTVkNGI=.jpg','devArt98',0,'None','Platform game, Action-adventure game, Hack and slash, Adventure','Ubisoft Montreal, Ubisoft, Gameloft, Ubisoft Casablanca','Ubisoft','June 15, 2005','Microsoft Windows, macOS, PlayStation Portable, MORE','10/11/2022 12:04:33'),(47,'Dark Angel: Vampire Apocalypse','ps2','MGFjY2VhZjYwZGY5MWJlMzVkM2MyNWUyMTI2NTIzZTg=.jpg','devArt98',0,'None','Action role-playing game','Metro3D, Metropolis Digital','Metro3D','July 8, 2001','PlayStation 2','10/11/2022 12:29:30'),(48,'Gungrave: Overdose','ps2','MGMyOWQzMGNkYTgyYmI5MGRkMGMxNjZhZjUzNzlmMmI=.jpg','devArt98',0,'None','Third-person shooter','Red Entertainment, Ikusabune Co., Ltd., Ikusabune Inc.','Red Entertainment, Mastiff','March 4, 2004','PlayStation 2','10/11/2022 13:05:47'),(49,'Cold Fear','ps2','MWFkNjM1ODAyNTQ3ZWYzZGZhMzcyZDZiZTFmZTNhMTM=.jpg','anto98',0,'None','Survival horror, Third-person shooter, Action-adventure game','Darkworks','Ubisoft','March 15, 2005','PlayStation 2, Microsoft Windows, Xbox','10/11/2022 13:21:36'),(50,'Folklore','ps3','YWFkMjUwZjFkZTQyMDZhOWEzMzcyMWY4NDJkMjc3MDk=.jpg','anto98',0,'None','Action-adventure game, Action role-playing game','Game Republic, Shirogumi, Gaia','Sony Interactive Entertainment','June 21, 2007','PlayStation 3','10/12/2022 18:44:27'),(51,'Aeon Flux','ps2','YjU5OGUwYTAxMDM4MzcyMDAyNWIyZjY1OThlMGE0Njk=.jpg','anto98',0,'None','Action-adventure game, Shooter Video Game, Puzzle Video Game','Terminal Reality','Majesco Entertainment','November 15, 2005','PlayStation 2, Xbox','10/12/2022 18:51:00'),(52,'Dead or Alive 2','ps2','YWE0Y2NkMGE0NDAyOGUzNmQ0ZWZkZThiYzEzMjIwNTg=.jpg','anto98',0,'None','Fighting game, Action game','Tecmo, Team Ninja','Tecmo, Koei Tecmo, Acclaim Entertainment, Sony Interactive Entertainment','October 16, 1999','Dreamcast, PlayStation 2, Nintendo 64, Arcade game','10/12/2022 18:54:55'),(53,'Blood Will Tell: Tezuka Osamu[quot1]s Dororo','ps2','NWU2N2E3Mzg4MDg1NjNiMDA5NzhmMThiYzE2Y2Q1OTM=.jpg','anto98',0,'None','Action-adventure game, Fighting game, Role-playing Video Game','Sega AM1, Red Entertainment, Sega, Paon Corporation','Sega, Tezuka Productions','September 9, 2004','PlayStation 2','10/12/2022 19:03:58'),(54,'Kimi ga Nozomu Eien','ps2','Y2JlODA1OGM3NmQyMDZiMzIzYWU1ODhmNDQ4YWM3MGM=.jpg','anto98',0,'None','Eroge, Visual novel','Age','Acid, Alchemist, Princess Soft','August 3, 2001','Windows, Dreamcast, PlayStation 2','10/12/2022 19:23:40'),(55,'Afro Samurai','ps3','NGQ5MDBlZTFkZDcxMjI1NGQ1NGZiZGQ1ZWNkZjk0MmE=.jpg','anto98',2,'None','Beat [quot1]em up, Fighting game, Hack and slash, Action-adventure game','BNE Entertainment, Bandai Namco Holdings','BNE Entertainment, Surge','January 27, 2009','PlayStation 3, Xbox 360','10/13/2022 09:05:44'),(56,'Shikigami no Shiro','ps2','OTk4OGZjOGQ3ODliZTBlNTlhM2U1OWExN2E1MjkyMTM=.jpg','anto98',2,'None','Shoot [quot1]em up','Alfa System, Cosmo Machia','XS Games, Media Quest, Taito, SourceNext, Komodo','2001','PlayStation 2, Microsoft Windows, Xbox, Arcade game','10/13/2022 11:51:47'),(57,'Resident Evil 4','ps2','NGYyYWQzOGFhMDY1NmFhYWZkN2E2OWJiZWU0M2E4NTc=.jpg','devArt98',3,'None','Puzzle Video Game, Survival horror, Third-person shooter, Action-adventure game','Capcom, Capcom Production Studio 4','Capcom','January 11, 2005','PlayStation 2, Android, PlayStation 4, GameCube, MORE','10/13/2022 12:04:03'),(58,'Payday 2','ps3','ODllODBlMjA1Y2QzZmI4Zjk5NDIxYTE4MWQ1ZDA1NGY=.jpg','anto98',2,'None','Cooperative First-Person Shooter','Overkill Software, Starbreeze Studios, OVERKILL - a Starbreeze Studio., Sumo Digital','Starbreeze Studios, 505 Games','August 13, 2013','PlayStation 4, Xbox One, Nintendo Switch, PlayStation 3, Microsoft Windows, Xbox 360, Linux','10/13/2022 20:31:22'),(59,'Guitar Hero Smash Hits','ps2','NmM5NDQ2MGZlYTE3OTYxOTdlOWRlN2Q0N2YxMTg1MDA=.jpg','нещо98',6,'None','Rhythm game, Action game','Beenox','RedOctane, Activision, Activision Blizzard','June 16, 2009','PlayStation 3, Xbox 360, PlayStation 2, Wii','10/16/2022 18:25:05'),(60,'Okami','ps2','ZjQwZjc0ZjM3NDRjNWQyZWZiNTE5Njg5NGRhYzI1Mzc=.jpg','anto98',2,'None','Role-playing Video Game, Action-adventure game','Capcom, Clover Studio, Ready at Dawn','Capcom','April 20, 2006','Nintendo Switch, PlayStation 2, Wii, PlayStation 3, Xbox One, Microsoft Windows','10/16/2022 21:40:13'),(61,'Grandia III','ps2','YmIyN2VjZTZhMzhjMDc5ZmQwZTYwZjY2MDM4ZjEyZmU=.jpg','anto98',2,'https://cdromance.com/ps2-iso/grandia-iii-usaundub/','Japanese role-playing game, Adventure game','Game Arts','Square Enix','August 4, 2005','PlayStation 2','10/16/2022 21:44:22'),(62,'Tokyo Xtreme Racer: Drift 2','ps2','NGNjM2VhZTU4ZWI4Yzk0ZDJiYjI0ZmQwM2E5ZThkMDE=.jpg','anto98',2,'https://romspure.cc/roms/sony-playstation-2/tokyo-xtreme-racer-drift-2/#google_vignette','Racing Video Game','Genki','Genki, Crave Entertainment, Konami','July 28, 2005','PlayStation 2','10/16/2022 21:49:01');
/*!40000 ALTER TABLE `pending_uploads` ENABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=582 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rated_comments`
--

LOCK TABLES `rated_comments` WRITE;
/*!40000 ALTER TABLE `rated_comments` DISABLE KEYS */;
INSERT INTO `rated_comments` VALUES (581,40,3),(555,33,2),(177,27,2),(179,28,2),(213,26,3),(204,28,3),(212,29,3),(474,29,2),(522,44,6),(250,29,4),(238,32,4),(249,33,4),(256,35,4),(257,36,4),(258,34,4),(273,35,2),(368,32,2),(570,40,2),(535,36,2),(571,43,2),(440,40,5),(434,42,5),(572,45,2),(575,44,2),(578,48,2),(579,47,2);
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
) ENGINE=MyISAM AUTO_INCREMENT=817 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rated_games`
--

LOCK TABLES `rated_games` WRITE;
/*!40000 ALTER TABLE `rated_games` DISABLE KEYS */;
INSERT INTO `rated_games` VALUES (138,10,0,1),(99,5,0,1),(93,8,1,0),(108,10,1,0),(32,5,1,0),(88,8,0,1),(144,7,1,0),(143,7,0,1),(139,9,0,1),(137,9,1,0),(707,7,0,2),(706,7,2,0),(686,8,2,0),(442,6,2,0),(574,9,0,2),(572,9,2,0),(438,10,2,0),(162,1,2,0),(439,10,0,2),(665,14,2,0),(666,14,0,2),(230,12,0,2),(231,12,2,0),(305,7,3,0),(306,7,0,3),(247,14,3,0),(246,14,0,3),(241,10,0,3),(279,9,0,3),(244,9,3,0),(261,3,3,0),(281,15,0,3),(280,15,3,0),(284,1,0,3),(283,1,3,0),(661,15,2,0),(664,16,0,2),(663,16,2,0),(394,7,0,4),(364,9,0,4),(315,9,4,0),(395,7,4,0),(385,10,4,0),(386,10,0,4),(346,16,4,0),(345,16,0,4),(375,12,4,0),(334,1,0,4),(335,1,4,0),(338,2,0,4),(339,2,4,0),(340,4,4,0),(341,4,0,4),(347,6,4,0),(348,6,0,4),(352,11,4,0),(351,11,0,4),(383,17,4,0),(381,17,0,4),(390,14,0,4),(374,12,0,4),(391,14,4,0),(388,8,4,0),(389,8,0,4),(392,15,0,4),(393,15,4,0),(441,6,0,2),(662,15,0,2),(593,7,0,5),(524,15,5,0),(523,15,0,5),(514,16,0,5),(515,10,0,5),(516,9,0,5),(687,8,0,2),(703,18,2,0),(641,18,6,0),(704,18,0,2),(711,19,2,0),(713,20,3,0),(714,24,2,0),(774,25,3,0),(726,27,3,0),(722,29,3,0),(723,29,0,3),(724,28,3,0),(725,28,0,3),(727,27,0,3),(728,28,0,2),(739,29,0,2),(743,27,0,2),(806,25,0,2),(805,25,2,0),(753,30,3,0),(754,30,0,3),(755,33,3,0),(756,33,0,3),(772,34,0,3),(771,34,3,0),(773,31,3,0),(775,32,3,0),(776,35,3,0),(777,36,2,0),(778,36,0,2),(779,42,2,0),(780,42,0,2),(808,45,0,2),(807,45,2,0),(783,42,3,0),(784,45,3,0),(785,43,3,0),(786,43,0,3),(789,46,3,0),(790,46,0,3),(791,47,2,0),(792,47,0,2),(810,39,0,2),(811,39,2,0),(799,33,2,0),(803,46,2,0),(800,32,2,0),(801,30,2,0),(802,31,2,0),(812,48,6,0),(816,34,2,0);
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
  `user_rank` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'z','z','$2y$10$j8eYPFiMYdYtiUeJCWbNleXI7RB1jM3l7Y1KwUXzPXDR7jNXhGdaO','\\ps-classics\\img\\wFz5XPWb79QpekP-Pennywise-PNG-Clipart.png','',0,0,2),(2,'anto98','abv@abv.bg','$2y$10$gcj9ZgFxGzMly5d4YIYB5elxW9reLNMXGg3DVdsAYNRyTufKY4mLi','\\ps-classics\\img\\yeah.png','',0,0,0),(3,'devArt98','zzz@abv.bg','$2y$10$Hs.UbQN53GFxYYW6WeDdQOFvlle94n1wrWNxNog8EphqvqHUJyq7a','\\ps-classics\\img\\wFz5XPWb79QpekP-Pennywise-PNG-Clipart.png','',0,0,1),(4,'Motha[quot1]Fucka','az[quot1]@email.bg','$2y$10$kW3POFjNYpUCL1i3YIvPnO8hlRS0rN2QVPIwwVKOlHeZ7T9vyeod6','\\ps-classics\\img\\wFz5XPWb79QpekP-Pennywise-PNG-Clipart.png','',0,0,2),(5,'Брадва123','az@abv.bg','$2y$10$brwBj8kr70EbYSQYyDFfU.pVPY3/UgenTdmQXKjh8ORe4OJKoXvn2','\\ps-classics\\img\\wFz5XPWb79QpekP-Pennywise-PNG-Clipart.png','',0,0,2),(6,'нещо98','z@abv.bg','$2y$10$PDImV8eZES2AvuXOs9E.V.AIAvSc33uoac95Y18eUJoktZgIg4zau','\\ps-classics\\img\\wFz5XPWb79QpekP-Pennywise-PNG-Clipart.png','',0,0,2);
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
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `viewed_games`
--

LOCK TABLES `viewed_games` WRITE;
/*!40000 ALTER TABLE `viewed_games` DISABLE KEYS */;
INSERT INTO `viewed_games` VALUES (1,7,1),(2,8,1),(3,9,1),(4,10,1),(5,11,1),(6,4,1),(7,7,2),(8,6,1),(9,4,2),(10,1,2),(11,9,2),(12,8,2),(13,6,2),(14,3,2),(15,11,2),(16,10,2),(17,2,2),(18,14,2),(19,12,2),(20,14,3),(21,12,3),(22,7,3),(23,5,3),(24,11,3),(25,10,3),(26,9,3),(27,6,3),(28,4,3),(29,2,3),(30,1,3),(31,3,3),(32,15,3),(33,15,2),(34,16,2),(35,8,3),(36,16,3),(37,7,4),(38,9,4),(39,10,4),(40,8,4),(41,16,4),(42,12,4),(43,15,4),(44,2,4),(45,1,4),(46,4,4),(47,5,4),(48,6,4),(49,11,4),(50,3,4),(51,14,4),(52,17,4),(53,17,2),(54,5,2),(55,17,3),(56,7,5),(57,15,5),(58,16,5),(59,10,5),(60,9,5),(61,18,2),(62,18,6),(63,7,6),(64,15,6),(65,5,6),(66,1,6),(67,9,6),(68,19,2),(69,20,3),(70,24,2),(71,23,2),(72,25,2),(73,25,3),(74,27,3),(75,28,3),(76,29,3),(77,24,3),(78,28,2),(79,29,2),(80,27,2),(81,20,2),(82,30,3),(83,32,3),(84,32,2),(85,33,3),(86,31,3),(87,18,3),(88,19,3),(89,34,3),(90,35,2),(91,30,2),(92,35,3),(93,36,2),(94,38,2),(95,39,2),(96,34,2),(97,42,2),(98,43,2),(99,44,2),(100,45,2),(101,42,3),(102,45,3),(103,38,3),(104,39,3),(105,43,3),(106,46,3),(107,47,2),(108,46,2),(109,33,2),(110,31,2),(111,48,6),(112,42,6),(113,49,2),(114,50,2),(115,51,2);
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

-- Dump completed on 2022-10-21 23:35:41
