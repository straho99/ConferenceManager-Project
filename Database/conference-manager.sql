# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.42)
# Database: conference-manager
# Generation Time: 2015-11-29 02:27:58 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table conferences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `conferences`;

CREATE TABLE `conferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` longtext NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `OwnerId` int(11) NOT NULL,
  `Venue_Id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Id` (`id`),
  KEY `OwnerId` (`OwnerId`),
  KEY `Venue_Id` (`Venue_Id`),
  CONSTRAINT `Conference_Venue` FOREIGN KEY (`Venue_Id`) REFERENCES `venues` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `User_MyConferences` FOREIGN KEY (`OwnerId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `conferences` WRITE;
/*!40000 ALTER TABLE `conferences` DISABLE KEYS */;

INSERT INTO `conferences` (`id`, `Title`, `StartDate`, `EndDate`, `OwnerId`, `Venue_Id`)
VALUES
	(7,'PHP 7: the good, the bad and the evil','2015-11-29 00:00:00','2015-11-30 00:00:00',1,2),
	(8,'Android World Wide Developers Conference','2015-12-07 00:00:00','2015-12-11 00:00:00',4,3);

/*!40000 ALTER TABLE `conferences` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table conferencesParticipants
# ------------------------------------------------------------

DROP TABLE IF EXISTS `conferencesParticipants`;

CREATE TABLE `conferencesParticipants` (
  `ConferenceId` int(11) NOT NULL,
  `ParticipantId` int(11) NOT NULL,
  PRIMARY KEY (`ConferenceId`,`ParticipantId`),
  KEY `User_AttendingConferences_Target` (`ParticipantId`),
  CONSTRAINT `User_AttendingConferences_Source` FOREIGN KEY (`ConferenceId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `User_AttendingConferences_Target` FOREIGN KEY (`ParticipantId`) REFERENCES `conferences` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table halls
# ------------------------------------------------------------

DROP TABLE IF EXISTS `halls`;

CREATE TABLE `halls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` longtext NOT NULL,
  `Capacity` int(11) NOT NULL,
  `VenueId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Id` (`id`),
  KEY `VenueId` (`VenueId`),
  CONSTRAINT `Venue_Halls` FOREIGN KEY (`VenueId`) REFERENCES `venues` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `halls` WRITE;
/*!40000 ALTER TABLE `halls` DISABLE KEYS */;

INSERT INTO `halls` (`id`, `Title`, `Capacity`, `VenueId`)
VALUES
	(1,'Hall 1',2500,1),
	(2,'Hall 2',1000,1),
	(3,'Hall 3',500,1),
	(5,'Republika',20,4),
	(6,'Stara Planina',53,4),
	(7,'London',121,3),
	(8,'Paris',11,3),
	(9,'Lubljana',77,3),
	(10,'Danube',45,2),
	(11,'Nile',53,2),
	(12,'Amazon',20,2),
	(16,'Rodina',100,4);

/*!40000 ALTER TABLE `halls` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table lectureBreaks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lectureBreaks`;

CREATE TABLE `lectureBreaks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` longtext NOT NULL,
  `Description` longtext,
  `LectureId` int(11) NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table lectures
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lectures`;

CREATE TABLE `lectures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` longtext NOT NULL,
  `Description` longtext,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `ConferenceId` int(11) NOT NULL,
  `Hall_Id` int(11) DEFAULT NULL,
  `Speaker_Id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Id` (`id`),
  KEY `ConferenceId` (`ConferenceId`),
  CONSTRAINT `Conference_Lectures` FOREIGN KEY (`ConferenceId`) REFERENCES `conferences` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `lectures` WRITE;
/*!40000 ALTER TABLE `lectures` DISABLE KEYS */;

INSERT INTO `lectures` (`id`, `Title`, `Description`, `StartDate`, `EndDate`, `ConferenceId`, `Hall_Id`, `Speaker_Id`)
VALUES
	(38,'Lecture 1','Nice lecture','2015-11-29 09:00:00','2015-11-29 11:00:00',7,10,5),
	(39,'Lecture 2','Nice lecture','2015-11-29 10:00:00','2015-11-29 12:00:00',7,11,7),
	(40,'Lecture 3','Nicest lecture','2015-11-29 11:00:00','2015-11-29 13:00:00',7,12,8),
	(41,'Lecture 4','Great lecture','2015-11-29 14:00:00','2015-11-29 17:00:00',7,10,2),
	(42,'Lecture 5','The best lecture!','2015-11-29 12:30:00','2015-11-29 14:30:00',7,11,NULL),
	(43,'Lecture 6','Very interesting lecture','2015-11-29 15:00:00','2015-11-29 18:00:00',7,12,NULL),
	(44,'What\'s new in Marshmallow','All the best new features of Android 6.0','2015-12-07 09:00:00','2015-12-07 11:00:00',8,NULL,NULL);

/*!40000 ALTER TABLE `lectures` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table lecturesParticipants
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lecturesParticipants`;

CREATE TABLE `lecturesParticipants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LectureId` int(11) NOT NULL,
  `ParticipantId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `LectureId` (`LectureId`),
  KEY `ParticipantId` (`ParticipantId`),
  CONSTRAINT `lecturesparticipants_ibfk_1` FOREIGN KEY (`LectureId`) REFERENCES `lectures` (`id`),
  CONSTRAINT `lecturesparticipants_ibfk_2` FOREIGN KEY (`ParticipantId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `lecturesParticipants` WRITE;
/*!40000 ALTER TABLE `lecturesParticipants` DISABLE KEYS */;

INSERT INTO `lecturesParticipants` (`id`, `LectureId`, `ParticipantId`)
VALUES
	(9,39,1),
	(10,38,1),
	(11,42,1),
	(12,43,1);

/*!40000 ALTER TABLE `lecturesParticipants` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SenderId` int(11) NOT NULL,
  `RecipientId` int(11) NOT NULL,
  `Content` longtext NOT NULL,
  `CreatedOn` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Id` (`id`),
  KEY `RecipientId` (`RecipientId`),
  KEY `SenderId` (`SenderId`),
  CONSTRAINT `User_RecievedMessages` FOREIGN KEY (`RecipientId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `User_SentMessages` FOREIGN KEY (`SenderId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Content` longtext NOT NULL,
  `UserId` int(11) NOT NULL,
  `IsRead` smallint(11) NOT NULL,
  `CreatedOn` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;

INSERT INTO `notifications` (`id`, `Content`, `UserId`, `IsRead`, `CreatedOn`)
VALUES
	(1,'New conference titled \'PHP 7: the good, the bad and the evil\' was added by user strahil.',1,0,'2015-11-28 16:02:32'),
	(2,'New conference titled \'PHP 7: the good, the bad and the evil\' was added by user strahil.',2,0,'2015-11-28 16:02:32'),
	(3,'New conference titled \'PHP 7: the good, the bad and the evil\' was added by user strahil.',3,0,'2015-11-28 16:02:32'),
	(4,'New conference titled \'PHP 7: the good, the bad and the evil\' was added by user strahil.',4,0,'2015-11-28 16:02:32'),
	(5,'New conference titled \'PHP 7: the good, the bad and the evil\' was added by user strahil.',5,0,'2015-11-28 16:02:32'),
	(6,'New conference titled \'PHP 7: the good, the bad and the evil\' was added by user strahil.',7,0,'2015-11-28 16:02:32'),
	(7,'New conference titled \'PHP 7: the good, the bad and the evil\' was added by user strahil.',8,0,'2015-11-28 16:02:32'),
	(8,'New conference titled \'PHP 7: the good, the bad and the evil\' was added by user strahil.',9,0,'2015-11-28 16:02:32'),
	(9,'New conference titled \'PHP 7: the good, the bad and the evil\' was added by user strahil.',10,0,'2015-11-28 16:02:32'),
	(10,'You received venue reservation request for venue \'InterExpoCenter\' by conference \'PHP 7: the good, the bad and the evil\'.',3,0,'2015-11-28 16:02:39'),
	(11,'You received Speaker invitation for the lecture \'Lecture 2\'.',7,0,'2015-11-28 18:05:40'),
	(12,'You received Speaker invitation for the lecture \'Lecture 1\'.',5,0,'2015-11-28 18:05:47'),
	(13,'You received Speaker invitation for the lecture \'Lecture 3\'.',8,0,'2015-11-28 18:07:07'),
	(14,'You received Speaker invitation for the lecture \'Lecture 4\'.',2,0,'2015-11-29 03:02:58'),
	(15,'New conference titled \'Android World Wide Developers Conference\' was added by user milena.',1,0,'2015-11-29 03:19:09'),
	(16,'New conference titled \'Android World Wide Developers Conference\' was added by user milena.',2,0,'2015-11-29 03:19:09'),
	(17,'New conference titled \'Android World Wide Developers Conference\' was added by user milena.',3,0,'2015-11-29 03:19:09'),
	(18,'New conference titled \'Android World Wide Developers Conference\' was added by user milena.',4,0,'2015-11-29 03:19:09'),
	(19,'New conference titled \'Android World Wide Developers Conference\' was added by user milena.',5,0,'2015-11-29 03:19:09'),
	(20,'New conference titled \'Android World Wide Developers Conference\' was added by user milena.',7,0,'2015-11-29 03:19:09'),
	(21,'New conference titled \'Android World Wide Developers Conference\' was added by user milena.',8,0,'2015-11-29 03:19:09'),
	(22,'New conference titled \'Android World Wide Developers Conference\' was added by user milena.',9,0,'2015-11-29 03:19:09'),
	(23,'New conference titled \'Android World Wide Developers Conference\' was added by user milena.',10,0,'2015-11-29 03:19:09'),
	(24,'You received venue reservation request for venue \'SofiaExpoCenter\' by conference \'Android World Wide Developers Conference\'.',4,0,'2015-11-29 03:19:23');

/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`id`, `Name`)
VALUES
	(1,'user'),
	(2,'conferenceOwner'),
	(3,'venueOwner'),
	(4,'admin');

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table speakerInvitations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `speakerInvitations`;

CREATE TABLE `speakerInvitations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LectureId` int(11) NOT NULL,
  `SpeakerId` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `speakerInvitations` WRITE;
/*!40000 ALTER TABLE `speakerInvitations` DISABLE KEYS */;

INSERT INTO `speakerInvitations` (`id`, `LectureId`, `SpeakerId`, `Status`)
VALUES
	(17,39,7,0),
	(18,38,5,0),
	(19,40,8,0),
	(20,41,2,0);

/*!40000 ALTER TABLE `speakerInvitations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` longtext NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `fullname`, `telephone`)
VALUES
	(1,'strahil','strahil@mail.bg','$2y$10$eu.DPmrDeEQE2o2rYSqnaur77SbcS.JFQo4mEZJry8mnf4JOKQv02','Strahil Ruychev','+359 2 1234567'),
	(2,'ivan','ivan@mail.bg','$2y$10$eu.DPmrDeEQE2o2rYSqnaur77SbcS.JFQo4mEZJry8mnf4JOKQv02','Ivan Ivanov','+359 2 1234567'),
	(3,'evlogi','evlogi@mail.bg','$2y$10$eu.DPmrDeEQE2o2rYSqnaur77SbcS.JFQo4mEZJry8mnf4JOKQv02','Evlogi Georgiev','+359 2 1234567'),
	(4,'milena','milena@mail.bg','$2y$10$eu.DPmrDeEQE2o2rYSqnaur77SbcS.JFQo4mEZJry8mnf4JOKQv02','Milena Penkova','+359 2 1234567'),
	(5,'anelia','anelia@mail.bg','$2y$10$eu.DPmrDeEQE2o2rYSqnaur77SbcS.JFQo4mEZJry8mnf4JOKQv02','Anelia Nikolova','+359 2 1234567'),
	(7,'anatoli','anatoli@gmail.com','$2y$10$ZtYqIwb0XaMVaRJUcdUaHem8sgNqcxQrYnslx2ICPJLXLs3l/hesy','Anatoli Angelov','+ 359 73 123 777'),
	(8,'barish','barish@abv.com','$2y$10$NcpLY2n0Lz9yJQkYN50exuYJm1JVNvgligFhuV.gdL2yXaPyc1WDm\n','Barish Yumerov','+359 2 777 123'),
	(9,'asya','asya@yahoo.com','$2y$10$X.5AVIo4JtZxcgBgB3yT8OfaP/FWJTtePTQNQCgtyPFCKI/BOR4jK','Asya Mincheva','+359 23 555 777'),
	(10,'evstati','evstati@test.bg','$2y$10$oPKMrPg0TSoX8FKKCFEbmumxqWMzdcdNbe3gFi4AJn6cXMYRBAN8q','Evstati Evstatiev','+359 02 987 654');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_roles`;

CREATE TABLE `users_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `users_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users_roles` WRITE;
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;

INSERT INTO `users_roles` (`id`, `user_id`, `role_id`)
VALUES
	(1,4,2),
	(3,7,1),
	(4,7,2),
	(5,1,3),
	(6,4,3),
	(7,2,3),
	(8,1,1),
	(9,1,4),
	(10,3,3),
	(11,3,2);

/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table venueReservationRequests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `venueReservationRequests`;

CREATE TABLE `venueReservationRequests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VenueId` int(11) NOT NULL,
  `ConferenceId` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `venueReservationRequests` WRITE;
/*!40000 ALTER TABLE `venueReservationRequests` DISABLE KEYS */;

INSERT INTO `venueReservationRequests` (`id`, `VenueId`, `ConferenceId`, `Status`)
VALUES
	(17,2,7,1),
	(18,3,8,1);

/*!40000 ALTER TABLE `venueReservationRequests` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table venues
# ------------------------------------------------------------

DROP TABLE IF EXISTS `venues`;

CREATE TABLE `venues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` longtext NOT NULL,
  `Description` longtext NOT NULL,
  `Address` longtext NOT NULL,
  `OwnerId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Id` (`id`),
  KEY `OwnerId` (`OwnerId`),
  CONSTRAINT `User_MyVenues` FOREIGN KEY (`OwnerId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `venues` WRITE;
/*!40000 ALTER TABLE `venues` DISABLE KEYS */;

INSERT INTO `venues` (`id`, `Title`, `Description`, `Address`, `OwnerId`)
VALUES
	(1,'NDK','Very big and ugly convention centre, a relique from the comunist past. Cheap to rent though...','Sofia, Bulgaria',2),
	(2,'InterExpoCenter','Modern and well equipped convention centres. Has metro station nearby.','Tsarigradsko Shausse, Sofia, Bulgaria',3),
	(3,'SofiaExpoCenter','The newest convention centre in Sofia. Has the best equipement and fascilities.','Paradise Centre Mall, Sofia, Bulgaria',4),
	(4,'Interpred','Somewhat old, but still popular convention centre. Big halls, appropriate for large events.','Dragan Tsankov blvd., Sofia, Bulgaria',4),
	(5,'The Hilton Hotel','Spacious and luxurious hotel right in the centre of Sofia','1 Cherni Vrah blvd., Sofia',1);

/*!40000 ALTER TABLE `venues` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
