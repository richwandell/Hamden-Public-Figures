CREATE DATABASE  IF NOT EXISTS `politics` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `politics`;
-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: 192.168.33.10    Database: politics
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

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
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `date_id` int(11) DEFAULT NULL,
  `event_name` varchar(150) DEFAULT NULL,
  `recurring` char(1) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  KEY `date_id` (`date_id`),
  KEY `event_id` (`event_id`),
  KEY `event_name` (`event_name`(20))
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,4861,'Earth Day Event','y','Earth Day event at the middle school\r'),(2,4870,'Woman\'\'s Club Installation Dinner','u','new officer swear in\r'),(3,4878,'Hamden Firefighters: History, Evolution and Events','n','Historical presentation\r'),(4,4891,'Hamden Land Trust Convservation Annual Meeting','y','\r'),(5,4891,'Symposium on International Relations (44th)','u','Cosponsors: Yale Program for International Education Resources; Sacred Heart University)\r'),(6,4891,'Traffic Calming Workshop','u','\r'),(7,4895,'Memorial Weekend Classic Car Show (19th)','y','car show at Quinnipiac University\r'),(8,4896,'Memorial Day Parade (5/27/2013)','y','parade\r'),(9,4896,'Memorial Day Mass (5/27/2013)','u','\r'),(10,4901,'Rabies Vaccination Clinic (29th)','y','\r'),(11,4901,'CT Trails Day at Johnson\'\'s Pond','u','\r'),(12,4902,'Walk for Awareness','u','breast cancer fund raiser\r'),(13,5055,'Woman\'\'s Club Fashion Show','u','\r'),(14,5296,'Old Timers Game','u','Sometime in 2014\r'),(15,4903,'Looking Forward Fashion Show (17th)','y','cancer fund raiser\r'),(16,4928,'Fireworks Display (20th)','y','\r'),(17,4965,'Hamden\'\'s National Night Out','u','Rochford Field. Crime and drug prevention. 40 businesses and organizations participated\r'),(18,5296,'Summer Reading Program','y','Summer program at Miller Library\r'),(19,5801,'Athletic Hall of Fame Dinner','y','12th annual\r'),(20,5781,'Meet Your Legislative Council Candidates Forum','u','\r'),(21,5771,'Meet Election Candidates','u','meet candidates for upcoming election\r'),(22,5782,'Autumn Fling Costume Party','y','\r'),(23,5777,'Open House','u','\r'),(24,5766,'Out of the Darkness Walk','y','5th annual. Suicide prevention \r'),(25,5771,'Mayoral Debate','u','Thornton Wilder Hall\r'),(26,5000,'Installation Dinner','u','\r'),(27,5000,'Mayoral Election','y','\r');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_organization`
--

DROP TABLE IF EXISTS `event_organization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_organization` (
  `event_organization_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `organization_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`event_organization_id`),
  KEY `event_id` (`event_id`),
  KEY `organization_id` (`organization_id`),
  KEY `event_organization_id` (`event_organization_id`),
  CONSTRAINT `event_organization_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`),
  CONSTRAINT `event_organization_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`organization_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_organization`
--

LOCK TABLES `event_organization` WRITE;
/*!40000 ALTER TABLE `event_organization` DISABLE KEYS */;
INSERT INTO `event_organization` VALUES (1,26,3),(2,13,3),(3,4,3),(4,7,5),(5,9,7),(6,9,3),(7,10,5),(8,11,3),(9,15,1),(10,15,1),(11,16,3),(12,17,3),(13,17,3),(14,17,9),(15,17,5),(16,17,9),(17,27,5),(18,27,5),(19,24,3);
/*!40000 ALTER TABLE `event_organization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_person`
--

DROP TABLE IF EXISTS `event_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_person` (
  `event_person_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`event_person_id`),
  KEY `event_id` (`event_id`),
  KEY `person_id` (`person_id`),
  KEY `event_person_id` (`event_person_id`),
  CONSTRAINT `event_person_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`),
  CONSTRAINT `event_person_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_person`
--

LOCK TABLES `event_person` WRITE;
/*!40000 ALTER TABLE `event_person` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_title`
--

DROP TABLE IF EXISTS `job_title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_title` (
  `job_title_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`job_title_id`),
  KEY `job_title_id` (`job_title_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_title`
--

LOCK TABLES `job_title` WRITE;
/*!40000 ALTER TABLE `job_title` DISABLE KEYS */;
INSERT INTO `job_title` VALUES (1,'1st Vice President\r'),(2,'2nd Vice President\r'),(3,'Advisor\r'),(4,'Associate Professor - Political Science\r'),(5,'Chairman\r'),(6,'Co-chair\r'),(7,'Coordinator\r'),(8,'Correspondence Secretary\r'),(9,'Council Member at large\r'),(10,'Director\r'),(11,'Economic Development Coordinator\r'),(12,'Fire Chief\r'),(13,'Librarian\r'),(14,'Mayor\r'),(15,'Member\r'),(16,'Paralegal\r'),(17,'Past President and Installing Officer\r'),(18,'Police Chief\r'),(19,'President\r'),(20,'Principle\r'),(21,'Recording Secretary\r'),(22,'Rotarian\r'),(23,'State Party Chairman\r'),(24,'Superintendant of Schools\r'),(25,'Town Clerk\r'),(26,'Town Planner\r'),(27,'Trustee\r'),(28,'Vice Chairman\r');
/*!40000 ALTER TABLE `job_title` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organization`
--

DROP TABLE IF EXISTS `organization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organization` (
  `organization_id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_type_id` int(11) DEFAULT NULL,
  `organization_name` varchar(120) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `year_modified` varchar(4) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`organization_id`),
  KEY `organization_type_id` (`organization_type_id`),
  KEY `organization_id` (`organization_id`),
  KEY `organization_name` (`organization_name`(20)),
  CONSTRAINT `organization_ibfk_1` FOREIGN KEY (`organization_type_id`) REFERENCES `organization_type` (`organization_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organization`
--

LOCK TABLES `organization` WRITE;
/*!40000 ALTER TABLE `organization` DISABLE KEYS */;
INSERT INTO `organization` VALUES (1,3,'AARP\'\'s Experience Corps','','2013','','\r'),(2,1,'Connex Credit Union','','','','\r'),(3,1,'D\'\'Camm Gentlemen\'\'s Clothiers','','2013','','\r'),(4,5,'Democratic Party','','2013','','\r'),(5,3,'Dunbar Hill Civic Association','','2013','','\r'),(6,3,'Elks Lodge #2224','','2013','','\r'),(7,3,'Elm City Cycling','','2013','','\r'),(8,4,'Experience Corps','non-profit tutoring group','2013','','\r'),(9,5,'Hamden - Boards and Commissions - ','','2015','','\r'),(10,5,'Hamden - Departments - Arts, Recreation, Culture','','2015','','\r'),(11,5,'Hamden - Departments - Finance','','2015','','\r'),(12,5,'Hamden - Departments - Fire','','2015','','\r'),(13,5,'Hamden - Departments - Planning and Zoning','','2015','','\r'),(14,5,'Hamden - Departments - Police','','2015','','\r'),(15,5,'Hamden - Departments - Youth Services','','','','\r'),(16,3,'Hamden American Legion Post 150','','2013','','\r'),(17,5,'Hamden Art, Recreation, Culture','','2013','','\r'),(18,5,'Hamden Board of Education ','','2013','','\r'),(19,3,'Hamden Boy Scouts and Cub Scouts','','2013','','\r'),(20,1,'Hamden Chamber of Commerce','','2015','','\r'),(21,5,'Hamden Commission on Disability Rights and Opportunities','','2015','','\r'),(22,3,'Hamden Democratic Headquarters','','2015','2600 Dixwell','\r'),(23,4,'Hamden Education Foundation','','2015','','\r'),(24,3,'Hamden Fathers Baseball/Softball Association','','2013','','\r'),(25,5,'Hamden Government','','2013','','\r'),(26,3,'Hamden Historical Society','','2013','','\r'),(27,3,'Hamden Land Conservation Trust','','2013','','\r'),(28,5,'Hamden Library','','2015','','\r'),(29,5,'Hamden Library - Business and Career Center','','2015','','\r'),(30,5,'Hamden Library - Miller Library','http://www.hamdenlibrary.org/','2013','','\r'),(31,9,'Hamden Miller Senior Center Cafe',' ','2015','','\r'),(32,5,'Hamden Police Department','','2013','','\r'),(33,3,'Hamden Quilters / Crafters','','2013','','\r'),(34,3,'Hamden Veterans Commission','','2013','','\r'),(35,3,'Hamden Veterans Organization','','2013','','\r'),(36,3,'Hamden Volunteer Firefighters Fireworks Commission','','','','\r'),(37,3,'Hamden Woman\'\'s Club','','2013','','\r'),(38,5,'Juvenile Review Board','','2013','','\r'),(39,1,'La Moda Fashions','','2013','','\r'),(40,1,'Laurel View Country Club ','','2013','','\r'),(41,3,'League of Women Voters of Hamden-North Haven','','2013','','\r'),(42,5,'Legislative Council','','2013','','\r'),(43,6,'Maple Woods at Hamden','','2013','','\r'),(44,5,'Mayor\'\'s Office','','2013','','\r'),(45,7,'Mishkan Israel','','2013','','\r'),(46,9,'North American Family Institute','','2013','','\r'),(47,3,'Out of the Darkness','','2015','','Organizes a walk against depression and suicide\r'),(48,1,'Paradise Nurseries','','2013','','\r'),(49,9,'Positive Choices Campaign','','2013','','\r'),(50,1,'Quinnipiac Bank and Trust','','2013','','\r'),(51,5,'Republican Party','','2013','','\r'),(52,3,'Rotary Club','www.hamdenctrotary.org','2013','','\r'),(53,8,'Sacred Heart University','','2013','','\r'),(54,4,'School - Hamden Hall Country Day School','','2013','','\r'),(55,4,'School - Hamden High School','','2015','','\r'),(56,4,'School - West Woods School','','2015','','\r'),(57,4,'Shepard Glen Elementary School','','2015','','\r'),(58,9,'Spring Glen Garden Club','','','','\r'),(59,7,'St. John the Baptist Church','','2013','','\r'),(60,2,'St. Rita Church Food Pantry','','2013','','\r'),(61,5,'Town Attorney\'\'s Office','','2013','','\r'),(62,3,'West Woods Neighborhood Association','','2015','','\r'),(63,3,'Whitneyville Civic Association','','2015','','\r'),(64,1,'Whitneyville Innovative Learning Center','','2015','60 Connolly Parkway #18','Preschool\r'),(65,5,'Youth Services Bureau','','2013','','\r');
/*!40000 ALTER TABLE `organization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organization_type`
--

DROP TABLE IF EXISTS `organization_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organization_type` (
  `organization_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`organization_type_id`),
  KEY `organization_type_id` (`organization_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organization_type`
--

LOCK TABLES `organization_type` WRITE;
/*!40000 ALTER TABLE `organization_type` DISABLE KEYS */;
INSERT INTO `organization_type` VALUES (1,'Business\r'),(2,'Charity\r'),(3,'Civic\r'),(4,'Education\r'),(5,'Government\r'),(6,'Health Care\r'),(7,'Religion\r'),(8,'University\r'),(9,'unknown\r');
/*!40000 ALTER TABLE `organization_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `full_name` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`person_id`),
  KEY `person_id` (`person_id`),
  KEY `full_name` (`full_name`(30))
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person`
--

LOCK TABLES `person` WRITE;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` VALUES (1,'Amodio','Marian','Marian Amodio\r'),(2,'Anthony','Robert','Robert Anthony\r'),(3,'Berardesca','David','David Berardesca\r'),(4,'Calogero','Antionette','Antionette Calogero\r'),(5,'Coleman','Mimsey','Mimsey Coleman\r'),(6,'Coogan','Michelle','Michelle Coogan\r'),(7,'Decola','Salvatore','Salvatore Decola\r'),(8,'DeNardis','Leslie','Leslie DeNardis\r'),(9,'Dudchik','Nancy','Nancy Dudchik\r'),(10,'Ellis','Bobbi','Bobbi Ellis\r'),(11,'Fuller','Elliot','Elliot Fuller\r'),(12,'Gaetano','Ellie','Ellie Gaetano\r'),(13,'Glynn','Colwell','Colwell Glynn\r'),(14,'Goeler','Jody','Jody Goeler\r'),(15,'Goldman','Marcy','Marcy Goldman\r'),(16,'Gorman','Al','Al Gorman\r'),(17,'Hudson','Alton','Alton Hudson'),(18,'Imler','Shelley','Shelley Imler\r'),(19,'Jackson','Scott','Scott Jackson\r'),(20,'Johnson','Dave','Dave Johnson\r'),(21,'Kamienski','Norm','Norm Kamienski\r'),(22,'Keegan','John','John Keegan\r'),(23,'Kennelly','Jack','Jack Kennelly\r'),(24,'Kops','Dan','Dan Kops\r'),(25,'Kroop','Dale','Dale Kroop\r'),(26,'Labriola','Jerry','Jerry Labriola\r'),(27,'Loewenbaum','Rosalie','Rosalie Loewenbaum\r'),(28,'Lujick','Patty','Patty Lujick\r'),(29,'Martens','Denise','Denise Martens\r'),(30,'Mastropetre','Michele','Michele Mastropetre\r'),(31,'McConville','Annmarie','Annmarie McConville\r'),(32,'McGarry','Mick','Mick McGarry\r'),(33,'McLaughlin','Nancy','Nancy McLaughlin\r'),(34,'Miller','Richard','Richard Miller\r'),(35,'Morrison','Vera','Vera Morrison\r'),(36,'Noble','Carol','Carol Noble\r'),(37,'O\'Niel','Josephine','Josephine O\'Niel\r'),(38,'Panzo','Lew','Lew Panzo\r'),(39,'Park','Jane','Jane Park\r'),(40,'Pascarella','James','James Pascarella\r'),(41,'Plock','Kristen','Kristen Plock\r'),(42,'Rowe-Lewis','Berita','Berita Rowe-Lewis\r'),(43,'Rubino','Susan','Susan Rubino\r'),(44,'Stewart','Deborah','Deborah Stewart\r'),(45,'Tozzo','Donald','Donald Tozzo\r'),(46,'Tozzo','Eileen','Eileen Tozzo\r'),(47,'Vasil','Gail','Gail Vasil\r'),(48,'Wnek','Richard','Richard Wnek\r'),(49,'Wydra','Tom','Tom Wydra\r');
/*!40000 ALTER TABLE `person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person_organization`
--

DROP TABLE IF EXISTS `person_organization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person_organization` (
  `person_organization_id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `notes` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`person_organization_id`),
  UNIQUE KEY `o_p_s_j` (`organization_id`,`person_id`,`job_title_id`,`start_date`),
  KEY `organization_id` (`organization_id`),
  KEY `person_id` (`person_id`),
  KEY `start_date_id` (`start_date`),
  KEY `end_date_id` (`end_date`),
  KEY `job_title_id` (`job_title_id`),
  KEY `person_organization_id` (`person_organization_id`),
  CONSTRAINT `person_organization_ibfk_5` FOREIGN KEY (`job_title_id`) REFERENCES `job_title` (`job_title_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person_organization`
--

LOCK TABLES `person_organization` WRITE;
/*!40000 ALTER TABLE `person_organization` DISABLE KEYS */;
INSERT INTO `person_organization` VALUES (1,37,4,'2013-05-19 00:00:00','2013-05-19 00:00:00',2,'\r'),(2,17,5,'2013-05-19 00:00:00','2013-05-19 00:00:00',10,'\r'),(3,18,8,'2013-08-16 00:00:00','2013-08-16 00:00:00',15,'\r'),(4,53,8,'2013-08-16 00:00:00','2013-08-16 00:00:00',4,'\r'),(5,37,10,'2013-05-19 00:00:00','2013-05-19 00:00:00',8,'\r'),(6,37,12,'2013-05-19 00:00:00','2013-05-19 00:00:00',1,'\r'),(7,42,16,'2013-08-16 00:00:00','2013-08-16 00:00:00',9,'Democrat\r'),(8,6,17,'2013-05-19 00:00:00','2013-05-19 00:00:00',19,'\r'),(9,37,18,'2013-05-19 00:00:00','2013-05-19 00:00:00',2,'\r'),(10,25,19,'2013-05-07 00:00:00','2013-05-07 00:00:00',14,'\r'),(11,6,21,'2013-05-19 00:00:00','2013-05-19 00:00:00',27,'\r'),(12,42,23,'2013-08-16 00:00:00','2013-08-16 00:00:00',9,'Democrat\r'),(13,25,25,'2013-05-19 00:00:00','2013-05-19 00:00:00',11,'\r'),(14,51,26,'2013-08-16 00:00:00','2013-08-16 00:00:00',23,'\r'),(15,61,28,'2013-05-07 00:00:00','2013-05-07 00:00:00',16,'\r'),(16,30,29,'2013-08-16 00:00:00','2013-08-16 00:00:00',13,'\r'),(18,37,31,'2013-05-19 00:00:00','2013-05-19 00:00:00',21,'\r'),(19,30,33,'2013-08-16 00:00:00','2013-08-16 00:00:00',13,'\r'),(20,52,34,'2013-05-19 00:00:00','2013-05-19 00:00:00',22,'\r'),(21,25,35,'2013-08-16 00:00:00','2013-08-16 00:00:00',25,'\r'),(22,37,36,'2013-05-19 00:00:00','2013-05-19 00:00:00',19,'\r'),(23,42,36,'2013-08-16 00:00:00','2013-08-16 00:00:00',9,'Democrat\r'),(24,6,37,'2013-05-19 00:00:00','2013-05-19 00:00:00',1,'\r'),(25,4,38,'2013-08-16 00:00:00','2013-08-16 00:00:00',5,'\r'),(26,6,39,'2013-05-19 00:00:00','2013-05-19 00:00:00',17,'\r'),(27,42,42,'2013-08-16 00:00:00','2013-08-16 00:00:00',9,'Democrat\r'),(28,65,43,'2013-08-16 00:00:00','2013-08-16 00:00:00',7,'\r'),(29,49,44,'2013-08-16 00:00:00','2013-08-16 00:00:00',3,'\r'),(30,6,45,'2013-05-07 00:00:00','2013-05-07 00:00:00',6,'\r'),(31,6,46,'2013-05-07 00:00:00','2013-05-07 00:00:00',15,'\r'),(32,6,48,'2013-05-19 00:00:00','2013-05-19 00:00:00',27,'\r'),(33,25,25,'2015-09-30 00:00:00','2015-09-30 00:00:00',11,'\r'),(34,20,9,'2015-09-30 00:00:00','2015-09-30 00:00:00',19,'\r'),(35,28,1,'2015-09-30 00:00:00','2015-09-30 00:00:00',10,'\r'),(36,25,24,'2015-10-07 00:00:00','2015-10-07 00:00:00',26,'\r'),(37,13,30,'2015-10-07 00:00:00','2015-10-07 00:00:00',28,'\r'),(38,25,14,'2015-10-07 00:00:00','2015-10-07 00:00:00',24,'\r'),(39,18,22,'2015-10-07 00:00:00','2015-10-07 00:00:00',5,'\r'),(40,32,49,'2015-10-07 00:00:00','2015-10-07 00:00:00',18,'\r'),(41,42,40,'2015-10-07 00:00:00','2015-10-07 00:00:00',19,'\r'),(42,56,6,'2015-10-14 00:00:00','2015-10-14 00:00:00',20,'\r'),(43,12,3,'2016-01-28 00:00:00','2016-01-28 00:00:00',12,'\r'),(44,12,38,'2016-01-28 00:00:00','2016-01-28 00:00:00',12,NULL),(45,1,17,'2016-06-12 00:00:00','2016-06-17 00:00:00',1,NULL);
/*!40000 ALTER TABLE `person_organization` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-19 14:17:21
