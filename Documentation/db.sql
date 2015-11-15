-- MySQL dump 10.13  Distrib 5.6.24, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: conferencemanager
-- ------------------------------------------------------
-- Server version	5.6.24

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
-- Table structure for table `breaks`
--

DROP TABLE IF EXISTS `breaks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `breaks` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` longtext NOT NULL,
  `Description` longtext,
  `LectureId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `LectureId` (`LectureId`),
  CONSTRAINT `Lecture_Breaks` FOREIGN KEY (`LectureId`) REFERENCES `lectures` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `breaks`
--

LOCK TABLES `breaks` WRITE;
/*!40000 ALTER TABLE `breaks` DISABLE KEYS */;
/*!40000 ALTER TABLE `breaks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conferences`
--

DROP TABLE IF EXISTS `conferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conferences` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` longtext NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `OwnerId` int(11) NOT NULL,
  `Venue_Id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `OwnerId` (`OwnerId`),
  KEY `Venue_Id` (`Venue_Id`),
  CONSTRAINT `Conference_Venue` FOREIGN KEY (`Venue_Id`) REFERENCES `venues` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `User_MyConferences` FOREIGN KEY (`OwnerId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conferences`
--

LOCK TABLES `conferences` WRITE;
/*!40000 ALTER TABLE `conferences` DISABLE KEYS */;
INSERT INTO `conferences` VALUES (1,'PHP 7 - the good, the bad and the evil','2015-12-01 18:57:02','2015-12-04 18:57:02',4,1),(2,'Android World Devs Conference','2015-12-06 18:57:02','2015-12-11 18:57:02',1,2),(3,'ASP.Net Web Development - the future','2015-12-11 18:57:02','2015-12-15 18:57:02',2,3);
/*!40000 ALTER TABLE `conferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conferencesparticipants`
--

DROP TABLE IF EXISTS `conferencesparticipants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conferencesparticipants` (
  `ConferenceId` int(11) NOT NULL,
  `ParticipantId` int(11) NOT NULL,
  PRIMARY KEY (`ConferenceId`,`ParticipantId`),
  KEY `User_AttendingConferences_Target` (`ParticipantId`),
  CONSTRAINT `User_AttendingConferences_Source` FOREIGN KEY (`ConferenceId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `User_AttendingConferences_Target` FOREIGN KEY (`ParticipantId`) REFERENCES `conferences` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conferencesparticipants`
--

LOCK TABLES `conferencesparticipants` WRITE;
/*!40000 ALTER TABLE `conferencesparticipants` DISABLE KEYS */;
/*!40000 ALTER TABLE `conferencesparticipants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `halls`
--

DROP TABLE IF EXISTS `halls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `halls` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` longtext NOT NULL,
  `Capacity` int(11) NOT NULL,
  `VenueId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `VenueId` (`VenueId`),
  CONSTRAINT `Venue_Halls` FOREIGN KEY (`VenueId`) REFERENCES `venues` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `halls`
--

LOCK TABLES `halls` WRITE;
/*!40000 ALTER TABLE `halls` DISABLE KEYS */;
INSERT INTO `halls` VALUES (1,'Hall 1',2500,1),(2,'Hall 2',1000,1),(3,'Hall 3',500,1),(4,'Rodina',100,4),(5,'Republika',20,4),(6,'Stara Planina',53,4),(7,'London',121,3),(8,'Paris',11,3),(9,'Lubljana',77,3),(10,'Danube',45,2),(11,'Nile',53,2),(12,'Amazon',20,2);
/*!40000 ALTER TABLE `halls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lectures`
--

DROP TABLE IF EXISTS `lectures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lectures` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` longtext NOT NULL,
  `Description` longtext,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `ConferenceId` int(11) NOT NULL,
  `Hall_Id` int(11) DEFAULT NULL,
  `Speaker_Id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `ConferenceId` (`ConferenceId`),
  KEY `Hall_Id` (`Hall_Id`),
  KEY `Speaker_Id` (`Speaker_Id`),
  CONSTRAINT `Conference_Lectures` FOREIGN KEY (`ConferenceId`) REFERENCES `conferences` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `Lecture_Hall` FOREIGN KEY (`Hall_Id`) REFERENCES `halls` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Lecture_Speaker` FOREIGN KEY (`Speaker_Id`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lectures`
--

LOCK TABLES `lectures` WRITE;
/*!40000 ALTER TABLE `lectures` DISABLE KEYS */;
INSERT INTO `lectures` VALUES (1,'What\'s new in PHP 7','Lecture description goes here...','2015-12-02 03:57:02','2015-12-02 06:57:02',1,NULL,NULL),(2,'PHP 7 Speed Improvements','Lecture description goes here...','2015-12-02 07:57:02','2015-12-02 09:57:02',1,NULL,NULL),(3,'PHP 7 Strict Types','Lecture description goes here...','2015-12-02 04:57:02','2015-12-02 07:57:02',1,NULL,NULL);
/*!40000 ALTER TABLE `lectures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecturesparticipants`
--

DROP TABLE IF EXISTS `lecturesparticipants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecturesparticipants` (
  `LectureId` int(11) NOT NULL,
  `ParticipantId` int(11) NOT NULL,
  PRIMARY KEY (`LectureId`,`ParticipantId`),
  KEY `User_AttendingLectures_Target` (`ParticipantId`),
  CONSTRAINT `User_AttendingLectures_Source` FOREIGN KEY (`LectureId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `User_AttendingLectures_Target` FOREIGN KEY (`ParticipantId`) REFERENCES `lectures` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturesparticipants`
--

LOCK TABLES `lecturesparticipants` WRITE;
/*!40000 ALTER TABLE `lecturesparticipants` DISABLE KEYS */;
/*!40000 ALTER TABLE `lecturesparticipants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `SenderId` int(11) NOT NULL,
  `RecipientId` int(11) NOT NULL,
  `Content` longtext NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `RecipientId` (`RecipientId`),
  KEY `SenderId` (`SenderId`),
  CONSTRAINT `User_RecievedMessages` FOREIGN KEY (`RecipientId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `User_SentMessages` FOREIGN KEY (`SenderId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Content` longtext NOT NULL,
  `IsRead` tinyint(1) NOT NULL,
  `RecipientId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `RecipientId` (`RecipientId`),
  CONSTRAINT `User_Notifications` FOREIGN KEY (`RecipientId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` longtext NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `speakerinvitations`
--

DROP TABLE IF EXISTS `speakerinvitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `speakerinvitations` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `LectureId` int(11) NOT NULL,
  `SpeakerId` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `SpeakerId` (`SpeakerId`),
  KEY `LectureId` (`LectureId`),
  CONSTRAINT `Lecture_SpeakerInvitations` FOREIGN KEY (`LectureId`) REFERENCES `lectures` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `User_MySpeakerInvitations` FOREIGN KEY (`SpeakerId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `speakerinvitations`
--

LOCK TABLES `speakerinvitations` WRITE;
/*!40000 ALTER TABLE `speakerinvitations` DISABLE KEYS */;
/*!40000 ALTER TABLE `speakerinvitations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Username` longtext NOT NULL,
  `Email` longtext NOT NULL,
  `PasswordHash` longtext NOT NULL,
  `FullName` longtext,
  `Telephone` longtext,
  `Role_Id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `Role_Id` (`Role_Id`),
  CONSTRAINT `User_Role` FOREIGN KEY (`Role_Id`) REFERENCES `roles` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'strahil','strahil@mail.bg','123456','Strahil Ruychev','+359 2 12345678',NULL),(2,'ivan','ivan@mail.bg','123456','Ivan Petrov','+359 2 12345678',NULL),(3,'evlogi','evlogi@mail.bg','123456','Evlogi Temelkov','+359 2 12345678',NULL),(4,'milena','milena@mail.bg','123456','Milena Zdravkova','+359 2 12345678',NULL),(5,'anelia','anelia@mail.bg','123456','Anelia Nikolova','+359 2 12345678',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venuereservationrequests`
--

DROP TABLE IF EXISTS `venuereservationrequests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venuereservationrequests` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `VenueId` int(11) NOT NULL,
  `ConferenceId` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `VenueId` (`VenueId`),
  KEY `ConferenceId` (`ConferenceId`),
  CONSTRAINT `Conference_VenueReservationRequests` FOREIGN KEY (`ConferenceId`) REFERENCES `conferences` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Venue_ReservationRequests` FOREIGN KEY (`VenueId`) REFERENCES `venues` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venuereservationrequests`
--

LOCK TABLES `venuereservationrequests` WRITE;
/*!40000 ALTER TABLE `venuereservationrequests` DISABLE KEYS */;
INSERT INTO `venuereservationrequests` VALUES (1,1,1,0),(2,2,2,0),(3,3,3,0);
/*!40000 ALTER TABLE `venuereservationrequests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venues`
--

DROP TABLE IF EXISTS `venues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venues` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` longtext NOT NULL,
  `Description` longtext NOT NULL,
  `Address` longtext NOT NULL,
  `OwnerId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `OwnerId` (`OwnerId`),
  CONSTRAINT `User_MyVenues` FOREIGN KEY (`OwnerId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venues`
--

LOCK TABLES `venues` WRITE;
/*!40000 ALTER TABLE `venues` DISABLE KEYS */;
INSERT INTO `venues` VALUES (1,'NDK','Very big and ugly convention centre, a relique from the comunist past. Cheap to rent though...','Sofia, Bulgaria',2),(2,'InterExpoCenter','Modern and well equipped convention centres. Has metro station nearby.','Tsarigradsko Shausse, Sofia, Bulgaria',3),(3,'SofiaExpoCenter','The newest convention centre in Sofia. Has the best equipement and fascilities.','Paradise Centre Mall, Sofia, Bulgaria',4),(4,'Interpred','Somewhat old, but still popular convention centre. Big halls, appropriate for large events.','Dragan Tsankov blvd., Sofia, Bulgaria',4);
/*!40000 ALTER TABLE `venues` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-15 14:51:18
