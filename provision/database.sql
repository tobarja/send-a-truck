DROP TABLE IF EXISTS `Customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `address1` varchar(50) NOT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `Customers` VALUES (1,'Acme, Inc.','James','Smith','jsmith@acme.com','9105551212','123 Main St',NULL,'Rockingham','NC','28379');
INSERT INTO `Customers` VALUES (2,'Wheels R Us.','Motley','Crue','mcrue@wheelsrus.com','9105552323','40 Apple Rd',NULL,'Hamlet','NC','28345');
DROP TABLE IF EXISTS `TruckRequests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TruckRequests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `TruckRequests_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `Customers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TruckRequests` VALUES (1,1,'2015-09-06 09:07:58');
INSERT INTO `TruckRequests` VALUES (2,2,'2015-09-07 11:08:09');
INSERT INTO `TruckRequests` VALUES (3,1,'2015-09-07 13:08:15');
DROP TABLE IF EXISTS `UserPermissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserPermissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `UserPermissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Customers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `UserPermissions` VALUES (1,1,'view_users');
INSERT INTO `UserPermissions` VALUES (2,1,'view_requests');
INSERT INTO `UserPermissions` VALUES (3,1,'view_customers');
INSERT INTO `UserPermissions` VALUES (4,1,'edit_user_permissions');
INSERT INTO `UserPermissions` VALUES (5,1,'edit_users');
DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `Users` VALUES (1,'admin','$2y$10$2AF22We0Ab3zmPSBxWfWkOK559OBel/3Bi3At5BFcZ9jeiuPRSLeK');
