-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: rmi
-- ------------------------------------------------------
-- Server version	5.7.10-log

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
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pais` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text,
  `Continent` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` VALUES (1,'Aruba','North America'),(2,'Afghanistan','Asia'),(3,'Angola','Africa'),(4,'Anguilla','North America'),(5,'Albania','Europe'),(6,'Andorra','Europe'),(7,'Netherlands Antilles','North America'),(8,'United Arab Emirates','Asia'),(9,'Argentina','South America'),(10,'Armenia','Asia'),(11,'American Samoa','Oceania'),(12,'Antarctica','Antarctica'),(13,'French Southern territories','Antarctica'),(14,'Antigua and Barbuda','North America'),(15,'Australia','Oceania'),(16,'Austria','Europe'),(17,'Azerbaijan','Asia'),(18,'Burundi','Africa'),(19,'Belgium','Europe'),(20,'Benin','Africa'),(21,'Burkina Faso','Africa'),(22,'Bangladesh','Asia'),(23,'Bulgaria','Europe'),(24,'Bahrain','Asia'),(25,'Bahamas','North America'),(26,'Bosnia and Herzegovina','Europe'),(27,'Belarus','Europe'),(28,'Belize','North America'),(29,'Bermuda','North America'),(30,'Bolivia','South America'),(31,'Brazil','South America'),(32,'Barbados','North America'),(33,'Brunei','Asia'),(34,'Bhutan','Asia'),(35,'Bouvet Island','Antarctica'),(36,'Botswana','Africa'),(37,'Central African Republic','Africa'),(38,'Canada','North America'),(39,'Cocos (Keeling) Islands','Oceania'),(40,'Switzerland','Europe'),(41,'Chile','South America'),(42,'China','Asia'),(43,'Côte d\'Ivoire','Africa'),(44,'Cameroon','Africa'),(45,'Congo, The Democratic Republic of the','Africa'),(46,'Congo','Africa'),(47,'Cook Islands','Oceania'),(48,'Colombia','South America'),(49,'Comoros','Africa'),(50,'Cape Verde','Africa'),(51,'Costa Rica','North America'),(52,'Cuba','North America'),(53,'Christmas Island','Oceania'),(54,'Cayman Islands','North America'),(55,'Cyprus','Asia'),(56,'Czech Republic','Europe'),(57,'Germany','Europe'),(58,'Djibouti','Africa'),(59,'Dominica','North America'),(60,'Denmark','Europe'),(61,'Dominican Republic','North America'),(62,'Algeria','Africa'),(63,'Ecuador','South America'),(64,'Egypt','Africa'),(65,'Eritrea','Africa'),(66,'Western Sahara','Africa'),(67,'Spain','Europe'),(68,'Estonia','Europe'),(69,'Ethiopia','Africa'),(70,'Finland','Europe'),(71,'Fiji Islands','Oceania'),(72,'Falkland Islands','South America'),(73,'France','Europe'),(74,'Faroe Islands','Europe'),(75,'Micronesia, Federated States of','Oceania'),(76,'Gabon','Africa'),(77,'United Kingdom','Europe'),(78,'Georgia','Asia'),(79,'Ghana','Africa'),(80,'Gibraltar','Europe'),(81,'Guinea','Africa'),(82,'Guadeloupe','North America'),(83,'Gambia','Africa'),(84,'Guinea-Bissau','Africa'),(85,'Equatorial Guinea','Africa'),(86,'Greece','Europe'),(87,'Grenada','North America'),(88,'Greenland','North America'),(89,'Guatemala','North America'),(90,'French Guiana','South America'),(91,'Guam','Oceania'),(92,'Guyana','South America'),(93,'Hong Kong','Asia'),(94,'Heard Island and McDonald Islands','Antarctica'),(95,'Honduras','North America'),(96,'Croatia','Europe'),(97,'Haiti','North America'),(98,'Hungary','Europe'),(99,'Indonesia','Asia'),(100,'India','Asia'),(101,'British Indian Ocean Territory','Africa'),(102,'Ireland','Europe'),(103,'Iran','Asia'),(104,'Iraq','Asia'),(105,'Iceland','Europe'),(106,'Israel','Asia'),(107,'Italy','Europe'),(108,'Jamaica','North America'),(109,'Jordan','Asia'),(110,'Japan','Asia'),(111,'Kazakstan','Asia'),(112,'Kenya','Africa'),(113,'Kyrgyzstan','Asia'),(114,'Cambodia','Asia'),(115,'Kiribati','Oceania'),(116,'Saint Kitts and Nevis','North America'),(117,'South Korea','Asia'),(118,'Kuwait','Asia'),(119,'Laos','Asia'),(120,'Lebanon','Asia'),(121,'Liberia','Africa'),(122,'Libyan Arab Jamahiriya','Africa'),(123,'Saint Lucia','North America'),(124,'Liechtenstein','Europe'),(125,'Sri Lanka','Asia'),(126,'Lesotho','Africa'),(127,'Lithuania','Europe'),(128,'Luxembourg','Europe'),(129,'Latvia','Europe'),(130,'Macao','Asia'),(131,'Morocco','Africa'),(132,'Monaco','Europe'),(133,'Moldova','Europe'),(134,'Madagascar','Africa'),(135,'Maldives','Asia'),(136,'Mexico','North America'),(137,'Marshall Islands','Oceania'),(138,'Macedonia','Europe'),(139,'Mali','Africa'),(140,'Malta','Europe'),(141,'Myanmar','Asia'),(142,'Mongolia','Asia'),(143,'Northern Mariana Islands','Oceania'),(144,'Mozambique','Africa'),(145,'Mauritania','Africa'),(146,'Montserrat','North America'),(147,'Martinique','North America'),(148,'Mauritius','Africa'),(149,'Malawi','Africa'),(150,'Malaysia','Asia'),(151,'Mayotte','Africa'),(152,'Namibia','Africa'),(153,'New Caledonia','Oceania'),(154,'Niger','Africa'),(155,'Norfolk Island','Oceania'),(156,'Nigeria','Africa'),(157,'Nicaragua','North America'),(158,'Niue','Oceania'),(159,'Netherlands','Europe'),(160,'Norway','Europe'),(161,'Nepal','Asia'),(162,'Nauru','Oceania'),(163,'New Zealand','Oceania'),(164,'Oman','Asia'),(165,'Pakistan','Asia'),(166,'Panama','North America'),(167,'Pitcairn','Oceania'),(168,'Peru','South America'),(169,'Philippines','Asia'),(170,'Palau','Oceania'),(171,'Papua New Guinea','Oceania'),(172,'Poland','Europe'),(173,'Puerto Rico','North America'),(174,'North Korea','Asia'),(175,'Portugal','Europe'),(176,'Paraguay','South America'),(177,'Palestine','Asia'),(178,'French Polynesia','Oceania'),(179,'Qatar','Asia'),(180,'RÃ©union','Africa'),(181,'Romania','Europe'),(182,'Russian Federation','Europe'),(183,'Rwanda','Africa'),(184,'Saudi Arabia','Asia'),(185,'Sudan','Africa'),(186,'Senegal','Africa'),(187,'Singapore','Asia'),(188,'South Georgia and the South Sandwich Islands','Antarctica'),(189,'Saint Helena','Africa'),(190,'Svalbard and Jan Mayen','Europe'),(191,'Solomon Islands','Oceania'),(192,'Sierra Leone','Africa'),(193,'El Salvador','North America'),(194,'San Marino','Europe'),(195,'Somalia','Africa'),(196,'Saint Pierre and Miquelon','North America'),(197,'Sao Tome and Principe','Africa'),(198,'Suriname','South America'),(199,'Slovakia','Europe'),(200,'Slovenia','Europe'),(201,'Sweden','Europe'),(202,'Swaziland','Africa'),(203,'Seychelles','Africa'),(204,'Syria','Asia'),(205,'Turks and Caicos Islands','North America'),(206,'Chad','Africa'),(207,'Togo','Africa'),(208,'Thailand','Asia'),(209,'Tajikistan','Asia'),(210,'Tokelau','Oceania'),(211,'Turkmenistan','Asia'),(212,'East Timor','Asia'),(213,'Tonga','Oceania'),(214,'Trinidad and Tobago','North America'),(215,'Tunisia','Africa'),(216,'Turkey','Asia'),(217,'Tuvalu','Oceania'),(218,'Taiwan','Asia'),(219,'Tanzania','Africa'),(220,'Uganda','Africa'),(221,'Ukraine','Europe'),(222,'United States Minor Outlying Islands','Oceania'),(223,'Uruguay','South America'),(224,'United States','North America'),(225,'Uzbekistan','Asia'),(226,'Holy See (Vatican City State)','Europe'),(227,'Saint Vincent and the Grenadines','North America'),(228,'Venezuela','South America'),(229,'Virgin Islands, British','North America'),(230,'Virgin Islands, U.S.','North America'),(231,'Vietnam','Asia'),(232,'Vanuatu','Oceania'),(233,'Wallis and Futuna','Oceania'),(234,'Samoa','Oceania'),(235,'Yemen','Asia'),(236,'Yugoslavia','Europe'),(237,'South Africa','Africa'),(238,'Zambia','Africa'),(239,'Zimbabwe','Africa');
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-29 18:38:15
